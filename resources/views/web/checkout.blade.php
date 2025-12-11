@extends('layouts.web.main-layout')

@section('title', 'Checkout')
@section('indexing', 'no')

@section('content')

<style>
    .error-msg {
        position: absolute;
        left: 0;
        bottom: -20px;
    }


    /* hidden drop down code  */
    .hidden-sum-block {
        overflow: hidden;
        transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
        max-height: 500px;
        /* big enough for your content */
        opacity: 1;
    }

    .hidden-sum-block.collapsed {
        max-height: 0;
        opacity: 0;
    }
    .iti__country-list{
        z-index: 2000 !important;
    }

    .iti__flag-container .iti__selected-flag{

        border-right: 1px solid #d9d0d0 !important;
    }
    .iti--allow-dropdown{
        width: 100% !important;
    }
</style>


<section class="flex justify-center items-center min-h-screen w-full h-auto px-6 py-12">
    <div class="max-w-7xl w-full">
        @php
        // Use trialMode passed from controller, fallback to calculation if not set
        $trialMode = $trialMode ?? (session()->has('trial_mode') || (isset($_POST['plan']) && $_POST['plan'] == config('paypal.trial_plan_id')) || session('trial_plan') == config('paypal.trial_plan_id'));
        $trialUsed = session('trial_used', false) || (auth()->check() && (int)(auth()->user()->is_trial) === 1);
        @endphp

        <form class="flex gap-10 lg:flex-row flex-col " novalidate>
            <div class="w-full">

                <div class="w-full bg-white shadow-[0px_3px_32px_#dbd5d5] rounded-lg px-8  pb-8 pt-0">
                    <div class="w-full flex justify-start items-center pt-5 pb-3">
                        <a class="btn-secondary text-[15px] px-5 py-1" href="/">Go Back</a>
                    </div>
                    <h2 class="text-xl font-semibold mb-8">Billing Address</h2>

                    <div class="space-y-8">

                        <!-- First + Last Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="floating-label-group">
                                <input type="text" id="firstName" placeholder=" " value="" required />
                                <label for="firstName">First Name</label>
                            </div>

                            <div class="floating-label-group">
                                <input type="text" id="lastName" placeholder=" " value="" required />
                                <label for="lastName">Last Name</label>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="floating-label-group">
                            <input type="email" id="email" placeholder=" " value="{{ auth()->user()->email ?? '' }}" required />
                            <label for="email">Email Address</label>

                        </div>

                        <!-- Street Address -->
                        <div class="space-y-8">
                            <div class="floating-label-group">
                                <input type="text" id="address1" placeholder=" " required />
                                <label for="address1">Street Address</label>
                            </div>

                            <div class="floating-label-group">
                                <input type="text" id="address2" placeholder=" " />
                                <label for="address2">Apartment, suite (optional)</label>
                            </div>
                        </div>

                        <!-- State / City -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="floating-label-group">
                                <select id="country" required>
                                    <option value="" disabled selected>Select a country</option>
                                    <!-- Countries will be loaded via API -->
                                </select>
                                <label for="country">Country</label>
                            </div>

                            <div class="floating-label-group">
                                <input type="text" id="city" placeholder=" " value="" required />
                                <label for="city">City</label>
                            </div>
                        </div>

                        <!-- Zip / Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6 gap-8">
                            <div class="floating-label-group">
                                <input type="number" id="zip" placeholder=" " value="" required />
                                <label for="zip">Pin Code</label>
                            </div>
                            <div class="floating-label-group">
    <input type="tel" id="phone" placeholder=" " value="" required />
    <!-- <label for="phone"></label> -->
</div>
                        </div>

                        <!-- Checkboxes -->
                        <!-- <div class="space-y-4 pt-4">
                            <label class="flex items-center gap-3 text-gray-700 cursor-pointer">
                                <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded" />
                                <span>My billing and shipping address are the same</span>
                            </label>

                            <label class="flex items-center gap-3 text-gray-700 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded" />
                                <span>Create an account for later use</span>
                            </label>
                        </div> -->

                    </div>
                </div>


            </div>
            <div class=" w-auto smx:min-w-[450px]">


                <div class="space-y-6">
                    <!-- Order Review -->
                    <div class="bg-white shadow-[0px_3px_32px_#dbd5d5] rounded-lg p-6 ">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">Order Review</h2>
                            <!-- <i class="fas fa-chevron-up text-gray-600"></i> -->
                            @unless($trialMode)
                            <div id="modal-package-toggle" class="btn-primary text-[15px] px-3 py-1">Change</div>
                            @endunless
                        </div>

                        <div id="selected-package-wrapper" class="space-y-6">

                        </div>
                    </div>


                    <!-- Discount Codes -->
                    @unless($trialMode)
                    <div class="bg-white shadow-[0px_3px_32px_#dbd5d5] rounded-lg p-6 ">
                        <!-- <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold">Discount Codes</h2>
                            <i class="fas fa-chevron-up text-gray-600"></i>
                        </div> -->

                        <!-- Coupon Input -->

                        <div class="floating-label-group">
                            <input type="text" id="discount" placeholder=" " value="" />
                            <label for="discount">Discount Coupon Code</label>
                        </div>




                    </div>
                    @endunless

                    <div class=" w-full bg-white shadow-[0px_3px_32px_#dbd5d5] rounded-lg p-6 border">
                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold">Billing Summary</h2>
                            <i id="sum-drop-hi" class="fas fa-chevron-up text-gray-600"></i>
                        </div>

                        <div class="hidden-sum-block ">
                            <!-- Subtotal -->
                            <div class="flex justify-between mt-6 text-gray-700">
                                <span>Subtotal</span>
                                <span id="subtotal-amount"></span>
                            </div>

                            <!-- Discount -->
                            <div class="flex justify-between mt-2 text-gray-700">
                                <span>Discount</span>
                                <span class="text-red-500"></span>
                            </div>
                        </div>



                        <!-- Divider -->
                        <hr class="my-6">

                        <!-- Grand Total -->
                        <div class="flex justify-between">
                            <span class="font-semibold text-gray-800">Grand Total</span>
                            <span id="grand-total-amount" class="font-bold text-xl text-gray-900"></span>
                        </div>

                        <!-- Checkbox -->
                        <label class="flex items-start gap-2 mt-6 text-sm text-gray-600">
                            <input type="checkbox" class="mt-1 w-4 h-4 accent-blue-600" required>
                            <span>
                                Please check to acknowledge our
                                <a href="#" class="text-blue-600 underline">Privacy & Terms Policy</a>
                            </span>
                        </label>

                        <!-- Button -->
                        @if($trialMode)
                        @if($trialUsed)
                        <div class="mt-6 p-3 rounded-md bg-red-50 text-red-700 border border-red-200">
                            You have already used your trial. No further trial activations are available.
                        </div>
                        @else
                        <button type="button" id="trial-complete-btn" class="w-full mt-6 bg-green-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-green-700 transition-all">
                            Complete Purchase
                        </button>
                        @endif
                        @else
                        <!-- PayPal Button Container -->
                        <div id="paypal-button-container" class="mt-6">
                            <p class="text-gray-500 text-sm mb-4">Please select a package to proceed with payment</p>
                        </div>

                        <!-- Hidden submit button (kept for form validation if needed) -->
                        <button id="pay-btn" type="submit" class="hidden w-full mt-6 bg-blue-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-blue-700 transition-all">
                            Pay
                        </button>
                        @endif
                    </div>


                </div>



            </div>
        </form>
    </div>
