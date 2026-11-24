<?php

namespace App\Mcp\Tools;

use App\Mcp\Support\BlogWriter;
use App\Models\Blogs;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Update a gpsites.io blog post by id. Only the fields you send change. Use publish to move it between draft, scheduled (publish_at) and live. The slug cannot be changed, so published links never break.')]
class UpdateBlogPostTool extends Tool
{
    use BlogPostFields;

    protected string $name = 'update_blog_post';

    public function handle(Request $request): Response
    {
        $data = $request->validate(['id' => ['required', 'integer']] + BlogWriter::fieldRules());

        $blog = Blogs::find($data['id']);
        if (! $blog) {
            return Response::error("No blog post with id {$data['id']}.");
        }

        unset($data['id'], $data['slug']);
        $blog = BlogWriter::save($blog, $data);

        return Response::json(['updated' => true] + BlogWriter::summary($blog));
    }

    public function schema(JsonSchema $schema): array
    {
        return ['id' => $schema->integer()->description('Id of the post to change.')->required()] + $this->postFields($schema);
    }
}
