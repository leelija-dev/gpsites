@extends('layouts.web.main-layout')

@section('title', 'Blogs')
@section('description', 'GPsites: one-stop link-building outreach automation tool and best backlinks marketplace helps you in extensive targeted outreach for quality link placements.')
@section('keywords', 'blogs, articles, restaurant tech, tips')
@section('indexing', 'no')

@section('content')
    <!-- Blogs Section -->
    <section class="blogs-section py-5">
        <div class="container">

            {{-- Page Header --}}
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="text-uppercase text-muted fw-bold mb-2">Test Category</h6>
                    <h1 class="display-4 fw-bold">Our Blogs</h1>
                    <p class="lead text-muted">Explore our latest articles and insights</p>
                </div>
            </div>

            {{-- ALL BLOGS LIST --}}
            <div class="row">
                <div class="col-12">
                    @forelse($blogs ?? [] as $blog)
                        <div class="blog-list-item py-4 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    {{-- Date --}}
                                    <div class="blog-meta mb-2">
                                        <span class="text-muted small">
                                            <i class="far fa-calendar-alt me-1"></i> 
                                            {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'Aug 11, 2026' }}
                                        </span>
                                    </div>
                                    
                                    {{-- Title --}}
                                    <h3 class="h4 fw-bold mb-2">
                                        <a href="{{ route('blog.show', $blog->slug ?? $blog->id) }}" class="text-dark text-decoration-none">
                                            {{ $blog->title ?? 'test 2' }}
                                        </a>
                                    </h3>
                                    
                                    {{-- Excerpt --}}
                                    <p class="text-muted mb-0">
                                        {{ Str::limit($blog->excerpt ?? $blog->content ?? 'Distributing tips manually is the best and most effective way to reward your restaurant staff, and', 100) }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
                                        {{-- Author Avatar --}}
                                        <div class="d-flex align-items-center me-3">
                                            <img src="{{ asset('blog_images/'.$blog->feature_image) ?? asset('images/avatar-placeholder.jpg') }}" 
                                                 alt="{{ $blog->author ?? 'Samann Kabir' }}" 
                                                 class="rounded-circle me-2" 
                                                 width="35" height="35" 
                                                 style="object-fit: cover;">
                                            <span class="fw-bold small">{{ $blog->author ?? 'Samann Kabir' }}</span>
                                        </div>
                                        
                                        {{-- Read Button --}}
                                        <a href="{{ route('blog.show', $blog->slug ?? $blog->id) }}" class="btn btn-outline-dark btn-sm rounded-pill px-4">
                                            Read <span class="ms-1">→</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Fallback static blog list --}}
                        @php
                            $fallbackCount = 3; // Change to 1 to match your image
                        @endphp
                        
                        @for($i = 0; $i < $fallbackCount; $i++)
                            <div class="blog-list-item py-4 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="blog-meta mb-2">
                                            <span class="text-muted small">
                                                <i class="far fa-calendar-alt me-1"></i> Aug 11, 2026
                                            </span>
                                        </div>
                                        
                                        <h3 class="h4 fw-bold mb-2">
                                            <a href="#" class="text-dark text-decoration-none">
                                                test 2
                                            </a>
                                        </h3>
                                        
                                        <p class="text-muted mb-0">
                                            Distributing tips manually is the best and most effective way to reward your restaurant staff, and
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
                                            <div class="d-flex align-items-center me-3">
                                                <img src="{{ asset('images/avatar-placeholder.jpg') }}" 
                                                     alt="Samann Kabir" 
                                                     class="rounded-circle me-2" 
                                                     width="35" height="35" 
                                                     style="object-fit: cover;">
                                                <span class="fw-bold small">Samann Kabir</span>
                                            </div>
                                            <a href="#" class="btn btn-outline-dark btn-sm rounded-pill px-4">
                                                Read <span class="ms-1">→</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endforelse
                </div>
            </div>

            {{-- Article Count --}}
            <div class="row mt-4">
                <div class="col-12">
                    <p class="text-muted small">
                        Showing {{ isset($blogs) ? $blogs->count() : 1 }} articles
                    </p>
                </div>
            </div>

            {{-- Pagination --}}
            @if(isset($blogs) && method_exists($blogs, 'links'))
                <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $blogs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection