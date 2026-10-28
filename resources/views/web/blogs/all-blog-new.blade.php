@extends('layouts.web.main-layout')

@section('title', 'Blogs')
{{-- @section('description', 'Explore the latest insights, stories, and expert tips on business growth, automation, outreach, SEO, and digital marketing with GPSites.') --}}
@section(
    'description',
    request()->routeIs('all-blogs.index')
        ? 'Explore the latest insights, stories, and expert tips on business growth, automation, outreach, SEO, and digital marketing with GPSites.'
        : (request()->routeIs('blog.category')
            ? ($category->description ?? '')
            : '')
)
@section('keywords',
    'Link Building Outreach Automation​, Outreach Automation, Link Building Outreach Tool, outreach
    automation tool​, automated outreach system​, backlink marketplace, backlinks websites, outreach automation tool')
@section('indexing', 'no')

@php
    $blogSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'GPSites Blog',
        'description' => request()->routeIs('all-blogs.index')
        ? 'Explore the latest insights, stories, and expert tips on business growth, automation, outreach, SEO, and digital marketing with GPSites.'
        : (request()->routeIs('blog.category')
            ? ($category->description ?? '')
            : ''),
        'url' => url()->current(),

        'mainEntity' => [
            '@type' => 'ItemList',
            'itemListElement' => $blogs->values()->map(function ($blog, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => url('/blog/' . $blog->slug),
                    'name' => $blog->title,
                ];
            })->toArray(),
        ],
    ];
@endphp

