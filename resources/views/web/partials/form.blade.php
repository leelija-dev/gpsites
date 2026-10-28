<form id="gp-inquiry" class="gp-form" data-inquiry data-connected="{{ !empty($contactAction) ? 'true' : 'false' }}" method="post" action="{{ $contactAction ?? url('/contact') }}">
    @csrf
    <h2>Send us an inquiry</h2>
    <p>Choose a topic and tell us how we can help. Fields marked * are required.</p>
    @if(session('gpsites_status'))<p class="gp-notice" role="status">{{ session('gpsites_status') }}</p>@endif
    @if($errors->any())<div class="gp-error" role="alert">
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>@endif
    <div class="gp-grid gp-cols-2"><label>Full name <span>*</span><input name="name" autocomplete="name" maxlength="120" value="{{ old('name') }}" placeholder="Your name" required></label><label>Email address <span>*</span><input name="email" type="email" autocomplete="email" maxlength="254" value="{{ old('email') }}" placeholder="Your email address" required></label></div>
    <label class="gp-phone-field">Phone number — optional<input name="phone" type="tel" autocomplete="tel" maxlength="40" value="{{ old('phone') }}" placeholder="Include your country code"></label>
    <label>Subject <span>*</span><select name="subject" required>
            <option value="">Select an inquiry type</option>
            @foreach(['Plans and pricing','Account or technical support','Campaign or order inquiry','Billing inquiry','Publisher partnership','Feedback or other inquiry'] as $topic)
            <option value="{{ $topic }}" @selected(old('subject')===$topic)>{{ $topic }}</option>
            @endforeach
        </select></label>
    <div class="gp-topics"><span>Plans and pricing</span><span>Account or technical support</span><span>Campaign or order inquiry</span><span>Billing inquiry</span><span>Publisher partnership</span><span>Feedback or other inquiry</span></div>
    <label>Message <span>*</span><textarea name="message" rows="5" maxlength="10000" placeholder="Tell us what you need help with. Include a website URL or campaign or order reference, if applicable." required>{{ old('message') }}</textarea></label>
    <p class="gp-form-help">Please do not include passwords, one-time codes or full payment card details.<br>Read our <a href="{{ $privacyUrl ?? url('/privacy-policy') }}">Privacy Policy</a> for information about how personal data is handled.</p>
    <button class="gp-button gp-submit" @disabled(empty($contactAction)) type="submit">Send Inquiry →</button>
    @if(empty($contactAction))<small class="gp-form-help">Email <a href="mailto:info@leelija.com">info@leelija.com</a> to send your inquiry.</small>@endif
</form>