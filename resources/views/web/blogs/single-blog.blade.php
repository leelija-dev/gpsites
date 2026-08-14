@extends('layouts.web.main-layout')
@section('title', $blog->meta_title ?? '' )
@section('description', $blog->meta_description ?? '' )
@section('keywords', $blog->keywords ?? '' )
@section('content')

<style>
    /* ============================================
   Blog Content Wrapper - Complete Styling
   Light Theme Only - No Dark Backgrounds
   Targeting the specific ID structure
   ============================================ */

#blog-content-wrapper {
    /* Container styling - Light theme */
    background-color: #ffffff;
    border-radius: 1rem;
    padding: 1.25rem;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.02);
    border: 1px solid #f1f5f9;
    max-width: 100%;
    overflow-wrap: break-word;
    word-wrap: break-word;
    color: #1e293b;
}

/* ============================================
   RESPONSIVE PADDING
   ============================================ */
@media (min-width: 768px) {
    #blog-content-wrapper {
        padding: 2rem;
    }
}

@media (min-width: 1024px) {
    #blog-content-wrapper {
        padding: 2.5rem;
    }
}

/* ============================================
   SECTION INTRO PARAGRAPH
   ============================================ */
#section-intro {
    font-size: 1rem;
    line-height: 1.75;
    color: #475569;
    margin-bottom: 1.25rem;
}

@media (min-width: 768px) {
    #section-intro {
        font-size: 1.125rem;
        line-height: 1.75;
    }
}

/* ============================================
   GENERAL PARAGRAPH STYLING
   ============================================ */
#blog-content-wrapper p {
    font-size: 1rem;
    line-height: 1.75;
    color: #1e293b;
    margin-bottom: 1rem;
}

@media (min-width: 768px) {
    #blog-content-wrapper p {
        font-size: 1.0625rem;
        line-height: 1.8;
    }
}

/* Italic text within paragraphs */
#blog-content-wrapper p em,
#blog-content-wrapper p i {
    color: #475569;
    font-style: italic;
}

/* Bold text within paragraphs */
#blog-content-wrapper p strong,
#blog-content-wrapper p b {
    color: #0f172a;
    font-weight: 600;
}

#blog-content-wrapper ol, ul, menu{
    list-style:disc !important;
}

/* ============================================
   HEADINGS - Hierarchical Differentiation
   ============================================ */

/* H2 - Main Section Headings */
#blog-content-wrapper h2 {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1.3;
    color: #0f172a;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 3px solid #e2e8f0;
    letter-spacing: -0.02em;
    scroll-margin-top: 80px;
}

@media (min-width: 768px) {
    #blog-content-wrapper h2 {
        font-size: 2.125rem;
        margin-top: 3rem;
    }
}

/* H3 - Sub-section Headings */
#blog-content-wrapper h3 {
    font-size: 1.35rem;
    font-weight: 600;
    line-height: 1.4;
    color: #1e293b;
    margin-top: 2rem;
    margin-bottom: 0.75rem;
    padding-left: 0.75rem;
    border-left: 4px solid #3b82f6;
    scroll-margin-top: 80px;
}

@media (min-width: 768px) {
    #blog-content-wrapper h3 {
        font-size: 1.5rem;
        margin-top: 2.25rem;
    }
}

/* H4 - Sub-sub-section Headings */
#blog-content-wrapper h4 {
    font-size: 1.125rem;
    font-weight: 600;
    line-height: 1.5;
    color: #334155;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    padding: 0.375rem 0.75rem;
    background-color: #f1f5f9;
    border-radius: 0.375rem;
    display: inline-block;
    scroll-margin-top: 80px;
}

@media (min-width: 768px) {
    #blog-content-wrapper h4 {
        font-size: 1.25rem;
    }
}

/* ============================================
   LISTS & BULLET POINTS
   ============================================ */
#blog-content-wrapper ul,
#blog-content-wrapper ol {
    margin-top: 0.75rem;
    margin-bottom: 1.25rem;
    padding-left: 1.5rem;
    color: #1e293b;
    font-size: 1rem;
    line-height: 1.75;
}

@media (min-width: 768px) {
    #blog-content-wrapper ul,
    #blog-content-wrapper ol {
        font-size: 1.0625rem;
        padding-left: 2rem;
    }
}

