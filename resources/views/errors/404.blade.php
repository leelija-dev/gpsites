@extends('layouts.web.main-layout')

@section('title', 'Page not found | GPSites')
@section('description', 'The page you were looking for could not be found. Explore GPSites pricing, the blog or contact our team.')
@section('indexing', 'no')

@php
    // Error pages can render without the session middleware, so $errors may be missing.
    // The footer's newsletter form uses @error, so share an empty bag.
    view()->share('errors', $errors ?? new \Illuminate\Support\ViewErrorBag);
@endphp

@section('content')
    <div class="gp-page">
        <section class="gp-section gp-hero">
            <div class="gp-container" style="text-align:center;max-width:720px">
                <span class="gp-eyebrow">Error 404</span>
                <h1>We couldn't find that page</h1>
                <p>The link may be out of date, or the page may have moved. Try one of these instead.</p>

                <form action="{{ route('all-blogs.index') }}" method="GET" role="search"
                    style="display:flex;gap:10px;max-width:480px;margin:24px auto 0">
                    <label for="notfound-search" class="sr-only">Search the blog</label>
                    <input id="notfound-search" type="search" name="search" placeholder="Search the GPSites blog"
                        style="flex:1;min-height:44px;padding:0 14px;border:1px solid #dcdcec;border-radius:6px">
                    <button type="submit" class="gp-button">Search</button>
                </form>

                <div class="gp-actions" style="justify-content:center">
                    <a class="gp-button" href="{{ route('home') }}">Go to the homepage</a>
                    <a class="gp-button gp-outline" href="{{ url('/#pricing') }}">See pricing</a>
                    <a class="gp-button gp-outline" href="{{ route('all-blogs.index') }}">Read the blog</a>
                    <a class="gp-button gp-outline" href="{{ route('contact') }}">Contact us</a>
                </div>
            </div>
        </section>
    </div>
@endsection
