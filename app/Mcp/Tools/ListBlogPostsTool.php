<?php

namespace App\Mcp\Tools;

use App\Mcp\Support\BlogWriter;
use App\Models\Blogs;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
#[Description('List gpsites.io blog posts, newest first, with their state (live, scheduled or draft) and publish time. Use it to check existing topics before writing, and to see the posting schedule.')]
class ListBlogPostsTool extends Tool
{
    protected string $name = 'list_blog_posts';

    public function handle(Request $request): Response
    {
        $data = $request->validate([
            'state' => ['in:all,live,scheduled,draft'],
            'search' => ['string', 'max:200'],
            'limit' => ['integer', 'min:1', 'max:100'],
        ]);

        $posts = Blogs::query()
            ->with('blogCategory')
            ->when(($data['state'] ?? 'all') === 'live', fn ($q) => $q->published())
            ->when(($data['state'] ?? 'all') === 'scheduled', fn ($q) => $q->where('status', true)->where('published_at', '>', now()))
            ->when(($data['state'] ?? 'all') === 'draft', fn ($q) => $q->where('status', false))
            ->when($data['search'] ?? null, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('title', 'like', "%{$s}%")->orWhere('slug', 'like', "%{$s}%")->orWhere('keywords', 'like', "%{$s}%")))
            ->orderByRaw('published_at IS NULL DESC')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit($data['limit'] ?? 30)
            ->get();

        return Response::json([
            'site_time' => now()->format('Y-m-d H:i T'),
            'count' => $posts->count(),
            'posts' => $posts->map(fn ($p) => BlogWriter::summary($p))->values(),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'state' => $schema->string()->enum(['all', 'live', 'scheduled', 'draft'])->description('Filter by state. Default all.'),
            'search' => $schema->string()->description('Text to find in the title, slug or keywords.'),
            'limit' => $schema->integer()->description('How many posts to return, 1-100. Default 30.'),
        ];
    }
}