#blog-content-wrapper li {
    margin-bottom: 0.375rem;
}

#blog-content-wrapper ul li::marker {
    color: #3b82f6;
}

/* ============================================
   FORMULA / CODE BLOCKS
   ============================================ */
#blog-content-wrapper p:has(> strong:contains("➡")),
#blog-content-wrapper p:has(> strong:contains("For")),
#blog-content-wrapper p:has(> strong:contains("Tip share")) {
    background-color: #f1f5f9;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    font-family: 'Courier New', monospace;
    font-size: 0.925rem;
    color: #0f172a;
    border-left: 4px solid #6366f1;
    margin: 0.75rem 0;
}

/* ============================================
   QUOTES & BLOCKQUOTES
   ============================================ */
#blog-content-wrapper blockquote {
    margin: 1.5rem 0;
    padding: 1rem 1.5rem;
    background-color: #f8fafc;
    border-left: 4px solid #8b5cf6;
    border-radius: 0 0.5rem 0.5rem 0;
    font-style: italic;
    color: #334155;
    font-size: 1.05rem;
}

#blog-content-wrapper blockquote p {
    margin-bottom: 0;
    font-size: inherit;
}

/* Inline quotes with em tags */
#blog-content-wrapper p em:not(:has(strong)) {
    color: #475569;
    background-color: #fefce8;
    padding: 0.1rem 0.3rem;
    border-radius: 0.25rem;
    font-style: italic;
}

/* ============================================
   SPECIAL HIGHLIGHTED TEXT
   ============================================ */
#blog-content-wrapper p:has(> strong) strong {
    color: #1e293b;
    font-weight: 600;
}

/* ============================================
   MISC - LINE BREAKS & SPACING
   ============================================ */
#blog-content-wrapper br {
    display: block;
    content: "";
    margin: 0.5rem 0;
}

/* ============================================
   LINKS
   ============================================ */
#blog-content-wrapper a {
    color: #2563eb;
    text-decoration: underline;
    text-underline-offset: 2px;
    transition: color 0.2s ease;
}

#blog-content-wrapper a:hover {
    color: #1d4ed8;
    text-decoration: none;
}

/* ============================================
   IMAGES
   ============================================ */
#blog-content-wrapper img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

/* ============================================
   TABLES
   ============================================ */
#blog-content-wrapper table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
    font-size: 0.9375rem;
    background-color: #ffffff;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

#blog-content-wrapper thead {
    background-color: #f1f5f9;
    border-bottom: 2px solid #e2e8f0;
}

#blog-content-wrapper th {
    padding: 0.75rem 1rem;
    text-align: left;
    font-weight: 600;
    color: #0f172a;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-right: 1px solid #e2e8f0;
}

#blog-content-wrapper th:last-child {
    border-right: none;
}

#blog-content-wrapper td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #e2e8f0;
    color: #1e293b;
    border-right: 1px solid #e2e8f0;
}

#blog-content-wrapper td:last-child {
    border-right: none;
}

#blog-content-wrapper tr:last-child td {
    border-bottom: none;
}

#blog-content-wrapper tbody tr:hover {
    background-color: #f8fafc;
}

#blog-content-wrapper tbody tr:nth-child(even) {
    background-color: #fafbfc;
}

#blog-content-wrapper tbody tr:nth-child(even):hover {
    background-color: #f1f5f9;
}

@media (max-width: 640px) {
    #blog-content-wrapper table {
        font-size: 0.8125rem;
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    
    #blog-content-wrapper th,
    #blog-content-wrapper td {
        padding: 0.5rem 0.75rem;
    }
}

/* ============================================
   HORIZONTAL RULES / DIVIDERS
   ============================================ */
#blog-content-wrapper hr {
    border: none;
    border-top: 2px solid #e2e8f0;
    margin: 2rem 0;
}

/* ============================================
   RESPONSIVE FINE-TUNING FOR MOBILE
   ============================================ */
