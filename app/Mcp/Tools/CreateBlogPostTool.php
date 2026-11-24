<?php

namespace App\Mcp\Tools;

use App\Mcp\Support\BlogWriter;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Create a gpsites.io blog post. It is saved as a hidden draft unless publish is "schedule" (goes live at publish_at) or "now". Returns the post id, public URL and admin edit link.')]
class CreateBlogPostTool extends Tool
{
    use BlogPostFields;

    protected string $name = 'create_blog_post';

    public function handle(Request $request): Response
    {
        $rules = BlogWriter::fieldRules();
        foreach (['title', 'category', 'content', 'meta_title', 'keywords'] as $field) {
            array_unshift($rules[$field], 'required');
        }

        $blog = BlogWriter::save(null, $request->validate($rules));

        return Response::json(['created' => true] + BlogWriter::summary($blog));
    }

    public function schema(JsonSchema $schema): array
    {
        $fields = $this->postFields($schema);
        foreach (['title', 'category', 'content', 'meta_title', 'keywords'] as $field) {
            $fields[$field]->required();
        }
        $fields['slug'] = $schema->string()->description('Optional URL slug. Made from the title when left out; a number is added if it is taken.');

        return $fields;
    }
}
