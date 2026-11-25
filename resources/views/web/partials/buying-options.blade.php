{{--
    The three ways a customer gets a placement. Used on the homepage, About,
    free trial and pricing pages.
    Optional: $tint (bool), $headingTag (h2|h3).
--}}
@php $h = $headingTag ?? 'h2'; @endphp
<section class="gp-section {{ !empty($tint) ? 'gp-tint' : '' }} gp-buying" id="ways-to-buy">
    <div class="gp-container">
        <span class="gp-eyebrow">Offers and orders</span>
        <{{ $h }} class="{{ $headingClass ?? '' }}">Three ways to get your guest post or link insertion</{{ $h }}>
        <p class="gp-buying-intro">Every plan shows you the latest sites available on that plan. From there, you choose how much of the deal you want to handle yourself.</p>

        <div class="gp-grid gp-cols-3">
            <article class="gp-card">
                <span class="gp-pill">Every plan</span>
                <h3>Send an offer to the site owner</h3>
                <p>Pitch one site or send offers in bulk. Each offer goes straight to the owner's or editor's verified email, with your own price.</p>
                <p>If they accept, you pay the site owner directly once the post is live, against their invoice. No markup from us.</p>
            </article>
            <article class="gp-card">
                <span class="gp-pill">Every plan</span>
                <h3>Order through GPSites</h3>
                <p>Rather not negotiate? Place the order with us and our team handles it with the site for you.</p>
                <p>Orders through GPSites have their own price, which is different from our negotiated price. You pay after you get the live URL.</p>
            </article>
            <article class="gp-card gp-featured-card">
                <span class="gp-pill">Agency plan</span>
                <h3>Order at our negotiated prices</h3>
                <p>Agency members see the minimum prices our team negotiated with each site and can order directly at those prices.</p>
                <p>You can still send your own offers whenever you'd like to try a different price.</p>
            </article>
        </div>
        <p class="gp-note gp-buying-note">Whichever route you take, every message is kept in your GPSites portal and sent to you by email.</p>
    </div>
</section>

@once
    @push('head')
        <style>
            .gp-page .gp-buying-intro{max-width:760px}
            .gp-page .gp-buying .gp-card h3{font-size:17px;margin:10px 0 8px}
            .gp-page .gp-buying .gp-card p{margin:0 0 8px}
            .gp-page .gp-buying .gp-pill{display:inline-block;font-size:12px;font-weight:700;padding:3px 10px;border-radius:999px;background:#efe9ff;color:#5b2cf5}
            .gp-page .gp-buying .gp-featured-card{border-color:#5b2cf5}
            .gp-page .gp-buying-note{margin-top:14px}
        </style>
    @endpush
@endonce