@media (max-width: 480px) {
    #blog-content-wrapper {
        padding: 0.75rem;
        border-radius: 0.75rem;
    }

    #blog-content-wrapper h2 {
        font-size: 1.4rem;
        margin-top: 1.75rem;
    }

    #blog-content-wrapper h3 {
        font-size: 1.15rem;
        padding-left: 0.5rem;
    }

    #blog-content-wrapper h4 {
        font-size: 1rem;
        padding: 0.25rem 0.5rem;
    }

    #blog-content-wrapper p {
        font-size: 0.9375rem;
        line-height: 1.7;
    }

    #blog-content-wrapper ul,
    #blog-content-wrapper ol {
        padding-left: 1.25rem;
        font-size: 0.9375rem;
    }

    /* Formula blocks on mobile */
    #blog-content-wrapper p:has(> strong:contains("➡")),
    #blog-content-wrapper p:has(> strong:contains("For")),
    #blog-content-wrapper p:has(> strong:contains("Tip share")) {
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
        overflow-x: auto;
        white-space: pre-wrap;
        word-break: break-all;
    }

    #blog-content-wrapper blockquote {
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }
}

/* ============================================
   PRINT STYLES
   ============================================ */
@media print {
    #blog-content-wrapper {
        box-shadow: none;
        border: 1px solid #ddd;
        padding: 1.5rem;
        background-color: #ffffff;
    }

    #blog-content-wrapper h2 {
        border-bottom-color: #ccc;
    }

    #blog-content-wrapper h3 {
        border-left-color: #666;
    }

    #blog-content-wrapper h4 {
        background-color: #f5f5f5;
        color: #000;
    }

    #blog-content-wrapper a {
        color: #000;
        text-decoration: underline;
    }

    #blog-content-wrapper table {
        box-shadow: none;
        border: 1px solid #ccc;
    }

    #blog-content-wrapper thead {
        background-color: #f0f0f0;
    }

    #blog-content-wrapper th {
        color: #000;
    }

    #blog-content-wrapper td {
        color: #000;
    }
}

/* ============================================
   ADDITIONAL UTILITY CLASSES
   ============================================ */

/* Highlight important text */
#blog-content-wrapper .highlight {
    background-color: #fef3c7;
    padding: 0.1rem 0.3rem;
    border-radius: 0.25rem;
    color: #92400e;
}

/* Success/positive text */
#blog-content-wrapper .text-success {
    color: #065f46;
    background-color: #d1fae5;
    padding: 0.1rem 0.3rem;
    border-radius: 0.25rem;
}

/* Warning text */
#blog-content-wrapper .text-warning {
    color: #92400e;
    background-color: #fef3c7;
    padding: 0.1rem 0.3rem;
    border-radius: 0.25rem;
}

/* Info text */
#blog-content-wrapper .text-info {
    color: #1e40af;
    background-color: #dbeafe;
    padding: 0.1rem 0.3rem;
    border-radius: 0.25rem;
}

/* Numbered step containers */
#blog-content-wrapper .step {
    background-color: #f8fafc;
    padding: 1rem 1.25rem;
    border-radius: 0.5rem;
    margin: 1rem 0;
    border-left: 4px solid #3b82f6;
}

#blog-content-wrapper .step-number {
    display: inline-block;
    font-weight: 700;
    color: #3b82f6;
    font-size: 1.1rem;
    margin-right: 0.5rem;
}

/* Card-style content boxes */
#blog-content-wrapper .info-box {
    background-color: #f8fafc;
    padding: 1.25rem;
    border-radius: 0.5rem;
    margin: 1.25rem 0;
    border: 1px solid #e2e8f0;
}

#blog-content-wrapper .info-box h4 {
    margin-top: 0;
    background-color: transparent;
    padding: 0;
}

#blog-content-wrapper .info-box p:last-child {
    margin-bottom: 0;
}

/* TOC Styles */
#tocList a.active {
    color: #6C3CE1;
    font-weight: 600;
}

#tocList a.active .toc-dot {
    background-color: #6C3CE1;
    width: 8px;
    height: 8px;
}

#tocList a .toc-dot {
    transition: all 0.2s ease;
}

/* Mobile TOC */
#mobileTocList a.active {
    color: #6C3CE1;
    font-weight: 600;
}

.mobile-toc-toggle i:last-child {
    transition: transform 0.3s ease;
}

