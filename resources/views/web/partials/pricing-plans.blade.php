{{--
    Plan cards with a Monthly / Yearly switch. Used on the homepage and on /pricing.
    Monthly is the default. Yearly prices = 12 x monthly price minus the yearly discount,
    calculated by App\Models\Plan::priceFor(); checkout recalculates the amount on the server.
    Expects: $plans (active paid plans, cheapest first).
--}}
@php
    $yearlyDiscount = \App\Models\Plan::yearlyDiscountPercent();
    $discountLabel = rtrim(rtrim(number_format($yearlyDiscount, 2), '0'), '.');
    $money = fn ($v) => '$' . (floor($v) == $v ? number_format($v) : number_format($v, 2));
@endphp

<div class="gp-billing-switch" role="group" aria-label="Billing period">
    <button type="button" class="gp-billing-option is-active" data-billing="monthly" aria-pressed="true">Monthly</button>
    <button type="button" class="gp-billing-option" data-billing="yearly" aria-pressed="false">Yearly <span class="gp-save-badge">Save {{ $discountLabel }}%</span></button>
</div>

<div class="gp-grid gp-cols-3 gp-plans" data-billing-scope>
    @foreach($plans as $index => $plan)
    @php
        $isDark     = $index === 1;
        $isFeatured = $loop->last && !$isDark;
        $monthlyPrice = (float) $plan->price;
        $yearlyPrice = $plan->priceFor(\App\Models\Plan::BILLING_YEARLY);
        $yearlyFull = round($monthlyPrice * 12, 2);
        $yearlySaving = round($yearlyFull - $yearlyPrice, 2);
        $yearlyPerMonth = $plan->monthlyEquivalentFor(\App\Models\Plan::BILLING_YEARLY);
    @endphp

    <article class="gp-price {{ $isDark ? 'gp-dark' : '' }} {{ $isFeatured ? 'gp-featured' : '' }}">
        @if($isFeatured)
            <span class="gp-ribbon">Most popular</span>
        @endif

        <h3>{{ $plan->name }}</h3>

        <div class="gp-price-value" data-show-billing="monthly">${{ number_format($plan->price) }}<small> / {{ $plan->duration == 30 ? null : ($plan->duration == 31 ? null : $plan->duration )}}{{ $plan->duration === 30||$plan->duration === 31 ? 'Month' : 'days' }}</small></div>
        <div class="gp-price-value" data-show-billing="yearly" hidden>{{ $money($yearlyPrice) }}<small> / Year</small></div>
        <p class="gp-price-note" data-show-billing="yearly" hidden>
            <s>{{ $money($yearlyFull) }}</s> · You save {{ $money($yearlySaving) }} · {{ $money($yearlyPerMonth) }}/month
        </p>

        <span class="gp-mail-pill">{{ $plan->mail_available ?? '0' }} Mail/day</span>

        @if($plan->features && $plan->features->count() > 0)
            <ul>
                @foreach($plan->features->where('is_active', true) as $feature)
                    <li>{{ $feature->feature }}</li>
                @endforeach
            </ul>

            <form method="POST" action="{{ auth()->check() ? route('checkout') : route('intent.plan') }}"
                data-gtm-event="select_plan" data-gtm-plan-name="{{ $plan->name }}"
                data-gtm-value="{{ $monthlyPrice }}" data-gtm-currency="{{ config('app.currency_code', 'USD') }}"
                data-gtm-billing="monthly"
                data-price-monthly="{{ $monthlyPrice }}" data-price-yearly="{{ $yearlyPrice }}">
                @csrf
                <input type="hidden" name="plan" value="{{ $plan->id }}">
                <input type="hidden" name="billing" value="monthly" data-billing-input>
                <button type="submit" class="gp-button {{ $isDark ? 'gp-white' : ($isFeatured ? '' : 'gp-soft') }}">Get Started</button>
            </form>
        @endif
    </article>
    @endforeach
</div>

@once
@push('head')
<style>
    .gp-page .gp-billing-switch{display:inline-flex;gap:4px;padding:4px;margin:6px 0 22px;border:1px solid var(--line,#e6e3f2);border-radius:999px;background:#fff}
    .gp-page .gp-billing-option{border:0;background:transparent;font:inherit;font-size:14px;font-weight:600;color:var(--ink,#151331);padding:8px 16px;border-radius:999px;cursor:pointer}
    .gp-page .gp-billing-option.is-active{background:var(--purple,#5428ff);color:#fff}
    .gp-page .gp-save-badge{display:inline-block;margin-left:6px;font-size:12px;font-weight:700;padding:2px 8px;border-radius:999px;background:#e9fbef;color:#167a3c}
    .gp-page .gp-billing-option.is-active .gp-save-badge{background:rgba(255,255,255,.2);color:#fff}
    .gp-page .gp-price-note{margin:2px 0 8px;font-size:13px;color:var(--muted,#5f5b78)}
    .gp-page .gp-dark .gp-price-note{color:rgba(255,255,255,.8)}
    .gp-page .gp-price.gp-dark .gp-price-value small,
    .gp-page .gp-price.gp-dark li{color:#fff}
    .gp-page [data-show-billing][hidden]{display:none!important}
</style>
@endpush
@push('scripts-after')
<script>
(function () {
    function setBilling(cycle) {
        document.querySelectorAll('.gp-billing-option').forEach(function (b) {
            var on = b.getAttribute('data-billing') === cycle;
            b.classList.toggle('is-active', on);
            b.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        document.querySelectorAll('[data-show-billing]').forEach(function (el) {
            el.hidden = el.getAttribute('data-show-billing') !== cycle;
        });
        document.querySelectorAll('[data-billing-input]').forEach(function (input) {
            input.value = cycle;
            var form = input.form;
            if (form) {
                form.setAttribute('data-gtm-billing', cycle);
                form.setAttribute('data-gtm-value', form.getAttribute(cycle === 'yearly' ? 'data-price-yearly' : 'data-price-monthly'));
            }
        });
    }
    document.addEventListener('click', function (e) {
        var btn = e.target.closest && e.target.closest('.gp-billing-option');
        if (btn) setBilling(btn.getAttribute('data-billing'));
    });
    // Let links like /pricing?billing=yearly open on the yearly view.
    if (/[?&]billing=yearly\b/.test(location.search)) {
        document.addEventListener('DOMContentLoaded', function () { setBilling('yearly'); });
    }
})();
</script>
@endpush
@endonce
