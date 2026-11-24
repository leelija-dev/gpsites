<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;

/** Input fields shared by the create and update tools. */
trait BlogPostFields
{
    protected function postFields(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->description('Post title (H1).'),
            'category' => $schema->string()->description('Category id, name or slug from list_blog_categories.'),
            'content' => $schema->string()->description('Full post body as HTML (h2/h3, p, ul/ol, table, a, strong). Do not repeat the title as an h1.'),
            'excerpt' => $schema->string()->description('Short summary shown on the blog list. Max 100 characters.'),
            'tags' => $schema->array()->items($schema->string())->description('Tags, e.g. ["link building", "guest posting"].'),
            'meta_title' => $schema->string()->description('SEO title, ideally 50-60 characters.'),
            'keywords' => $schema->string()->description('Comma-separated target keywords.'),
            'meta_description' => $schema->string()->description('SEO meta description, ideally 140-160 characters. Max 500.'),
            'schema' => $schema->string()->description('Optional JSON-LD markup (e.g. Article or FAQPage) as a string.'),
            'feature_image_url' => $schema->string()->description('Optional public https URL of a JPEG, PNG or WebP feature image (max 5 MB). It is downloaded and stored on the site.'),
            'feature_image_alt' => $schema->string()->description('Alt text for the feature image.'),
            'faqs' => $schema->array()->items($schema->object([
                'question' => $schema->string()->required(),
                'answer' => $schema->string()->required(),
            ]))->description('FAQ items shown under the post. On update, the list replaces all existing FAQs.'),
            'publish' => $schema->string()->enum(['draft', 'schedule', 'now'])
                ->description('draft = saved but hidden (default for new posts); schedule = goes live automatically at publish_at; now = goes live immediately.'),
            'publish_at' => $schema->string()->description('When publish="schedule": date and time, e.g. "2026-12-01 10:00" (read as IST) or ISO 8601 with offset.'),
        ];
    }
}
