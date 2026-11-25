@extends('layouts.web.main-layout')

@section('title', 'About GPSites | Link Building Marketplace by Leelija')
@section('description', 'GPSites, by Leelija, is a link building marketplace with done-for-you outreach: we contact site owners, negotiate prices and audit every site every six months.')
@section('keywords', 'about gpsites')
@section('indexing', 'yes')

{{-- 1. ADD ISOLATION CSS DIRECTLY TO THE PAGE --}}
@push('styles')
<style>
    /* 
      This isolates your GPSites styles from the main layout.
      It forces the parent <main> to act as a normal block, 
      preventing your content from overlapping or pushing the navbar.
    */
    main {
        display: block !important;
        position: relative !important;
        min-height: auto !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .gp-isolated-page {
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden; /* Prevents side-scrolling from absolute elements */
        position: relative;
        z-index: 1;
        /* Add top padding if your navbar is sticky/fixed and overlapping */
        padding-top: 80px; 
    }

    /* Ensure the navbar stays above your content */
    nav, header { 
        position: relative;
        z-index: 50; 
    }
</style>
@endpush

@section('content')
{{-- 2. WRAP IN THE ISOLATION DIV --}}
<div class="gp-isolated-page">
    <div class="gp-page gp-about">
        <section class="gp-section gp-hero">
            <div class="gp-container">
                <nav class="gp-crumb" aria-label="Breadcrumb"><a href="{{ $homeUrl ?? url('/') }}">Home</a> / <span aria-current="page">About</span></nav>
                <div class="gp-split">
                    <div><span class="gp-eyebrow">A Leelija platform</span>
                        <h1>About <span>GPSites</span></h1>
                        <h2 class="gp-subheading">Better connections.<br>More organized outreach.</h2>
                        <p>GPSites is a link building marketplace and outreach automation platform that helps SEO agencies and businesses find relevant publishers, send offers and manage orders. Leelija is our parent company.</p>
                        <div class="gp-actions"><a class="gp-button " href="{{ $homeUrl ?? url('/') }}">Explore GPSites</a><a class="gp-button gp-outline" href="{{ $contactUrl ?? url('/contact') }}">Contact Our Team</a></div>
                    </div>
                    <div><img class="gp-art" src="{{ asset('/images/about/about-hero.webp') }}" alt="GPSites team planning publisher outreach" width="1572" height="924" loading="eager" fetchpriority="high" decoding="async"></div>
                </div>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container">
                <div class="gp-split gp-story">
                    <div>
                        <h2 class="gp-underline">Why GPSites exists</h2>
                        <blockquote>More time for the<br>decisions that matter.</blockquote>
                    </div>
                    <div>
                        <p>Finding suitable websites, tracking down the real owner, agreeing terms and chasing replies can take weeks for a handful of links.</p>
                        <p>So our outreach team does that part. We contact site owners and editors, get them to agree to guest posts or link insertions, negotiate the minimum price and collect each site's publishing guidelines. You choose the sites and the content that fit your goals, and skip the outreach headache.</p>
                    </div>
                </div>
                <div class="gp-grid gp-cols-2 ">
                    <article class="gp-card gp-horizontal gp-mission"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9" />
                                <circle cx="12" cy="12" r="5" />
                                <path d="m12 12 9-9M17 2v5h5" />
                            </svg></span>
                        <div>
                            <h3>Our mission</h3>
                            <p>Reduce repetitive publisher outreach work while giving agencies and businesses more control over their campaigns.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal gp-mission"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12q11-16 22 0-11 16-22 0Z" />
                                <circle cx="12" cy="12" r="4" />
                            </svg></span>
                        <div>
                            <h3>Our vision</h3>
                            <p>Make publisher outreach easier to understand and manage through useful information, direct relationships and practical automation.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="gp-section gp-dark">
            <div class="gp-container">
                <div class="gp-split">
                    <div><span class="gp-eyebrow">Parent company</span>
                        <h2>Part of Leelija</h2>
                        <p>Leelija is the parent company of GPSites. Its services span design, website and product development, SEO and digital marketing.</p>
                        <p>GPSites focuses on helping marketers discover publishers and organize outreach.</p><a class="gp-button gp-white" href="https://leelija.com/">Learn more about Leelija ↗</a>
                    </div>
                    <div class="gp-brand-pair">
                        <div><strong>Leelija</strong><b>Parent company</b>
                            <p>Design, development,<br>SEO and digital marketing</p>
                        </div><span>······</span>
                        <div><strong class="gp-wordmark">GPSITES</strong><b>Publisher outreach platform</b>
                            <p>Find publishers, send offers<br>and manage campaigns</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('web.partials.service-groundwork', ['headingClass' => 'gp-underline'])
        <section class="gp-section gp-tint">
            <div class="gp-container">
                <h2 class="gp-underline">What GPSites helps you do</h2>
                <div class="gp-tools">
                    <div class="gp-grid gp-cols-2 ">
                        <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="10" cy="10" r="7" />
                                    <path d="m15 15 6 6" />
                                </svg></span>
                            <div>
                                <h3>Find relevant publishers</h3>
                                <p>Search our database to find sites that fit your campaign.</p>
                            </div>
                        </article>
                        <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <path d="m3 6 9 7 9-7" />
                                </svg></span>
                            <div>
                                <h3>Send offers or order</h3>
                                <p>Send single or bulk offers to verified owner emails, or order through GPSites.</p>
                            </div>
                        </article>
                        <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 3h9l9 9-9 9-9-9V3Z" />
                                    <circle cx="8" cy="8" r="1" />
                                </svg></span>
                            <div>
                                <h3>Use negotiated prices</h3>
                                <p>Agency members see our negotiated prices and order at them.</p>
                            </div>
                        </article>
                        <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 5h14M8 12h14M8 19h14M2 5h1M2 12h1M2 19h1" />
                                </svg></span>
                            <div>
                                <h3>Keep campaigns organized</h3>
                                <p>Manage offers, orders and automatic follow-ups.</p>
                            </div>
                        </article>
                    </div><img class="gp-art" src="{{ asset('/images/about/about-tools.webp') }}" alt="GPSites outreach tools overview" width="1576" height="1360" loading="lazy" decoding="async">
                </div><a class="gp-link" href="{{ $homeUrl ?? url('/') }}">Explore the GPSites platform →</a>
            </div>
        </section>
        @include('web.partials.buying-options', ['headingClass' => 'gp-underline'])

        <section class="gp-section ">
            <div class="gp-container">
                <h2 class="gp-underline">Who we help</h2>
                <div class="gp-grid gp-cols-3 gp-audiences">
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="7" r="3" />
                                <circle cx="18" cy="8" r="2" />
                                <path d="M2 21v-3a7 7 0 0 1 14 0v3H2ZM17 14q5 0 5 7h-4" />
                            </svg></span>
                        <div>
                            <h3>SEO agencies</h3>
                            <p>Organize outreach for multiple clients and manage campaigns in one place.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m2 7 10-5 10 5 M4 8v14h16V8 M8 10v2m4-2v2m4-2v2M8 15v2m4-2v2m4 0v-2M10 22v-3h4v3" />
                            </svg></span>
                        <div>
                            <h3>In-house marketing teams</h3>
                            <p>Find relevant publishers and keep outreach organized across campaigns.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="7" r="3" />
                                <circle cx="18" cy="8" r="2" />
                                <path d="M2 21v-3a7 7 0 0 1 14 0v3H2ZM17 14q5 0 5 7h-4" />
                            </svg></span>
                        <div>
                            <h3>Independent marketers</h3>
                            <p>Discover opportunities and manage outreach without the manual work.</p>
                        </div>
                    </article>
                </div>
                <h2 class="gp-underline">The principles behind our approach</h2>
                <div class="gp-grid gp-cols-4 ">
                    <article class="gp-principle"><b>01</b>
                        <h3>Relevance comes first</h3>
                        <p>Consider the publisher’s audience and content alongside metrics.</p>
                    </article>
                    <article class="gp-principle"><b>02</b>
                        <h3>Automation supports the work</h3>
                        <p>Reduce repetitive sending and follow-up tasks.</p>
                    </article>
                    <article class="gp-principle"><b>03</b>
                        <h3>People remain part of the process</h3>
                        <p>Keep clear communication at the heart of publisher relationships.</p>
                    </article>
                    <article class="gp-principle"><b>04</b>
                        <h3>Useful content matters</h3>
                        <p>Create content readers can use and agree appropriate disclosures for paid placements.</p>
                    </article>
                </div>
            </div>
        </section>
        <section class="gp-section gp-tint">
            <div class="gp-container">
                <div class="gp-split">
                    <div>
                        <h2 class="gp-underline">The people behind the platform</h2>
                        <p>Our work combines publisher outreach with the technology that helps you manage campaigns. Behind the listings are conversations with owners, contact updates and price negotiations.</p><a class="gp-button " href="{{ $contactUrl ?? url('/contact') }}">Speak with the GPSites team</a>
                    </div><img class="gp-art" src="{{ asset('/images/about/about-team.webp') }}" alt="The team behind GPSites" width="1288" height="464" loading="lazy" decoding="async">
                </div>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container">
                <h2 class="gp-underline">Questions about GPSites</h2>
                <div class="gp-faq gp-faq-columns">
                    <details open>
                        <summary>Who is the parent company of GPSites?</summary>
                        <div>Leelija is the parent company of GPSites, providing design, development, SEO and digital marketing services.</div>
                    </details>
                    <details>
                        <summary>What is GPSites?</summary>
                        <div>A link building marketplace with done-for-you publisher outreach. We contact and vet the sites; you pick them and send offers or order.</div>
                    </details>
                    <details>
                        <summary>Is GPSites a marketplace or an outreach tool?</summary>
                        <div>Both. Our team does the publisher outreach and negotiation, and the platform lets you send offers, order through us and manage every conversation. Agency members can also see our negotiated prices and order at them.</div>
                    </details>
                    <details>
                        <summary>How do you maintain publisher information?</summary>
                        <div>Our team contacts site owners and editors, verifies that each contact email is the owner's or editor's own, negotiates the minimum price and collects publishing guidelines. We only list sites with stable, permanent traffic and strong metrics, and every site is audited every six months.</div>
                    </details>
                    <details>
                        <summary>Where is the GPSites team based?</summary>
                        <div>Taki Road, Bamunmura, Barasat, Kolkata 700125, West Bengal, India.</div>
                    </details>
                    <details>
                        <summary>Is GP Sites the same as GPSites.io?</summary>
                        <div>GPSites is the brand name used at gpsites.io.</div>
                    </details>
                </div>
            </div>
        </section>
        <section class="gp-section gp-cta">
            <div class="gp-container">
                <h2>Let us help you plan your next outreach campaign</h2>
                <p>Tell us your niche, target publishers and campaign size.</p>
                <div class="gp-actions"><a class="gp-button gp-white" href="{{ $contactUrl ?? url('/contact') }}">Contact Our Team</a><a class="gp-button gp-outline" href="{{ $pricingUrl ?? url('/#pricing') }}">Compare Plans</a></div>
            </div>
        </section>
    </div>
</div>
@endsection