</section>


<!-- Modal Background -->
<div id="package-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[2000] min-h-screen">

    <!-- Modal Box -->
    <div class="bg-white rounded-lg shadow-xl w-fit p-6 relative max-h-[90vh] overflow-y-scroll">

        <!-- Close Button -->
        <button id="modal-close" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl">
            &times;
        </button>

        <h2 class="text-xl font-semibold mb-4">Choose Your Package</h2>

        <!-- <div class="max-w-7xl mx-auto lg:px-6 px-0 grid grid-cols-1 md:grid-cols-3 gap-8 ">


            <div class="bg-white rounded-2xl shadow-md px-8 pb-8 pt-0 border border-gray-100 overflow-hidden hover:scale-[1.04] transition-all duration-300 ease-in-out">
                <div class="text-center">
                    <div class="bg-purple-100  text-purple-600 relative top-[-3px] py-[7px] px-[22px] mb-[3rem] rounded-b-[10px] text-sm font-semibold inline-block">
                        STARTER BOOST
                    </div>

                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-purple-50 rounded-full flex justify-center items-center">
                            <span class="text-purple-600 text-3xl">🚀</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold">Basic Plan</h3>
                    <p class="text-4xl font-bold mt-2">$1,000<span class="text-base font-medium">/month</span></p>
                    <p class="text-gray-500 text-sm mb-4">Billed Annually</p>
                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full mb-6">
                        Up to 3 Platforms
                    </span>
                </div>

                <ul class="space-y-3 text-gray-600">
                    <li>• Social Media Management</li>
                    <li>• 8 Monthly Social Media Posts</li>
                    <li>• SEO Strategy & Keyword Research</li>
                    <li>• Google Ads & Social Media Ad Campaigns</li>
                    <li>• Monthly Analytics and Performance Report</li>
                    <li>• Bi-Weekly Strategy Call</li>
                </ul>

                <div class="text-center my-10">
                    <a href="#" class="btn-primary package-get-started rounded-full w-full block" data-package-id="basic" data-package-name="Basic Plan" data-package-price="1000">Get Started</a>
                </div>
            </div>


            <div class="bg-gradient-to-br from-black to-primary text-white rounded-2xl shadow-xl px-8 pb-8  overflow-hidden hover:scale-[1.04] transition-all duration-300 ease-in-out">
                <div class="text-center">
                    <div class="bg-purple-600 text-white relative top-[-3px] py-[7px] px-[22px] mb-[3rem] rounded-b-[10px] text-sm font-semibold inline-block">
                        GROWTH ACCELERATOR
                    </div>

                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex justify-center items-center">
                            <span class="text-white text-3xl">⚙️</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold">Standard Package</h3>
                    <p class="text-4xl font-bold mt-2">$2,500<span class="text-base font-medium">/month</span></p>
                    <p class="text-purple-200 text-sm mb-4">Billed Annually</p>
                    <span class="inline-block bg-white/20 text-white text-xs px-3 py-1 rounded-full mb-6">
                        Up to 5 Platforms
                    </span>
                </div>

                <ul class="space-y-3 text-purple-100">
                    <li>• Social Media Management</li>
                    <li>• 8 Monthly Social Media Posts</li>
                    <li>• SEO Strategy & Keyword Research</li>
                    <li>• Google Ads & Social Media Ad Campaigns</li>
                    <li>• Monthly Analytics and Performance Report</li>
                    <li>• Bi-Weekly Strategy Call</li>
                </ul>

                <div class="text-center my-10 ">
                    <a href="#" class="btn-secondary package-get-started rounded-full w-full block" data-package-id="standard" data-package-name="Standard Package" data-package-price="2500">Get Started</a>
                </div>
            </div>


            <div class="bg-white rounded-2xl shadow-md px-8 pb-8 border border-gray-100 overflow-hidden hover:scale-[1.04] transition-all duration-300 ease-in-out">
                <div class="text-center">
                    <div class="bg-purple-100 text-purple-600 relative top-[-3px] py-[7px] px-[22px] mb-[3rem] rounded-b-[10px] text-sm font-semibold inline-block">
                        MARKET LEADER
                    </div>

                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-purple-50 rounded-full flex justify-center items-center">
                            <span class="text-purple-600 text-3xl">👑</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold">Premium Package</h3>
                    <p class="text-4xl font-bold mt-2">$5,000<span class="text-base font-medium">/month</span></p>
                    <p class="text-gray-500 text-sm mb-4">Billed Annually</p>
                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full mb-6">
                        Up to 7 Platforms
                    </span>
                </div>

                <ul class="space-y-3 text-gray-600">
                    <li>• Social Media Management</li>
                    <li>• 8 Monthly Social Media Posts</li>
                    <li>• SEO Strategy & Keyword Research</li>
                    <li>• Google Ads & Social Media Ad Campaigns</li>
                    <li>• Monthly Analytics and Performance Report</li>
                    <li>• Bi-Weekly Strategy Call</li>
                </ul>

                <div class="text-center my-10 w-full">
                    <a href="#" class="btn-primary package-get-started rounded-full w-full block" data-package-id="premium" data-package-name="Premium Package" data-package-price="5000">Get Started</a>
                </div>
            </div>

        </div> -->

        <div class="max-w-7xl mx-auto lg:px-6 px-0 grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($allPlans as $index => $plan)
            @php
            $isHighlighted = $index === 1; // Highlight second plan (Standard)
            $badgeColors = [
            ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'badge' => 'STARTER BOOST'],
            ['bg' => 'bg-purple-600', 'text' => 'text-white', 'badge' => 'GROWTH ACCELERATOR'],
            ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'badge' => 'MARKET LEADER']
            ];
            $badge = $badgeColors[$index % count($badgeColors)] ?? $badgeColors[0];
            $icons = ['🚀', '⚙️', '👑'];
            $icon = $icons[$index % count($icons)] ?? '📦';
            @endphp

            <div class="bg-white rounded-2xl shadow-md px-8 pb-8 pt-0 border border-gray-100 overflow-hidden hover:scale-[1.04] transition-all duration-300 ease-in-out {{ $isHighlighted ? 'bg-gradient-to-br from-black to-primary text-white shadow-xl' : '' }}">
                <div class="text-center">
                    <div class="bg-{{ $badge['bg'] }} {{ $badge['text'] }} relative top-[-3px] py-[7px] px-[22px] mb-[3rem] rounded-b-[10px] text-sm font-semibold inline-block">
                        {{ $badge['badge'] }}
                    </div>

                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 {{ $isHighlighted ? 'bg-white/20' : 'bg-purple-50' }} rounded-full flex justify-center items-center">
                            <span class="{{ $isHighlighted ? 'text-white' : 'text-purple-600' }} text-3xl">{{ $icon }}</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold">{{ $plan->name }}</h3>
                    <p class="text-4xl font-bold mt-2">${{ number_format($plan->price) }}<span class="text-base font-medium">/month</span></p>
                    <p class="{{ $isHighlighted ? 'text-purple-200' : 'text-gray-500' }} text-sm mb-4">Billed Annually</p>
                    <span class="inline-block {{ $isHighlighted ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-700' }} text-xs px-3 py-1 rounded-full mb-6">
                        Up to {{ $index + 1 }} Platforms
                    </span>
                </div>

                <ul class="space-y-3 {{ $isHighlighted ? 'text-purple-100' : 'text-gray-600' }}">
                    @foreach($plan->features as $feature)
                    <li>• {{ $feature->feature }}</li>
                    @endforeach
                </ul>

                <div class="text-center my-10">
                    <a href="#" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} package-get-started rounded-full w-full block"
                        data-package-id="{{ $plan->id }}"
                        data-package-name="{{ $plan->name }}"
                        data-package-price="{{ $plan->price }}">Get Started</a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