<script type="application/ld+json">
{!! json_encode(
    $blogSchema,
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
) !!}
</script>
@push('styles')
<style>
    /* 
      1. Fix the layout wrapper to stack items correctly (Navbar on top, content below)
    */
    main {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 
      2. Isolate your GPSites content and prevent overflow
    */
    .gp-isolated-page {
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden; 
        position: relative;
        z-index: 1;
        padding-top: 80px; /* Adjust this if your navbar height is different */
    }

    /* Ensure navbar stays on top */
    nav, header { 
        position: relative;
        z-index: 50; 
    }
</style>
@endpush

@section('content')

{{-- WRAPPED THE ENTIRE CONTENT IN THE ISOLATION DIV --}}
<div class="gp-isolated-page">
    
    @include('web.partials.assets')

    @php
    $articles = $articles ?? [
    ['title' => 'What Is an SEO Title? A Simple Guide for Beginners', 'summary' => 'Start with an introduction to SEO titles and how they fit into your page’s search appearance.', 'image' => 'gpsites/images/title.webp', 'date' => 'Oct 02, 2026', 'datetime' => '2026-10-02', 'slug' => 'what-is-an-seo-title', 'cta' => 'Read the SEO title guide', 'author' => 'Safikul Islam', 'category' => 'SEO', 'url' => '/blog/what-is-an-seo-title'],
    ['title' => 'How to Find Competitors’ Keywords: A Practical SEO Guide', 'summary' => 'Explore competitor keyword research as a starting point for finding search terms relevant to your business.', 'image' => 'gpsites/images/keywords.webp', 'date' => 'Sep 16, 2026', 'datetime' => '2026-09-16', 'slug' => 'how-to-find-competitors-keywords', 'cta' => 'Explore keyword research', 'author' => 'Safikul Islam', 'category' => 'SEO', 'url' => '/blog/how-to-find-competitors-keywords'],
    ['title' => 'Types of Link Building in SEO: A Complete Guide for 2026', 'summary' => 'Explore guest posting, digital PR, broken link building and other approaches before choosing a method for your campaign.', 'image' => 'gpsites/images/links.webp', 'date' => 'Aug 20, 2026', 'datetime' => '2026-08-20', 'slug' => 'types-of-link-building-in-seo', 'cta' => 'Explore types of link building', 'author' => 'Safikul Islam', 'category' => 'SEO', 'url' => '/blog/types-of-link-building-in-seo'],
    ];
    $articles = collect($articles)->all();
    @endphp

    <div class="gp-page gp-blogs">
        <section class="gp-section gp-hero">
            <div class="gp-container">
                <nav class="gp-crumb" aria-label="Breadcrumb"><a href="{{ $homeUrl ?? url('/') }}">Home</a> / <span aria-current="page">Blog</span></nav>
                <div class="gp-split">
                    <div><span class="gp-eyebrow">The GPSites Blog</span>
                        <h1>Link Building Blog &amp;<br>Practical <span>SEO Guides</span></h1>
                        <p>A useful SEO plan starts with knowing what to do next. The GPSites blog helps you explore link building, research competitors’ keywords and understand the on-page details that make your content easier to find.</p>
                        <p>Whether you manage client campaigns, market your own business or are learning the basics, start with the question you need to answer.</p>
                        <div class="gp-actions"></div>
                    </div>
                    <div><img class="gp-art" src="{{ asset('gpsites/images/blogs-hero.webp') }}" alt="" width="371" height="249" loading="lazy"></div>
                </div>
                <form class="gp-blog-search" data-blog-search role="search">
                    <div class="gp-search-line"><label>Search the blog<div class="gp-search-input"><input type="search" name="q" placeholder="Search by topic or keyword"><button class="gp-button">Search</button></div></label><label>Browse topics<select name="category">
                                <option value="all">All articles</option>
                                <option value="SEO">SEO</option>
                            </select></label></div>
                    <div class="gp-pills"><button type="button" data-category="all" class="gp-button active" aria-pressed="true">All articles</button><button type="button" data-category="SEO" class="gp-button gp-outline" aria-pressed="false">SEO</button></div>
                </form>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container">
                <h2 class="gp-underline">Explore the latest SEO guides</h2>
                <div class="gp-between">
                    <p>Compare link building approaches, find ideas for keyword research or get familiar with SEO titles.<br>Choose a guide that fits the work in front of you.</p><small data-blog-count aria-live="polite">{{ count($articles) }} {{ count($articles) === 1 ? 'article' : 'articles' }}</small>
                </div>
                <div class="gp-grid gp-cols-3">@forelse($articles as $article)
                    <article class="gp-post" data-post data-category="{{ $article['category'] ?? 'SEO' }}"><img class="gp-art" src="{{ asset($article['image']) }}" alt="" width="534" height="308" loading="lazy"><span class="gp-pill">{{ $article['category'] ?? 'SEO' }}</span>
                        <h2><a href="{{ url($article['url']) }}">{{ $article['title'] }}</a></h2>
                        <p>{{ $article['summary'] }}</p>
                        <div class="gp-meta">{{ $article['author'] }} · <time datetime="{{ $article['datetime'] }}">{{ $article['date'] }}</time></div><a class="gp-link" href="{{ url($article['url']) }}">{{ $article['cta'] ?? 'Read guide' }} →</a>
                    </article>
                    @empty
                    <p>No articles are available yet.</p>
                    @endforelse
                </div>
                <div data-blog-empty hidden>
                    <p>No articles match your search. Try a broader keyword or view all articles.</p><button class="gp-button" data-blog-reset type="button">View all articles</button>
                </div>
            </div>
        </section>
        <section class="gp-section gp-tint">
            <div class="gp-container">
                <div class="gp-blog-about"><img class="gp-art" src="{{ asset('gpsites/images/blog-about.webp') }}" alt="" width="299" height="163" loading="lazy">
                    <div>
                        <h2 class="gp-underline">About the GPSites blog</h2>
                        <p>This blog is part of GPSites, a link building marketplace and outreach automation platform. Leelija is our parent company. Our articles offer a starting point for understanding SEO topics before you put them into practice.</p><a class="gp-link" href="{{ $aboutUrl ?? url('/about') }}">Learn more about GPSites →</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="gp-section gp-cta">
            <div class="gp-container">
                <div class="gp-blog-cta">
                    <div>
                        <h2>Ready to plan your publisher outreach?</h2>
                        <p>Use GPSites to discover publishers, filter sites by niche, authority metrics and traffic, and manage your outreach offers.</p>
                        <p>Start with the audience you want to reach, then review the publishers that fit your campaign.</p>
                        <div class="gp-actions"><a class="gp-button gp-white" href="{{ $homeUrl ?? url('/') }}">Explore GPSites</a><a class="gp-button gp-outline" href="{{ $contactUrl ?? url('/contact') }}">Ask our team a question</a></div>
                    </div><img class="gp-art" src="{{ asset('gpsites/images/blog-cta.webp') }}" alt="" width="193" height="141" loading="lazy">
                </div>
            </div>
        </section>
    </div>
</div>
@endsection