.mobile-toc-toggle i:last-child.rotate-180 {
    transform: rotate(180deg);
}

/* ============================================
   FAQ SECTION STYLES
   ============================================ */
.faq-section {
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 2px solid #e2e8f0;
}

.faq-section .faq-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.faq-section .faq-title i {
    color: #6C3CE1;
}

.faq-section .faq-subtitle {
    color: #64748b;
    font-size: 1rem;
    margin-bottom: 1.5rem;
}

.faq-item {
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    margin-bottom: 0.75rem;
    overflow: hidden;
    transition: all 0.2s ease;
    background-color: #ffffff;
}

.faq-item:hover {
    border-color: #cbd5e1;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.faq-item.active {
    border-color: #6C3CE1;
    box-shadow: 0 4px 16px rgba(108, 60, 225, 0.08);
}

.faq-question {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    cursor: pointer;
    background-color: #fafbfc;
    transition: background-color 0.2s ease;
    user-select: none;
}

.faq-question:hover {
    background-color: #f1f5f9;
}

.faq-question .question-text {
    font-weight: 600;
    color: #0f172a;
    font-size: 1rem;
    flex: 1;
    padding-right: 1rem;
}

.faq-question .faq-toggle-icon {
    flex-shrink: 0;
    color: #94a3b8;
    transition: transform 0.3s ease, color 0.2s ease;
    font-size: 0.875rem;
}

.faq-item.active .faq-question .faq-toggle-icon {
    transform: rotate(180deg);
    color: #6C3CE1;
}

.faq-answer {
    max-height: 0;
    
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
    padding: 0 1.25rem;
    color: #475569;
    line-height: 1.7;
    font-size: 0.95rem;
}

.faq-answer p {
    margin: 0;
    padding: 0;
}

.faq-item.active .faq-answer {
    max-height: 800px;
    padding: 0 1.25rem 1.25rem 1.25rem;
}

.faq-answer ul,
.faq-answer ol {
    padding-left: 1.5rem;
    margin: 0.5rem 0;
}

.faq-answer li {
    margin-bottom: 0.25rem;
}

.faq-empty {
    text-align: center;
    padding: 2rem 1.5rem;
    background-color: #f8fafc;
    border-radius: 1rem;
    border: 1px dashed #e2e8f0;
    color: #94a3b8;
}

.faq-empty i {
    font-size: 2rem;
    color: #cbd5e1;
    margin-bottom: 0.5rem;
    display: block;
}

@media (max-width: 640px) {
    .faq-question {
        padding: 0.875rem 1rem;
    }
    
    .faq-question .question-text {
        font-size: 0.9rem;
    }
    
    .faq-item.active .faq-answer {
        padding: 0 1rem 1rem 1rem;
    }
    
    .faq-section .faq-title {
        font-size: 1.4rem;
    }
}
</style>

<!-- Reading Progress -->
<div id="readingProgressModern" class="fixed top-0 left-0 h-1 z-[1000] bg-gradient-to-r from-[#6C3CE1] via-[#8B5CF6] to-[#A78BFA] shadow-[0_2px_12px_rgba(108,60,225,0.3)] transition-[width] duration-75 ease-linear" style="width:0%;"></div>

