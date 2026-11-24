<?php

namespace App\Mcp\Tools;

use App\Models\BlogCategory;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
#[Description('List the gpsites.io blog categories (id, name, slug). Every post needs one of these categories.')]
class ListBlogCategoriesTool extends Tool
{
    protected string $name = 'list_blog_categories';

    public function handle(Request $request): Response
    {
        return Response::json(
            BlogCategory::query()->orderBy('name')->get(['id', 'name', 'slug', 'status'])
                ->map(fn ($c) => ['id' => $c->id, 'name' => $c->name, 'slug' => $c->slug, 'active' => (bool) $c->status])
        );
    }
}
