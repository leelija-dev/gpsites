@extends('layouts.web.main-layout')

@section('title', 'Free 7-Day Trial: Link Building & Outreach Tool | GPSites')
@section('description', 'Try GPSites free for 7 days. Search guest posting sites by niche, DA, DR and traffic, then send your first outreach offers. No credit card required.')
@section('indexing', 'yes')

@php
    $trialDays = 7;
    $trialCredits = (int) ($trialPlan->mail_available ?? 3) ?: 3;
    $creditsLabel = $trialCredits . ' email ' . \Illuminate\Support\Str::plural('credit', $trialCredits);
    $isLoggedIn = auth()->check();
    $trialAlreadyUsed = $isLoggedIn && (int) (auth()->user()->is_trial ?? 0) === 1;

    $trialFaqs = [
        ['q' => 'Do I need a credit card to start the free trial?',
         'a' => 'No. You create a free account (or log in), confirm the trial on the checkout page and start using GPSites. We do not ask for card or PayPal details for the trial.'],
        ['q' => 'How long does the GPSites free trial last?',
         'a' => "The trial runs for {$trialDays} days from the day you activate it on the checkout page, not from the day you sign up."],
        ['q' => 'How many outreach emails can I send during the trial?',
         'a' => "The trial includes {$creditsLabel}. Each one lets you contact a publisher, so use them on the sites you are most interested in."],
        ['q' => 'What happens when the trial ends?',
         'a' => 'Trial access and any unused credits stop after ' . $trialDays . ' days. Nothing is charged, because no payment method was added. If GPSites suits your workflow, choose a monthly plan to keep going.'],
        ['q' => 'Can I start the free trial more than once?',
         'a' => 'No. Each account can activate one free trial. If you have already used yours, you can pick a plan from the pricing section at any time.'],
        ['q' => 'Which niches can I search during the trial?',
         'a' => 'You can filter publishers across around 30 niches, including technology, finance, health, business, education, real estate, lifestyle, food and fashion. Combine a niche with minimum DA, DR and traffic to narrow the list.'],
        ['q' => 'Will publishers accept every offer I send?',
         'a' => 'Not always. Publishers decide whether to accept an offer, and many have their own content guidelines. Relevant sites, a clear proposal and a fair price give you the best chance of a reply.'],
        ['q' => 'Is the trial right for agencies?',
         'a' => 'Yes. Agencies use the trial to check publisher quality in their clients\' niches before committing. The Agency plan adds negotiated publisher prices and direct ordering once you upgrade.'],
    ];

    $trialSchema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebPage',
                '@id' => route('start-trial.page') . '#webpage',
                'url' => route('start-trial.page'),
                'name' => 'Free 7-Day Trial of GPSites',
                'description' => "Try GPSites free for {$trialDays} days with {$creditsLabel}. No credit card required.",
                'isPartOf' => ['@id' => url('/') . '#website'],
                'about' => ['@id' => url('/') . '#software'],
                'breadcrumb' => ['@id' => route('start-trial.page') . '#breadcrumb'],
                'inLanguage' => 'en-US',
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => route('start-trial.page') . '#breadcrumb',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Free trial'],
                ],
            ],
            [
                '@type' => 'FAQPage',
                '@id' => route('start-trial.page') . '#faq',
                'mainEntity' => array_map(fn ($f) => [
                    '@type' => 'Question',
                    'name' => $f['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                ], $trialFaqs),
            ],
        ],
    ];
@endphp

@push('head')
    <link rel="preload" as="image" type="image/webp"
        imagesrcset="{{ asset('images/home-hero-480.webp') }} 480w, {{ asset('images/home-hero.webp') }} 909w"
        imagesizes="(max-width: 700px) 90vw, 50vw" fetchpriority="high">
    <script type="application/ld+json">{!! json_encode($trialSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    <style>
        .gp-trial-page .gp-trial-cta{margin:0;display:inline-block}
        .gp-trial-page .gp-trial-cta .gp-button{border:0;cursor:pointer;font:inherit;font-weight:600}
        .gp-trial-page .gp-facts{display:flex;flex-wrap:wrap;gap:10px 22px;margin:18px 0 0;padding:0;list-style:none;font-size:14px;color:#29263f}
        .gp-trial-page .gp-facts li:before{content:'✓';color:#5428ff;font-weight:700;margin-right:8px}
        .gp-trial-page .gp-plan-days{display:grid;gap:14px;counter-reset:day}
        .gp-trial-page .gp-plan-days .gp-card{display:grid;grid-template-columns:120px 1fr;gap:18px;align-items:start}
        .gp-trial-page .gp-plan-days b{color:#5428ff;font-size:14px}
        .gp-trial-page .gp-compare td,.gp-trial-page .gp-compare th{font-size:14px;white-space:normal}
        .gp-trial-page .gp-compare tr.gp-row-trial td{background:#f7f4ff;font-weight:600}
        .gp-trial-page .gp-used{background:#fff7e6;border:1px solid #f3d08a;color:#6b4a00;padding:12px 16px;border-radius:7px;font-size:14px;margin-top:18px}
        @media(max-width:700px){.gp-trial-page .gp-plan-days .gp-card{grid-template-columns:1fr;gap:6px}}
    </style>
@endpush

@php
    // One trial button used in several places. Same behaviour as the homepage buttons.
    $trialButton = function (string $label = 'Start Free Trial', string $class = '') use ($isLoggedIn) {
        return view('web.partials.start-trial-button', compact('label', 'class', 'isLoggedIn'))->render();
    };
@endphp

@section('content')
<div class="gp-page gp-trial-page">

    {{-- Hero --}}
    <section class="gp-section gp-hero">
        <div class="gp-container gp-split">
            <div>
                <nav class="gp-crumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Free trial</span>
                </nav>
                <span class="gp-eyebrow">Free {{ $trialDays }}-day trial</span>
                <h1>Try GPSites free for {{ $trialDays }} days</h1>
                <p>Search real publisher websites by niche, DA, DR and traffic, check the details that matter, and send your first outreach offers. You'll know within a week whether GPSites fits the way you build links.</p>

                @if ($trialAlreadyUsed)
                    <div class="gp-used">You have already used your free trial on this account. Pick a plan to keep finding publishers and sending offers.</div>
                    <div class="gp-actions">
                        <a class="gp-button" href="{{ url('/#pricing') }}">View plans</a>
                        <a class="gp-button gp-outline" href="{{ route('contact') }}">Talk to our team</a>
                    </div>
                @else
                    <div class="gp-actions">
                        {!! $trialButton('Start Free Trial') !!}
                        <a class="gp-button gp-outline" href="#how-it-works">See how it works</a>
                    </div>
                @endif

                <ul class="gp-facts">
                    <li>{{ $trialDays }} days free</li>
                    <li>{{ $creditsLabel }}</li>
                    <li>No credit card</li>
                    <li>One trial per account</li>
                </ul>
            </div>
            <div>
                <picture>
                    <source type="image/webp"
                        srcset="{{ asset('images/home-hero-480.webp') }} 480w, {{ asset('images/home-hero.webp') }} 909w"
                        sizes="(max-width: 700px) 90vw, 50vw">
                    <img class="gp-art" src="{{ asset('images/home-hero.png') }}"
                        alt="GPSites publisher search filtered by niche, DA, DR and traffic"
                        width="909" height="513" loading="eager" fetchpriority="high" decoding="async">
                </picture>
            </div>
        </div>
    </section>

    {{-- What's included --}}
    <section class="gp-section">
        <div class="gp-container">
            <span class="gp-eyebrow">What's included</span>
            <h2>Everything you need to test publisher outreach properly</h2>
            <p>The trial isn't a demo with fake data. You work with the same publisher network and outreach tools our paying customers use.</p>
            <div class="gp-grid gp-cols-4">
                <article class="gp-card">
                    <span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg></span>
                    <h3>Publisher search</h3>
                    <p>Filter guest posting sites by niche, Domain Authority, Domain Rating and monthly traffic to build a shortlist in minutes.</p>
                </article>
                <article class="gp-card">
                    <span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 5-6"/></svg></span>
                    <h3>Site insights</h3>
                    <p>Review each site's metrics and available placement types, such as guest posts and link insertions, before you reach out.</p>
                </article>
                <article class="gp-card">
                    <span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg></span>
                    <h3>{{ ucfirst($creditsLabel) }}</h3>
                    <p>Send personalised offers to publishers directly from GPSites, using contact details our team keeps up to date.</p>
                </article>
                <article class="gp-card">
                    <span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18M8 2v4M16 2v4"/></svg></span>
                    <h3>Offer tracking</h3>
                    <p>Keep conversations and offers in one place, so you can see who replied and what was agreed.</p>
                </article>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="gp-section gp-tint" id="how-it-works">
        <div class="gp-container">
            <span class="gp-eyebrow">How it works</span>
            <h2>Start your trial in under two minutes</h2>
            <div class="gp-grid gp-cols-4">
                <article class="gp-step">
                    <span class="gp-icon"><b>1</b></span>
                    <div><h3>Click Start Free Trial</h3><p>Use any trial button on this page.</p></div>
                </article>
                <article class="gp-step">
                    <span class="gp-icon"><b>2</b></span>
                    <div><h3>Log in or sign up</h3><p>Create a free GPSites account, or log in if you already have one.</p></div>
                </article>
                <article class="gp-step">
                    <span class="gp-icon"><b>3</b></span>
                    <div><h3>Confirm your trial</h3><p>Activate it on the checkout page. No payment details are needed.</p></div>
                </article>
                <article class="gp-step">
                    <span class="gp-icon"><b>4</b></span>
                    <div><h3>Find sites and send offers</h3><p>Your {{ $trialDays }} days start now. Search, shortlist and reach out.</p></div>
                </article>
            </div>
        </div>
    </section>

    {{-- How to use the 7 days --}}
    <section class="gp-section">
        <div class="gp-container gp-split" style="align-items:start">
            <div>
                <span class="gp-eyebrow">Make the most of it</span>
                <h2>A simple plan for your {{ $trialDays }}-day trial</h2>
                <p>With {{ $creditsLabel }}, the trial rewards focus. Here's how SEO teams usually get a clear answer before the week is over.</p>
                <p>Pick one real campaign, such as a client site or a page you want to rank, and test GPSites against it. You'll learn far more than by browsing at random.</p>
            </div>
            <div class="gp-plan-days">
                <article class="gp-card"><b>Day 1</b><div><h3>Build your shortlist</h3><p>Filter by your niche and minimum DA, DR and traffic. Save 15 to 20 sites that genuinely match your topic.</p></div></article>
                <article class="gp-card"><b>Day 2</b><div><h3>Check the details</h3><p>Compare metrics and placement options, then narrow the list to the {{ $trialCredits }} sites you'd be happiest to appear on.</p></div></article>
                <article class="gp-card"><b>Day 2 to 3</b><div><h3>Send your best offers</h3><p>Write a short, specific pitch for each publisher. Mention the topic you'd cover and why it suits their readers.</p></div></article>
                <article class="gp-card"><b>Day 4 to 7</b><div><h3>Track replies and decide</h3><p>Follow the conversations in GPSites, note response quality, and compare the plans against your monthly outreach volume.</p></div></article>
            </div>
        </div>
    </section>

    {{-- Trial vs plans --}}
    @if ($plans->count())
    <section class="gp-section gp-tint">
        <div class="gp-container">
            <span class="gp-eyebrow">After the trial</span>
            <h2>Keep going with the plan that fits your workload</h2>
            <p>Nothing is charged when the trial ends. If GPSites works for you, upgrade to a monthly plan for more daily emails and wider publisher access.</p>
            <div class="gp-table-panel gp-scroll" style="background:#fff">
                <table class="gp-compare">
                    <thead>
                        <tr><th scope="col">Plan</th><th scope="col">Price</th><th scope="col">Outreach emails</th><th scope="col">Highlights</th></tr>
                    </thead>
                    <tbody>
                        <tr class="gp-row-trial">
                            <td>Free trial</td>
                            <td>$0</td>
                            <td>{{ $trialCredits }} in total</td>
                            <td>{{ $trialDays }} days, no credit card</td>
                        </tr>
                        @foreach ($plans as $plan)
                            @php $highlights = $plan->features->where('is_active', true)->pluck('feature')->take(3)->implode(' · '); @endphp
                            <tr>
                                <td>{{ $plan->name }}</td>
                                <td>{{ config('app.currency', '$') }}{{ number_format((float) $plan->price) }} / month</td>
                                <td>{{ number_format((int) $plan->mail_available) }} per day</td>
                                <td>{{ $highlights }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="gp-actions"><a class="gp-link" href="{{ url('/#pricing') }}">Compare every plan feature →</a></div>
        </div>
    </section>
    @endif

    {{-- FAQ --}}
    <section class="gp-section" id="faq">
        <div class="gp-container">
            <span class="gp-eyebrow">FAQ</span>
            <h2>Free trial questions, answered</h2>
            <div class="gp-faq gp-faq-columns">
                @foreach ($trialFaqs as $i => $faq)
                    <details {{ $i === 0 ? 'open' : '' }}>
                        <summary>{{ $faq['q'] }}</summary>
                        <div>{{ $faq['a'] }}</div>
                    </details>
                @endforeach
            </div>
            <p class="gp-note">Still deciding? <a class="gp-link" href="{{ route('contact') }}">Ask our team a question</a> or read the <a class="gp-link" href="{{ route('all-blogs.index') }}">GPSites blog</a> for practical link building guides.</p>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="gp-section gp-cta">
        <div class="gp-container">
            <h2>Find your first publishers this week</h2>
            <p>{{ $trialDays }} days free · {{ $creditsLabel }} · No credit card required</p>
            <div class="gp-actions">
                @if ($trialAlreadyUsed)
                    <a class="gp-button gp-white" href="{{ url('/#pricing') }}">View plans</a>
                @else
                    {!! $trialButton('Start Free Trial', 'gp-white') !!}
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
