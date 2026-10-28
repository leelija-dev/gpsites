@extends('layouts.web.main-layout')

@section('title', 'Contact')
@section('description', 'Contact GPSites for sales, support, or publisher inquiries. We are here to help you with your outreach campaigns.')
@section('keywords', 'contact gpsites, gpsites contact number, gpsites email')
@section('indexing', 'no')

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
    <div class="gp-page gp-contact">
        <section class="gp-section gp-hero">
            <div class="gp-container">
                <nav class="gp-crumb" aria-label="Breadcrumb"><a href="{{ $homeUrl ?? url('/') }}">Home</a> / <span aria-current="page">Contact</span></nav>
                <div class="gp-split">
                    <div><span class="gp-eyebrow">Sales, support & publisher inquiries</span>
                        <h1>Contact <span>GPSites</span></h1>
                        <p>Have a question about GPSites, need help with a campaign, or want to discuss a publisher partnership? We’re here to help you find the next step.</p>
                        <p>GPSites is a link building marketplace and outreach automation platform. Leelija is our parent company.</p>
                        <div class="gp-actions"><a class="gp-button " href="#gp-inquiry">Send an Inquiry</a><a class="gp-button gp-outline" href="mailto:info@leelija.com">Email Our Team</a></div>
                    </div>
                    <div><img class="gp-art" src="{{ asset('gpsites/images/contact-hero.webp') }}" alt="" width="320" height="198" loading="lazy"></div>
                </div>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container">
                <div class="gp-contact-grid">
                    <div>
                        <h2 class="gp-underline">Let’s start a conversation</h2>
                        <article class="gp-card gp-detail"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <path d="m3 6 9 7 9-7" />
                                </svg></span>
                            <div>
                                <h3>Email our team</h3>
                                <p><a class="gp-link" href="mailto:info@leelija.com">info@leelija.com</a><small>Include “GPSites” in your subject line.</small></p>
                            </div>
                        </article>
                        <article class="gp-card gp-detail"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m5 2 4 5-3 3q2 6 8 8l3-3 5 4q-1 5-6 3C8 20 3 15 2 7q-1-4 3-5Z" />
                                </svg></span>
                            <div>
                                <h3>Call GPSites</h3>
                                <p><a class="gp-link" href="tel:+916290101838">+91 629 010 1838</a><br><a class="gp-link" href="tel:+913325849017">+91 332 584 9017</a><small>For a callback, include your preferred time and time zone.</small></p>
                            </div>
                        </article>
                        <article class="gp-card gp-detail"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg></span>
                            <div>
                                <h3>Our contact address</h3>
                                <p>Taki Road, Bamunmura, Barasat<br>Kolkata 700125, West Bengal, India<small>Please contact us before planning an in-person meeting.</small></p>
                            </div>
                        </article>
                        <article class="gp-card gp-detail gp-parent"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m2 7 10-5 10 5 M4 8v14h16V8 M8 10v2m4-2v2m4-2v2M8 15v2m4-2v2m4 0v-2M10 22v-3h4v3" />
                                </svg></span>
                            <div>
                                <h3>Part of Leelija</h3>
                                <p><a class="gp-link" href="https://leelija.com/">Learn about our parent company →</a></p>
                            </div>
                        </article>
                    </div>
                    <div class="gp-form-card">@include('web.partials.form')</div>
                </div>
            </div>
        </section>
        <section class="gp-section gp-tint">
            <div class="gp-container">
                <h2 class="gp-underline">How can we help?</h2>
                <div class="gp-grid gp-cols-3 ">
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6" />
                            </svg></span>
                        <div>
                            <h3>Plans & agency requirements</h3>
                            <p>Share your niche, expected outreach volume and team requirements. We’ll help you understand your options.<br><a class="gp-link" href="{{ $pricingUrl ?? url('/#pricing') }}">Compare GPSites plans →</a></p>
                        </div>
                    </article>
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 2-1 3-3 1-3 4 2 2-1 4 3 3 3-1 3 4 4-1 1-3 4-2-1-4 2-3-3-3-4 1-2-3Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg></span>
                        <div>
                            <h3>Account, campaign & order support</h3>
                            <p>Include your account email, a clear description and any relevant campaign, order or payment reference.</p>
                        </div>
                    </article>
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="7" r="3" />
                                <circle cx="18" cy="8" r="2" />
                                <path d="M2 21v-3a7 7 0 0 1 14 0v3H2ZM17 14q5 0 5 7h-4" />
                            </svg></span>
                        <div>
                            <h3>Publisher partnerships</h3>
                            <p>Share your full website URL, niche, available placement types and how you would like to collaborate.</p>
                        </div>
                    </article>
                </div>
                <div class="gp-helper">
                    <h3>A few details help us understand your request</h3>
                    <div class="gp-grid gp-cols-3 ">
                        <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6" />
                                </svg></span>
                            <div>
                                <h3>Choosing a plan</h3>
                                <p>Your niche and expected outreach volume</p>
                            </div>
                        </article>
                        <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 2-1 3-3 1-3 4 2 2-1 4 3 3 3-1 3 4 4-1 1-3 4-2-1-4 2-3-3-3-4 1-2-3Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg></span>
                            <div>
                                <h3>Getting support</h3>
                                <p>What happened, the steps you took and any error text</p>
                            </div>
                        </article>
                        <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 3h9l9 9-9 9-9-9V3Z" />
                                    <circle cx="8" cy="8" r="1" />
                                </svg></span>
                            <div>
                                <h3>Becoming a publisher</h3>
                                <p>Your website URL and available placement types</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container">
                <h2 class="gp-underline">Questions about contacting GPSites</h2>
                <div class="gp-faq ">
                    <details open>
                        <summary>How do I contact GPSites support?</summary>
                        <div>Email info@leelija.com or select a support topic in the form. Include your account email and a clear description of the issue.</div>
                    </details>
                    <details>
                        <summary>Can you help me choose a plan for my agency?</summary>
                        <div>Tell us about your niche, team requirements and expected outreach volume. We can explain the available subscriptions.</div>
                    </details>
                    <details>
                        <summary>What should I include in an order or billing inquiry?</summary>
                        <div>Include your account email, order or invoice reference and a short explanation. Do not send passwords or full payment card details.</div>
                    </details>
                    <details>
                        <summary>How can a publisher discuss working with GPSites?</summary>
                        <div>Select Publisher partnership or email our team. Include your website URL, niche and placement types.</div>
                    </details>
                    <details>
                        <summary>Why does GPSites use a Leelija email address?</summary>
                        <div>Leelija is our parent company. Include GPSites in your subject line to identify your inquiry.</div>
                    </details>
                    <details>
                        <summary>Where is GPSites located?</summary>
                        <div>Taki Road, Bamunmura, Barasat, Kolkata 700125, West Bengal, India. Please contact us before visiting.</div>
                    </details>
                </div>
            </div>
        </section>
        <section class="gp-section gp-cta">
            <div class="gp-container">
                <h2>Tell us what you need from GPSites</h2>
                <p>Comparing plans, following up on an order or exploring a partnership? Share the details with our team.</p>
                <div class="gp-actions"><a class="gp-button gp-white" href="#gp-inquiry">Send an Inquiry</a></div>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container">
                <h2 class="gp-underline">Learn more while you wait</h2>
                <div class="gp-grid gp-cols-3 ">
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="10" cy="10" r="7" />
                                <path d="m15 15 6 6" />
                            </svg></span>
                        <div>
                            <h3>Explore GPSites</h3>
                            <p>Search publishers, send offers and manage campaigns.<br><a class="gp-link" href="{{ $homeUrl ?? url('/') }}">Explore GPSites →</a></p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6" />
                            </svg></span>
                        <div>
                            <h3>About GPSites</h3>
                            <p>Learn more about our platform, mission and how we work.<br><a class="gp-link" href="{{ $aboutUrl ?? url('/about') }}">About GPSites →</a></p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m2 7 10-5 10 5 M4 8v14h16V8 M8 10v2m4-2v2m4-2v2M8 15v2m4-2v2m4 0v-2M10 22v-3h4v3" />
                            </svg></span>
                        <div>
                            <h3>Visit Leelija</h3>
                            <p>Our parent company, providing design, development and marketing services.<br><a class="gp-link" href="https://leelija.com/">Visit Leelija →</a></p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection