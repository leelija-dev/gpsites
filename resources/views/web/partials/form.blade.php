@php
    $subjects = [
        'pricing'     => 'Plans and pricing',
        'support'     => 'Account or technical support',
        'campaign'    => 'Campaign or order inquiry',
        'billing'     => 'Billing inquiry',
        'partnership' => 'Publisher partnership',
        'feedback'    => 'Feedback or other inquiry',
    ];
@endphp
<style>
    .gp-form input.gp-invalid,
.gp-form select.gp-invalid,
.gp-form textarea.gp-invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 1px #ef4444;
}

.gp-form .gp-field-error {
    display: block;
    color: #dc2626;
    font-size: 0.8rem;
    margin-top: 0.25rem;
}
.gp-form label small,
.gp-form label .error,
.gp-form label .error-message,
.gp-form label .invalid-feedback {
color: #dc2626 !important;
    
    font-size: 0.8rem;
}
.gp-form .gp-alert {
    padding: 14px 16px;
    border-radius: 10px;
    font-size: 0.9rem;
    margin: 0 0 16px;
    border: 1px solid transparent;
}
.gp-form .gp-alert-success {
    background: #ecfdf3 !important;
    color: #15803d !important;
    border-color: #86efac !important;
}
.gp-form .gp-alert-error {
    background: #fef2f2 !important;
    color: #b91c1c !important;
    border-color: #fca5a5 !important;
}
    </style>
<form id="contact-us" class="gp-form" method="post" action="{{ route('contact.store') }}" novalidate>
    @csrf

    <h2>Send us an inquiry</h2>
    <p>Choose a topic and tell us how we can help. Fields marked * are required.</p>

   @if(session('success'))
    <div class="gp-alert gp-alert-success" role="status">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="gp-alert gp-alert-error" role="alert">{{ session('error') }}</div>
@endif
    <div class="gp-grid gp-cols-2">
        @csrf
<input type="hidden" name="source" value="contact">
        <label>Full name <span>*</span>
            <input id="full_name" name="name" autocomplete="name" maxlength="120"
                   value="{{ old('name') }}" placeholder="Your name"
                   class="@error('name') gp-invalid @enderror"
                   @error('name') aria-invalid="true" @enderror required>
                   @error('name')<small class="gp-field-error">{{ $message }}</small>@enderror
        </label>

        <label>Email address <span>*</span>
            <input id="email" name="email" type="email" autocomplete="email" maxlength="254"
                   value="{{ old('email') }}" placeholder="Your email address"
                   class="@error('email') gp-invalid @enderror"
                   @error('email') aria-invalid="true" @enderror required>
            @error('email')<small class="color-red">{{ $message }}</small>@enderror
        </label>
    </div>

    <label class="gp-phone-field">Phone number — optional
        <input id="phone" name="phone" type="tel" autocomplete="tel" maxlength="40"
               value="{{ old('phone') }}" placeholder="Include your country code"
               class="@error('phone') gp-invalid @enderror"
               @error('phone') aria-invalid="true" @enderror>
        @error('phone')<small class="gp-field-error">{{ $message }}</small>@enderror
    </label>

    <label>Subject <span>*</span>
        <select id="subject" name="subject"
                class="@error('subject') gp-invalid @enderror"
                @error('subject') aria-invalid="true" @enderror required>
            <option value="">Select an inquiry type</option>
            @foreach($subjects as $value => $label)
                <option value="{{ $value }}" @selected(old('subject') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('subject')<small class="gp-field-error">{{ $message }}</small>@enderror
    </label>

    <div class="gp-topics">
        @foreach($subjects as $label)<span>{{ $label }}</span>@endforeach
    </div>

    <label>Message <span>*</span>
        <textarea id="message" name="message" rows="5" maxlength="10000"
                  placeholder="Tell us what you need help with. Include a website URL or campaign or order reference, if applicable."
                  class="@error('message') gp-invalid @enderror"
                  @error('message') aria-invalid="true" @enderror required>{{ old('message') }}</textarea>
        @error('message')<small class="gp-field-error">{{ $message }}</small>@enderror
    </label>

    <p class="gp-form-help">
        Please do not include passwords, one-time codes or full payment card details.<br>
        Read our <a href="{{ url('/privacy-policy') }}">Privacy Policy</a> for information about how personal data is handled.
    </p>

    <button class="gp-button gp-submit disabled:opacity-50 disabled:cursor-not-allowed" type="submit" id="submit-btn">
        <span id="btn-text">Send Inquiry →</span>
        <span id="btn-loading" class="hidden">Sending...</span>
    </button>
</form>