<!-- Back to Top -->
<button id="backToTopModern" class="fixed bottom-8 right-8 w-12 h-12 rounded-full bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] text-white border-none shadow-[0_4px_24px_rgba(108,60,225,0.35)] cursor-pointer opacity-0 invisible scale-90 transition-all duration-300 z-[999] flex items-center justify-center text-lg hover:scale-110 hover:-translate-y-1 hover:shadow-[0_8px_32px_rgba(108,60,225,0.45)]" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- ===== MAIN WRAPPER ===== -->
<section class="bg-slate-50 py-10 md:py-14 px-4">
    <div class="blog-post-wrapper container mx-auto">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-slate-400 pb-6 flex-wrap border-b border-slate-100/40 mb-8" aria-label="Breadcrumb">
        <a href="javascript:void(0)" onclick="goToBlogIndex()" class="text-[#6C3CE1] font-medium hover:text-[#4A1A8A] hover:underline transition-all duration-200 cursor-pointer"><i class="fas fa-home"></i> Blog</a>
        <span class="text-slate-300 text-xs"><i class="fas fa-chevron-right"></i></span>
        <a href="{{url('/blogs') }}?search={{$blog->blogCategory->slug}}" class="text-[#6C3CE1] font-medium hover:text-[#4A1A8A] hover:underline transition-all duration-200 cursor-pointer">{{ $blog->blogCategory->name ?? ''}}</a>
        <span class="text-slate-300 text-xs"><i class="fas fa-chevron-right"></i></span>
        <span class="text-slate-700 font-semibold truncate">{{$blog->title ?? ''}}</span>
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
                    <!-- Dynamically generated by JavaScript -->
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
                        <i class="fas fa-chevron-down text-[#6C3CE1] transition-transform duration-300 mobile-toc-toggle-icon"></i>
                    </div>
                    <ul class="list-none p-0 m-0 max-h-0 overflow-hidden transition-[max-height] duration-300" id="mobileTocList">
                        <!-- Dynamically generated by JavaScript -->
                    </ul>
                </div>
            </div>

            <!-- Post Header -->
            <header class="mb-8">
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight my-2 tracking-tight">{{$blog->title ?? ''}}</h1>

                <div class="flex flex-wrap items-center gap-3 md:gap-5 py-4 border-t border-b border-slate-100 mb-2">
                    <span class="flex items-center gap-2 text-slate-600 text-sm">
                        <i class="fas fa-user-circle text-[#6C3CE1]"></i>
                        <span>By <span class="font-semibold text-slate-900">{{$blog->admin?->name}}</span></span>
                    </span>
                    <span class="flex items-center gap-2 text-slate-600 text-sm">
                        <i class="fas fa-calendar-alt text-[#6C3CE1]"></i>
                        <span>{{$blog->created_at->format('M d, Y')}}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] text-white px-4 py-1 rounded-full text-xs font-semibold uppercase tracking-wide shadow-[0_2px_8px_rgba(108,60,225,0.25)] transition-transform duration-200 hover:scale-105 hover:shadow-[0_4px_16px_rgba(108,60,225,0.35)]">
                        <i class="fas fa-tag"></i> {{$blog->blogCategory->name}}
                    </span>
                </div>
            </header>

            <!-- Featured Image -->
            <div class="relative rounded-2xl overflow-hidden mb-10 shadow-[0_12px_40px_rgba(0,0,0,0.06)] bg-slate-100 group">
                <img src="{{asset('blog_images/'.$blog->feature_image)}}" alt="{{$blog->feature_image_alt ?? ''}}" loading="lazy" class="w-full h-auto max-h-[480px] object-cover transition-transform duration-700 group-hover:scale-105">
                <span class="absolute bottom-6 left-6 bg-black/60 backdrop-blur-md text-white px-4 py-1.5 rounded-full text-xs font-medium border border-white/10">
                    <i class="fas fa-camera"></i> Featured
                </span>
            </div>

            <!-- Content -->
            <div id="blog-content-wrapper" class="bg-white rounded-2xl p-5 md:p-8 lg:p-10 shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100">

                <p id="section-intro" class="text-base md:text-lg leading-relaxed text-slate-600 mb-5">{{$blog->excerpt ?? ''}}</p>
                {!! $blog->content ?? '' !!}

                <!-- ===== FAQ SECTION ===== -->
                @if(isset($blog->faq) && $blog->faq->isNotEmpty())
                <div class="faq-section">
                    <div class="faq-title">
                        <i class="fas fa-question-circle"></i>
                        Frequently Asked Questions
                    </div>
                    <p class="faq-subtitle">Find answers to common questions about this topic.</p>

                    <div class="faq-container" id="faqContainer">
                        @foreach($blog->faq as $index => $faq)
                        <div class="faq-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                            <div class="faq-question" onclick="toggleFaq({{ $index }})">
                                <span class="question-text">{{ $faq->question ?? 'Question' }}</span>
                                <i class="fas fa-chevron-down faq-toggle-icon"></i>
                            </div>
                            <div class="faq-answer">
                                {!! $faq->answer ?? '' !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- ===== FEATURED AUTHOR BLOCK ===== -->
            <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] mt-10 transition-shadow duration-300 hover:shadow-[0_8px_32px_rgba(0,0,0,0.06)]">
                <div class="flex flex-col sm:flex-row gap-5 items-start">
                   <div class="w-20 h-20 rounded-full flex-shrink-0
                bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6]
                flex items-center justify-center
                text-white text-3xl font-bold
                shadow-[0_4px_20px_rgba(108,60,225,0.25)]
                relative">

                @if($blog->admin?->image)
                    <img
                        src="{{ asset('admin_image/' . $blog->admin->image) }}"
                        alt="{{ $blog->admin?->name ?? 'Admin' }}"
                        class="w-full h-full object-cover rounded-full">
                @else
                    <span>
                        {{ strtoupper(substr($blog->admin?->name ?? 'A', 0, 1)) }}
                    </span>
                @endif

                <span class="absolute bottom-1 right-1
                            w-[18px] h-[18px]
                            bg-green-500 rounded-full
                            border-[3px] border-white
                            shadow-[0_2px_8px_rgba(34,197,94,0.4)]">
                </span>

            </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 md:gap-4 mb-1">
                            <h4 class="text-xl font-bold text-slate-900 m-0">{{$blog->admin?->name ?? ''}}</h4>
                        </div>
                       <div class="text-sm text-[#6C3CE1] font-medium mb-2">
                            {{ $blog->admin?->getRoleNames()->first() ?? '' }}
                        </div>
                        <p class="text-sm leading-relaxed text-slate-600 mb-3">
                            {{ $blog->admin?->description ?? '' }}
                        </p>
                    </div>
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
                @foreach($latestBlogs as $letestBlog)
                <a href="{{route('blog.show', $letestBlog->slug)}}">
                <div class="flex gap-3 py-2.5 border-b border-slate-100 cursor-pointer transition-all duration-200 items-center hover:pl-1" >
                    <span class="text-xs font-bold text-slate-300 w-5 flex-shrink-0 text-center">{{$loop->iteration ?? ''}}</span>
                    
                    <div class="flex-1 min-w-0">
                        <h5 class="text-sm font-semibold text-slate-900 m-0 mb-0.5 leading-tight">{{$letestBlog->title ?? ''}}</h5>
                        <span class="text-[0.65rem] text-slate-400">{{$letestBlog->created_at->format('M d, Y')}}</span>
                    </div>
                </div>
                </a>
                @endforeach
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.02)]">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-900 uppercase tracking-wide mb-4">
                    <i class="fas fa-folder-open text-[#6C3CE1]"></i>
                    Categories
                </div>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($categories as $cat)
                    <a href="{{url('/blogs') }}?search={{$cat->slug}}"><span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-medium cursor-pointer transition-all duration-200 hover:bg-slate-200 hover:border-[#6C3CE1] hover:text-[#6C3CE1]" >{{$cat->name ?? ''}}</span>
                    </a>
                    @endforeach
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
            </h2>
            <a href="{{route('all-blogs.index')}}"  class="text-[#6C3CE1] font-semibold text-sm no-underline flex items-center gap-1.5 transition-all duration-300 hover:text-[#4A1A8A] hover:translate-x-1 cursor-pointer">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestBlogs as $latestBlog)
            <!-- Card 1 -->
            <a href="{{route('blog.show', ['slug' => $latestBlog->slug])}}"  class="group bg-white rounded-2xl overflow-hidden border border-slate-100 transition-all duration-500 no-underline text-inherit shadow-[0_4px_16px_rgba(0,0,0,0.02)] hover:-translate-y-2 hover:shadow-[0_16px_48px_rgba(108,60,225,0.08)] hover:border-[#6C3CE1]">
                <div class="relative overflow-hidden bg-slate-100 h-48">
                    <img src="{{asset('blog_images/'.$latestBlog->feature_image)}}" alt="{{$latestBlog->feature_image_alt ?? ''}}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <span class="absolute top-4 left-4 bg-[#6C3CE1]/90 backdrop-blur-md text-white px-4 py-1 rounded-full text-[0.65rem] font-semibold uppercase tracking-wide border border-white/10">{{$latestBlog->blogCategory->name ?? ''}}</span>
                    
                </div>
                <div class="p-5 pb-6">
                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                        <span class="w-6 h-6 rounded-full bg-gradient-to-br from-[#6C3CE1] to-[#8B5CF6] flex items-center justify-center text-white text-[0.5rem] font-bold flex-shrink-0"><img src="{{asset('admin_image/'.$latestBlog->admin?->image)}}" alt="image" class="w-full h-full object-cover rounded-full"></span>
                        <span class="font-semibold text-slate-600">{{$latestBlog->admin?->name ?? ''}}</span>
                        <span>•</span>
                        <span>{{$latestBlog->created_at->format('M d, Y')}}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mt-1 mb-2 leading-tight transition-colors duration-200 group-hover:text-[#6C3CE1]">{{$latestBlog->title ?? ''}}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-3 line-clamp-2">{{$latestBlog->excerpt ?? ''}}</p>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                        <span class="text-[#6C3CE1] font-semibold text-xs flex items-center gap-1 transition-all duration-300 group-hover:gap-2">Read More <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>
            @endforeach
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

    // ===== GENERATE TABLE OF CONTENTS DYNAMICALLY =====
    function generateTOC() {
        const wrapper = document.getElementById('blog-content-wrapper');
        if (!wrapper) return;

        // Find all H2 and H3 elements within the wrapper
        const headings = wrapper.querySelectorAll('h2, h3');
        if (headings.length === 0) {
            // If no headings, hide TOC
            const tocList = document.getElementById('tocList');
            const mobileTocList = document.getElementById('mobileTocList');
            if (tocList) tocList.innerHTML = '<li class="text-sm text-slate-400 py-2">No sections found</li>';
            if (mobileTocList) mobileTocList.innerHTML = '<li class="text-sm text-slate-400 py-2">No sections found</li>';
            return;
        }

        let tocHtml = '';
        let mobileTocHtml = '';
        let tocItemCount = 0;

        headings.forEach((heading, index) => {
            // Generate ID if not present
            if (!heading.id) {
                // Clean the text to create an ID
                let id = heading.textContent
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                
                // If empty or too short, use a fallback
                if (!id || id.length < 2) {
                    id = 'section-' + (index + 1);
                }
                heading.id = id;
            }

            const headingId = heading.id;
            const headingText = heading.textContent.trim();
            const isH2 = heading.tagName.toLowerCase() === 'h2';
            const isH3 = heading.tagName.toLowerCase() === 'h3';

            // Determine indentation level
            const indentClass = isH3 ? 'pl-6' : '';
            const dotColor = isH3 ? 'bg-slate-300' : 'bg-[#6C3CE1]';
            const textSize = isH3 ? 'text-xs text-slate-400' : 'text-sm text-slate-600';
            const borderClass = isH3 ? '' : 'border-b border-slate-50';
            
            // Create TOC item for desktop
            tocHtml += `
                <li class="py-1.5 ${borderClass}">
                    <a href="#${headingId}" class="${indentClass} flex items-center gap-2.5 ${textSize} no-underline transition-all duration-200 px-2 py-1 rounded-lg cursor-pointer hover:text-[#6C3CE1] hover:bg-slate-50" data-target="${headingId}">
                        <span class="toc-dot w-1.5 h-1.5 rounded-full ${dotColor} flex-shrink-0 transition-all duration-200"></span>
                        ${headingText}
                    </a>
                </li>
            `;

            // Create TOC item for mobile
            const mobileIndent = isH3 ? 'pl-5' : '';
            const mobileBorder = isH3 ? '' : 'border-b border-slate-50';
            mobileTocHtml += `
                <li class="py-1.5 ${mobileBorder}">
                    <a href="#${headingId}" class="${mobileIndent} ${textSize} no-underline flex items-center gap-2 px-2 py-1 rounded-lg hover:text-[#6C3CE1] hover:bg-slate-50" data-target="${headingId}">
                        ${headingText}
                    </a>
                </li>
            `;

            tocItemCount++;
        });

        // Update DOM
        const tocList = document.getElementById('tocList');
        const mobileTocList = document.getElementById('mobileTocList');

        if (tocList) {
            if (tocItemCount === 0) {
                tocList.innerHTML = '<li class="text-sm text-slate-400 py-2">No sections found</li>';
            } else {
                tocList.innerHTML = tocHtml;
            }
        }

        if (mobileTocList) {
            if (tocItemCount === 0) {
                mobileTocList.innerHTML = '<li class="text-sm text-slate-400 py-2">No sections found</li>';
            } else {
                mobileTocList.innerHTML = mobileTocHtml;
            }
        }
    }

    // ===== FAQ TOGGLE FUNCTION =====
    window.toggleFaq = function(index) {
        const faqItems = document.querySelectorAll('.faq-item');
        const clickedItem = faqItems[index];
        
        if (!clickedItem) return;
        
        // If clicked item is already active, close it
        if (clickedItem.classList.contains('active')) {
            clickedItem.classList.remove('active');
            return;
        }
        
        // Close all other items
        faqItems.forEach(item => {
            item.classList.remove('active');
        });
        
        // Open the clicked item
        clickedItem.classList.add('active');
    };

    // ===== READING PROGRESS =====
    const progressBar = document.getElementById('readingProgressModern');

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

        // Update progress bar at top
        if (progressBar) {
            progressBar.style.width = percent + '%';
        }

        // Highlight active TOC item
        const headings = document.querySelectorAll('#blog-content-wrapper h2, #blog-content-wrapper h3');
        const tocLinks = document.querySelectorAll('#tocList a, #mobileTocList a');

        let currentSection = null;
        let currentIndex = -1;

        headings.forEach((section, idx) => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= 120) {
                currentSection = section.id;
                currentIndex = idx;
            }
        });

        tocLinks.forEach(link => {
            link.classList.remove('active');
            if (link.dataset.target === currentSection) {
                link.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', function() {
        const scrollTop = window.scrollY;
        
        // Back to top button
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

    // ===== BACK TO TOP =====
    document.getElementById('backToTopModern').addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // ===== MOBILE TOC TOGGLE =====
    window.toggleMobileTOC = function() {
        const list = document.getElementById('mobileTocList');
        const icon = document.querySelector('.mobile-toc-toggle-icon');
        
        if (list) {
            const isOpen = list.style.maxHeight !== '0px' && list.style.maxHeight !== '';
            
            if (isOpen) {
                list.style.maxHeight = '0px';
                if (icon) icon.classList.remove('rotate-180');
            } else {
                // Calculate content height
                list.style.maxHeight = list.scrollHeight + 'px';
                if (icon) icon.classList.add('rotate-180');
            }
        }
    };

    // Close mobile TOC when a link is clicked
    document.addEventListener('click', function(e) {
        const mobileLink = e.target.closest('#mobileTocList a');
        if (mobileLink) {
            const list = document.getElementById('mobileTocList');
            const icon = document.querySelector('.mobile-toc-toggle-icon');
            if (list) {
                list.style.maxHeight = '0px';
                if (icon) icon.classList.remove('rotate-180');
            }
        }
    });

    // ===== TOC SMOOTH SCROLL =====
    document.addEventListener('click', function(e) {
        const link = e.target.closest('#tocList a, #mobileTocList a');
        if (link && link.getAttribute('href')) {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const target = document.querySelector(targetId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });

    // ===== NAVIGATION FUNCTIONS =====
    window.goToBlogIndex = function() {
        window.location.href = "{{url('/blogs')}}";
    };

    // ===== GENERATE TOC ON PAGE LOAD =====
    // Run after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            generateTOC();
            // Initial TOC progress update
            setTimeout(updateTOCProgress, 200);
        });
    } else {
        generateTOC();
        setTimeout(updateTOCProgress, 200);
    }

    // Re-generate TOC if content changes dynamically (for any reason)
    // This is a safety net
    setTimeout(generateTOC, 500);

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
    #tocList a.active {
        color: #6C3CE1;
        font-weight: 600;
    }
    #tocList a.active .toc-dot {
        background-color: #6C3CE1;
        width: 8px;
        height: 8px;
    }
    #mobileTocList a.active {
        color: #6C3CE1;
        font-weight: 600;
    }
    .mobile-toc-toggle-icon {
        transition: transform 0.3s ease;
    }
    .mobile-toc-toggle-icon.rotate-180 {
        transform: rotate(180deg);
    }
</style>

@endsection