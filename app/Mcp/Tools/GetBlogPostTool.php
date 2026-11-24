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
#[Description('Get one gpsites.io blog post in full (content HTML, SEO fields, FAQs, image, state) by id or slug.')]
class GetBlogPostTool extends Tool
{
    protected string $name = 'get_blog_post';

    public function handle(Request $request): Response
    {
        $data = $request->validate([
            'id' => ['required_without:slug', 'integer'],
            'slug' => ['required_without:id', 'string'],
        ]);

        $blog = Blogs::with('faq', 'blogCategory')
            ->when($data['id'] ?? null, fn ($q, $id) => $q->whereKey($id), fn ($q) => $q->where('slug', $data['slug']))
            ->first();

        return $blog ? Response::json(BlogWriter::full($blog)) : Response::error('No blog post found.');
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->description('Post id.'),
            'slug' => $schema->string()->description('Post slug, used when id is not given.'),
        ];
    }
}