@endsection
@section('scripts')
<script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&currency=USD&components=buttons&enable-funding=venmo&disable-funding=paylater"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script for intl-tel-input -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pass plan data from PHP to JavaScript
        const planData = @json($planModel ?? null);
        const trialMode = @json($trialMode ?? false);

        // Global country mapping for converting codes to names
        let countryCodeToName = {};

        // Initialize intl-tel-input for phone field
        const phoneInput = document.querySelector("#phone");
        let iti = null;
        let maxNationalDigits = 15; // Default fallback for national number (without country code)
        let currentCountryCode = 'in'; // Default country code
        let currentDialCode = '+91'; // Default dial code for India

        // Phone validation configuration
        const PHONE_CONFIG = {
            ALLOWED_CHARS: /^[0-9+\-\s()]*$/, // Only allow digits, plus, hyphen, space, parentheses
            DIGITS_ONLY: /^[0-9]*$/ // For final validation - digits only
        };

        // ZIP code configuration
        const ZIP_CONFIG = {
            MAX_LENGTH: 7, // Maximum 7 digits for ZIP code
            DIGITS_ONLY: /^\d*$/ // Only digits allowed
        };

        // Store the full phone number with country code
        let fullPhoneNumberWithCountryCode = '';

        if (phoneInput && typeof window.intlTelInput === 'function') {
            // Initialize intl-tel-input with custom configuration
            iti = window.intlTelInput(phoneInput, {
                initialCountry: "in",
                preferredCountries: ["gb", "us", "in"],
                separateDialCode: false, // Don't show separate dial code
                allowDropdown: true,
                autoPlaceholder: "aggressive",
                formatOnDisplay: true,
                nationalMode: true, // Show national numbers only in input
                // DISABLE auto formatting to prevent adding leading 0
                formatOnDisplay: false,
                // Use custom formatting instead
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    // Store current country code and dial code
                    currentCountryCode = selectedCountryData.iso2;
                    currentDialCode = `+${selectedCountryData.dialCode}`;
                    
                    // Extract max digits from placeholder text
                    // Get the example number WITHOUT leading 0 if present
                    let exampleNumber = selectedCountryPlaceholder;
                    // Remove any formatting characters to get just digits
                    const digitsOnly = exampleNumber.replace(/[^\d]/g, '');
                    
                    // For some countries, remove leading 0 from example
                    if (digitsOnly.startsWith('0')) {
                        // Check if this country typically has leading 0
                        const countriesWithLeadingZero = ['gb', 'uk', 'in', 'de', 'fr', 'it', 'es'];
                        if (countriesWithLeadingZero.includes(selectedCountryData.iso2.toLowerCase())) {
                            maxNationalDigits = digitsOnly.length - 1; // Exclude leading 0
                            console.log(`Country ${selectedCountryData.iso2} has leading 0, max national digits: ${maxNationalDigits}`);
                        } else {
                            maxNationalDigits = digitsOnly.length;
                        }
                    } else {
                        maxNationalDigits = digitsOnly.length;
                    }
                    
                    console.log(`Country: ${selectedCountryData.name}, National number max digits: ${maxNationalDigits}, Dial Code: ${currentDialCode}`);
                    
                    // Return simpler placeholder without formatting
                    return `Enter ${maxNationalDigits} digit phone number`;
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
            });

            // Create a hidden input to store the full phone number with country code
            const hiddenPhoneInput = document.createElement('input');
            hiddenPhoneInput.type = 'hidden';
            hiddenPhoneInput.name = 'phone'; // This will be sent to server
            hiddenPhoneInput.id = 'full_phone';
            phoneInput.parentNode.appendChild(hiddenPhoneInput);

            // Update the hidden input whenever phone number changes
            function updateHiddenPhoneInput() {
                if (iti) {
                    try {
                        // Get the raw input value (without any formatting)
                        const rawValue = phoneInput.value;
                        // Remove all non-digit characters
                        const nationalNumber = rawValue.replace(/[^\d]/g, '');
                        
                        // Remove leading 0 if present (for countries that add it)
                        let cleanNationalNumber = nationalNumber;
                        if (nationalNumber.startsWith('0')) {
                            cleanNationalNumber = nationalNumber.substring(1);
                        }
                        
                        // Combine with dial code
                        fullPhoneNumberWithCountryCode = `${currentDialCode}${cleanNationalNumber}`;
                        hiddenPhoneInput.value = fullPhoneNumberWithCountryCode;
                        
                        console.log('Full phone number stored:', fullPhoneNumberWithCountryCode, 'National:', cleanNationalNumber);
                    } catch (e) {
                        console.error('Error updating hidden phone input:', e);
                        const nationalNumber = phoneInput.value.replace(/[^\d]/g, '');
                        let cleanNationalNumber = nationalNumber;
                        if (nationalNumber.startsWith('0')) {
                            cleanNationalNumber = nationalNumber.substring(1);
                        }
                        fullPhoneNumberWithCountryCode = `${currentDialCode}${cleanNationalNumber}`;
                        hiddenPhoneInput.value = fullPhoneNumberWithCountryCode;
                    }
                }
            }

            // Track when country changes
            phoneInput.addEventListener('countrychange', function() {
                if (iti) {
                    const selectedCountryData = iti.getSelectedCountryData();
                    currentCountryCode = selectedCountryData.iso2;
                    currentDialCode = `+${selectedCountryData.dialCode}`;

                    // Clear the input when country changes to avoid formatting issues
                    phoneInput.value = '';
                    
                    // Update max digits based on country
                    const placeholder = phoneInput.placeholder;
                    // Simple logic: most countries have 10 digits max
                    switch(currentCountryCode) {
                        case 'us':
                        case 'ca':
                        case 'in':
                            maxNationalDigits = 10;
                            break;
                        case 'gb':
                            maxNationalDigits = 10; // UK numbers are typically 10 digits without leading 0
                            break;
                        default:
                            maxNationalDigits = 15;
                    }

                    console.log(`Country changed to: ${selectedCountryData.name}, New national max digits: ${maxNationalDigits}, Dial Code: ${currentDialCode}`);

                    // Update hidden input
                    updateHiddenPhoneInput();
                    
                    // Clear any existing error
                    clearError(phoneInput);
                }
            });

            // Get current NATIONAL digit count (without country code)
            function getCurrentNationalDigitCount(value) {
                // Remove all non-digits and any leading 0
                let digits = value.replace(/[^\d]/g, '');
                if (digits.startsWith('0')) {
                    digits = digits.substring(1);
                }
                return digits.length;
            }

            // Get national number only (without country code and without leading 0)
            function getNationalNumber(value) {
                let digits = value.replace(/[^\d]/g, '');
                // Remove leading 0 if present
                if (digits.startsWith('0')) {
                    digits = digits.substring(1);
                }
                return digits;
            }

            // Helper to format national number WITHOUT adding leading 0
            function formatNationalNumber(number, countryCode) {
                if (!number) return '';
                
                let cleanNumber = number;
                // Ensure we don't have leading 0
                if (cleanNumber.startsWith('0')) {
                    cleanNumber = cleanNumber.substring(1);
                }

                // Only format if we have full number
                switch(countryCode) {
                    case 'us':
                    case 'ca':
                        if (cleanNumber.length === 10) {
                            return cleanNumber.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                        }
                        break;
                    case 'in':
                        if (cleanNumber.length === 10) {
                            return cleanNumber.replace(/(\d{5})(\d{5})/, '$1 $2');
                        }
                        break;
                    case 'gb':
                        if (cleanNumber.length === 10) {
                            return cleanNumber.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
                        }
                        break;
                }

                // Default: just return the number without leading 0
                return cleanNumber;
            }

            // Simple input handler - just allow digits and basic formatting
            phoneInput.addEventListener('input', function(e) {
                let value = this.value;

                // Get cursor position before any changes
                const cursorPos = this.selectionStart;

                // Remove any non-allowed characters
                const cleaned = value.replace(/[^0-9\s\-()]/g, '');

                // Get national digit count (without leading 0)
                const nationalDigitCount = getCurrentNationalDigitCount(cleaned);

                // If NATIONAL digits exceed max, truncate
                if (nationalDigitCount > maxNationalDigits) {
                    // Get national number only
                    let nationalNumber = getNationalNumber(cleaned);
                    
                    // Truncate to max national digits
                    nationalNumber = nationalNumber.substring(0, maxNationalDigits);
                    
                    // Format the national number
                    const result = formatNationalNumber(nationalNumber, currentCountryCode);
                    
                    this.value = result;

                    // Adjust cursor position
                    const newCursorPos = Math.min(cursorPos, result.length);
                    this.setSelectionRange(newCursorPos, newCursorPos);
                } else if (cleaned !== value) {
                    this.value = cleaned;
                }

                // Update the hidden full phone number
                updateHiddenPhoneInput();
                
                // Update filled state
                if (this.value.trim()) {
                    this.classList.add('filled');
                } else {
                    this.classList.remove('filled');
                }
            });

            // Prevent paste of invalid characters and enforce max digits
            phoneInput.addEventListener('paste', function(e) {
                e.preventDefault();

                // Get pasted text
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');

                // Clean the pasted text - keep only digits
                let pastedDigits = pastedText.replace(/[^0-9]/g, '');

                // Get current national digits count
                const currentNationalNumber = getNationalNumber(this.value);
                const currentNationalDigitCount = currentNationalNumber.length;

                // Calculate how many digits we can add
                const availableDigits = maxNationalDigits - currentNationalDigitCount;

                if (availableDigits <= 0) {
                    // Already at max national digits
                    return;
                }

                // Take only as many digits as we can fit
                pastedDigits = pastedDigits.substring(0, availableDigits);

                if (pastedDigits.length === 0) {
                    return;
                }

                // Append to current national number
                const newNationalNumber = (currentNationalNumber + pastedDigits).substring(0, maxNationalDigits);

                // Format the new number
                const newValue = formatNationalNumber(newNationalNumber, currentCountryCode);
                
                this.value = newValue;

                // Move cursor to end
                this.setSelectionRange(newValue.length, newValue.length);

                // Update the hidden full phone number
                updateHiddenPhoneInput();

                // Update filled state
                if (this.value.trim()) {
                    this.classList.add('filled');
                }
            });

            // Prevent keydown for adding more NATIONAL digits if at max
            phoneInput.addEventListener('keydown', function(e) {
                // Get current national digit count
                const currentNationalNumber = getNationalNumber(this.value);
                const currentNationalDigitCount = currentNationalNumber.length;

                // Check if it's a digit key (0-9 or numpad)
                const isDigit = /^\d$/.test(e.key) || (e.key >= '0' && e.key <= '9');

                // Check if it's a control key
                const isControl = [
                    'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight',
                    'ArrowUp', 'ArrowDown', 'Tab', 'Home', 'End',
                    'Enter', 'Escape'
                ].includes(e.key);

                // Check if it's a formatting character that we allow
                const isFormattingChar = /[\-\s()]/.test(e.key);

                if (isDigit && !e.ctrlKey && !e.metaKey && !e.altKey) {
                    // If already at max NATIONAL digits, prevent adding more
                    if (currentNationalDigitCount >= maxNationalDigits) {
                        e.preventDefault();
                        return;
                    }
                    
                    // Prevent typing 0 as first digit
                    if (currentNationalDigitCount === 0 && e.key === '0') {
                        e.preventDefault();
                        return;
                    }
                }

                // Allow control keys and formatting characters
                if (!isDigit && !isControl && !isFormattingChar && !e.ctrlKey && !e.metaKey && !e.altKey) {
                    // Prevent typing other characters
                    e.preventDefault();
                }
            });

            // Format the number on blur if valid
            phoneInput.addEventListener('blur', function() {
                // Count current national digits
                const nationalNumber = getNationalNumber(this.value);

                // STRICT enforcement - truncate if exceeds max NATIONAL digits
                if (nationalNumber.length > maxNationalDigits) {
                    const truncatedNational = nationalNumber.substring(0, maxNationalDigits);
                    this.value = formatNationalNumber(truncatedNational, currentCountryCode);
                }

                // Validate with intl-tel-input if we have enough digits
                if (iti && nationalNumber.length >= 6 && nationalNumber.length <= maxNationalDigits) {
                    // Create a temporary full number for validation
                    const tempFullNumber = `${currentDialCode}${nationalNumber}`;
                    
                    // Check if the number is valid
                    const isValid = iti.isValidNumber(tempFullNumber);
                    
                    if (isValid) {
                        // Format the national number nicely
                        this.value = formatNationalNumber(nationalNumber, currentCountryCode);
                    }
                }

                // Check if required and empty after formatting
                if (this.hasAttribute('required')) {
                    const nationalNumber = getNationalNumber(this.value);
                    const cleanNationalNumber = nationalNumber.startsWith('0') ? nationalNumber.substring(1) : nationalNumber;
                    
                    if (cleanNationalNumber.length === 0) {
                        showError(this, 'This field is required');
                    }
                }

                // Update the hidden full phone number
                updateHiddenPhoneInput();
                
                if (this.value.trim()) {
                    this.classList.add('filled');
                } else {
                    this.classList.remove('filled');
                }
            });

            // Also update on focus out (for good measure)
            phoneInput.addEventListener('focusout', function() {
                updateHiddenPhoneInput();
            });

            // Set initial filled state for phone
            if (phoneInput.value) {
                // Clean initial value if it has leading 0
                let initialValue = phoneInput.value;
                if (initialValue.startsWith('0')) {
                    phoneInput.value = initialValue.substring(1);
                }
                phoneInput.classList.add('filled');
                updateHiddenPhoneInput();
            }
        }

        // ZIP code input handling
        const zipInput = document.getElementById('zip');
        if (zipInput) {
            // Input event handler for ZIP code
            zipInput.addEventListener('input', function(e) {
                let value = this.value;
                
                // Remove all non-digit characters
                let digitsOnly = value.replace(/\D/g, '');
                
                // Truncate to max length
                digitsOnly = digitsOnly.substring(0, ZIP_CONFIG.MAX_LENGTH);
                
                // Update the value with digits only
                this.value = digitsOnly;
                
                // Update filled state
                if (this.value.trim()) {
                    this.classList.add('filled');
                } else {
                    this.classList.remove('filled');
                }
                
                // Clear any existing error
                clearError(this);
            });

            // Prevent paste of non-digit characters
            zipInput.addEventListener('paste', function(e) {
                e.preventDefault();
                
                // Get pasted text
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                
                // Extract only digits
                const digitsOnly = pastedText.replace(/\D/g, '');
                
                // Get current cursor position
                const cursorPos = this.selectionStart;
                const currentValue = this.value;
                
                // Calculate how many digits we can add
                const currentLength = currentValue.replace(/\D/g, '').length;
                const availableDigits = ZIP_CONFIG.MAX_LENGTH - currentLength;
                
                if (availableDigits <= 0) {
                    return;
                }
                
                // Take only as many digits as we can fit
                const digitsToAdd = digitsOnly.substring(0, availableDigits);
                
                if (digitsToAdd.length === 0) {
                    return;
                }
                
                // Insert digits at cursor position
                const before = currentValue.substring(0, cursorPos);
                const after = currentValue.substring(cursorPos);
                
                // Combine and keep only digits
                const newValue = (before + digitsToAdd + after).replace(/\D/g, '');
                this.value = newValue.substring(0, ZIP_CONFIG.MAX_LENGTH);
                
                // Move cursor to appropriate position
                const newCursorPos = Math.min(cursorPos + digitsToAdd.length, this.value.length);
                this.setSelectionRange(newCursorPos, newCursorPos);
                
                // Update filled state
                if (this.value.trim()) {
                    this.classList.add('filled');
                }
            });

            // Prevent typing non-digit characters
            zipInput.addEventListener('keydown', function(e) {
                // Allow control keys
                const isControl = [
                    'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight',
                    'ArrowUp', 'ArrowDown', 'Tab', 'Home', 'End',
                    'Enter', 'Escape'
                ].includes(e.key);
                
                // Allow digit keys (0-9 or numpad)
                const isDigit = /^\d$/.test(e.key) || (e.key >= '0' && e.key <= '9');
                
                // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                const isCtrlCombination = (e.ctrlKey || e.metaKey) && 
                    (e.key === 'a' || e.key === 'c' || e.key === 'v' || e.key === 'x');
                
                // If not a digit, control key, or Ctrl combination, prevent typing
                if (!isDigit && !isControl && !isCtrlCombination) {
                    e.preventDefault();
                    return;
                }
                
                // If it's a digit and we're at max length, prevent typing
                if (isDigit && !e.ctrlKey && !e.metaKey && !e.altKey) {
                    const currentDigits = this.value.replace(/\D/g, '');
                    if (currentDigits.length >= ZIP_CONFIG.MAX_LENGTH) {
                        e.preventDefault();
                        return;
                    }
                }
            });

            // Format on blur (add hyphen for US-style ZIP+4 if exactly 9 digits)
            zipInput.addEventListener('blur', function() {
                const value = this.value;
                const digitsOnly = value.replace(/\D/g, '');
                
                // Format as ZIP+4 if exactly 9 digits
                if (digitsOnly.length === 9) {
                    this.value = digitsOnly.replace(/^(\d{5})(\d{4})$/, '$1-$2');
                }
                // Otherwise just use the digits (up to 7 digits)
                else {
                    this.value = digitsOnly.substring(0, ZIP_CONFIG.MAX_LENGTH);
                }
                
                // Update filled state
                if (this.value.trim()) {
                    this.classList.add('filled');
                }
            });

            // On focus, remove formatting and show only digits
            zipInput.addEventListener('focus', function() {
                const value = this.value;
                // Remove any hyphens to show only digits during editing
                this.value = value.replace(/\D/g, '');
            });

            // Set initial filled state for ZIP
            if (zipInput.value) {
                zipInput.classList.add('filled');
            }
        }

        // Validation function
        function validateField(input) {
            const value = input.value.trim();
            const id = input.id;
            clearError(input);

            // Check if field is required and empty
            if (input.hasAttribute('required') && !value) {
                showError(input, 'This field is required');
                return false;
            }

            // If field is empty and not required, it's valid
            if (!value) {
                return true;
            }

            // Field has value, proceed with validation
            if (id === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                showError(input, 'Please enter a valid email');
                return false;
            }

            if (id === 'phone') {
                // Get national number digits (without country code and without leading 0)
                const nationalNumber = getNationalNumber ? getNationalNumber(value) : value.replace(/[^0-9]/g, '');
                // Remove leading 0 if present
                const cleanNationalNumber = nationalNumber.startsWith('0') ? nationalNumber.substring(1) : nationalNumber;
                const nationalDigitCount = cleanNationalNumber.length;

                // Check if user entered any digits
                if (nationalDigitCount === 0) {
                    // If field is required, we already handled empty case above
                    // If not required and only formatting characters were entered, it's okay
                    return true;
                }

                // First, check national digit count
                if (nationalDigitCount > maxNationalDigits) {
                    showError(input, `Phone number cannot exceed ${maxNationalDigits} digits`);
                    return false;
                }

                if (nationalDigitCount < 6) { // Minimum reasonable length for a phone number
                    showError(input, 'Phone number is too short');
                    return false;
                }

                // Then check with intl-tel-input validation if available
                if (iti) {
                    // Create full number for validation
                    const fullNumberForValidation = `${currentDialCode}${cleanNationalNumber}`;
                    
                    if (!iti.isValidNumber(fullNumberForValidation)) {
                        showError(input, 'Please enter a valid phone number');
                        return false;
                    }
                } else {
                    // Fallback validation without intl-tel-input
                    if (!/^[0-9\s\-()]*$/.test(value)) {
                        showError(input, 'Only digits and basic phone characters (-, (, ), space) are allowed');
                        return false;
                    }
                }
            }

            if (id === 'zip') {
                // Remove any hyphens for validation
                const digitsOnly = value.replace(/\D/g, '');
                
                // Check if it's only digits
                if (!ZIP_CONFIG.DIGITS_ONLY.test(digitsOnly)) {
                    showError(input, 'ZIP code must contain only numbers');
                    return false;
                }
                
                // Check max length
                if (digitsOnly.length > ZIP_CONFIG.MAX_LENGTH) {
                    showError(input, `ZIP code cannot exceed ${ZIP_CONFIG.MAX_LENGTH} digits`);
                    return false;
                }
                
                // Check minimum length (typically 3-5 digits depending on country)
                if (digitsOnly.length < 3) {
                    showError(input, 'ZIP code is too short');
                    return false;
                }
            }

            return true;
        }

        // Show error function
        function showError(input, message) {
            const group = input.closest('.floating-label-group');
            group.classList.add('error');
            let errorEl = group.querySelector('.error-msg');
            if (!errorEl) {
                errorEl = document.createElement('p');
                errorEl.className = 'error-msg text-red-500 text-xs mt-1 absolute';
                group.style.position = 'relative';
                group.appendChild(errorEl);
            }
            errorEl.textContent = message;
        }

        // Clear error function
        function clearError(input) {
            const group = input.closest('.floating-label-group');
            group.classList.remove('error');
            const errorEl = group.querySelector('.error-msg');
            if (errorEl) errorEl.remove();
        }

        const form = document.querySelector('form');
        const inputs = document.querySelectorAll('.floating-label-group input, .floating-label-group select');
        const selectedWrapper = document.getElementById('selected-package-wrapper');
        const modal = document.getElementById('package-modal');
        const subtotalEl = document.getElementById('subtotal-amount');
        const grandTotalEl = document.getElementById('grand-total-amount');
        const payBtn = document.getElementById('pay-btn');
        const toggleSummaryBtn = document.getElementById('sum-drop-hi');
        const hiddenSummary = document.querySelector('.hidden-sum-block');
        const fmt = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        });

        let validationBlocked = false;

        // === LOAD COUNTRIES FROM API ===
        async function loadCountries() {
            const countrySelect = document.getElementById('country');
            if (!countrySelect) return;

            try {
                countrySelect.innerHTML = '<option value="" disabled>Loading countries...</option>';

                const response = await fetch('https://restcountries.com/v3.1/all?fields=name,cca2');
                if (!response.ok) {
                    throw new Error('Failed to fetch countries');
                }

                const countries = await response.json();
                countries.sort((a, b) => a.name.common.localeCompare(b.name.common));

                countrySelect.innerHTML = '<option value="" disabled selected>Select a country</option>';

                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.cca2;
                    option.textContent = country.name.common;
                    countrySelect.appendChild(option);

                    // Store mapping for later use
                    countryCodeToName[country.cca2] = country.name.common;
                });

                console.log(`Loaded ${countries.length} countries successfully`);

            } catch (error) {
                console.error('Error loading countries:', error);

                const fallbackCountries = [
                    { code: 'US', name: 'United States' },
                    { code: 'CA', name: 'Canada' },
                    { code: 'GB', name: 'United Kingdom' },
                    { code: 'AU', name: 'Australia' },
                    { code: 'DE', name: 'Germany' },
                    { code: 'FR', name: 'France' },
                    { code: 'IT', name: 'Italy' },
                    { code: 'ES', name: 'Spain' },
                    { code: 'NL', name: 'Netherlands' },
                    { code: 'BE', name: 'Belgium' },
                    { code: 'IN', name: 'India' },
                    { code: 'JP', name: 'Japan' },
                    { code: 'CN', name: 'China' },
                    { code: 'BR', name: 'Brazil' },
                    { code: 'MX', name: 'Mexico' }
                ];

                countrySelect.innerHTML = '<option value="" disabled selected>Select a country</option>';
                fallbackCountries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.code;
                    option.textContent = country.name;
                    countrySelect.appendChild(option);

                    // Store mapping for later use
                    countryCodeToName[country.code] = country.name;
                });

                console.log('Using fallback countries due to API error');
            }
        }

        // Initialize PayPal Buttons
        let paypalButtons;
        let selectedPackage = null;

        function initPayPalButtons() {
            if (trialMode) {
                console.log('Skipping PayPal initialization for trial mode');
                return;
            }

            if (typeof paypal === 'undefined') {
                console.warn('PayPal SDK not loaded yet, retrying...');
                setTimeout(() => {
                    if (typeof paypal === 'undefined') {
                        console.error('PayPal SDK failed to load');
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Service Unavailable',
                            text: 'PayPal payment service is currently unavailable. Please refresh the page and try again.',
                            confirmButtonColor: '#ef4444'
                        });
                    } else {
                        initPayPalButtons();
                    }
                }, 2000);
                return;
            }

            if (paypalButtons) {
                paypalButtons.close();
            }

            const packageElement = selectedWrapper.querySelector('[data-item="1"]');
            if (!packageElement) {
                return;
            }

            selectedPackage = {
                id: packageElement.dataset.packageId,
                price: parseFloat(packageElement.dataset.price)
            };

            paypalButtons = paypal.Buttons({
                createOrder: function(data, actions) {
                    let isValid = true;
                    inputs.forEach(input => {
                        if (!validateField(input)) isValid = false;
                    });

                    const termsCheckbox = document.querySelector('input[type="checkbox"][required]');
                    if (termsCheckbox && !termsCheckbox.checked) {
                        isValid = false;
                    }

                    // Special check for phone field since it's required
                    const phoneField = document.getElementById('phone');
                    if (phoneField && phoneField.hasAttribute('required') && !validateField(phoneField)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Phone Number Required',
                            text: 'Please enter a valid phone number to proceed.',
                            confirmButtonColor: '#ef4444'
                        });
                        validationBlocked = true;
                        throw new Error('Phone number is required');
                    }

                    if (!isValid) {
                        const errorMessage = 'Please complete all required fields and accept the terms before proceeding with payment.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Please Complete the Form',
                            html: `
                                <ul class="text-left text-sm">
                                    ${!termsCheckbox?.checked ? '<li>Accept Privacy & Terms Policy</li>' : ''}
                                    ${[...inputs].some(i => i.closest('.floating-label-group')?.classList.contains('error')) ? '<li>Fix highlighted fields</li>' : ''}
                                </ul>
                            `,
                            confirmButtonColor: '#ef4444'
                        });
                        validationBlocked = true;
                        throw new Error(errorMessage);
                    }

                    return fetch('{{ route("checkout.create-order") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: JSON.stringify({
                                plan_id: selectedPackage.id,
                                billing_info: getBillingInfo()
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                if (response.status === 419) {
                                    throw new Error('Session expired. Please refresh the page and try again.');
                                } else if (response.status >= 500) {
                                    throw new Error('Server error. Please try again later.');
                                } else {
                                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                                }
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message || 'Failed to create order');
                            }
                            return data.order_id;
                        })
                        .catch(error => {
                            if (error.name === 'TypeError' && error.message.includes('fetch')) {
                                throw new Error('Network error. Please check your internet connection and try again.');
                            }
                            throw error;
                        });
                },
                onApprove: function(data, actions) {
                    if (!data.orderID) {
                        console.error('No PayPal order ID received');
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Error',
                            text: 'Invalid payment session. Please try again.',
                            confirmButtonColor: '#ef4444'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Processing Payment...',
                        text: 'Please wait while we process your payment.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    return fetch('/checkout/capture-payment', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: JSON.stringify({
                                order_id: data.orderID
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successful!',
                                    text: 'Redirecting to confirmation page...',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = `/checkout/success`;
                                });
                            } else {
                                throw new Error(data.message || 'Payment failed');
                            }
                        })
                        .catch(error => {
                            console.error('Payment capture error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Payment Failed',
                                text: error.message || 'There was an error processing your payment. Please try again.',
                                confirmButtonColor: '#ef4444'
                            });
                        });
                },
                onCancel: function(data) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Payment Cancelled',
                        text: 'You have cancelled the payment process.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/checkout/cancel';
                    });
                },
                onError: function(err) {
                    console.error('PayPal error:', err);
                    if (validationBlocked) {
                        validationBlocked = false;
                        return;
                    }

                    let errorMessage = 'There was an error with PayPal. Please try again.';
                    let errorTitle = 'Payment Error';

                    if (err && err.message) {
                        if (err.message.includes('Could not resolve host') || err.message.includes('network') || err.message.includes('connection')) {
                            errorTitle = 'Connection Error';
                            errorMessage = 'Unable to connect to payment service. Please check your internet connection and try again.';
                        } else if (err.message.includes('419') || err.message.includes('session')) {
                            errorTitle = 'Session Expired';
                            errorMessage = 'Your session has expired. Please refresh the page and try again.';
                        } else if (err.message.includes('authentication') || err.message.includes('unauthorized')) {
                            errorTitle = 'Authentication Error';
                            errorMessage = 'Payment service authentication failed. Please try again later.';
                        } else if (err.message.includes('Failed to create order')) {
                            errorTitle = 'Order Creation Failed';
                            errorMessage = 'Unable to create payment order. Please try again.';
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: errorTitle,
                        text: errorMessage,
                        confirmButtonColor: '#ef4444'
                    });
                }
            });

            paypalButtons.render('#paypal-button-container');
        }

        function getBillingInfo() {
            const countryCode = document.getElementById('country').value;
            const countryName = countryCodeToName[countryCode] || countryCode;

            // Get full phone number from hidden input
            const fullPhoneInput = document.getElementById('full_phone');
            const phoneWithCountryCode = fullPhoneInput ? fullPhoneInput.value : '';

            // Get the national number (without country code) for display purposes if needed
            const phoneDisplay = document.getElementById('phone').value;

            return {
                first_name: document.getElementById('firstName').value,
                last_name: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                address1: document.getElementById('address1').value,
                address2: document.getElementById('address2').value,
                city: document.getElementById('city').value,
                country: countryName, // Use full country name instead of code
                country_code: countryCode, // Keep the original country code for reference
                zip: document.getElementById('zip').value,
                phone: phoneDisplay, // National number only (for display)
                full_phone: phoneWithCountryCode, // Full number with country code
                phone_country_code: currentDialCode // Current dial code
            };
        }

        // Floating Labels + Validation
        inputs.forEach(input => {
            const group = input.closest('.floating-label-group');
            if (input.value.trim()) group.classList.add('has-value');

            input.addEventListener('focus', () => group.classList.add('focused'));
            input.addEventListener('blur', () => {
                group.classList.remove('focused');
                input.value.trim() ? group.classList.add('has-value') : group.classList.remove('has-value');
                validateField(input);
            });
            input.addEventListener('input', () => clearError(input));
        });

        // REPLACE PACKAGE - ONLY ONE PACKAGE ALLOWED AT A TIME
        function replacePackage(pkg) {
            console.log('replacePackage called with:', pkg);
            selectedWrapper.innerHTML = '';

            const wasEmpty = selectedWrapper.children.length === 0;

            const row = document.createElement('div');
            row.className = 'flex items-center justify-between py-5 border-b last:border-0 bg-gray-50 rounded-lg mb-3 px-4 relative';
            row.dataset.item = '1';
            row.dataset.price = pkg.price;
            row.dataset.packageId = pkg.id;

            row.innerHTML = `
                <div class="flex flex-col smx:flex-row smx:items-center gap-2 sm:gap-6 w-full ">
                  <div class="flex items-center gap-4 flex-1 min-w-0 xs:flex-row flex-col ">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg flex-shrink-0">
                      ${pkg.name}
                    </div>
                    <div class="xs:flex-1 xs:min-w-0 xs:w-auto w-full xs:text-left text-center">
                      <p class="package-name font-bold text-gray-800 text-lg truncate ">
                        ${pkg.name}
                      </p>
                      <p class="text-xs text-gray-500 mt-1">
                        $${pkg.price.toLocaleString()}
                      </p>
                    </div>
                  </div>
                  <div class="flex items-center xs:justify-end justify-center mt-2 smxl:mt-0">
                    <p class="package-price text-[1.2rem] font-bold text-gray-900 whitespace-nowrap ">
                      ${fmt.format(pkg.price)}
                    </p>
                  </div>
                </div>
            `;

            selectedWrapper.appendChild(row);
            updateTotals();

            console.log('Package successfully added to order review:', pkg.name, 'Price:', pkg.price);

            setTimeout(initPayPalButtons, 100);
        }

        // "Get Started" buttons inside modal - REPLACE package
        document.querySelectorAll('.package-get-started').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const pkg = {
                    id: this.dataset.packageId,
                    name: this.dataset.packageName,
                    price: parseFloat(this.dataset.packagePrice),
                    validity: this.dataset.duration
                };

                replacePackage(pkg);

                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        });

        function updateTotals() {
            let total = 0;
            selectedWrapper.querySelectorAll('[data-item="1"]').forEach(el => {
                total += parseFloat(el.dataset.price || 0);
            });
            const amount = fmt.format(total);
            if (subtotalEl) subtotalEl.textContent = amount;
            if (grandTotalEl) grandTotalEl.textContent = amount;
            if (payBtn) payBtn.textContent = `Pay ${amount}`;
        }

        // Collapsible Summary
        if (hiddenSummary) {
            hiddenSummary.classList.add('collapsed');
        }
        if (toggleSummaryBtn) {
            toggleSummaryBtn.classList.replace('fa-chevron-up', 'fa-chevron-down');
            toggleSummaryBtn.addEventListener('click', () => {
                hiddenSummary.classList.toggle('collapsed');
                toggleSummaryBtn.classList.toggle('fa-chevron-up');
                toggleSummaryBtn.classList.toggle('fa-chevron-down');
            });
        }

        // Modal Controls
        const modalToggle = document.getElementById('modal-package-toggle');
        const modalClose = document.getElementById('modal-close');

        if (modalToggle) {
            modalToggle.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        }
        if (modalClose) {
            modalClose.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        }
        if (modal) {
            modal.addEventListener('click', e => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        }

        // Form Submit (skip in trial mode)
        if (!trialMode) form.addEventListener('submit', async function(e) {
            e.preventDefault();

            let isValid = true;

            inputs.forEach(input => {
                if (!validateField(input)) isValid = false;
            });

            const termsCheckbox = document.querySelector('input[type="checkbox"][required]');
            const termsLabel = termsCheckbox?.closest('label');

            if (termsCheckbox && !termsCheckbox.checked) {
                isValid = false;
                if (termsLabel) {
                    termsLabel.style.color = '#ef4444';
                    termsLabel.style.fontWeight = '600';
                }
            } else {
                if (termsLabel) {
                    termsLabel.style.color = '';
                    termsLabel.style.fontWeight = '';
                }
            }

            if (selectedWrapper.children.length === 0) {
                isValid = false;
            }

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Please Complete the Form',
                    html: `
                        <ul class="text-left text-sm">
                            ${!termsCheckbox?.checked ? '<li>Accept Privacy & Terms Policy</li>' : ''}
                            ${selectedWrapper.children.length === 0 ? '<li>Select a package</li>' : ''}
                            ${[...inputs].some(i => i.closest('.floating-label-group')?.classList.contains('error')) ? '<li>Fix highlighted fields</li>' : ''}
                        </ul>
                    `,
                    confirmButtonColor: '#ef4444'
                });
                return;
            }

            const result = await Swal.fire({
                icon: 'question',
                title: 'Confirm Your Order',
                html: `
                    <div class="text-left max-h-96 overflow-y-auto">
                        ${Array.from(selectedWrapper.children).map(row => {
                            const name = row.querySelector('.package-name')?.textContent || 'Unknown';
                            const id = row.querySelector('.package-id')?.textContent || '';
                            const price = row.querySelector('.package-price')?.textContent || '$0.00';
                            return `
                                <div class="flex justify-between mb-3 p-3 bg-gray-50 rounded">
                                    <div>
                                        <strong>${name}</strong><br>
                                        <small class="text-gray-500">ID: ${id}</small>
                                    </div>
                                    <span class="font-bold">${price}</span>
                                </div>
                            `;
                        }).join('')}
                        <hr class="my-4 border-gray-300">
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total:</span>
                            <span>${grandTotalEl.textContent}</span>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Yes, Complete Purchase',
                cancelButtonText: 'Review Order',
                confirmButtonColor: '#10b981',
                width: '600px'
            });

            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Purchase Successful!',
                    text: 'Thank you! Confirmation email sent.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });

        // Auto-select package if plan data is available
        if (planData && !trialMode) {
            const autoSelectedPackage = {
                id: planData.id.toString(),
                name: planData.name,
                price: parseFloat(planData.price)
            };
            replacePackage(autoSelectedPackage);
        }

        // Handle trial complete button for plan 14
        const trialCompleteBtn = document.getElementById('trial-complete-btn');
        if (trialCompleteBtn) {
            trialCompleteBtn.addEventListener('click', async function() {
                let isValid = true;

                inputs.forEach(input => {
                    if (!validateField(input)) isValid = false;
                });

                const termsCheckbox = document.querySelector('input[type="checkbox"][required]');
                const termsLabel = termsCheckbox?.closest('label');

                if (termsCheckbox && !termsCheckbox.checked) {
                    isValid = false;
                    if (termsLabel) {
                        termsLabel.style.color = '#ef4444';
                        termsLabel.style.fontWeight = '600';
                    }
                } else {
                    if (termsLabel) {
                        termsLabel.style.color = '';
                        termsLabel.style.fontWeight = '';
                    }
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please Complete the Form',
                        html: `
                            <ul class="text-left text-sm">
                                ${!termsCheckbox?.checked ? '<li>Accept Privacy & Terms Policy</li>' : ''}
                                ${[...inputs].some(i => i.closest('.floating-label-group')?.classList.contains('error')) ? '<li>Fix highlighted fields</li>' : ''}
                            </ul>
                        `,
                        confirmButtonColor: '#ef4444'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Activating Trial...',
                    text: 'Please wait while we activate your trial.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    const response = await fetch('/checkout/free-complete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            plan_id: '{{ config("paypal.trial_plan_id") }}',
                            billing_info: getBillingInfo()
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to activate trial');
                    }

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = '/checkout/success?trial=1';
                    } else {
                        throw new Error(data.message || 'Failed to activate trial');
                    }

                } catch (error) {
                    console.error('Trial activation error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Trial Activation Failed',
                        text: error.message || 'There was an error activating your trial. Please try again.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        }

        // Auto-select plan 14 for trial mode
        if (@json($trialMode ?? false)) {
            const allPlans = @json($allPlans ?? []);
            console.log('Trial mode active, checking allPlans:', allPlans);
            const trialPlan = allPlans.find(plan => plan.id == {{ config('paypal.trial_plan_id') }});

            if (trialPlan) {
                console.log('Auto-selecting trial plan:', trialPlan.name);
                replacePackage({
                    id: trialPlan.id.toString(),
                    name: trialPlan.name,
                    price: parseFloat(trialPlan.price)
                });
                console.log('Trial plan selected successfully and added to order review');
            } else {
                console.error('Trial plan (id: {{ config("paypal.trial_plan_id") }}) not found in allPlans');
                console.log('Available plans:', allPlans.map(p => ({id: p.id, name: p.name})));
            }
        }

        // Load countries on page load
        loadCountries();
        updateTotals();
    });
</script>
@endsection
