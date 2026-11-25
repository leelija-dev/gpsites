{{--
    "We do the outreach, you pick the sites" + quality rules.
    Used on the homepage, About and free trial pages.
    Optional: $tint (bool) adds the tinted background, $headingTag (h2|h3).
--}}
@php $h = $headingTag ?? 'h2'; @endphp
<section class="gp-section {{ !empty($tint) ? 'gp-tint' : '' }} gp-groundwork" id="done-for-you-outreach">
    <div class="gp-container">
        <span class="gp-eyebrow">Done-for-you outreach</span>
        <{{ $h }} class="{{ $headingClass ?? '' }}">We do the outreach. You pick the sites.</{{ $h }}>
        <p class="gp-groundwork-intro">Cold-emailing site owners, chasing editors who never reply, haggling over price, then finding out the site wants 1,500 words and no casino links. That's the part of link building nobody enjoys. Our outreach team does it every day, before a site ever shows up in your GPSites account, so you don't have to.</p>

        <div class="gp-grid gp-cols-4">
            <article class="gp-card">
                <h3>Owners and editors contacted</h3>
                <p>We reach the real person who decides what gets published on each site, not a reseller or a generic inbox.</p>
            </article>
            <article class="gp-card">
                <h3>Guest posts and link insertions agreed</h3>
                <p>A site is only listed once its owner or editor has said yes to guest posts, link insertions or both.</p>
            </article>
            <article class="gp-card">
                <h3>Minimum price negotiated</h3>
                <p>We push for the lowest price each site will accept and record it, so nobody starts from the rate card.</p>
            </article>
            <article class="gp-card">
                <h3>Publishing guidelines collected</h3>
                <p>Word count, link rules, accepted topics and anything the site won't publish. You see it before you pitch.</p>
            </article>
        </div>

        <h3 class="gp-groundwork-sub">Our quality rules</h3>
        <div class="gp-grid gp-cols-4">
            <article class="gp-card">
                <h3>Stable, permanent traffic</h3>
                <p>We list sites whose organic traffic holds steady over time, not sites with a short spike that's already fading.</p>
            </article>
            <article class="gp-card">
                <h3>Strong metrics</h3>
                <p>Authority, traffic and niche relevance are checked before a site goes in. Thin or spammy sites stay out.</p>
            </article>
            <article class="gp-card">
                <h3>Owner-verified emails</h3>
                <p>Every contact email is the site owner's or editor's own, confirmed by our team. Your offer reaches the person who can say yes.</p>
            </article>
            <article class="gp-card">
                <h3>Audited every six months</h3>
                <p>Every listed site is re-checked every six months. Sites that lose traffic or stop meeting our rules are removed.</p>
            </article>
        </div>
    </div>
</section>

@once
    @push('head')
        <style>
            .gp-page .gp-groundwork-intro{max-width:780px}
            .gp-page .gp-groundwork-sub{margin:34px 0 14px;font-size:20px}
            .gp-page .gp-groundwork .gp-card h3{font-size:16px;margin:0 0 6px}
            .gp-page .gp-groundwork .gp-card p{margin:0}
        </style>
    @endpush
@endonce
