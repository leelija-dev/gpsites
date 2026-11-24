<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Blogs;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * Serves /sitemap.xml from the database so new blog posts appear automatically
 * and <lastmod> reflects real edit dates instead of the time of the request.
 */
class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap_xml', 3600, function () {
            $urls = [];

            // Public marketing pages. No <lastmod>: these have no reliable edit date,
            // and a fake "today" value teaches Google to ignore the field.
            foreach (['home', 'about', 'all-blogs.index', 'contact', 'privacy-policy', 'terms-of-service', 'start-trial.page', 'pricing'] as $name) {
                $urls[] = ['loc' => route($name)];
            }

            $posts = Blogs::published()->get(['slug', 'updated_at', 'created_at']);
            $latestPost = $posts->max(fn ($p) => $p->updated_at ?? $p->created_at);
            if ($latestPost) {
                // The blog index changes whenever a post does.
                $urls[2]['lastmod'] = $latestPost->toAtomString();
            }

            foreach ($posts as $post) {
                $urls[] = [
                    'loc' => route('blog.show', $post->slug),
                    'lastmod' => optional($post->updated_at ?? $post->created_at)->toAtomString(),
                ];
            }

            // Category archives only when they hold at least one published post.
            $categories = BlogCategory::where('status', true)
                ->whereIn('id', Blogs::published()->select('category'))
                ->get(['slug']);
            foreach ($categories as $category) {
                $urls[] = ['loc' => route('blog.category', $category->slug)];
            }

            return view('sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
