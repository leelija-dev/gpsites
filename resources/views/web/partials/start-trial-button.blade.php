{{-- Same behaviour as the homepage trial buttons: guests go through start.trial (login, then checkout in trial mode);
     logged-in users go straight to checkout with the trial plan. --}}
<form method="POST" class="gp-trial-cta" data-gtm-event="start_trial_click"
    action="{{ $isLoggedIn ? route('checkout') : route('start.trial') }}">
    @csrf
    @if ($isLoggedIn)
        <input type="hidden" name="plan" value="{{ config('paypal.trial_plan_id') }}">
    @endif
    <button type="submit" class="gp-button {{ $class ?? '' }}">{{ $label }}</button>
</form>
