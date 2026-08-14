@extends('layouts.web.main-layout')

@section('title', 'Blogs')
@section('description',
    'Scale up your link-building outreach with our one-stop AI-powered outreach automation,
    link-building, and guest posting marketplace.')
@section('keywords',
    'Link Building Outreach Automation​, Outreach Automation, Link Building Outreach Tool, outreach
    automation tool​, automated outreach system​, backlink marketplace, backlinks websites, outreach automation tool')
@section('indexing', 'no')

@section('content')

    <style>
        /* ----- SMOOTH CARD HOVER EFFECTS ----- */
        .blog-card {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            background: white;
            border-radius: 1rem;
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
            cursor: pointer;
            will-change: transform;
        }

        /* Card glow effect on hover */
        .blog-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 1rem;
            padding: 2px;
            background: linear-gradient(135deg, rgba(71, 19, 150, 0.3), rgba(177, 59, 255, 0.3));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .blog-card:hover::before {
            opacity: 1;
        }

        /* Card hover transform */
        .blog-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow:
                0 20px 40px -12px rgba(71, 19, 150, 0.2),
                0 10px 20px -8px rgba(71, 19, 150, 0.08);
            border-color: rgba(71, 19, 150, 0.15);
        }

        /* Image section hover */
        .blog-card .card-image {
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .blog-card:hover .card-image {
            background: linear-gradient(135deg, rgba(71, 19, 150, 0.05), rgba(177, 59, 255, 0.08));
        }

        .blog-card .card-image .emoji-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .blog-card:hover .card-image .emoji-wrapper {
            transform: scale(1.15) rotate(-3deg);
        }

        /* Category badge hover */
        .blog-card .category-badge {
            transition: all 0.3s ease;
            background: rgba(71, 19, 150, 0.08);
            backdrop-filter: blur(4px);
            font-weight: 500;
            letter-spacing: 0.025em;
            border: 1px solid rgba(71, 19, 150, 0.1);
            color: #471396;
        }

        .blog-card:hover .category-badge {
            background: rgba(71, 19, 150, 0.15);
            border-color: rgba(71, 19, 150, 0.2);
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(71, 19, 150, 0.1);
        }

        /* Title hover */
        .blog-card .card-title {
            transition: color 0.3s ease;
        }

        .blog-card:hover .card-title {
            color: #471396;
        }

        /* Author section hover */
        .blog-card .card-footer {
            transition: all 0.3s ease;
            border-top-color: rgba(71, 19, 150, 0.05);
        }

        .blog-card:hover .card-footer {
            border-top-color: rgba(71, 19, 150, 0.15);
        }

        /* Read more indicator */
        .blog-card .read-more {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #471396;
            font-weight: 600;
            font-size: 0.875rem;
            opacity: 0;
            transform: translateX(-8px);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            margin-top: 0.5rem;
        }

        .blog-card:hover .read-more {
            opacity: 1;
            transform: translateX(0);
        }

        .blog-card .read-more i {
            transition: transform 0.3s ease;
        }

        .blog-card:hover .read-more i {
            transform: translateX(4px);
        }

        /* Card content overlay shine */
        .blog-card .card-shine {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 30%,
                    rgba(255, 255, 255, 0.1) 0%,
                    transparent 60%);
            opacity: 0;
            transition: opacity 0.6s ease;
            pointer-events: none;
        }

        .blog-card:hover .card-shine {
            opacity: 1;
        }

        /* Smooth image background transition */
        .blog-card .card-image-bg {
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            background: linear-gradient(135deg, #f8fafc, #f3edf9);
        }

        .blog-card:hover .card-image-bg {
            background: linear-gradient(135deg, rgba(71, 19, 150, 0.05), rgba(177, 59, 255, 0.1));
        }

        /* ---- EXISTING STYLES ---- */
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(71, 19, 150, 0.15);
            border-color: #471396;
        }

        .hero-gradient {
            background: linear-gradient(145deg, #f8fafc 0%, #f3edf9 100%);
        }

        .empty-icon {
            opacity: 0.5;
        }

        /* ----- CUSTOM DROPDOWN STYLES ----- */
        .custom-dropdown {
            position: relative;
            min-width: 180px;
            flex-shrink: 0;
        }

        .dropdown-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            color: #1e293b;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            user-select: none;
            white-space: nowrap;
        }

        .dropdown-trigger:hover {
            border-color: #471396;
        }

        .dropdown-trigger:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(71, 19, 150, 0.2);
            border-color: #471396;
        }

        .dropdown-trigger .arrow {
            margin-left: 0.5rem;
            transition: transform 0.2s ease;
            color: #94a3b8;
            flex-shrink: 0;
        }

        .dropdown-trigger.open .arrow {
            transform: rotate(180deg);
        }

        .dropdown-trigger .selected-label {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            text-align: left;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 12px 30px -8px rgba(71, 19, 150, 0.12);
            padding: 0.4rem 0;
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px) scale(0.97);
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top center;
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.96);
            min-width: 100%;
        }

        .dropdown-menu.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.25rem;
            font-size: 0.875rem;
            color: #334155;
            cursor: pointer;
            transition: background 0.12s ease;
        }

        .dropdown-item:hover {
            background: #f3edf9;
        }

        .dropdown-item.active {
            background: #ede7f5;
            color: #471396;
            font-weight: 500;
        }

        .dropdown-item .item-icon {
            width: 1.2rem;
            text-align: center;
            color: #64748b;
            flex-shrink: 0;
        }

        .dropdown-item.active .item-icon {
            color: #471396;
        }

        .dropdown-item .check-mark {
            margin-left: auto;
            color: #471396;
            opacity: 0;
            transition: opacity 0.15s;
            flex-shrink: 0;
        }

        .dropdown-item.active .check-mark {
            opacity: 1;
        }

        /* ----- SKELETON LOADING STYLES ----- */
        .skeleton {
            background: linear-gradient(90deg,
                    #f0f0f0 25%,
                    #e0e0e0 50%,
                    #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s ease-in-out infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .skeleton-card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            opacity: 0;
            animation: fadeIn 0.3s ease forwards;
        }

        .skeleton-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .skeleton-card:nth-child(2) {
            animation-delay: 0.10s;
        }

        .skeleton-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .skeleton-card:nth-child(4) {
            animation-delay: 0.20s;
        }

        .skeleton-card:nth-child(5) {
            animation-delay: 0.25s;
        }

        .skeleton-card:nth-child(6) {
            animation-delay: 0.30s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .skeleton-image {
            height: 112px;
            background: linear-gradient(90deg,
                    #f0f0f0 25%,
                    #e8e8e8 50%,
                    #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s ease-in-out infinite;
        }

        .skeleton-title {
            height: 20px;
            width: 85%;
            margin-bottom: 8px;
        }

        .skeleton-excerpt {
            height: 14px;
            width: 100%;
            margin-bottom: 6px;
        }

        .skeleton-excerpt.short {
            width: 75%;
        }

        .skeleton-badge {
            height: 22px;
            width: 80px;
            border-radius: 9999px;
            margin-bottom: 12px;
        }

        .skeleton-author {
            height: 14px;
            width: 120px;
        }

        .skeleton-date {
            height: 14px;
            width: 100px;
        }

        /* responsive fixes */
        @media (max-width: 640px) {
            .custom-dropdown {
                min-width: unset;
                width: 100%;
            }

            .dropdown-menu {
                left: 0;
                right: 0;
            }

            .blog-card:hover {
                transform: translateY(-4px) scale(1.01);
            }
        }

        /* ensure proper width on all screens */
        .search-wrapper {
            flex: 1 1 auto;
            min-width: 0;
        }

        @media (min-width: 640px) {
            .search-wrapper {
                flex: 1 1 0%;
            }
        }

        /* Loading state for grid */
        #blogGrid.loading .blog-card {
            opacity: 0.6;
            pointer-events: none;
        }

        #blogGrid .blog-card {
            transition: opacity 0.3s ease;
        }

        /* Card entry animation */
        .blog-card {
            opacity: 0;
            animation: cardEntry 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        @keyframes cardEntry {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Stagger delays for cards */
        .blog-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .blog-card:nth-child(2) {
            animation-delay: 0.10s;
        }

        .blog-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .blog-card:nth-child(4) {
            animation-delay: 0.20s;
        }

        .blog-card:nth-child(5) {
            animation-delay: 0.25s;
        }

        .blog-card:nth-child(6) {
            animation-delay: 0.30s;
        }

        .blog-card:nth-child(7) {
            animation-delay: 0.35s;
        }

        .blog-card:nth-child(8) {
            animation-delay: 0.40s;
        }

        .blog-card:nth-child(9) {
            animation-delay: 0.45s;
        }
    </style>

    <section class="relative min-h-screen flex items-center justify-center overflow-hidden lg:py-16 py-12 px-6">
        <div class="container mx-auto">

            <!-- Header -->
            <div class="hero-gradient rounded-3xl p-6 sm:p-10 mb-10 md:mb-14 border border-white/40 shadow-sm text-center">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight">
                    <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Blog</span>
                    <span class="text-slate-700">Hub</span>
                </h1>
                <p class="text-slate-500 mt-1 text-sm sm:text-base max-w-xl mx-auto">
                    <i class="fas fa-compass text-primary-light mr-1.5"></i> Explore stories · filter by topic · search
                    anything
                </p>
                <div
                    class="inline-flex items-center gap-2 mt-3 text-xs text-slate-400 bg-white/60 px-4 py-1.5 rounded-full border border-primary/10 backdrop-blur-sm">
                    <i class="fas fa-newspaper text-primary"></i>
                    <span><span id="postCount" class="font-semibold text-slate-600">9</span> articles</span>
                </div>
            </div>

            <!-- Centered Search + Custom Dropdown -->
            <div class="max-w-4xl mx-auto mb-10 sm:mb-12 px-4 sm:px-0">
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-stretch">

                    <!-- Search -->
                    <div class="search-wrapper relative flex-1 min-w-0">
                        <form action="{{ url('/blogs') }}" method="GET" class="search-wrapper relative flex-1 min-w-0">
                            <i
                                class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none">
                            </i>

                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Search blog posts..."
                                class="search-input w-full h-11 sm:h-12 bg-white border border-slate-200 rounded-xl sm:rounded-full
               py-2.5 pl-11 pr-4 text-sm sm:text-base text-slate-700
               focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary
               transition-all duration-200 placeholder:text-slate-400 shadow-sm" />
                        </form>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="custom-dropdown relative w-full sm:w-56 lg:w-64" id="categoryDropdown">
                        <button type="button"
                            class="dropdown-trigger w-full h-11 sm:h-12 flex items-center justify-between
                       gap-3 px-4 bg-white border border-slate-200 rounded-xl sm:rounded-full
                       text-sm sm:text-base text-slate-700 shadow-sm
                       hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20
                       transition-all duration-200"
                            id="dropdownTrigger" aria-haspopup="true" aria-expanded="false">
                            <span class="selected-label truncate text-left" id="selectedLabel">
                                📋 All categories
                            </span>
                            <span class="arrow shrink-0 text-slate-400 transition-transform duration-200">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </span>
                        </button>

                        <div class="dropdown-menu absolute z-50 left-0 right-0 mt-2 bg-white border border-slate-200
                       rounded-xl shadow-lg overflow-hidden"
                            id="dropdownMenu" role="listbox">
                            <!-- items injected by JS -->
                        </div>
                    </div>

                </div>
            </div>

            <!-- Blog Grid with Skeleton Loading -->
            <div id="blogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <!-- Skeleton cards will be shown initially -->
            </div>

            <!-- Empty State -->
            <div id="emptyState"
                class="hidden text-center py-16 mt-6 bg-white/60 rounded-3xl border border-primary/10 backdrop-blur-sm">
                <div class="empty-icon text-5xl text-primary/30 mb-4"><i class="fas fa-search"></i></div>
                <p class="text-slate-600 text-lg font-semibold">No posts found</p>
                <p class="text-slate-400 text-sm mt-1 max-w-xs mx-auto">Try a different keyword or category</p>
            </div>

            <!-- Footer -->
            <div
                class="mt-16 text-center text-xs text-slate-400 border-t border-primary/10 pt-6 flex flex-wrap justify-center gap-4">
                <span><i class="fas fa-sync-alt text-primary/40 mr-1"></i> live filter</span>
                <span><i class="fas fa-mobile-alt text-primary/40 mr-1"></i> fully responsive</span>
                <span>custom dropdown · vanilla js</span>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    @php
        $blogData = $blogs
            ->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title ?? '',
                    'slug' => $blog->slug ?? '',
                    'excerpt' => $blog->excerpt ?? '',
                    'category' => $blog->blogCategory->name ?? '',
                    'categorySlug' => $blog->blogCategory->slug ?? '',
                    'date' => $blog->created_at ? $blog->created_at->format('M d, Y') : 'N/A',
                    // 'readTime' => '6 min read',
                    'author' => $blog->admin->name ?? '',
                    'emoji' => '⚛️',
                    'image' => asset('blog_images/' . $blog->feature_image ?? null),
                    'imageAlt' => $blog->feature_image_alt ?? null
                ];
            })
            ->values()
            ->toArray();

        $categoryData = $blogCategory
            ->map(function ($category) {
                return [
                    'value' => $category->slug,
                    'label' => $category->name,
                    'slug' => $category->slug,
                ];
            })
            ->values()
            ->toArray();
    @endphp
    <script>
        (function() {
            // ---------- BLOG DATA ----------
            const blogs = @json($blogData);

            console.log(blogs);
            //     {
            //         id: 2,
            //         title: "Design Systems: From Theory to Practice",
            //         excerpt: "Learn how to build scalable, consistent design systems that bridge the gap between design and development.",
            //         category: "design",
            //         date: "Apr 28, 2026",
            //         readTime: "8 min read",
            //         author: "Marcus Rivera",
            //         emoji: "🎨"
            //     },
            //     {
            //         id: 3,
            //         title: "The Pomodoro Technique 2.0",
            //         excerpt: "We revisit the classic productivity method and add modern twists to stay focused in a distracted world.",
            //         category: "productivity",
            //         date: "Apr 15, 2026",
            //         readTime: "4 min read",
            //         author: "Jamie Fox",
            //         emoji: "⏳"
            //     },
            //     {
            //         id: 4,
            //         title: "Minimalist Living in a Digital Age",
            //         excerpt: "How to declutter your digital life, reduce screen time, and find more meaning in everyday moments.",
            //         category: "lifestyle",
            //         date: "Mar 30, 2026",
            //         readTime: "5 min read",
            //         author: "Taylor Nguyen",
            //         emoji: "🌿"
            //     },
            //     {
            //         id: 5,
            //         title: "Building Accessible Web Components",
            //         excerpt: "Practical guidelines for crafting inclusive, accessible components that work for everyone.",
            //         category: "tech",
            //         date: "Mar 18, 2026",
            //         readTime: "7 min read",
            //         author: "Jordan Lee",
            //         emoji: "♿"
            //     },
            //     {
            //         id: 6,
            //         title: "Color Psychology in UI Design",
            //         excerpt: "Explore how color influences user perception and decision-making, with real-world case studies.",
            //         category: "design",
            //         date: "Mar 5, 2026",
            //         readTime: "6 min read",
            //         author: "Samira Patel",
            //         emoji: "🌈"
            //     },
            //     {
            //         id: 7,
            //         title: "Notion as a Second Brain",
            //         excerpt: "A comprehensive guide to organizing your life and work using Notion's powerful database features.",
            //         category: "productivity",
            //         date: "Feb 20, 2026",
            //         readTime: "9 min read",
            //         author: "Chris Wong",
            //         emoji: "🧠"
            //     },
            //     {
            //         id: 8,
            //         title: "Mindful Eating: A Journey to Better Health",
            //         excerpt: "Small changes in your eating habits can lead to significant improvements in physical and mental well-being.",
            //         category: "lifestyle",
            //         date: "Feb 8, 2026",
            //         readTime: "4 min read",
            //         author: "Dr. Elena Ross",
            //         emoji: "🥗"
            //     },
            //     {
            //         id: 9,
            //         title: "The Future of AI in Creative Coding",
            //         excerpt: "How generative AI is reshaping the creative coding landscape and opening new possibilities for artists.",
            //         category: "tech",
            //         date: "Jan 25, 2026",
            //         readTime: "5 min read",
            //         author: "Alex Rivera",
            //         emoji: "🤖"
            //     }
            // ];

            // category config for dropdown
            let categories = @json($categoryData);
            // Add "All" category at the beginning
            categories.unshift({
                value: 'all',
                label: '📋 All categories',
                slug: ''
            });
            // [{
            //         value: 'all',
            //         label: '📋 All categories'
            //     },
            //     {
            //         value: 'tech',
            //         label: '💻 Tech'
            //     },
            //     {
            //         value: 'design',
            //         label: '🎨 Design'
            //     },
            //     {
            //         value: 'productivity',
            //         label: '⚡ Productivity'
            //     },
            //     {
            //         value: 'lifestyle',
            //         label: '🌿 Lifestyle'
            //     }
            // ];

            // DOM refs
            const grid = document.getElementById('blogGrid');
            const emptyState = document.getElementById('emptyState');
            // const searchInput = document.getElementById('searchInput');
            const postCount = document.getElementById('postCount');

            // Custom dropdown refs
            const dropdownTrigger = document.getElementById('dropdownTrigger');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const selectedLabel = document.getElementById('selectedLabel');

            // state
            let activeCategory = 'all';
            let searchQuery = '';
            let dropdownOpen = false;
            let isLoading = true;

            // ---------- SKELETON LOADING ----------
            function showSkeletons() {
                const skeletonHTML = Array(6).fill(0).map((_, index) => `
                <div class="skeleton-card" style="animation-delay: ${(index + 1) * 0.05}s">
                    <div class="skeleton-image"></div>
                    <div class="p-5">
                        <div class="skeleton skeleton-badge"></div>
                        <div class="skeleton skeleton-title"></div>
                        <div class="skeleton skeleton-excerpt"></div>
                        <div class="skeleton skeleton-excerpt short"></div>
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100">
                            <div class="skeleton skeleton-author"></div>
                            <div class="skeleton skeleton-date"></div>
                        </div>
                    </div>
                </div>
            `).join('');

                grid.innerHTML = skeletonHTML;
                grid.classList.add('loading');
            }

            // ---------- RENDER BLOG CARDS ----------
            function render() {
                // Show loading state
                grid.classList.add('loading');

                // Simulate loading delay (remove this in production)
                setTimeout(() => {
                    // filter by category
                    let filtered = blogs.filter(b => activeCategory === 'all' ? true : b.category ===
                        activeCategory);

                    // filter by search (title + excerpt)
                    const q = searchQuery.trim().toLowerCase();
                    if (q) {
                        filtered = filtered.filter(b =>
                            b.title.toLowerCase().includes(q) ||
                            b.excerpt.toLowerCase().includes(q)
                        );
                    }

                    // update post count
                    postCount.textContent = filtered.length;

                    // empty state
                    if (filtered.length === 0) {
                        grid.innerHTML = '';
                        grid.classList.remove('loading');
                        grid.classList.add('hidden');
                        emptyState.classList.remove('hidden');
                        return;
                    }

                    grid.classList.remove('hidden');
                    emptyState.classList.add('hidden');

                    // build cards with smooth hover effects
                    let html = '';
                    filtered.forEach((b) => {
                        html += `
                        <div class="blog-card group">
                            <!-- Shine effect overlay -->
                            <div class="card-shine"></div>
                            
                            <!-- Image section -->
                            
                           <!-- Image section -->
                           <a href="{{ url('blog') }}/${b.slug}" class="block">
                            <div class="card-image card-image-bg w-full h-48 overflow-hidden border-b border-primary/10">
                                <span class="emoji-wrapper drop-shadow-sm w-full h-full flex items-center justify-center">
                                    ${b.image ? 
                                        `<img src="${b.image}" alt="${b.imageAlt}" class="w-full h-full object-cover">` : 
                                        `<span class="text-6xl">${b.emoji || '📄'}</span>`
                                    }
                                </span>
                            </div>
                            </a>
                            <!-- Content -->
                            <div class="p-5 flex flex-col flex-1 relative">
                                <span class="category-badge inline-block px-3 py-1 rounded-full text-xs uppercase tracking-wider self-start mb-2.5">
                                    ${b.category}
                                </span>
                                <a href="{{ url('blog') }}/${b.slug}" class="block">
                                <h3 class="card-title text-lg font-bold text-slate-800 leading-snug mb-1.5 line-clamp-2">
                                    ${b.title}
                                </h3>
                                </a>
                                <p class="text-sm text-slate-500 leading-relaxed flex-1 mb-3 line-clamp-3">
                                    ${b.excerpt }
                                </p>
                                
                                <!-- Read more indicator -->
                                <a href="{{ url('blog') }}/${b.slug}" class="block">
                                    <div class="read-more">
                                        Read more <i class="fas fa-arrow-right"></i>
                                    </div>
                                </a>
                                <!-- Footer -->
                                <div class="card-footer flex items-center justify-between text-xs text-slate-400 border-t border-primary/10 pt-3 mt-2">
                                    <span class="font-medium text-slate-600">
                                        <i class="far fa-user-circle mr-1"></i>${b.author}
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <span>${b.date}</span> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                    });

                    grid.innerHTML = html;
                    grid.classList.remove('loading');
                    isLoading = false;
                }, 400); // Simulated loading delay - remove in production
            }

            // ---------- BUILD CUSTOM DROPDOWN MENU ----------
            function buildDropdown() {
                let itemsHtml = '';
                categories.forEach(cat => {
                    const isActive = cat.value === activeCategory;
                    itemsHtml += `
                    <a href="{{ url('/blogs') }}?search=${cat.slug}"> <div class="dropdown-item ${isActive ? 'active' : ''}" data-value="${cat.value}" role="option" aria-selected="${isActive}">
                        <span class="item-icon">${cat.label}</span> 
                        <span class="check-mark"><i class="fas fa-check"></i></span>
                    </div></a>
                `;
                });
                dropdownMenu.innerHTML = itemsHtml;
                // update trigger label
                const activeCat = categories.find(c => c.value === activeCategory);
                selectedLabel.textContent = activeCat ? activeCat.label : '📋 All categories';
            }

            // ---------- DROPDOWN TOGGLE ----------
            function toggleDropdown(forceState) {
                const open = (forceState !== undefined) ? forceState : !dropdownOpen;
                dropdownOpen = open;
                dropdownMenu.classList.toggle('open', dropdownOpen);
                dropdownTrigger.classList.toggle('open', dropdownOpen);
                dropdownTrigger.setAttribute('aria-expanded', dropdownOpen);
            }

            // ---------- SELECT CATEGORY ----------
            function selectCategory(value) {
                if (activeCategory === value) {
                    toggleDropdown(false);
                    return;
                }
                activeCategory = value;
                // update dropdown items active state
                const items = dropdownMenu.querySelectorAll('.dropdown-item');
                items.forEach(item => {
                    const val = item.getAttribute('data-value');
                    const isActive = val === value;
                    item.classList.toggle('active', isActive);
                    item.setAttribute('aria-selected', isActive);
                });
                // update trigger label
                const cat = categories.find(c => c.value === value);
                if (cat) selectedLabel.textContent = cat.label;
                // close dropdown
                toggleDropdown(false);
                // re-render blogs
                render();
            }

            // ---------- EVENT LISTENERS ----------
            // 1) Dropdown trigger click
            dropdownTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleDropdown();
            });

            // 2) Dropdown item click (event delegation)
            dropdownMenu.addEventListener('click', function(e) {
                const item = e.target.closest('.dropdown-item');
                if (!item) return;
                const value = item.getAttribute('data-value');
                if (value) selectCategory(value);
            });

            // 3) Close dropdown on outside click
            document.addEventListener('click', function(e) {
                const container = document.getElementById('categoryDropdown');
                if (!container.contains(e.target) && dropdownOpen) {
                    toggleDropdown(false);
                }
            });

            // 4) Keyboard: Escape to close
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && dropdownOpen) {
                    toggleDropdown(false);
                    dropdownTrigger.focus();
                }
            });

            // 5) Search with debounce
            // let debounce;
            // searchInput.addEventListener('input', function() {
            //     clearTimeout(debounce);
            //     grid.classList.add('loading');
            //     debounce = setTimeout(() => {
            //         searchQuery = this.value;
            //         render();
            //     }, 300);
            // });

            // ---------- INIT ----------
            // Show skeletons first
            showSkeletons();

            // Build dropdown
            buildDropdown();

            // Load actual content after initial delay
            setTimeout(() => {
                render();
            }, 600);

            // Add keyframe animation to the page if not exists
            if (!document.getElementById('skeleton-keyframes')) {
                const style = document.createElement('style');
                style.id = 'skeleton-keyframes';
                style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
                document.head.appendChild(style);
            }

        })();
    </script>

@endsection
