@extends('layouts.web.main-layout')

@section('content')

<!-- Reading Progress -->
<div id="readingProgressModern" class="fixed top-0 left-0 h-1 z-[1000] bg-gradient-to-r from-[#6C3CE1] via-[#8B5CF6] to-[#A78BFA] shadow-[0_2px_12px_rgba(108,60,225,0.3)] transition-[width] duration-75 ease-linear" style="width:0%;"></div>

<!-- Back to Top -->
<button id="backToTopModern" class="fixed bottom-8 right-8 w-12 h-12 rounded-full bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] text-white border-none shadow-[0_4px_24px_rgba(108,60,225,0.35)] cursor-pointer opacity-0 invisible scale-90 transition-all duration-300 z-[999] flex items-center justify-center text-lg hover:scale-110 hover:-translate-y-1 hover:shadow-[0_8px_32px_rgba(108,60,225,0.45)]" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- ===== MAIN WRAPPER ===== -->
<section class="bg-slate-50 py-10 md:py-14  px-4">
    <div class="blog-post-wrapper container mx-auto mx-auto">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-slate-400 pb-6 flex-wrap border-b border-slate-100/40 mb-8" aria-label="Breadcrumb">
        <a href="javascript:void(0)" onclick="goToBlogIndex()" class="text-[#6C3CE1] font-medium hover:text-[#4A1A8A] hover:underline transition-all duration-200 cursor-pointer"><i class="fas fa-home"></i> Blog</a>
        <span class="text-slate-300 text-xs"><i class="fas fa-chevron-right"></i></span>
        <a href="javascript:void(0)" onclick="filterByCategory('digital-marketing')" class="text-[#6C3CE1] font-medium hover:text-[#4A1A8A] hover:underline transition-all duration-200 cursor-pointer">Digital Marketing</a>
        <span class="text-slate-300 text-xs"><i class="fas fa-chevron-right"></i></span>
        <span class="text-slate-700 font-semibold truncate">The Ultimate Guide to Link Building in 2026</span>
    </nav>

    <!-- Grid -->
    <div class="grid grid-cols-1 lgg:grid-cols-[260px_1fr_250px] gap-4 items-start">

        <!-- ===== LEFT SIDEBAR - TABLE OF CONTENTS ===== -->
        <aside class="hidden lgg:block sticky top-20">
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.02)]">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-900 uppercase tracking-wider pb-3 border-b-2 border-slate-100 mb-5">
                    <i class="fas fa-list-ul text-[#6C3CE1] text-sm"></i>
                    Table of Contents
                </div>
                <ul class="list-none p-0 m-0" id="tocList">
                    <li class="py-1.5 border-b border-slate-50">
                        <a href="#section-intro" class="active flex items-center gap-2.5 text-slate-600 text-sm no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-intro">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200 group-hover:bg-[#6C3CE1] group-hover:w-2 group-hover:h-2"></span>
                            Introduction
                        </a>
                    </li>
                    <li class="py-1.5 border-b border-slate-50">
                        <a href="#section-why" class="flex items-center gap-2.5 text-slate-600 text-sm no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-why">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200"></span>
                            Why Link Building Still Matters
                        </a>
                    </li>
                    <li class="pl-6 py-1 border-b border-slate-50">
                        <a href="#section-evolving" class="flex items-center gap-2.5 text-slate-400 text-xs no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-evolving">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200"></span>
                            The Evolving Landscape
                        </a>
                    </li>
                    <li class="py-1.5 border-b border-slate-50">
                        <a href="#section-strategies" class="flex items-center gap-2.5 text-slate-600 text-sm no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-strategies">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200"></span>
                            Top Link Building Strategies
                        </a>
                    </li>
                    <li class="pl-6 py-1 border-b border-slate-50">
                        <a href="#section-skyscraper" class="flex items-center gap-2.5 text-slate-400 text-xs no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-skyscraper">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200"></span>
                            Skyscraper Technique 2.0
                        </a>
                    </li>
                    <li class="pl-6 py-1 border-b border-slate-50">
                        <a href="#section-data" class="flex items-center gap-2.5 text-slate-400 text-xs no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-data">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200"></span>
                            Data-Driven Content
                        </a>
                    </li>
                    <li class="pl-6 py-1 border-b border-slate-50">
                        <a href="#section-guest" class="flex items-center gap-2.5 text-slate-400 text-xs no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-guest">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200"></span>
                            Strategic Guest Posting
                        </a>
                    </li>
                    <li class="py-1.5 border-b border-slate-50">
                        <a href="#section-mistakes" class="flex items-center gap-2.5 text-slate-600 text-sm no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-mistakes">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200"></span>
                            Common Mistakes to Avoid
                        </a>
                    </li>
                    <li class="py-1.5">
                        <a href="#section-measuring" class="flex items-center gap-2.5 text-slate-600 text-sm no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="section-measuring">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200 flex-shrink-0 transition-all duration-200"></span>
                            Measuring Your Success
                        </a>
                    </li>
                </ul>
                <div class="mt-5 pt-4 border-t border-slate-100">
                    <div class="flex justify-between text-xs text-slate-400 mb-1.5">
                        <span>Reading Progress</span>
                        <span id="tocProgressText">0%</span>
                    </div>
                    <div class="w-full h-1 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-[#6C3CE1] to-[#8B5CF6] rounded-full transition-[width] duration-200 ease" id="tocProgressFill" style="width:0%;"></div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <div class="min-w-0">

            <!-- Mobile TOC -->
            <div class="lgg:hidden mb-8">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.02)]">
                    <div class="flex justify-between items-center cursor-pointer font-bold text-slate-900 text-sm" onclick="toggleMobileTOC()">
                        <span><i class="fas fa-list-ul text-[#6C3CE1]"></i> Table of Contents</span>
                        <i class="fas fa-chevron-down text-[#6C3CE1] transition-transform duration-300"></i>
                    </div>
                    <ul class="list-none p-0 m-0 max-h-0 overflow-hidden transition-[max-height] duration-300" id="mobileTocList">
                        <li class="py-1.5 border-b border-slate-50"><a href="#section-intro" class="text-slate-600 text-sm no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">Introduction</a></li>
                        <li class="py-1.5 border-b border-slate-50"><a href="#section-why" class="text-slate-600 text-sm no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">Why Link Building Still Matters</a></li>
                        <li class="pl-5 py-1 border-b border-slate-50"><a href="#section-evolving" class="text-slate-400 text-xs no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">The Evolving Landscape</a></li>
                        <li class="py-1.5 border-b border-slate-50"><a href="#section-strategies" class="text-slate-600 text-sm no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">Top Link Building Strategies</a></li>
                        <li class="pl-5 py-1 border-b border-slate-50"><a href="#section-skyscraper" class="text-slate-400 text-xs no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">Skyscraper Technique 2.0</a></li>
                        <li class="pl-5 py-1 border-b border-slate-50"><a href="#section-data" class="text-slate-400 text-xs no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">Data-Driven Content</a></li>
                        <li class="pl-5 py-1 border-b border-slate-50"><a href="#section-guest" class="text-slate-400 text-xs no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">Strategic Guest Posting</a></li>
                        <li class="py-1.5 border-b border-slate-50"><a href="#section-mistakes" class="text-slate-600 text-sm no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">Common Mistakes to Avoid</a></li>
                        <li class="py-1.5"><a href="#section-measuring" class="text-slate-600 text-sm no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50">Measuring Your Success</a></li>
                    </ul>
                </div>
            </div>

            <!-- Post Header -->
            <header class="mb-8">
                <div class="text-5xl mb-2 inline-block">🚀</div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight my-2 tracking-tight">The Ultimate Guide to Link Building in 2026</h1>

                <div class="flex flex-wrap items-center gap-3 md:gap-5 py-4 border-t border-b border-slate-100 mb-2">
                    <span class="flex items-center gap-2 text-slate-600 text-sm">
                        <i class="fas fa-user-circle text-[#6C3CE1]"></i>
                        <span>By <span class="font-semibold text-slate-900">Sarah Johnson</span></span>
                    </span>
                    <span class="flex items-center gap-2 text-slate-600 text-sm">
                        <i class="fas fa-calendar-alt text-[#6C3CE1]"></i>
                        <span>January 15, 2026</span>
                    </span>
                    <span class="flex items-center gap-2 text-slate-600 text-sm">
                        <i class="fas fa-clock text-[#6C3CE1]"></i>
                        <span>8 min read</span>
                    </span>
                    <span class="flex items-center gap-2 text-slate-600 text-sm">
                        <i class="fas fa-eye text-[#6C3CE1]"></i>
                        <span id="viewCountModern">12,847 views</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] text-white px-4 py-1 rounded-full text-xs font-semibold uppercase tracking-wide shadow-[0_2px_8px_rgba(108,60,225,0.25)] transition-transform duration-200 hover:scale-105 hover:shadow-[0_4px_16px_rgba(108,60,225,0.35)]">
                        <i class="fas fa-tag"></i> Digital Marketing
                    </span>
                </div>

                <div class="flex flex-wrap gap-2 mt-4">
                    <span class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs font-medium transition-all duration-200 cursor-pointer hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1] hover:-translate-y-px" onclick="filterByTag('link-building')">#link-building</span>
                    <span class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs font-medium transition-all duration-200 cursor-pointer hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1] hover:-translate-y-px" onclick="filterByTag('seo')">#seo</span>
                    <span class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs font-medium transition-all duration-200 cursor-pointer hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1] hover:-translate-y-px" onclick="filterByTag('digital-marketing')">#digital-marketing</span>
                    <span class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs font-medium transition-all duration-200 cursor-pointer hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1] hover:-translate-y-px" onclick="filterByTag('outreach')">#outreach</span>
                </div>
            </header>

            <!-- Featured Image -->
            <div class="relative rounded-2xl overflow-hidden mb-10 shadow-[0_12px_40px_rgba(0,0,0,0.06)] bg-slate-100 group">
                <img src="https://images.unsplash.com/photo-1432889821006-6d2a5bd3f6c0?w=1200&q=80" alt="Link Building Guide 2026" loading="lazy" class="w-full h-auto max-h-[480px] object-cover transition-transform duration-700 group-hover:scale-105">
                <span class="absolute bottom-6 left-6 bg-black/60 backdrop-blur-md text-white px-4 py-1.5 rounded-full text-xs font-medium border border-white/10">
                    <i class="fas fa-camera"></i> Featured
                </span>
            </div>

            <!-- Content -->
            <div class="bg-white rounded-2xl p-5 md:p-8 lg:p-10 shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100">

                <p id="section-intro" class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">Link building remains one of the most critical factors for SEO success in 2026. But the landscape has evolved dramatically. Gone are the days of spammy directory submissions and low-quality guest posts. Today, it's all about building genuine relationships, creating remarkable content, and earning links that actually move the needle.</p>

                <div class="bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 rounded-2xl p-5 md:p-6 flex items-start gap-4 my-6">
                    <div class="text-2xl text-[#6C3CE1] flex-shrink-0 mt-0.5"><i class="fas fa-bullseye"></i></div>
                    <div>
                        <strong class="text-slate-800">Key Insight:</strong> <span class="text-slate-600">According to recent studies, pages with high-quality backlinks rank <strong class="text-slate-800">3.5x higher</strong> in search results than those with few or low-quality links.</span>
                    </div>
                </div>

                <h2 id="section-why" class="text-2xl md:text-3xl font-bold text-slate-900 mt-10 mb-4 tracking-tight pb-2 border-b-3 border-slate-100 scroll-mt-8">Why Link Building Still Matters</h2>
                <p class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">Even with Google's increasingly sophisticated algorithms, backlinks remain one of the top ranking factors. They serve as a vote of confidence from other websites, signaling to search engines that your content is valuable, credible, and worth ranking higher.</p>

                <h3 id="section-evolving" class="text-xl md:text-2xl font-semibold text-slate-800 mt-7 mb-3 scroll-mt-8">The Evolving Landscape</h3>
                <p class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">Link building in 2026 is less about quantity and more about quality. Search engines have become incredibly good at identifying manipulative link-building tactics. The focus now is on earning links through genuine value creation and relationship building.</p>

                <div class="bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 rounded-2xl p-5 md:p-6 flex items-start gap-4 my-6">
                    <div class="text-2xl text-[#6C3CE1] flex-shrink-0 mt-0.5"><i class="fas fa-lightbulb"></i></div>
                    <div>
                        <strong class="text-slate-800">Pro Tip:</strong> <span class="text-slate-600">Instead of chasing hundreds of low-quality links, focus on acquiring 10-20 high-authority, relevant backlinks that will provide lasting SEO value.</span>
                    </div>
                </div>

                <h2 id="section-strategies" class="text-2xl md:text-3xl font-bold text-slate-900 mt-10 mb-4 tracking-tight pb-2 border-b-3 border-slate-100 scroll-mt-8">Top Link Building Strategies for 2026</h2>

                <h3 id="section-skyscraper" class="text-xl md:text-2xl font-semibold text-slate-800 mt-7 mb-3 scroll-mt-8">1. The Skyscraper Technique 2.0</h3>
                <p class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">The skyscraper technique, pioneered by Brian Dean, is more relevant than ever. The modern approach involves identifying popular content in your niche, creating something significantly better, and then strategically promoting it to the right audience.</p>

                <div class="bg-slate-900 text-slate-200 p-5 md:p-6 rounded-xl overflow-x-auto font-mono text-sm leading-relaxed my-5">
                    // Modern Skyscraper Approach<br>
                    1. Find popular content with lots of backlinks<br>
                    2. Create something 10x better<br>
                    3. Add unique data, visuals, or insights<br>
                    4. Reach out to sites linking to the original<br>
                    5. Personalize outreach with specific value points
                </div>

                <h3 id="section-data" class="text-xl md:text-2xl font-semibold text-slate-800 mt-7 mb-3 scroll-mt-8">2. Data-Driven Content Marketing</h3>
                <p class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">Original research and data-driven content are link magnets. When you create unique data, surveys, or studies, you become a primary source that others want to cite. This approach builds authority and earns natural backlinks organically.</p>

                <h3 id="section-guest" class="text-xl md:text-2xl font-semibold text-slate-800 mt-7 mb-3 scroll-mt-8">3. Strategic Guest Posting</h3>
                <p class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">Guest posting isn't dead—it's evolved. The key is focusing on high-authority, relevant publications where you can provide genuine value to their audience. It's about building your personal brand and expertise, not just getting a link.</p>

                <h2 id="section-mistakes" class="text-2xl md:text-3xl font-bold text-slate-900 mt-10 mb-4 tracking-tight pb-2 border-b-3 border-slate-100 scroll-mt-8">Common Mistakes to Avoid</h2>
                <ul class="list-disc pl-6 text-slate-600 text-base leading-relaxed space-y-2 my-4">
                    <li><strong class="text-slate-700">Buying links:</strong> This can result in severe penalties from search engines.</li>
                    <li><strong class="text-slate-700">Ignoring relevance:</strong> Links from unrelated sites have minimal value and can look unnatural.</li>
                    <li><strong class="text-slate-700">Spamming comments:</strong> Comment spam is a waste of time and can harm your reputation.</li>
                    <li><strong class="text-slate-700">Neglecting link quality:</strong> One high-quality link is worth more than 100 low-quality ones.</li>
                </ul>

                <blockquote class="border-l-4 border-[#6C3CE1] pl-6 my-6 italic text-slate-600 bg-slate-50 p-5 rounded-xl border-l-4 border-[#6C3CE1]">
                    <p class="mb-0">"The best link building strategy is to create content so valuable that people can't help but link to it. Focus on being genuinely helpful, and the links will follow naturally."</p>
                    <footer class="mt-2 text-sm text-slate-500">— Sarah Johnson, SEO Strategist</footer>
                </blockquote>

                <h2 id="section-measuring" class="text-2xl md:text-3xl font-bold text-slate-900 mt-10 mb-4 tracking-tight pb-2 border-b-3 border-slate-100 scroll-mt-8">Measuring Your Link Building Success</h2>
                <p class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">Tracking your link building efforts is crucial. Key metrics to monitor include:</p>
                <ul class="list-disc pl-6 text-slate-600 text-base leading-relaxed space-y-2 my-4">
                    <li><strong class="text-slate-700">Domain Authority (DA)</strong> - Track improvements over time</li>
                    <li><strong class="text-slate-700">Referring Domains</strong> - Monitor growth in unique linking sites</li>
                    <li><strong class="text-slate-700">Organic Traffic</strong> - Correlate link growth with traffic increases</li>
                    <li><strong class="text-slate-700">Keyword Rankings</strong> - Track positions for target keywords</li>
                </ul>

                <p class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">Remember, link building is a long-term investment. Results take time, but the compounding effect of a strong backlink profile is invaluable for your SEO success.</p>

                <div class="bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 rounded-2xl p-5 md:p-6 flex items-start gap-4 my-6">
                    <div class="text-2xl text-[#6C3CE1] flex-shrink-0 mt-0.5"><i class="fas fa-rocket"></i></div>
                    <div>
                        <strong class="text-slate-800">Ready to start?</strong> <span class="text-slate-600">Begin by auditing your current backlink profile and identifying your top competitors' link sources. Then create a strategic plan to earn high-quality links that will boost your SEO performance.</span>
                    </div>
                </div>

                <!-- Post Footer Tags -->
                <div class="mt-10 pt-6 border-t border-slate-100">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-sm font-semibold text-slate-400 mr-2"><i class="fas fa-tags"></i> Tags:</span>
                        <a href="javascript:void(0)" onclick="filterByTag('link-building')" class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs no-underline transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]">#link-building</a>
                        <a href="javascript:void(0)" onclick="filterByTag('seo')" class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs no-underline transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]">#seo</a>
                        <a href="javascript:void(0)" onclick="filterByTag('digital-marketing')" class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs no-underline transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]">#digital-marketing</a>
                        <a href="javascript:void(0)" onclick="filterByTag('outreach')" class="bg-slate-100 text-slate-600 px-4 py-1 rounded-full text-xs no-underline transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]">#outreach</a>
                    </div>
                </div>
            </div>

            <!-- Post Footer Actions -->
            <div class="flex flex-wrap justify-between items-center gap-5 mt-10 pt-8 border-t-2 border-slate-100">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-sm font-medium text-slate-400 mr-1"><i class="fas fa-share-alt"></i> Share:</span>
                    <a href="#" class="w-9 h-9 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_6px_16px_rgba(108,60,225,0.15)] hover:border-[#6C3CE1] hover:text-[#6C3CE1] hover:bg-[#1DA1F2] hover:border-[#1DA1F2] hover:text-white" onclick="sharePost('twitter')" aria-label="Share on Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_6px_16px_rgba(108,60,225,0.15)] hover:border-[#6C3CE1] hover:text-[#6C3CE1] hover:bg-[#4267B2] hover:border-[#4267B2] hover:text-white" onclick="sharePost('facebook')" aria-label="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_6px_16px_rgba(108,60,225,0.15)] hover:border-[#6C3CE1] hover:text-[#6C3CE1] hover:bg-[#0A66C2] hover:border-[#0A66C2] hover:text-white" onclick="sharePost('linkedin')" aria-label="Share on LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <button class="w-9 h-9 rounded-full border border-slate-200 bg-white flex items-center justify-center text-slate-500 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_6px_16px_rgba(108,60,225,0.15)] hover:border-[#6C3CE1] hover:text-[#6C3CE1] hover:bg-[#6C3CE1] hover:border-[#6C3CE1] hover:text-white" onclick="copyLink()" aria-label="Copy link">
                        <i class="fas fa-link"></i>
                    </button>
                </div>

                <div class="flex gap-3">
                    <a href="javascript:void(0)" onclick="navigateToPost('prev')" class="flex items-center gap-2 px-5 py-2 rounded-full bg-slate-100 text-slate-700 font-medium text-sm border-none cursor-pointer transition-all duration-300 no-underline hover:bg-[#6C3CE1] hover:text-white hover:-translate-x-1 hover:shadow-[0_4px_12px_rgba(108,60,225,0.25)]">
                        <i class="fas fa-arrow-left"></i> Previous
                    </a>
                    <a href="javascript:void(0)" onclick="navigateToPost('next')" class="flex items-center gap-2 px-5 py-2 rounded-full bg-slate-100 text-slate-700 font-medium text-sm border-none cursor-pointer transition-all duration-300 no-underline hover:bg-[#6C3CE1] hover:text-white hover:translate-x-1 hover:shadow-[0_4px_12px_rgba(108,60,225,0.25)]">
                        Next <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- ===== FEATURED AUTHOR BLOCK ===== -->
            <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] mt-10 transition-shadow duration-300 hover:shadow-[0_8px_32px_rgba(0,0,0,0.06)]">
                <div class="flex flex-col sm:flex-row gap-5 items-start">
                    <div class="w-20 h-20 rounded-full flex-shrink-0 bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] flex items-center justify-center text-white text-3xl font-bold shadow-[0_4px_20px_rgba(108,60,225,0.25)] relative">
                        SJ
                        <span class="absolute bottom-1 right-1 w-[18px] h-[18px] bg-green-500 rounded-full border-3 border-white shadow-[0_2px_8px_rgba(34,197,94,0.4)]"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 md:gap-4 mb-1">
                            <h4 class="text-xl font-bold text-slate-900 m-0">Sarah Johnson</h4>
                            <span class="bg-gradient-to-br from-amber-400 to-amber-500 text-slate-900 text-[0.6rem] font-bold px-3 py-0.5 rounded-full uppercase tracking-wide"><i class="fas fa-star"></i> Top Contributor</span>
                            <span class="bg-slate-100 text-slate-600 text-[0.65rem] font-medium px-3 py-0.5 rounded-full"><i class="fas fa-pen-fancy"></i> 47 articles</span>
                        </div>
                        <div class="text-sm text-[#6C3CE1] font-medium mb-2">Senior SEO Strategist &amp; Digital Marketing Expert</div>
                        <p class="text-sm leading-relaxed text-slate-600 mb-3">
                            Sarah is a seasoned SEO strategist with over 12 years of experience in digital marketing. 
                            She specializes in link building, content strategy, and technical SEO. She has helped 200+ 
                            businesses achieve top rankings and sustainable organic growth.
                        </p>
                        <div class="flex flex-wrap gap-4 py-3 border-y border-slate-100 mb-3">
                            <span class="flex items-center gap-1.5 text-sm text-slate-500"><i class="fas fa-pen-fancy text-[#6C3CE1]"></i> <strong class="text-slate-900">47</strong> Published Posts</span>
                            <span class="flex items-center gap-1.5 text-sm text-slate-500"><i class="fas fa-heart text-red-500"></i> <strong class="text-slate-900">2.4K</strong> Likes</span>
                            <span class="flex items-center gap-1.5 text-sm text-slate-500"><i class="fas fa-comment text-[#6C3CE1]"></i> <strong class="text-slate-900">312</strong> Comments</span>
                            <span class="flex items-center gap-1.5 text-sm text-slate-500"><i class="fas fa-trophy text-amber-500"></i> <strong class="text-slate-900">#3</strong> Top Author</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-all duration-300 hover:bg-[#6C3CE1] hover:text-white hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(108,60,225,0.25)]"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-all duration-300 hover:bg-[#6C3CE1] hover:text-white hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(108,60,225,0.25)]"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-all duration-300 hover:bg-[#6C3CE1] hover:text-white hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(108,60,225,0.25)]"><i class="fab fa-github"></i></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-all duration-300 hover:bg-[#6C3CE1] hover:text-white hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(108,60,225,0.25)]"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-all duration-300 hover:bg-[#6C3CE1] hover:text-white hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(108,60,225,0.25)]"><i class="fas fa-globe"></i></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-all duration-300 hover:bg-[#6C3CE1] hover:text-white hover:-translate-y-1 hover:shadow-[0_4px_12px_rgba(108,60,225,0.25)]"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments -->
            <div class="mt-10 pt-8 border-t-2 border-slate-100">
                <div class="flex items-center gap-3 text-xl font-bold text-slate-900 mb-6">
                    <i class="fas fa-comments text-[#6C3CE1]"></i>
                    Comments (24)
                </div>
                <div class="bg-slate-50 rounded-2xl p-8 md:p-10 text-center border-2 border-dashed border-slate-200">
                    <i class="fas fa-comment-dots text-4xl text-[#6C3CE1] opacity-30 block mb-2"></i>
                    <p class="text-slate-400 mb-0 text-sm">Comments are coming soon. Join the discussion and share your thoughts!</p>
                </div>
            </div>

            <!-- Related Posts -->
            <div class="mt-12 pt-10 border-t-2 border-slate-100">
                <div class="flex items-center gap-3 text-2xl font-bold text-slate-900 mb-6">
                    <i class="fas fa-book-open text-[#6C3CE1]"></i>
                    You Might Also Like
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="javascript:void(0)" onclick="navigateToPost('related1')" class="bg-white rounded-2xl p-5 pb-6 border border-slate-100 transition-all duration-500 no-underline text-inherit hover:-translate-y-2 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] hover:border-[#6C3CE1]">
                        <span class="text-3xl block mb-2">📊</span>
                        <h5 class="text-sm font-semibold text-slate-900 mb-1 leading-tight">10 SEO Metrics That Actually Matter in 2026</h5>
                        <span class="text-xs text-slate-400">6 min read • Dec 28, 2025</span>
                    </a>
                    <a href="javascript:void(0)" onclick="navigateToPost('related2')" class="bg-white rounded-2xl p-5 pb-6 border border-slate-100 transition-all duration-500 no-underline text-inherit hover:-translate-y-2 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] hover:border-[#6C3CE1]">
                        <span class="text-3xl block mb-2">📝</span>
                        <h5 class="text-sm font-semibold text-slate-900 mb-1 leading-tight">Content Marketing Trends: What's Working Now</h5>
                        <span class="text-xs text-slate-400">7 min read • Jan 02, 2026</span>
                    </a>
                    <a href="javascript:void(0)" onclick="navigateToPost('related3')" class="bg-white rounded-2xl p-5 pb-6 border border-slate-100 transition-all duration-500 no-underline text-inherit hover:-translate-y-2 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] hover:border-[#6C3CE1]">
                        <span class="text-3xl block mb-2">🔍</span>
                        <h5 class="text-sm font-semibold text-slate-900 mb-1 leading-tight">Google's AI Overview: How to Optimize Your Content</h5>
                        <span class="text-xs text-slate-400">5 min read • Jan 08, 2026</span>
                    </a>
                    <a href="javascript:void(0)" onclick="navigateToPost('related4')" class="bg-white rounded-2xl p-5 pb-6 border border-slate-100 transition-all duration-500 no-underline text-inherit hover:-translate-y-2 hover:shadow-[0_12px_32px_rgba(0,0,0,0.06)] hover:border-[#6C3CE1]">
                        <span class="text-3xl block mb-2">📈</span>
                        <h5 class="text-sm font-semibold text-slate-900 mb-1 leading-tight">Building a Sustainable SEO Strategy for 2026</h5>
                        <span class="text-xs text-slate-400">9 min read • Jan 12, 2026</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- ===== RIGHT SIDEBAR ===== -->
        <aside class="flex flex-col gap-8 sticky top-8">

            <!-- Popular Posts -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.02)]">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-900 uppercase tracking-wide mb-4">
                    <i class="fas fa-fire text-red-500 text-sm"></i>
                    Popular Posts
                </div>

                <div class="flex gap-3 py-2.5 border-b border-slate-100 cursor-pointer transition-all duration-200 items-center hover:pl-1" onclick="navigateToPost('popular1')">
                    <span class="text-xs font-bold text-slate-300 w-5 flex-shrink-0 text-center">01</span>
                    <span class="text-xl flex-shrink-0">📱</span>
                    <div class="flex-1 min-w-0">
                        <h5 class="text-sm font-semibold text-slate-900 m-0 mb-0.5 leading-tight">Mobile-First Indexing: Complete Guide</h5>
                        <span class="text-[0.65rem] text-slate-400">3.2K views • Jan 10, 2026</span>
                    </div>
                </div>
                <div class="flex gap-3 py-2.5 border-b border-slate-100 cursor-pointer transition-all duration-200 items-center hover:pl-1" onclick="navigateToPost('popular2')">
                    <span class="text-xs font-bold text-slate-300 w-5 flex-shrink-0 text-center">02</span>
                    <span class="text-xl flex-shrink-0">🤖</span>
                    <div class="flex-1 min-w-0">
                        <h5 class="text-sm font-semibold text-slate-900 m-0 mb-0.5 leading-tight">AI Tools for Content Creation in 2026</h5>
                        <span class="text-[0.65rem] text-slate-400">2.8K views • Jan 05, 2026</span>
                    </div>
                </div>
                <div class="flex gap-3 py-2.5 border-b border-slate-100 cursor-pointer transition-all duration-200 items-center hover:pl-1" onclick="navigateToPost('popular3')">
                    <span class="text-xs font-bold text-slate-300 w-5 flex-shrink-0 text-center">03</span>
                    <span class="text-xl flex-shrink-0">🎯</span>
                    <div class="flex-1 min-w-0">
                        <h5 class="text-sm font-semibold text-slate-900 m-0 mb-0.5 leading-tight">Keyword Research: Beyond Search Volume</h5>
                        <span class="text-[0.65rem] text-slate-400">2.1K views • Dec 28, 2025</span>
                    </div>
                </div>
                <div class="flex gap-3 py-2.5 border-b border-slate-100 cursor-pointer transition-all duration-200 items-center hover:pl-1" onclick="navigateToPost('popular4')">
                    <span class="text-xs font-bold text-slate-300 w-5 flex-shrink-0 text-center">04</span>
                    <span class="text-xl flex-shrink-0">📈</span>
                    <div class="flex-1 min-w-0">
                        <h5 class="text-sm font-semibold text-slate-900 m-0 mb-0.5 leading-tight">Google Core Web Vitals Explained</h5>
                        <span class="text-[0.65rem] text-slate-400">1.9K views • Dec 20, 2025</span>
                    </div>
                </div>
                <div class="flex gap-3 py-2.5 cursor-pointer transition-all duration-200 items-center hover:pl-1" onclick="navigateToPost('popular5')">
                    <span class="text-xs font-bold text-slate-300 w-5 flex-shrink-0 text-center">05</span>
                    <span class="text-xl flex-shrink-0">🔒</span>
                    <div class="flex-1 min-w-0">
                        <h5 class="text-sm font-semibold text-slate-900 m-0 mb-0.5 leading-tight">HTTPS &amp; SSL: Security Best Practices</h5>
                        <span class="text-[0.65rem] text-slate-400">1.5K views • Dec 15, 2025</span>
                    </div>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.02)]">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-900 uppercase tracking-wide mb-4">
                    <i class="fas fa-envelope text-[#6C3CE1]"></i>
                    Newsletter
                </div>
                <p class="text-sm text-slate-600 mb-4 leading-relaxed">Get the latest SEO strategies and marketing insights delivered to your inbox weekly.</p>
                <input type="email" placeholder="Enter your email" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm transition-colors duration-200 bg-slate-50 focus:outline-none focus:border-[#6C3CE1] focus:shadow-[0_0_0_3px_rgba(108,60,225,0.1)] mb-3" aria-label="Email for newsletter">
                <button onclick="alert('Thanks for subscribing! 🎉')" class="w-full py-2.5 border-none rounded-xl bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] text-white font-semibold text-sm cursor-pointer transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(108,60,225,0.3)]">
                    <i class="fas fa-paper-plane"></i> Subscribe
                </button>
            </div>

            <!-- About Author Mini -->
            <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl p-6 border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.02)]">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-900 uppercase tracking-wide mb-4">
                    <i class="fas fa-user-astronaut text-[#6C3CE1]"></i>
                    About the Author
                </div>
                <div class="flex gap-3 items-center mb-2">
                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] flex items-center justify-center text-white font-bold text-base flex-shrink-0">SJ</div>
                    <div>
                        <span class="block font-bold text-slate-900 text-sm">Sarah Johnson</span>
                        <span class="text-xs text-slate-400">SEO Strategist • 12+ years</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed mb-2">Helping businesses grow through strategic SEO and link building. Speaker at SEO conferences worldwide.</p>
                <a href="javascript:void(0)" class="text-[#6C3CE1] font-semibold text-xs no-underline inline-flex items-center gap-1.5 transition-all duration-200 hover:gap-2.5 hover:text-[#4A1A8A] cursor-pointer">
                    View all posts <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.02)]">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-900 uppercase tracking-wide mb-4">
                    <i class="fas fa-folder-open text-[#6C3CE1]"></i>
                    Categories
                </div>
                <div class="flex flex-wrap gap-1.5">
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]" onclick="filterByCategory('seo')">SEO</span>
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]" onclick="filterByCategory('content-marketing')">Content Marketing</span>
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]" onclick="filterByCategory('link-building')">Link Building</span>
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]" onclick="filterByCategory('analytics')">Analytics</span>
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]" onclick="filterByCategory('business')">Business</span>
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]" onclick="filterByCategory('trends')">Trends</span>
                </div>
            </div>

        </aside>

    </div>
    <!-- End Grid -->

    <!-- ================================================== -->
    <!-- ===== FEATURED BLOG SECTION (BELOW SINGLE POST) ===== -->
    <!-- ================================================== -->
    <section class="mt-16 pt-12 border-t-2 border-slate-100">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 flex items-center gap-3 m-0">
                <i class="fas fa-star text-amber-500"></i>
                Featured Blogs
                <span class="text-sm font-normal text-slate-400 bg-slate-100 px-3 py-0.5 rounded-full ml-2">Editor's Pick</span>
            </h2>
            <a href="javascript:void(0)" onclick="goToBlogIndex()" class="text-[#6C3CE1] font-semibold text-sm no-underline flex items-center gap-1.5 transition-all duration-300 hover:text-[#4A1A8A] hover:translate-x-1 cursor-pointer">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1 -->
            <a href="javascript:void(0)" onclick="navigateToPost('featured1')" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 transition-all duration-500 no-underline text-inherit shadow-[0_4px_16px_rgba(0,0,0,0.02)] hover:-translate-y-2 hover:shadow-[0_16px_48px_rgba(108,60,225,0.08)] hover:border-[#6C3CE1]">
                <div class="relative overflow-hidden bg-slate-100 h-48">
                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&q=80" alt="SEO Strategy" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <span class="absolute top-4 left-4 bg-[#6C3CE1]/90 backdrop-blur-md text-white px-4 py-1 rounded-full text-[0.65rem] font-semibold uppercase tracking-wide border border-white/10">SEO Strategy</span>
                    <span class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-xl shadow-[0_2px_12px_rgba(0,0,0,0.08)]">📈</span>
                </div>
                <div class="p-5 pb-6">
                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                        <span class="w-6 h-6 rounded-full bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] flex items-center justify-center text-white text-[0.5rem] font-bold flex-shrink-0">JD</span>
                        <span class="font-semibold text-slate-600">John Doe</span>
                        <span>•</span>
                        <span>Jan 12, 2026</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mt-1 mb-2 leading-tight transition-colors duration-200 group-hover:text-[#6C3CE1]">10 SEO Strategies That Will Dominate 2026</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-3 line-clamp-2">Discover the most effective SEO strategies that top marketers are using to rank higher and drive more organic traffic in 2026.</p>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                        <span class="text-xs text-slate-400 flex items-center gap-1"><i class="far fa-clock"></i> 6 min read</span>
                        <span class="text-[#6C3CE1] font-semibold text-xs flex items-center gap-1 transition-all duration-300 group-hover:gap-2">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="javascript:void(0)" onclick="navigateToPost('featured2')" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 transition-all duration-500 no-underline text-inherit shadow-[0_4px_16px_rgba(0,0,0,0.02)] hover:-translate-y-2 hover:shadow-[0_16px_48px_rgba(108,60,225,0.08)] hover:border-[#6C3CE1]">
                <div class="relative overflow-hidden bg-slate-100 h-48">
                    <img src="https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=600&q=80" alt="Content Marketing" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <span class="absolute top-4 left-4 bg-[#6C3CE1]/90 backdrop-blur-md text-white px-4 py-1 rounded-full text-[0.65rem] font-semibold uppercase tracking-wide border border-white/10">Content Marketing</span>
                    <span class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-xl shadow-[0_2px_12px_rgba(0,0,0,0.08)]">✍️</span>
                </div>
                <div class="p-5 pb-6">
                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                        <span class="w-6 h-6 rounded-full bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] flex items-center justify-center text-white text-[0.5rem] font-bold flex-shrink-0">EM</span>
                        <span class="font-semibold text-slate-600">Emma Martinez</span>
                        <span>•</span>
                        <span>Jan 10, 2026</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mt-1 mb-2 leading-tight transition-colors duration-200 group-hover:text-[#6C3CE1]">Content Marketing Trends: What's Working in 2026</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-3 line-clamp-2">From AI-generated content to interactive experiences, explore the top content marketing trends that are driving engagement this year.</p>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                        <span class="text-xs text-slate-400 flex items-center gap-1"><i class="far fa-clock"></i> 8 min read</span>
                        <span class="text-[#6C3CE1] font-semibold text-xs flex items-center gap-1 transition-all duration-300 group-hover:gap-2">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="javascript:void(0)" onclick="navigateToPost('featured3')" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 transition-all duration-500 no-underline text-inherit shadow-[0_4px_16px_rgba(0,0,0,0.02)] hover:-translate-y-2 hover:shadow-[0_16px_48px_rgba(108,60,225,0.08)] hover:border-[#6C3CE1]">
                <div class="relative overflow-hidden bg-slate-100 h-48">
                    <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80" alt="Business Growth" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <span class="absolute top-4 left-4 bg-[#6C3CE1]/90 backdrop-blur-md text-white px-4 py-1 rounded-full text-[0.65rem] font-semibold uppercase tracking-wide border border-white/10">Business Growth</span>
                    <span class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-xl shadow-[0_2px_12px_rgba(0,0,0,0.08)]">🚀</span>
                </div>
                <div class="p-5 pb-6">
                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                        <span class="w-6 h-6 rounded-full bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] flex items-center justify-center text-white text-[0.5rem] font-bold flex-shrink-0">MC</span>
                        <span class="font-semibold text-slate-600">Michael Chen</span>
                        <span>•</span>
                        <span>Jan 08, 2026</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mt-1 mb-2 leading-tight transition-colors duration-200 group-hover:text-[#6C3CE1]">Scaling Your Business: Growth Hacks for 2026</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-3 line-clamp-2">Learn proven growth hacking techniques to scale your business faster, acquire more customers, and increase revenue in the competitive market.</p>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                        <span class="text-xs text-slate-400 flex items-center gap-1"><i class="far fa-clock"></i> 7 min read</span>
                        <span class="text-[#6C3CE1] font-semibold text-xs flex items-center gap-1 transition-all duration-300 group-hover:gap-2">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="javascript:void(0)" onclick="navigateToPost('featured4')" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 transition-all duration-500 no-underline text-inherit shadow-[0_4px_16px_rgba(0,0,0,0.02)] hover:-translate-y-2 hover:shadow-[0_16px_48px_rgba(108,60,225,0.08)] hover:border-[#6C3CE1]">
                <div class="relative overflow-hidden bg-slate-100 h-48">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&q=80" alt="Analytics" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <span class="absolute top-4 left-4 bg-[#6C3CE1]/90 backdrop-blur-md text-white px-4 py-1 rounded-full text-[0.65rem] font-semibold uppercase tracking-wide border border-white/10">Analytics</span>
                    <span class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-xl shadow-[0_2px_12px_rgba(0,0,0,0.08)]">📊</span>
                </div>
                <div class="p-5 pb-6">
                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                        <span class="w-6 h-6 rounded-full bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] flex items-center justify-center text-white text-[0.5rem] font-bold flex-shrink-0">AR</span>
                        <span class="font-semibold text-slate-600">Amanda Rivera</span>
                        <span>•</span>
                        <span>Jan 05, 2026</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mt-1 mb-2 leading-tight transition-colors duration-200 group-hover:text-[#6C3CE1]">Data Analytics: Making Smarter Business Decisions</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-3 line-clamp-2">Unlock the power of data analytics to make informed business decisions, optimize operations, and drive growth with actionable insights.</p>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                        <span class="text-xs text-slate-400 flex items-center gap-1"><i class="far fa-clock"></i> 5 min read</span>
                        <span class="text-[#6C3CE1] font-semibold text-xs flex items-center gap-1 transition-all duration-300 group-hover:gap-2">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>

        </div>
    </section>

</div>
</section>
<!-- End Wrapper -->

@endsection

@section('scripts')
<script>
    (function() {
        'use strict';

        // ===== READING PROGRESS =====
        const progressBar = document.getElementById('readingProgressModern');

        window.addEventListener('scroll', function() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            progressBar.style.width = scrollPercent + '%';

            const backToTop = document.getElementById('backToTopModern');
            if (scrollTop > 500) {
                backToTop.classList.add('!opacity-100', '!visible', '!scale-100');
                backToTop.classList.remove('opacity-0', 'invisible', 'scale-90');
            } else {
                backToTop.classList.remove('!opacity-100', '!visible', '!scale-100');
                backToTop.classList.add('opacity-0', 'invisible', 'scale-90');
            }

            // Update TOC progress
            updateTOCProgress();
        });

        // ===== TOC PROGRESS =====
        function updateTOCProgress() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const percent = docHeight > 0 ? Math.round((scrollTop / docHeight) * 100) : 0;

            const progressFill = document.getElementById('tocProgressFill');
            const progressText = document.getElementById('tocProgressText');

            if (progressFill) {
                progressFill.style.width = percent + '%';
            }
            if (progressText) {
                progressText.textContent = percent + '%';
            }

            // Highlight active TOC item
            const sections = document.querySelectorAll('.post-content-modern h2, .post-content-modern h3');
            const tocLinks = document.querySelectorAll('.toc-list a');

            let currentSection = null;
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= 150) {
                    currentSection = section.id;
                }
            });

            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (link.dataset.target === currentSection) {
                    link.classList.add('active');
                }
            });
        }

        // ===== BACK TO TOP =====
        document.getElementById('backToTopModern').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ===== MOBILE TOC TOGGLE =====
        window.toggleMobileTOC = function() {
            const list = document.getElementById('mobileTocList');
            const toggle = document.querySelector('.mobile-toc-toggle');
            list.classList.toggle('max-h-[500px]');
            list.classList.toggle('max-h-0');
            toggle.classList.toggle('rotate-180');
        };

        // Close mobile TOC when a link is clicked
        document.querySelectorAll('.mobile-toc-list a').forEach(link => {
            link.addEventListener('click', function() {
                const list = document.getElementById('mobileTocList');
                const toggle = document.querySelector('.mobile-toc-toggle');
                list.classList.remove('max-h-[500px]');
                list.classList.add('max-h-0');
                toggle.classList.remove('rotate-180');
            });
        });

        // ===== TOC SMOOTH SCROLL =====
        document.querySelectorAll('.toc-list a, .mobile-toc-list a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ===== SHARE FUNCTIONS =====
        window.sharePost = function(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.querySelector('h1')?.textContent || 'Blog Post');

            let shareUrl = '';
            switch(platform) {
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
                default:
                    return;
            }

            window.open(shareUrl, '_blank', 'width=600,height=400');
            return false;
        };

        // ===== COPY LINK =====
        window.copyLink = function() {
            const url = window.location.href;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    const btn = document.querySelector('.share-btn.copy');
                    const originalIcon = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check"></i>';
                    btn.style.background = '#6C3CE1';
                    btn.style.borderColor = '#6C3CE1';
                    btn.style.color = 'white';

                    setTimeout(() => {
                        btn.innerHTML = originalIcon;
                        btn.style.background = '';
                        btn.style.borderColor = '';
                        btn.style.color = '';
                    }, 2000);
                }).catch(() => {
                    fallbackCopy(url);
                });
            } else {
                fallbackCopy(url);
            }
        };

        function fallbackCopy(text) {
            const input = document.createElement('input');
            input.value = text;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            alert('Link copied to clipboard!');
        }

        // ===== KEYBOARD NAVIGATION =====
        document.addEventListener('keydown', function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

            const prevLink = document.querySelector('.nav-btn.prev:not(.disabled)');
            const nextLink = document.querySelector('.nav-btn:not(.prev):not(.disabled)');

            if (e.key === 'ArrowLeft' && prevLink) {
                prevLink.click();
            } else if (e.key === 'ArrowRight' && nextLink) {
                nextLink.click();
            }
        });

        // ===== ANIMATED VIEW COUNTER =====
        const viewCountEl = document.getElementById('viewCountModern');
        if (viewCountEl) {
            const target = parseInt(viewCountEl.textContent.replace(/,/g, ''));
            if (target > 1000) {
                let current = 0;
                const increment = Math.floor(target / 50);
                const interval = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(interval);
                    }
                    viewCountEl.textContent = current.toLocaleString() + ' views';
                }, 25);
            }
        }

        // ===== NAVIGATION FUNCTIONS =====
        window.goToBlogIndex = function() {
            alert('Navigate to Blog Index');
        };

        window.filterByCategory = function(category) {
            alert('Filter by category: ' + category);
        };

        window.filterByTag = function(tag) {
            alert('Filter by tag: ' + tag);
        };

        window.navigateToPost = function(postId) {
            alert('Navigate to post: ' + postId);
        };

        // ===== FEATURED BLOG CARD ANIMATION ON SCROLL =====
        const featuredCards = document.querySelectorAll('.featured-blog-card');
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                }
            });
        }, observerOptions);

        featuredCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
            cardObserver.observe(card);
        });

        // Initial TOC update
        setTimeout(updateTOCProgress, 100);

        // Mobile TOC toggle icon rotation
        document.querySelector('.mobile-toc-toggle')?.addEventListener('click', function() {
            const icon = this.querySelector('i:last-child');
            icon.classList.toggle('rotate-180');
        });

        // TOC link active state tracking for scroll
        const tocLinks = document.querySelectorAll('.toc-list a');
        const headings = document.querySelectorAll('.post-content-modern h2, .post-content-modern h3');

        window.addEventListener('scroll', function() {
            let current = '';
            headings.forEach(heading => {
                const rect = heading.getBoundingClientRect();
                if (rect.top <= 100) {
                    current = heading.id;
                }
            });

            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (link.dataset.target === current) {
                    link.classList.add('active');
                }
            });
        });

    })();
</script>

<style>
    /* Small utility overrides for Tailwind */
    .border-b-3 {
        border-bottom-width: 3px;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .toc-list a.active .toc-dot {
        @apply w-2 h-2 bg-[#6C3CE1];
    }
    /* Fix for mobile TOC toggle icon */
    .mobile-toc-toggle i:last-child {
        transition: transform 0.3s ease;
    }
    .mobile-toc-toggle i:last-child.rotate-180 {
        transform: rotate(180deg);
    }
    /* Share button hover overrides */
    .share-btn.twitter:hover { background: #1DA1F2; border-color: #1DA1F2; color: white; }
    .share-btn.facebook:hover { background: #4267B2; border-color: #4267B2; color: white; }
    .share-btn.linkedin:hover { background: #0A66C2; border-color: #0A66C2; color: white; }
    .share-btn.copy:hover { background: #6C3CE1; border-color: #6C3CE1; color: white; }
</style>

@endsection