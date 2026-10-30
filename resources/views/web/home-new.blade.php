@extends('layouts.web.main-layout')

@section('title', 'Link Building Marketplace & Outreach Automation Tool | GPSites')
@section('description', 'Find relevant guest posting sites, connect with publishers, and manage your outreach in one place. GPSites — the link building marketplace and outreach automation tool.')
@section('keywords', 'link building marketplace, guest posting sites, publisher outreach, outreach automation, backlink marketplace, GPSites')
@section('indexing', 'yes')

@section('content')
<style>
    .gp-blur {
    filter: blur(6px);
    user-select: none;
    pointer-events: none;
    display: inline-block;
}

.gp-empty{
    text-align:center !important;
    padding:48px 16px !important;
    white-space:normal !important;
}
.gp-empty-icon{
    width:56px;height:56px;margin:0 auto 14px;border-radius:50%;
    background:rgba(124,58,237,.10);color:#7c3aed;
    display:flex;align-items:center;justify-content:center;
}
.gp-empty-icon svg{width:28px;height:28px}
.gp-empty-icon.is-error{background:rgba(220,38,38,.10);color:#dc2626}
.gp-empty-title{font-size:16px;font-weight:700;line-height:1.4}
.gp-empty-hint{font-size:13px;opacity:.7;margin-top:4px;line-height:1.5}
.gp-spin{animation:gp-spin .9s linear infinite}
@keyframes gp-spin{to{transform:rotate(360deg)}}
/* ===== Offer cards ===== */
/* ===== Offer cards ===== */
.gp-home .gp-offers{display:grid;grid-template-columns:1fr 1fr;gap:14px;align-items:stretch}
@media (max-width:900px){.gp-home .gp-offers{grid-template-columns:1fr}}

.gp-home .gp-offer{display:flex;flex-direction:column;padding:16px}

.gp-home .gp-offer-head{display:flex;align-items:center;gap:10px;margin:0 0 6px}
.gp-home .gp-offer-head h3{margin:0;font-size:16px}
.gp-home .gp-offer-head .gp-icon{
    width:34px;height:34px;min-width:34px;flex:0 0 34px;padding:0;
    display:inline-flex;align-items:center;justify-content:center}
.gp-home .gp-offer-head .gp-icon svg{width:18px;height:18px}


/* always 3 lines high in both cards; long URL is cut with "…" */
.gp-home .gp-offer > p{
    margin:0 0 8px;font-size:12px;line-height:1.4;
    height:calc(3 * 1.4em);
    display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:3;
    overflow:hidden}
.gp-home .gp-offer .gp-offer-url{color:#5b2cf5;font-weight:700;overflow-wrap:anywhere}

/* fields */
.gp-home .gp-offer .gp-field{display:block;margin:0 0 8px;font-size:12px;font-weight:700;line-height:1.2}
.gp-home .gp-offer .gp-field input,
.gp-home .gp-offer .gp-field select{
    display:block;width:100%;box-sizing:border-box;margin-top:4px;
    height:36px;padding:0 12px;border:1px solid #dcdcec;border-radius:8px;
    background:#fafaff;color:#111;font:inherit;font-size:13px;font-weight:600}
.gp-home .gp-offer .gp-field input:focus,
.gp-home .gp-offer .gp-field select:focus{
    outline:none;border-color:#5b2cf5;box-shadow:0 0 0 3px rgba(91,44,245,.15)}
.gp-home .gp-offer .gp-field input[readonly]{background:#f1f1f8;cursor:not-allowed}

/* $ prefix */
.gp-home .gp-offer .gp-money{position:relative;display:block;margin-top:4px}
.gp-home .gp-offer .gp-money::before{
    content:'$';position:absolute;left:12px;top:50%;transform:translateY(-50%);
    font-size:13px;font-weight:700;color:#6b6b85}
.gp-home .gp-offer .gp-money input{margin-top:0;padding-left:26px}

/* dropdown arrow */
.gp-home .gp-offer .gp-field select{
    appearance:none;-webkit-appearance:none;cursor:pointer;padding-right:34px;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%235b2cf5' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 12px center}

/* button right below the last field (no empty gap) */
.gp-home .gp-offer .gp-button{margin-top:auto;display:block;text-align:center;padding:10px 14px;font-size:13px}
.gp-home .gp-offer .gp-hint{display:block;margin:-2px 0 8px;font-size:11px;font-weight:500;color:#6b6b85}
/* Free trial bar: text on the left, button at the far right end */
.gp-home #pricing .gp-trial-bar{display:flex;align-items:center;gap:16px}
.gp-home #pricing .gp-trial-bar > div{flex:1;min-width:0}       /* text takes the free space */
.gp-home #pricing .gp-trial-bar > form{margin:0 0 0 auto}       /* form (button) goes to the end */
.gp-home #pricing .gp-trial-bar > form .gp-button{white-space:nowrap;border:0;cursor:pointer}

@media (max-width:700px){
    .gp-home #pricing .gp-trial-bar{flex-wrap:wrap}
    .gp-home #pricing .gp-trial-bar > form{margin:0;width:100%}
    .gp-home #pricing .gp-trial-bar > form .gp-button{display:block;width:100%;text-align:center}
}
/* ===== Pricing cards ===== */
.gp-home #pricing .gp-plans{align-items:stretch}
.gp-home #pricing .gp-price{
    position:relative;display:flex;flex-direction:column;text-align:center;
    transition:transform .2s, box-shadow .2s}
.gp-home #pricing .gp-price:hover{transform:translateY(-4px)}
.gp-home #pricing .gp-price ul{text-align:left;flex:1}
.gp-home #pricing .gp-price form{margin-top:auto}
.gp-home #pricing .gp-price .gp-button{display:block;width:100%;text-align:center;border:0;cursor:pointer}

/* mail/day pill */
.gp-home #pricing .gp-mail-pill{
    display:inline-block;align-self:center;margin:0 0 18px;padding:4px 12px;
    border-radius:999px;background:#f1f1f6;color:#44445a;font-size:12px}

/* centre card: colours taken from the screenshot (black -> deep purple) */
.gp-home #pricing .gp-price.gp-dark{
    background:linear-gradient(135deg,#000000 0%,#1a0b3b 45%,#3b0f7c 100%);
    border-color:transparent;color:#fff;
    box-shadow:0 18px 40px rgba(40,10,100,.35)}
.gp-home #pricing .gp-price.gp-dark h3,
.gp-home #pricing .gp-price.gp-dark .gp-price-value,
.gp-home #pricing .gp-price.gp-dark .gp-price-value small,
.gp-home #pricing .gp-price.gp-dark li{color:#fff}
.gp-home #pricing .gp-price.gp-dark li::before{background:rgba(255,255,255,.18);color:#fff}
.gp-home #pricing .gp-price.gp-dark .gp-mail-pill{background:rgba(255,255,255,.18);color:#fff}

/* last card: "Most popular" */
.gp-home #pricing .gp-price.gp-featured{border:2px solid #5b2cf5;box-shadow:0 14px 34px rgba(91,44,245,.18)}
.gp-home #pricing .gp-ribbon{
    position:absolute;top:-12px;left:50%;transform:translateX(-50%);
    padding:4px 14px;border-radius:999px;background:#5b2cf5;color:#fff;
    font-size:11px;font-weight:700;letter-spacing:.04em;white-space:nowrap}
    .gp-home .gp-trial-form{margin:0;display:inline-block}
.gp-home .gp-trial-form .gp-button{border:0;cursor:pointer;font:inherit}
</style>

    <main class="gp-page gp-home">
        <section class="gp-section gp-hero">
            <div class="gp-container">
                <div class="gp-split">
                    <div><span class="gp-eyebrow">Publisher discovery & outreach</span>
                        <h1><span>Link Building</span><br>Marketplace &amp;<br>Outreach Automation Tool</h1>
                        <p>Find relevant guest posting sites, connect with publishers,<br> and manage your outreach in
                            one place.</p>
                        <div class="gp-actions">
                            <form method="POST" class="gp-trial-form"
    action="{{ auth()->check() ? route('checkout') : route('start.trial') }}">
    @csrf
    @auth
        <input type="hidden" name="plan" value="{{ config('paypal.trial_plan_id') }}">
    @endauth
    <button type="submit" class="gp-button {{ $class ?? '' }}">Start Free Trial</button>
</form><a class="gp-button gp-outline" href="#pricing">Compare
                                Plans</a><small class="gp-trial-note">7 days free · 3 email credits · No credit card
                                required</small></div>
                    </div>
                    <a href="#publisher-discovery">
                    <div><img class="gp-art" src="{{asset("/images/home-hero.png")}}" alt="" width="390"
                            height="249" loading="lazy"></div>
                </div></a>
            </div>
        </section>
        <section class="gp-section gp-tint gp-trust">
            <div class="gp-container">
                <div class="gp-grid gp-cols-3 ">
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="10" cy="10" r="7" />
                                <path d="m15 15 6 6" />
                            </svg></span>
                        <div>
                            <h3>Niche & metric filters</h3>
                            <p>Find the right publishers, faster.</p>
                        </div>
                    </article>
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m22 2-7 20-4-9-9-4 20-7ZM11 13 22 2" />
                            </svg></span>
                        <div>
                            <h3>Manual publisher outreach</h3>
                            <p>Send personalized, targeted offers.</p>
                        </div>
                    </article>
                    <article class="gp-card "><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="9" cy="7" r="3" />
                                <circle cx="18" cy="8" r="2" />
                                <path d="M2 21v-3a7 7 0 0 1 14 0v3H2ZM17 14q5 0 5 7h-4" />
                            </svg></span>
                        <div>
                            <h3>Unlimited team members</h3>
                            <p>Collaborate without limits.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- ===================== PUBLISHER DISCOVERY (live search) ===================== --}}
        <section class="gp-section" id="publisher-discovery">
            <div class="gp-container"><span class="gp-eyebrow">Publisher discovery</span>
                <h2>Find guest posting sites that fit your campaign</h2>
                <p>Search our database of publisher websites using niche and SEO metrics to find the best
                    opportunities<br>for your outreach campaign.</p>

                <form id="gp-search-form" class="gp-publisher-search" action="{{ route('find.niches') }}"
                    method="GET">
                    {{-- <div class="gp-placement">
                        <label><input type="radio" name="placement" value="guest-post" checked> Guest posts</label>
                        <label><input type="radio" name="placement" value="link-insertion"> Link insertions</label>
                        <label><input type="radio" name="placement" value="press-release"> Press releases</label>
                    </div> --}}

                    <div class="gp-filters">
                        <label>Niche
                            <select name="niche">
                                <option value="">Any niche</option>
                                @foreach ($niches_data as $n)
                                    @if (!empty(trim($n['niche_name'] ?? '')))
                                        <option value="{{ $n['niche_name'] }}">{{ $n['niche_name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </label>
                        <label>Domain Authority
                            <select name="da">
                                <option value="0">Any</option>
                                <option value="30">Min 30</option>
                                <option value="50">Min 50</option>
                                <option value="70">Min 70</option>
                            </select>
                        </label>
                        <label>Domain Rating
                            <select name="dr">
                                <option value="0">Any</option>
                                <option value="30">Min 30</option>
                                <option value="50">Min 50</option>
                                <option value="70">Min 70</option>
                            </select>
                        </label>
                        <label>Traffic
                            <select name="traffic">
                                <option value="0">Any</option>
                                <option value="10000">10,000+</option>
                                <option value="100000">100,000+</option>
                            </select>
                        </label>
                        <button type="submit" class="gp-button" id="gp-search-btn">Find Matching Sites</button>
                    </div>
                </form>

                <div class="gp-table-panel">
                    <div class="gp-between">
                        <b>Results</b>
                        <small id="gp-result-count">Choose your filters and search</small>
                    </div>
                    <div class="gp-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Niche</th>
                                    <th>DA</th>
                                    <th>DR</th>
                                    <th>Traffic</th>
                                    <th></th>
                                </tr>
                            </thead>
                            {{-- <tbody id="gp-results-body">
                                <tr>
                                    <td colspan="6">No search yet.</td>
                                </tr>
                            </tbody> --}}
                            <tbody id="gp-results-body">
    <tr>
        <td colspan="6" class="gp-empty">
            <div class="gp-empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            </div>
            <div class="gp-empty-title">Ready when you are</div>
            <div class="gp-empty-hint">Choose a niche and filters, then click Search.</div>
        </td>
    </tr>
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        {{-- ===================== END PUBLISHER DISCOVERY ===================== --}}

        <section class="gp-section " id="how-it-works">
            <div class="gp-container"><span class="gp-eyebrow">How it works</span>
                <h2>From publisher discovery to your next conversation</h2>
                <div class="gp-grid gp-cols-4 ">
                    <article class="gp-card gp-step"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="10" cy="10" r="7" />
                                <path d="m15 15 6 6" />
                            </svg></span>
                        <div>
                            <h3><b class="gp-purple">01</b><br>Find your sites</h3>
                            <p>Search by niche and SEO metrics to find relevant publishers.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-step"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6" />
                            </svg></span>
                        <div>
                            <h3><b class="gp-purple">02</b><br>Choose your approach</h3>
                            <p>Send custom offers or place direct orders (Agency).</p>
                        </div>
                    </article>
                    <article class="gp-card gp-step"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m22 2-7 20-4-9-9-4 20-7ZM11 13 22 2" />
                            </svg></span>
                        <div>
                            <h3><b class="gp-purple">03</b><br>Launch outreach</h3>
                            <p>Reach out to publishers and automate follow-ups.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-step"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 21h19 M6 17V9h3v8 M12 17V5h3v12 M18 17V2h3v15" />
                            </svg></span>
                        <div>
                            <h3><b class="gp-purple">04</b><br>Manage next steps</h3>
                            <p>Track conversations, offers and orders in one place.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="gp-section gp-tint" id="features">
            <div class="gp-container"><span class="gp-eyebrow">Features</span>
                <h2>Less repetitive work. More focused outreach.</h2>
                <div class="gp-grid gp-cols-3 ">
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="10" cy="10" r="7" />
                                <path d="m15 15 6 6" />
                            </svg></span>
                        <div>
                            <h3>Target relevant publishers</h3>
                            <p>Search by niche and metrics to find the best opportunities.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="m3 6 9 7 9-7" />
                            </svg></span>
                        <div>
                            <h3>Send custom offers</h3>
                            <p>Reach out with personalized offers on every plan.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 2-1 3-3 1-3 4 2 2-1 4 3 3 3-1 3 4 4-1 1-3 4-2-1-4 2-3-3-3-4 1-2-3Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg></span>
                        <div>
                            <h3>Automate follow-ups</h3>
                            <p>Save time with automated follow-up sequences.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 5h14M8 12h14M8 19h14M2 5h1M2 12h1M2 19h1" />
                            </svg></span>
                        <div>
                            <h3>Manage offers & orders</h3>
                            <p>Keep track of all your conversations, offers and orders.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 3h9l9 9-9 9-9-9V3Z" />
                                <circle cx="8" cy="8" r="1" />
                            </svg></span>
                        <div>
                            <h3>View negotiated prices</h3>
                            <p>Agency members can see publisher prices and place direct orders.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h19 M6 17V9h3v8 M12 17V5h3v12 M18 17V2h3v15" />
                            </svg></span>
                        <div>
                            <h3>Review site insights</h3>
                            <p>Check key metrics and placement options before you reach out.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="gp-section gp-dark">
            <div class="gp-container">
                <div class="gp-split">
                    <div><span class="gp-eyebrow">Pricing flexibility</span>
                        <h2>Your offer. Or a negotiated price.</h2>
                        <p>Send custom offers on every plan. Agency members can also view negotiated publisher prices
                            and place direct orders.</p>
                            @if(Auth::id())
                            <a class="gp-button gp-white" href="{{route('dashboard')}}">Explore
                            Agency</a>
                            @else
                            <a class="gp-button gp-white" href="{{route('login')}}">Explore
                            Agency</a>
                            @endif
                                       </div>
                    <div class="gp-offers">          {{-- ← ADD --}}
                    <div class="gp-offer">
    <div class="gp-offer-head">
        <span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2" />
                <path d="m3 6 9 7 9-7" />
            </svg></span>
        <h3>Custom offer</h3>
    </div>
    <p>Send a personalized offer to <span class="gp-offer-url" id="gp-offer-site">Loading site…</span></p>

    <label class="gp-field">Your offer (USD)
        <span class="gp-money">
            <input type="number" id="gp-offer-amount" min="1" step="1" inputmode="numeric"
                placeholder="Enter your offer, e.g. 250">
        </span>
    </label>

    <a class="gp-button" id="gp-offer-btn" href="{{ route('blog.index') }}">Send offer</a>
</div>

<div class="gp-offer">
    <div class="gp-offer-head">
        <span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2" />
                <path d="m3 6 9 7 9-7" />
            </svg></span>
        <h3>Direct order</h3>
    </div>
    <p>Our negotiated prices <span class="gp-offer-url" id="gp-direct-site">Loading site…</span></p>

    <label class="gp-field">Price type
        <select id="gp-price-type">
            <option value="">Select price type</option>
        </select>
    </label>

    <label class="gp-field">Publisher price (USD)
        <span class="gp-money">
            <input id="gp-direct-price" readonly placeholder="Auto-filled">
        </span>
    </label>

        <a class="gp-button" id="gp-direct-btn" href="{{ route('blog.index') }}">Place direct order</a>
</div>
                    </div>          {{-- ← ADD: closes gp-offers --}}
                </div>
            </div>
        </section>
        <section class="gp-section ">
            <div class="gp-container"><span class="gp-eyebrow">Built for your team</span>
                <h2>Built for the way your team works</h2>
                <div class="gp-grid gp-cols-3 gp-audiences">
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="7" r="3" />
                                <circle cx="18" cy="8" r="2" />
                                <path d="M2 21v-3a7 7 0 0 1 14 0v3H2ZM17 14q5 0 5 7h-4" />
                            </svg></span>
                        <div>
                            <h3>SEO agencies</h3>
                            <p>Organize outreach for multiple clients and manage campaigns in one place.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="m2 7 10-5 10 5 M4 8v14h16V8 M8 10v2m4-2v2m4-2v2M8 15v2m4-2v2m4 0v-2M10 22v-3h4v3" />
                            </svg></span>
                        <div>
                            <h3>In-house marketing teams</h3>
                            <p>Find relevant publishers and keep outreach organized across campaigns.</p>
                        </div>
                    </article>
                    <article class="gp-card gp-horizontal"><span class="gp-icon"><svg aria-hidden="true"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
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
            </div>
        </section>
        <section class="gp-section " id="pricing">
            <div class="gp-container"><span class="gp-eyebrow">Pricing</span>
                <h2>Choose the outreach plan that fits your workload</h2>
                <div class="gp-grid gp-cols-3 gp-plans">
    @foreach($plans as $index => $plan)
    @php
        $isDark     = $index === 1;                       
        $isFeatured = $loop->last && !$isDark;            
    @endphp

    <article class="gp-price {{ $isDark ? 'gp-dark' : '' }} {{ $isFeatured ? 'gp-featured' : '' }}">
        @if($isFeatured)
            <span class="gp-ribbon">Most popular</span>
        @endif

        <h3>{{ $plan->name }}</h3>

        <div class="gp-price-value">${{ number_format($plan->price) }}<small> / {{ $plan->duration == 30 ? null : ($plan->duration == 31 ? null : $plan->duration )}}{{ $plan->duration === 30||$plan->duration === 31 ? 'Month' : 'days' }}</small></div>

        <span class="gp-mail-pill">{{ $plan->mail_available ?? '0' }} Mail/day</span>

        @if($plan->features && $plan->features->count() > 0)
            <ul>
                @foreach($plan->features->where('is_active', true) as $feature)
                    <li>{{ $feature->feature }}</li>
                @endforeach
            </ul>

            @auth
                <form method="POST" action="{{ route('checkout') }}">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $plan->id }}">
                    <button type="submit" class="gp-button {{ $isDark ? 'gp-white' : ($isFeatured ? '' : 'gp-soft') }}">Get Started</button>
                </form>
            @else
                <form method="POST" action="{{ route('intent.plan') }}">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $plan->id }}">
                    <button type="submit" class="gp-button {{ $isDark ? 'gp-white' : ($isFeatured ? '' : 'gp-soft') }}">Get Started</button>
                </form>
            @endauth
        @endif
    </article>
    @endforeach
</div>
                <div class="gp-trial-bar"><span class="gp-icon"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6" />
                        </svg></span>
                    <div>
                        <h3>Try GPSites free for 7 days</h3><small>3 email credits · No credit card required</small>
                    </div>
                    @auth
                    <form method="POST" action="{{ route('checkout') }}" >
                        @csrf
                        <input type="hidden" name="plan" value="{{ config('paypal.trial_plan_id') }}">
                        <button
                            type="submit" class="gp-button content-end" >Start Free Trial
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('start.trial') }}" >
                        @csrf
                        <button
                            type="submit" class="gp-button content-end" >Start Free Trial
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </section>
        <section class="gp-section " id="faq">
            <div class="gp-container">
                <div class="gp-home-bottom">
                    <div><span class="gp-eyebrow">FAQ</span>
                        <h2>Questions before you get started?</h2>
                        <div class="gp-faq ">
                            <details open>
                                <summary>What is GPSites?</summary>
                                <div>A link building marketplace and outreach tool for finding publishers, sending
                                    offers and managing orders.</div>
                            </details>
                            <details>
                                <summary>How do offers and direct orders differ?</summary>
                                <div>Offers propose your terms. Agency members can place direct orders at negotiated
                                    prices.</div>
                            </details>
                            <details>
                                <summary>Which placement types are available?</summary>
                                <div>Guest posts, link insertions and press releases, depending on the publisher.</div>
                            </details>
                            <details>
                                <summary>Can my team use GPSites together?</summary>
                                <div>Yes. Subscription plans include unlimited team members.</div>
                            </details>
                            <details>
                                <summary>Does GPSites guarantee rankings?</summary>
                                <div>No. Rankings, indexing and AI search visibility are not guaranteed. Paid placements
                                    should use appropriate sponsored or nofollow links.</div>
                            </details>
                        </div>
                    </div>
                    <div class="gp-compact"><span class="gp-eyebrow">Contact</span>
                        <h2>Tell us about your outreach goals</h2>
                        <p>Have a question or want to learn more? Send us a message.</p><a class="gp-link"
                            href="mailto:info@leelija.com">info@leelija.com</a>
                        <form id="gp-inquiry" class="gp-form" data-inquiry data-connected="false" method="post"
                            action="{{ route('contact.store') }}">
                            @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif

                    <!-- Error Message -->
                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                    @endif
                            @csrf
                             <input type="hidden" name="source" value="home">
                            <h2>Send us an inquiry</h2>
                            <p>Choose a topic and tell us how we can help. Fields marked * are required.</p>


                            <div class="gp-grid gp-cols-2">
                                <label>Full name <span>*</span><input name="name"
                                        autocomplete="name" maxlength="120" value="" placeholder="Your name"
                                        required> 
                                        @error('name')
                                         <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                </label>
                                <label>Email address <span>*</span>
                                    <input name="email"
                                        type="email" autocomplete="email" maxlength="254" value=""
                                        placeholder="Your email address" required>
                                         @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                </label></div>
                                <label class="gp-phone-field">Phone number — optional<input name="phone" type="tel"
                                        autocomplete="tel" maxlength="40" value=""
                                        placeholder="Include your country code"></label>
                                <label>Subject <span>*</span><select name="subject" required>
                                    <option value="">Select an inquiry type</option>
                                    <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="Support" {{ old('subject') == 'Support' ? 'selected' : '' }}>Support</option>
                            <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                </select>
                                    @error('subject')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                    </label>
                            <div class="gp-topics"><span>Plans and pricing</span><span>Account or technical
                                    support</span><span>Campaign or order inquiry</span><span>Billing
                                    inquiry</span><span>Publisher partnership</span><span>Feedback or other
                                    inquiry</span></div>
                            <label>Message <span>*</span><textarea name="message" rows="5" maxlength="10000"
                                    placeholder="Tell us what you need help with. Include a website URL or campaign or order reference, if applicable."
                                    required></textarea>
                                @error('message')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                </label>
                            <p class="gp-form-help">Please do not include passwords, one-time codes or full payment card
                                details.<br>Read our <a href="">Privacy Policy</a> for information about how personal
                                data is handled.</p>
                            <button class="gp-button gp-submit" type="submit">Send Inquiry →</button>

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="gp-section gp-cta">
            <div class="gp-container">
                <h2>Find your next publisher with GPSites</h2>
                <p>Discover relevant sites, send your offer and manage the conversation in one place.</p>
                <div class="gp-actions"><form method="POST" class="gp-trial-form"
    action="{{ auth()->check() ? route('checkout') : route('start.trial') }}">
    @csrf
    @auth
        <input type="hidden" name="plan" value="{{ config('paypal.trial_plan_id') }}">
    @endauth
    <button type="submit" class="gp-button gp-white">Start Free Trial</button>
</form></div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
<script>
    // Smooth scroll for in-page anchor links (e.g. #pricing, #how-it-works, #features, #faq)
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (!targetId || targetId === '#') return;
                const target = document.querySelector(targetId);
                if (!target) return;

                e.preventDefault();
                const nav = document.querySelector('nav');
                const navHeight = nav ? nav.offsetHeight : 0;
                const offset = target.getBoundingClientRect().top + window.pageYOffset - navHeight - 12;

                window.scrollTo({ top: offset, behavior: 'smooth' });
            });
        });
    });
        
    const BLOG_URL = "{{ route('blog.index') }}";   // http://localhost:8000/blog

    // Publisher search -> find.niches route, results rendered in the table
    // Publisher search -> find.niches route, results rendered in the table
    document.addEventListener('DOMContentLoaded', function () {
        const form  = document.getElementById('gp-search-form');
        const body  = document.getElementById('gp-results-body');
        const count = document.getElementById('gp-result-count');
        const btn   = document.getElementById('gp-search-btn');
        if (!form || !body) return;

        function buildRow(cells) {
            const tr = document.createElement('tr');
            cells.forEach(function (text) {
                const td = document.createElement('td');
                td.textContent = (text === null || text === undefined || text === '') ? '' : text;
                tr.appendChild(td);
            });
            return tr;
        }

        /*function messageRow(text) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 6;
            td.textContent = text;
            tr.appendChild(td);
            return tr;
        }*/
       const EMPTY_ICONS = {
    empty:   '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0zM9 9l4 4m0-4l-4 4"/></svg>',
    loading: '<svg class="gp-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3a9 9 0 109 9"/></svg>',
    error:   '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>'
};

function messageRow(title, hint, type) {
    const tr = document.createElement('tr');
    const td = document.createElement('td');
    td.colSpan = 6;
    td.className = 'gp-empty';

    const icon = document.createElement('div');
    icon.className = 'gp-empty-icon' + (type === 'error' ? ' is-error' : '');
    icon.innerHTML = EMPTY_ICONS[type || 'empty'];   // fixed markup, no user data

    const t = document.createElement('div');
    t.className = 'gp-empty-title';
    t.textContent = title;

    td.appendChild(icon);
    td.appendChild(t);

    if (hint) {
        const h = document.createElement('div');
        h.className = 'gp-empty-hint';
        h.textContent = hint;
        td.appendChild(h);
    }

    tr.appendChild(td);
    return tr;
}
         let firstLoad = true;
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Map this form's fields to the parameter names the find.niches route expects
            const params = new URLSearchParams({
                niches:      form.niche.value,
                da_min:      form.da.value,
                da_max:      100,
                dr_min:      form.dr.value,
                dr_max:      100,
                traffic_min: form.traffic.value,
                traffic_max: 999999,
                per_page:    firstLoad ? 5 : 1000
            });
            firstLoad = false;
            btn.disabled = true;
            btn.textContent = 'Searching...';
            // body.replaceChildren(messageRow('Searching...'));
            body.replaceChildren(messageRow('Searching sites...', 'This will only take a moment.', 'loading'));
            count.textContent = '';

            try {
                const res = await fetch(form.action + '?' + params.toString(), {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);

                const json  = await res.json();
                const sites = Array.isArray(json) ? json : (json.data || []);

                body.replaceChildren();

                if (!sites.length) {
                    // body.appendChild(messageRow('No sites found for these filters.'));
                    body.appendChild(messageRow(
                            'No sites found for these filters.',
                            'Try lowering the DA, DR or traffic filters, or choose a different niche.',
                            'empty'
                        ));
                    count.textContent = '0 results';
                    return;
                }

                // sites.forEach(function (s) {
                //     const tr = buildRow([
                //         s.domain || s.url,
                //         s.niche || s.niche_name,
                //         s.da,
                //         s.dr,
                //         s.traffic,
                //         ''
                //     ]);
                //     tr.children[0].className = 'gp-purple';

                //     const a = document.createElement('a');
                //     a.className = 'gp-link';
                //     a.href = 'https://gpsites.io/login';
                //     a.textContent = 'View details →';
                //     tr.lastChild.appendChild(a);

                //     body.appendChild(tr);
                // });

                sites.forEach(function (s) {
                const tr = buildRow([s.domain || s.url, s.niche || s.niche_name, s.da, s.dr, '', '']);
                tr.children[0].className = 'gp-purple';

                // Traffic: blurred placeholder (not real data)
                const blur = document.createElement('span');
                blur.className = 'gp-blur';
                blur.textContent = '00,000';
                blur.title = 'Log in to view traffic';
                tr.children[4].appendChild(blur);

                const a = document.createElement('a');
                a.className = 'gp-link';
                // a.href = 'https://gpsites.io/login';
                // a.textContent = 'View details →';
                a.href = s.blog_id ? BLOG_URL + '?open_blog=' + encodeURIComponent(s.blog_id) : BLOG_URL;
                a.textContent = 'View details →';
                tr.lastChild.appendChild(a);

                body.appendChild(tr);
            });

                count.textContent = sites.length + (sites.length === 1 ? ' result' : ' results');
            } catch (err) {
                console.error(err);
                // body.replaceChildren(messageRow('Something went wrong. Please try again.'));
                body.replaceChildren(messageRow(
                    'Something went wrong',
                    "We couldn't load the results. Please try again.",
                    'error'
                ));
            } finally {
                btn.disabled = false;
                btn.textContent = 'Find Matching Sites';
            }
        });
         const section = document.getElementById('publisher-discovery');
        if (section && 'IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) {
                    observer.disconnect();
                    form.requestSubmit();
                }
            }, { rootMargin: '0px 0px -30% 0px' });
            observer.observe(section);
        } else {
            form.requestSubmit();
        }
    });
    const RANDOM_BLOGS_URL = "{{ route('random.blogs') }}";

    document.addEventListener('DOMContentLoaded', function () {
        const offerSite   = document.getElementById('gp-offer-site');
        const offerBtn    = document.getElementById('gp-offer-btn');
        const directSite  = document.getElementById('gp-direct-site');
        const directBtn   = document.getElementById('gp-direct-btn');
        const priceSelect = document.getElementById('gp-price-type');
        const priceInput  = document.getElementById('gp-direct-price');
        if (!offerSite || !directSite) return;

        const PRICE_TYPES = [
            ['general_guest_post_price',       'General guest post'],
            ['general_link_insertion_price',   'General link insertion'],
            ['sensitive_guest_post_price',     'Sensitive guest post'],
            ['sensitive_link_insertion_price', 'Sensitive link insertion']
        ];

        const blogLink = id => id ? BLOG_URL + '?open_blog=' + encodeURIComponent(id) : BLOG_URL;

        fetch(RANDOM_BLOGS_URL, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => { if (!res.ok) throw new Error('HTTP ' + res.status); return res.json(); })
            .then(json => {
                const blogs = json.data || [];
                const a = blogs[0];
                const b = blogs[1] || blogs[0];

                if (a) {                                   // Custom offer -> random blog
                    offerSite.textContent = a.domain;
                    offerBtn.href = blogLink(a.blog_id);
                }

                if (b) {                                   // Direct order -> another random blog
                    directSite.textContent = b.domain;
                    directBtn.href = blogLink(b.blog_id);

                    PRICE_TYPES.forEach(function (t) {
                        const price = Number(b[t[0]] || 0);
                        const opt = document.createElement('option');
                        opt.value = price;
                        opt.textContent = t[1] + ' — $' + price.toLocaleString();
                        priceSelect.appendChild(opt);
                    });
                }
            })
            .catch(function (err) {
                console.error(err);
                offerSite.textContent = directSite.textContent = 'Could not load a site';
            });

        // Auto-fill the price input when a price type is selected (user cannot type)
        priceSelect.addEventListener('change', function () {
            // priceInput.value = this.value === '' ? '' : '$' + Number(this.value).toLocaleString();
            priceInput.value = this.value === '' ? '' : Number(this.value).toLocaleString();
        });
    });
    
</script>
@endsection
