@extends('layouts.web.main-layout')

@section('title', 'GPSites Pricing: Guest Post & Link Insertion Outreach Plans')
@section('description', 'Compare GPSites plans for guest post and link insertion outreach. Vetted publishers, negotiated prices and no placement markup. Pay monthly or save 20% yearly.')
@section('indexing', 'yes')

@php
    $discount = \App\Models\Plan::yearlyDiscountPercent();
    $discountLabel = rtrim(rtrim(number_format($discount, 2), '0'), '.');
    $money = fn ($v) => '$' . (floor($v) == $v ? number_format($v) : number_format($v, 2));
    $cheapest = $plans->first();
    $fromPrice = $cheapest ? $money((float) $cheapest->price) : null;
    $trialDays = 7;
    $trialCredits = (int) ($trialPlan->mail_available ?? 3) ?: 3;

    // Feature comparison built from the features entered in the admin, so it always matches the plan cards.
    $featureNames = $plans->flatMap(fn ($p) => $p->features->where('is_active', true)->pluck('feature'))
        ->map(fn ($f) => trim($f))->unique()->values();
    $hasFeature = fn ($plan, $name) => $plan->features->where('is_active', true)
        ->contains(fn ($f) => trim($f->feature) === $name);

    $pricingFaqs = [
        ['q' => 'Is the placement price included in my GPSites plan?',
         'a' => 'No. Your plan pays for access to our vetted publisher network, the negotiated details we collect and the tools to send offers. The placement price for each guest post or link insertion is separate. You agree it with the site and pay the site owner or editor directly once your post is live.'],
        ['q' => 'How do I pay publishers for a guest post or link insertion?',
         'a' => 'After the site publishes your post, the owner or editor sends you an invoice and you pay them directly. GPSites does not add a markup to placement prices. Every message with the publisher is kept in your GPSites portal and sent by email, so you can follow the deal from either place.'],
        ['q' => 'Who writes the guest post content?',
         'a' => 'Each site owner decides. Some publishers accept your article, others prefer to write it themselves. You confirm the details with the owner before anything goes live, and the publishing guidelines our team collected help you get it right the first time.'],
        ['q' => 'What is the difference between an offer and a direct order?',
         'a' => 'On every plan you can send offers, to one site or in bulk, and propose your own price. Agency members can also see the prices our team has already negotiated with each site and place a direct order at that price, or still send an offer if they prefer.'],
        ['q' => 'Can Starter and Pro members see negotiated prices?',
         'a' => 'No. Negotiated publisher prices and direct orders are part of the Agency plan. Starter and Pro members see the up-to-date site list for their plan and contact publishers with single or bulk offers.'],
        ['q' => 'How much does yearly billing save?',
         'a' => "Paying yearly costs 12 months of your plan minus {$discountLabel}%. You pay once and get 365 days of access, with the same daily email allowance as the monthly plan."],
        ['q' => 'Do plans renew automatically?',
         'a' => 'No. Each payment covers one period, 30 days for monthly or 365 days for yearly. When it ends, you choose whether to buy again. We send a reminder before your plan expires.'],
        ['q' => 'Can I get a refund?',
         'a' => 'Monthly purchases are final and non-refundable. If you buy a yearly plan, you can request a full refund within 24 hours of payment. Full details are in our Terms of Service.'],
        ['q' => 'Is there a free trial?',
         'a' => "Yes. The free trial lasts {$trialDays} days and includes {$trialCredits} email credits. No credit card is needed, and each account can use one trial."],
        ['q' => 'How are payments processed?',
         'a' => 'Plan payments are processed securely through PayPal in US dollars. Publisher invoices for placements are settled directly between you and the site owner.'],
        ['q' => 'Does GPSites guarantee rankings?',
         'a' => 'No one can honestly guarantee rankings. We help you reach relevant sites with steady traffic and strong metrics, and publishers decide whether to accept each offer. Results depend on your site, your content and your competition.'],
    ];

    $offers = [];
    foreach ($plans as $p) {
        $offers[] = [
            '@type' => 'Offer', 'name' => $p->name . ' (monthly)', 'price' => (string) round((float) $p->price, 2),
            'priceCurrency' => 'USD', 'url' => route('pricing'),
            'priceSpecification' => ['@type' => 'UnitPriceSpecification', 'price' => (string) round((float) $p->price, 2), 'priceCurrency' => 'USD', 'billingDuration' => 'P1M'],
        ];
        $offers[] = [
            '@type' => 'Offer', 'name' => $p->name . ' (yearly)', 'price' => (string) $p->priceFor(\App\Models\Plan::BILLING_YEARLY),
            'priceCurrency' => 'USD', 'url' => route('pricing') . '?billing=yearly',
            'priceSpecification' => ['@type' => 'UnitPriceSpecification', 'price' => (string) $p->priceFor(\App\Models\Plan::BILLING_YEARLY), 'priceCurrency' => 'USD', 'billingDuration' => 'P1Y'],
        ];
    }

    $pricingSchema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'WebPage',
                '@id' => route('pricing') . '#webpage',
                'url' => route('pricing'),
                'name' => 'GPSites Pricing',
                'description' => 'Plans for guest post and link insertion outreach, billed monthly or yearly.',
                'isPartOf' => ['@id' => url('/') . '#website'],
                'about' => ['@id' => url('/') . '#software'],
                'breadcrumb' => ['@id' => route('pricing') . '#breadcrumb'],
                'inLanguage' => 'en-US',
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => route('pricing') . '#breadcrumb',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Pricing'],
                ],
            ],
            [
                '@type' => 'SoftwareApplication',
                '@id' => url('/') . '#software',
                'name' => config('gpsites.brand'),
                'url' => url('/'),
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem' => 'Web',
                'offers' => $offers,
            ],
            [
                '@type' => 'FAQPage',
                '@id' => route('pricing') . '#faq',
                'mainEntity' => array_map(fn ($f) => [
                    '@type' => 'Question', 'name' => $f['q'],
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                ], $pricingFaqs),
            ],
        ],
    ];
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode($pricingSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    <style>
        .gp-pricing-page .gp-hero{padding-bottom:28px}
        .gp-pricing-page .gp-hero .gp-container{text-align:center;max-width:860px}
        .gp-pricing-page .gp-hero .gp-crumb{justify-content:center}
        .gp-pricing-page .gp-hero p{margin-left:auto;margin-right:auto}
        .gp-pricing-page .gp-facts{display:flex;flex-wrap:wrap;justify-content:center;gap:8px 22px;margin:16px 0 0;padding:0;list-style:none;font-size:14px;color:#29263f}
        .gp-pricing-page .gp-facts li:before{content:'✓';color:#5428ff;font-weight:700;margin-right:8px}
        .gp-pricing-page #plans .gp-container{text-align:center}
        .gp-pricing-page #plans .gp-plans{text-align:left}
        .gp-pricing-page .gp-compare th,.gp-pricing-page .gp-compare td{font-size:14px;white-space:normal;vertical-align:top}
        .gp-pricing-page .gp-compare td.gp-yes{color:#5428ff;font-weight:700}
        .gp-pricing-page .gp-compare td.gp-no{color:#a9a6bd}
        .gp-pricing-page .gp-steps-list{counter-reset:s;list-style:none;padding:0;margin:18px 0 0;display:grid;gap:12px}
        .gp-pricing-page .gp-steps-list li{counter-increment:s;position:relative;padding:14px 16px 14px 56px;border:1px solid var(--line,#e6e3f2);border-radius:9px;background:#fff}
        .gp-pricing-page .gp-steps-list li:before{content:counter(s);position:absolute;left:16px;top:14px;width:26px;height:26px;border-radius:50%;background:#efeaff;color:#5428ff;font-weight:700;font-size:13px;display:flex;align-items:center;justify-content:center}
        .gp-pricing-page .gp-steps-list b{display:block;margin-bottom:3px}
        .gp-pricing-page .gp-stat{border-left:3px solid #5428ff;padding:6px 0 6px 16px;margin:20px 0 0;font-size:15px}
    </style>
@endpush

@section('content')
<div class="gp-page gp-pricing-page">

    {{-- Hero --}}
    <section class="gp-section gp-hero">
        <div class="gp-container">
            <nav class="gp-crumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Pricing</span>
            </nav>
            <span class="gp-eyebrow">Pricing</span>
            <h1>GPSites pricing for guest post and link insertion outreach</h1>
            <p>Your plan gives you a publisher network our team has already contacted, vetted and negotiated with. You choose the sites and send offers. Placements are paid to the publisher directly, with no markup from us.</p>
            <ul class="gp-facts">
                @if ($fromPrice)<li>Plans from {{ $fromPrice }}/month</li>@endif
                <li>Save {{ $discountLabel }}% with yearly billing</li>
                <li>{{ $trialDays }}-day free trial</li>
                <li>No auto-renewal</li>
            </ul>
        </div>
    </section>

    {{-- Plans --}}
    <section class="gp-section" id="plans" style="padding-top:0">
        <div class="gp-container">
            @include('web.partials.pricing-plans', ['plans' => $plans])
            <p class="gp-note" style="text-align:left">Prices are in US dollars. Yearly plans are paid once and give 365 days of access with the same daily email allowance. Placement fees are agreed with each publisher and paid to them separately.</p>
        </div>
    </section>

    {{-- What the subscription pays for --}}
    <section class="gp-section gp-tint">
        <div class="gp-container gp-split" style="align-items:start">
            <div>
                <span class="gp-eyebrow">What you're paying for</span>
                <h2>We do the outreach groundwork, so you don't have to</h2>
                <p>Finding a site, tracking down the right editor and agreeing a fair price can take weeks of emails. Our outreach team does that part continuously, before you ever log in.</p>
                <p>By the time a site appears in GPSites, someone on our team has already spoken to its owner or editor.</p>
            </div>
            <div class="gp-grid" style="gap:12px">
                <article class="gp-card"><h3>Publishers contacted for you</h3><p>We reach out to blog owners and editors directly and agree whether they accept guest posts, link insertions or both.</p></article>
                <article class="gp-card"><h3>Minimum prices negotiated</h3><p>When a site agrees, we negotiate the lowest price we can get and record it.</p></article>
                <article class="gp-card"><h3>Publishing guidelines collected</h3><p>Word counts, link rules and topic limits are gathered upfront, so your offer fits the site.</p></article>
                <article class="gp-card"><h3>Quality sites only</h3><p>We focus on sites with steady, permanent traffic and strong metrics across almost every niche, and review the list every six months.</p></article>
            </div>
        </div>
    </section>

    {{-- Compare plans --}}
    @if ($plans->count())
    <section class="gp-section">
        <div class="gp-container">
            <span class="gp-eyebrow">Compare plans</span>
            <h2>Starter, Pro and Agency side by side</h2>
            <p>All plans let you contact publishers with single or bulk offers and see the latest sites available on your plan. Agency adds our negotiated prices and direct ordering.</p>
            <div class="gp-table-panel gp-scroll" style="background:#fff">
                <table class="gp-compare">
                    <thead>
                        <tr>
                            <th scope="col">Feature</th>
                            @foreach ($plans as $p)<th scope="col">{{ $p->name }}</th>@endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Monthly price</th>
                            @foreach ($plans as $p)<td>{{ $money((float) $p->price) }} / month</td>@endforeach
                        </tr>
                        <tr>
                            <th scope="row">Yearly price ({{ $discountLabel }}% off)</th>
                            @foreach ($plans as $p)<td>{{ $money($p->priceFor(\App\Models\Plan::BILLING_YEARLY)) }} / year</td>@endforeach
                        </tr>
                        <tr>
                            <th scope="row">Outreach emails</th>
                            @foreach ($plans as $p)<td>{{ number_format((int) $p->mail_available) }} per day</td>@endforeach
                        </tr>
                        <tr>
                            <th scope="row">Send offers (single or bulk)</th>
                            @foreach ($plans as $p)<td class="gp-yes">✓</td>@endforeach
                        </tr>
                        @foreach ($featureNames as $name)
                            <tr>
                                <th scope="row">{{ $name }}</th>
                                @foreach ($plans as $p)
                                    @if ($hasFeature($p, $name))
                                        <td class="gp-yes" aria-label="Included">✓</td>
                                    @else
                                        <td class="gp-no" aria-label="Not included">–</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    {{-- How placement payments work --}}
    <section class="gp-section gp-tint">
        <div class="gp-container gp-split" style="align-items:start">
            <div>
                <span class="gp-eyebrow">Placement costs</span>
                <h2>How you pay for guest posts and link insertions</h2>
                <p>Your GPSites plan and your placement costs are separate. The plan pays for access and outreach. Each placement is a deal between you and the publisher, and you pay them only after your post is live.</p>
                <p class="gp-stat">Buying direct matters. BuzzStream's 2026 study of about 500,000 sites found a guest post costs $295 on average when bought directly from the site, compared with $461 through a vendor. <a class="gp-link" href="https://www.buzzstream.com/blog/guest-post-costs/" target="_blank" rel="noopener">Read the study</a></p>
            </div>
            <ol class="gp-steps-list">
                <li><b>Choose a site and make your move</b>Send an offer with your own price on any plan. Agency members can also place a direct order at our negotiated price.</li>
                <li><b>Agree the details with the publisher</b>The owner confirms the terms, the publishing guidelines and who writes the article.</li>
                <li><b>Your post goes live</b>The publisher publishes the guest post or adds your link to an existing article.</li>
                <li><b>Pay the publisher's invoice</b>The site owner or editor invoices you and you pay them directly. Every message is kept in your portal and sent by email.</li>
            </ol>
        </div>
    </section>

    {{-- Which plan --}}
    <section class="gp-section">
        <div class="gp-container">
            <span class="gp-eyebrow">Choosing a plan</span>
            <h2>Which plan is right for you?</h2>
            <div class="gp-grid gp-cols-3">
                @foreach ($plans as $p)
                    <article class="gp-card">
                        <h3>{{ $p->name }}</h3>
                        @if ($loop->first)
                            <p>For freelancers, site owners and small businesses running a few campaigns a month. {{ number_format((int) $p->mail_available) }} outreach emails a day is plenty for focused, personal pitches.</p>
                        @elseif ($loop->last)
                            <p>For agencies and teams that buy placements regularly. You see our negotiated prices, order directly at those prices and get the highest daily email allowance.</p>
                        @else
                            <p>For growing teams and in-house marketers with more pages to promote. More daily emails and wider publisher access than Starter.</p>
                        @endif
                        <p class="gp-note" style="margin:10px 0 0">{{ $money((float) $p->price) }}/month or {{ $money($p->priceFor(\App\Models\Plan::BILLING_YEARLY)) }}/year</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Trial --}}
    <section class="gp-section gp-tint">
        <div class="gp-container">
            <div class="gp-trial-bar">
                <span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6"/></svg></span>
                <div>
                    <h3>Not sure yet? Try GPSites free for {{ $trialDays }} days</h3><small>{{ $trialCredits }} email credits · No credit card required</small>
                </div>
                <a class="gp-button" href="{{ route('start-trial.page') }}">See the free trial</a>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="gp-section" id="faq">
        <div class="gp-container">
            <span class="gp-eyebrow">FAQ</span>
            <h2>Pricing questions, answered</h2>
            <div class="gp-faq gp-faq-columns">
                @foreach ($pricingFaqs as $i => $faq)
                    <details {{ $i === 0 ? 'open' : '' }}>
                        <summary>{{ $faq['q'] }}</summary>
                        <div>{{ $faq['a'] }}</div>
                    </details>
                @endforeach
            </div>
            <p class="gp-note">Questions about your account or an invoice? <a class="gp-link" href="{{ route('contact') }}">Contact our team</a>. See the <a class="gp-link" href="{{ route('terms-of-service') }}">Terms of Service</a> for full billing terms.</p>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="gp-section gp-cta">
        <div class="gp-container">
            <h2>Start reaching publishers who have already said yes</h2>
            <p>Pick a plan above, or try GPSites free for {{ $trialDays }} days first.</p>
            <div class="gp-actions">
                <a class="gp-button gp-white" href="#plans">Choose a plan</a>
                <a class="gp-button gp-outline" style="color:#fff;border-color:rgba(255,255,255,.6)" href="{{ route('start-trial.page') }}">Start free trial</a>
            </div>
        </div>
    </section>
</div>
@endsection
