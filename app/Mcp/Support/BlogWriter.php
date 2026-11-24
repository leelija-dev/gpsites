<?php

namespace App\Mcp\Support;

use App\Models\Admin;
use App\Models\BlogCategory;
use App\Models\Blogs;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Shared logic for the Claude blog connector: creating, updating and
 * describing blog posts the same way the Filament admin stores them.
 */
class BlogWriter
{
    /** Rules shared by create and update (create adds "required" where needed). */
    public static function fieldRules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'slug' => ['string', 'max:255'],
            'category' => ['string', 'max:255'],
            'tags' => ['array', 'max:20'],
            'tags.*' => ['string', 'max:100'],
            // Matches the admin form limit, so the post stays editable there.
            'excerpt' => ['string', 'max:100'],
            'content' => ['string'],
            'meta_title' => ['string', 'max:255'],
            'keywords' => ['string', 'max:1000'],
            'meta_description' => ['string', 'max:500'],
            'schema' => ['string'],
            'feature_image_url' => ['url:https', 'max:2000'],
            'feature_image_alt' => ['string', 'max:255'],
            'faqs' => ['array', 'max:30'],
            'faqs.*.question' => ['required', 'string', 'max:255'],
            'faqs.*.answer' => ['required', 'string'],
            'publish' => ['in:draft,schedule,now'],
            'publish_at' => ['required_if:publish,schedule', 'date'],
        ];
    }

    /**
     * Save a post. $blog is null for a new post.
     */
    public static function save(?Blogs $blog, array $data): Blogs
    {
        $isNew = $blog === null;
        $blog ??= new Blogs;

        $attributes = collect($data)->only([
            'title', 'excerpt', 'content', 'meta_title', 'keywords',
            'meta_description', 'schema', 'feature_image_alt',
        ])->all();

        if (array_key_exists('tags', $data)) {
            // Same format as the admin tag field (comma-separated), which the blog pages expect.
            $tags = array_filter(array_map(fn ($t) => trim(str_replace(',', ' ', $t)), $data['tags']));
            $attributes['tags'] = $tags ? implode(',', $tags) : null;
        }

        if (array_key_exists('category', $data)) {
            $attributes['category'] = self::resolveCategory($data['category'])->id;
        }

        if ($isNew) {
            $attributes['slug'] = self::uniqueSlug($data['slug'] ?? $data['title']);
            $attributes['created_by'] = self::authorId();
        }

        if (array_key_exists('publish', $data)) {
            [$attributes['status'], $attributes['published_at']] = self::publishState($data['publish'], $data['publish_at'] ?? null);
        } elseif ($isNew) {
            // Safe default: nothing goes live unless asked.
            [$attributes['status'], $attributes['published_at']] = [false, null];
        }

        // Download the image before touching the database, so a bad URL saves nothing.
        if (! empty($data['feature_image_url'])) {
            $attributes['feature_image'] = self::storeImage($data['feature_image_url']);
        }

        return DB::transaction(function () use ($blog, $attributes, $data) {
            $blog->fill($attributes);
            // Keep the chosen schedule even when the model's "publish now" default would fill it.
            if (array_key_exists('published_at', $attributes)) {
                $blog->published_at = $attributes['published_at'];
            }
            $blog->save();

            if (array_key_exists('faqs', $data)) {
                $blog->faq()->delete();
                foreach ($data['faqs'] as $faq) {
                    $blog->faq()->create([
                        'question' => $faq['question'],
                        'answer' => $faq['answer'],
                    ]);
                }
            }

            return $blog->fresh(['faq', 'blogCategory']);
        });
    }

    /** @return array{0: bool, 1: ?\DateTimeInterface} */
    public static function publishState(string $mode, ?string $publishAt): array
    {
        return match ($mode) {
            'draft' => [false, null],
            'now' => [true, now()],
            'schedule' => [true, self::futureTime($publishAt)],
        };
    }

    public static function futureTime(?string $value): CarbonImmutable
    {
        $tz = config('app.timezone');
        // A time without an offset is read as site time (IST).
        $time = CarbonImmutable::parse($value, $tz)->setTimezone($tz);

        if ($time->lessThanOrEqualTo(now()->addMinute())) {
            throw ValidationException::withMessages([
                'publish_at' => "publish_at must be in the future (site time is {$tz}, now ".now()->format('Y-m-d H:i').'). Use publish="now" to go live immediately.',
            ]);
        }

        return $time;
    }

    public static function resolveCategory(string $value): BlogCategory
    {
        $category = BlogCategory::query()
            ->when(ctype_digit($value), fn ($q) => $q->where('id', (int) $value),
                fn ($q) => $q->where('slug', Str::slug($value))->orWhere('name', $value))
            ->first();

        if (! $category) {
            $names = BlogCategory::pluck('name')->implode(', ');
            throw ValidationException::withMessages([
                'category' => "Unknown category \"{$value}\". Existing categories: {$names}. Categories are created in the admin panel.",
            ]);
        }

        return $category;
    }

    public static function uniqueSlug(string $source): string
    {
        $base = Str::slug($source) ?: 'post';
        $slug = $base;
        $i = 2;

        while (Blogs::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    protected static function authorId(): ?int
    {
        $configured = config('services.claude_mcp.author_id');

        return $configured ? (int) $configured : Admin::query()->orderBy('id')->value('id');
    }

    /**
     * Download a feature image into public/blog_images, where the admin uploads go.
     */
    public static function storeImage(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST);
        $ips = $host ? (gethostbynamel($host) ?: []) : [];
        foreach ($ips as $ip) {
            if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                $ips = [];
                break;
            }
        }
        if ($ips === []) {
            throw ValidationException::withMessages(['feature_image_url' => 'The image host could not be reached or is not a public address.']);
        }

        $response = Http::timeout(20)->withOptions(['allow_redirects' => ['max' => 3, 'protocols' => ['https']]])->get($url);
        $types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $type = strtolower(trim(explode(';', (string) $response->header('Content-Type'))[0]));
        $body = $response->body();

        if (! $response->successful() || ! isset($types[$type]) || @getimagesizefromstring($body) === false) {
            throw ValidationException::withMessages(['feature_image_url' => 'The URL did not return a JPEG, PNG or WebP image.']);
        }
        if (strlen($body) > 5 * 1024 * 1024) {
            throw ValidationException::withMessages(['feature_image_url' => 'The image is larger than 5 MB.']);
        }

        $name = Str::lower((string) Str::ulid()).'.'.$types[$type];
        Storage::disk('blog_images')->put($name, $body);

        return $name;
    }

    public static function state(Blogs $blog): string
    {
        if (! $blog->status) {
            return 'draft';
        }

        return $blog->isScheduled() ? 'scheduled' : 'live';
    }

    public static function summary(Blogs $blog): array
    {
        return [
            'id' => $blog->id,
            'title' => $blog->title,
            'slug' => $blog->slug,
            'state' => self::state($blog),
            'published_at' => $blog->published_at?->format('Y-m-d H:i T'),
            'category' => $blog->blogCategory?->name,
            'url' => route('blog.show', $blog->slug),
            'admin_edit_url' => url('/admin/blogs/'.$blog->id.'/edit'),
        ];
    }

    public static function full(Blogs $blog): array
    {
        return self::summary($blog) + [
            'tags' => is_array($blog->tags) ? $blog->tags : array_values(array_filter(explode(',', (string) $blog->tags))),
            'excerpt' => $blog->excerpt,
            'meta_title' => $blog->meta_title,
            'keywords' => $blog->keywords,
            'meta_description' => $blog->meta_description,
            'feature_image' => $blog->feature_image ? asset('blog_images/'.$blog->feature_image) : null,
            'feature_image_alt' => $blog->feature_image_alt,
            'schema' => $blog->schema,
            'faqs' => $blog->faq->map->only(['question', 'answer'])->values(),
            'content' => $blog->content,
        ];
    }
}
