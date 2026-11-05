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
    .gp-pills a.gp-button { text-decoration: none; display: inline-flex; align-items: center; }
.gp-post .gp-tags { display: flex; flex-wrap: wrap; gap: 6px; margin: 10px 0 14px; }
.gp-post .gp-tags a { font-size: .75rem; padding: 3px 10px; border-radius: 999px; background: #f1f5f9; color: #475569; text-decoration: none; }
.gp-post .gp-tags a:hover { background: #4a36db; color: #fff; }
.gp-post .gp-thumb { width: 100%; aspect-ratio: 534 / 308; object-fit: cover; border-radius: 12px; }
.gp-pagination { margin-top: 32px; display: flex; justify-content: center; }
</style>
@endpush

@section('content')

{{-- WRAPPED THE ENTIRE CONTENT IN THE ISOLATION DIV --}}
@php
    $isCategory = request()->routeIs('blog.category') && isset($category);
    $cats = (isset($blogCategory) && $blogCategory->count())
        ? $blogCategory
        : $blogs->map(fn ($b) => $b->blogCategory)->filter()->unique('id')->values();
@endphp
<div class="gp-isolated-page">
    
    {{-- @include('web.partials.assets') --}}

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
                    <div><img class="gp-art" src="{{ asset('/images/blog/blog-hero.png') }}" alt="" width="371" height="249" loading="lazy"></div>
                </div>
                <form class="gp-blog-search" data-blog-search role="search"
      action="{{ url('/blogs') }}" method="GET"
      data-base-url="{{ url('/blogs') }}"
      data-server-category="{{ $isCategory ? $category->slug : '' }}">
    <div class="gp-search-line">
        <label>Search the blog
            <div class="gp-search-input">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by blog title" >
                <button class="gp-button" type="submit">Search</button>
            </div>
        </label>
        <label>Browse topics
            <select name="category">
                <option value="all">All articles</option>
                @foreach($cats as $cat)
                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </label>
    </div>
    <div class="gp-pills">
        <button type="button" data-category="all" class="gp-button active" aria-pressed="true">All articles</button>
        @foreach($cats as $cat)
            <button type="button" data-category="{{ $cat->slug }}" class="gp-button gp-outline" aria-pressed="false">{{ $cat->name }}</button>
        @endforeach
    </div>
</form>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container">
                <h2 class="gp-underline">Explore the latest SEO guides</h2>
                <div class="gp-between">
                    <p>Compare link building approaches, find ideas for keyword research or get familiar with SEO titles.<br>Choose a guide that fits the work in front of you.</p><small data-blog-count aria-live="polite">{{ count($blogs) }} {{ count($blogs) === 1 ? 'article' : 'articles' }}</small>
                </div>
                <div class="gp-grid gp-cols-3">
    @forelse($blogs as $blog)
        <article class="gp-post" data-post
                 data-category="{{ $blog->blogCategory->slug ?? '' }}"
                 data-search="{{ \Illuminate\Support\Str::lower(strip_tags($blog->title.' '.$blog->excerpt.' '.$blog->tags.' '.($blog->blogCategory->name ?? ''))) }}">
            <a href="{{ url('blog/' . $blog->slug) }}">
                <img class="gp-art gp-thumb"
                     src="{{ $blog->feature_image ? asset('blog_images/' . $blog->feature_image) : asset('/images/blog/blog-hero.png') }}"
                     alt="{{ $blog->feature_image_alt ?: $blog->title }}" width="534" height="308" loading="lazy">
            </a>
            <span class="gp-pill">{{ $blog->blogCategory->name ?? 'General' }}</span>
            <h2><a href="{{ url('blog/' . $blog->slug) }}">{{ $blog->title }}</a></h2>
            <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $blog->excerpt), 160) }}</p>
            <div class="gp-meta">{{ $blog->admin->name ?? 'GPSites' }} · {{ optional($blog->created_at)->format('M d, Y') }}</div>
            <a class="gp-link" href="{{ url('blog/' . $blog->slug) }}">Read more →</a>
        </article>
    @empty
        <p>No articles are available yet.</p>
    @endforelse
