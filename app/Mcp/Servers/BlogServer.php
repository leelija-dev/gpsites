<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\CreateBlogPostTool;
use App\Mcp\Tools\GetBlogPostTool;
use App\Mcp\Tools\ListBlogCategoriesTool;
use App\Mcp\Tools\ListBlogPostsTool;
use App\Mcp\Tools\UpdateBlogPostTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('GPSites Blog')]
#[Version('1.0.0')]
#[Instructions(<<<'MD'
Write, schedule and update blog posts on gpsites.io, a link building marketplace and outreach platform.
- Call list_blog_categories before creating a post, and list_blog_posts to avoid repeating a topic or slug.
- New posts are drafts unless publish is "schedule" (with publish_at) or "now". Do not publish or schedule unless the user asked for it.
- Times without an offset are read as IST (Asia/Kolkata).
- content is HTML. Fill meta_title, keywords and meta_description for every post; add FAQs when they help readers.
- There is no delete tool: to take a post down, update it with publish="draft".
MD)]
class BlogServer extends Server
{
    protected array $tools = [
        ListBlogCategoriesTool::class,
        ListBlogPostsTool::class,
        GetBlogPostTool::class,
        CreateBlogPostTool::class,
        UpdateBlogPostTool::class,
    ];
}