</div>
<div data-blog-empty hidden>
    <p>No articles match your search. Try a broader keyword or view all articles.</p>
    <button class="gp-button" data-blog-reset type="button">View all articles</button>
</div>
                <div data-blog-empty hidden>
                    <p>No articles match your search. Try a broader keyword or view all articles.</p><button class="gp-button" data-blog-reset type="button">View all articles</button>
                </div>
            </div>
        </section>
        <section class="gp-section gp-tint">
            <div class="gp-container">
                <div class="gp-blog-about"><img class="gp-art" src="{{ asset('/images/blog/blog-about.png') }}" alt="" width="299" height="163" loading="lazy">
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
                    </div><img class="gp-art" src="{{ asset('/images/blog/blog-cta.png') }}" alt="" width="193" height="141" loading="lazy">
                </div>
            </div>
        </section>
    </div>
</div>

<script>
(function () {
    var form = document.querySelector('[data-blog-search]');
    if (!form) return;

    var input   = form.querySelector('input[name="search"]');
    var select  = form.querySelector('select[name="category"]');
    var pills   = [].slice.call(form.querySelectorAll('[data-category]'));
    var posts   = [].slice.call(document.querySelectorAll('[data-post]'));
    var countEl = document.querySelector('[data-blog-count]');
    var emptyEl = document.querySelector('[data-blog-empty]');
    var resetBt = document.querySelector('[data-blog-reset]');

    var baseUrl   = form.getAttribute('data-base-url');
    var serverCat = form.getAttribute('data-server-category') || '';
    var known     = [].map.call(select.options, function (o) { return o.value; });

    var params = new URLSearchParams(window.location.search);
    var state = {
        q: (params.get('search') || '').trim(),
        cat: params.get('category') || serverCat || 'all'
    };
    if (known.indexOf(state.cat) === -1) state.cat = 'all';

    function apply() {
        var q = state.q.trim().toLowerCase(), shown = 0;

        posts.forEach(function (p) {
            var okCat = state.cat === 'all' || p.getAttribute('data-category') === state.cat;
            var okQ   = !q || p.getAttribute('data-search').indexOf(q) > -1;
            p.hidden = !(okCat && okQ);
            if (!p.hidden) shown++;
        });

        if (countEl) countEl.textContent = shown + (shown === 1 ? ' article' : ' articles');
        if (emptyEl) emptyEl.hidden = shown !== 0;

        select.value = state.cat;
        pills.forEach(function (b) {
            var on = b.getAttribute('data-category') === state.cat;
            b.classList.toggle('active', on);
            b.classList.toggle('gp-outline', !on);
            b.setAttribute('aria-pressed', on ? 'true' : 'false');
        });

        var next = new URLSearchParams();
        if (q) next.set('search', state.q.trim());
        if (state.cat !== 'all' && state.cat !== serverCat) next.set('category', state.cat);
        var qs = next.toString();
        history.replaceState(null, '', window.location.pathname + (qs ? '?' + qs : ''));
    }

    function setCategory(slug) {
        // On /blogs/category/{slug} only that category is loaded, so go back to /blogs
        if (serverCat && slug !== serverCat) {
            var qs = new URLSearchParams();
            if (slug !== 'all') qs.set('category', slug);
            if (state.q.trim()) qs.set('search', state.q.trim());
            window.location.href = baseUrl + (qs.toString() ? '?' + qs.toString() : '');
            return;
        }
        state.cat = slug;
        apply();
    }

    pills.forEach(function (b) {
        b.addEventListener('click', function () { setCategory(b.getAttribute('data-category')); });
    });
    select.addEventListener('change', function () { setCategory(select.value); });

    // keep the raw value (including spaces) while typing
    input.addEventListener('input', function () { state.q = input.value; apply(); });
    form.addEventListener('submit', function (e) { e.preventDefault(); state.q = input.value; apply(); });

    if (resetBt) resetBt.addEventListener('click', function () {
        if (serverCat) { window.location.href = baseUrl; return; }
        state.q = ''; state.cat = 'all';
        input.value = '';
        apply();
    });

    input.value = state.q;   // set once on page load only
    apply();
})();
</script>
@endsection