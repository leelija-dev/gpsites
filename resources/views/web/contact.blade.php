@extends('layouts.web.main-layout')

@section('title', 'Contact')
@section('description', '')
@section('keywords', 'contact gpsites, gpsites contact number', 'gpsites email')
@section('indexing', 'no')

@section('content')

<section class="lg:py-16 py-12 px-6">
    <div class="container mx-auto ">
        <div class="grid lg:grid-cols-2 gap-12  ">

            <!-- Left side - Text content -->
            <div class="flex flex-col justify-start text-center lg:text-left">
                <div>
                    <div class="flex items-center space-x-2 mb-8 w-fit p-1 rounded-full border-[1px] border-gray-300 lg:mr-auto lg:ml-0 mx-auto">
                        <span class="bg-black text-white px-3 py-1 rounded-full text-sm font-semibold">Contact</span>
                        <a href="#" class="text-gray-600 text-sm flex items-center">
                            Answers, simplified.
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                    <h1 class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl
         font-bold  text-gray-900 leading-tight mb-4">
                        Let's Talk. <br> We're All Ears.
                    </h1>
                    <p class="text-gray-600 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl  mb-12">
                        Whether you've got a burning question, a big idea, or just want to say hi — we're ready.
                    </p>
                </div>

                <div class="grid grid-cols-1 smx:grid-cols-2 gap-8 text-gray-700">
                    <div>
                        <div class="flex items-center  lg:justify-start justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="font-semibold text-lg lg:text-xl">Email us</span>
                        </div>
                        <p class="text-gray-600"><a class="hover:text-secondary transition-all duration-300 ease-in-out inline-block w-fit" href="mailto:info@leelija.com">info@leelija.com</a></p>
                        <p class="text-gray-600">We reply within 24 hours.</p>
                    </div>
                    <div>
                        <div class="flex items-center  lg:justify-start justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="font-semibold text-lg lg:text-xl">Give us a ring</span>
                        </div>
                        <p class="text-gray-600 flex flex-col gap-1 lg:items-start items-center">
                            <a href="tel:+916290101838" class=" hover:text-secondary transition-all duration-300 ease-in-out inline-block w-fit">
                                +91 629 010 1838
                            </a>
                            <a href="tel:+913325849017" class=" hover:text-secondary transition-all duration-300 ease-in-out inline-block w-fit">
                                +91 332 584 9017
                            </a>
                        </p>
                        <p class="text-gray-600">Available Mon-Sat, 10am-6.30pm IST</p>
                    </div>
                    <div>
                        <div class="flex items-center  lg:justify-start justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-semibold text-lg lg:text-xl">Working Hours</span>
                        </div>
                        <p class="text-gray-600">Monday to Friday</p>
                        <p class="text-gray-600">10:00 AM - 6:30 PM (PST) . Sat - 2.00 PM</p>

                    </div>
                    <div>
                        <div class="flex items-center  lg:justify-start justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="font-semibold text-lg lg:text-xl">Address</span>
                        </div>
                        <p class="text-gray-600">Taki Road, Bamunmura, Barasat,<br>
                            Kolkata - 700125, West Bengal, India</p>
                    </div>
                </div>
            </div>

            <!-- Right side - Contact Form -->
            <div class="bg-white rounded-2xl shadow-[0_6px_19px_#ccc] p-8 lg:p-10">
                <form id="contact-us" method="post" action="{{route('contact.store')}}" class="space-y-6" novalidate>

                    <!-- Success Message -->
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="floating-label-group">
                            <input
                                type="text"
                                id="full_name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder=""
                                class="w-full px-4 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                required />
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full name</label>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="floating-label-group">
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder=""
                                class="w-full px-4 py-3 border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition" />
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="floating-label-group">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder=""
                            class="w-full px-4 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                            required />
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select
                            id="subject"
                            name="subject"
                            class="w-full px-4 py-3 text-[#a8a8a8] border @error('subject') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                            <option value="">Select a subject</option>
                            <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Support</option>
                            <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                        </select>
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="floating-label-group">
                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            placeholder=""
                            class="w-full px-4 py-3 border @error('message') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none"
                            required>{{ old('message') }}</textarea>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full btn-primary disabled:opacity-50 disabled:cursor-not-allowed"
                        id="submit-btn">
                        <span id="btn-text">Send Message</span>
                        <span id="btn-loading" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sending...
                        </span>
                    </button>
                </form>

            </div>

        </div>
    </div>
</section>

<section class="bg-[#031758] lg:py-16 py-12 px-6 text-center">
    <div class="container mx-auto px-6">

        <!-- Small Title -->
        <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit  mb-4">
            <span class="w-2 h-2 bg-primary rounded-full"></span>
            Subscribe Now
            <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
        </div>

        <!-- Main Heading -->
        <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
         font-bold  text-white mb-6 ">
            Looking for the best IT <br> business solutions?
        </h2>

        <!-- Success/Error Messages -->
        @if(session('success') && request()->routeIs('newsletter.subscribe'))
            <div class="max-w-2xl mx-auto mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info') && request()->routeIs('newsletter.subscribe'))
            <div class="max-w-2xl mx-auto mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg text-sm">
                {{ session('info') }}
            </div>
        @endif

        @error('email')
            <div class="max-w-2xl mx-auto mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ $message }}
            </div>
        @enderror

        <!-- Input + Button -->
        <form
            method="POST"
            action="{{ route('newsletter.subscribe') }}"
            class="max-w-2xl mx-auto flex items-center smx:flex-row flex-col bg-white smx:rounded-full rounded-[10px] shadow-lg overflow-hidden smx:pe-2 smx:p-0 p-4"
            id="newsletter-form">
            @csrf
            <input type="hidden" name="source" value="contact-page">
            <input type="hidden" name="redirect_to" value="{{ url()->current() }}">

            <!-- Email Input -->
            <input
                type="email"
                name="email"
                id="newsletter-email"
                value="{{ old('email', request()->routeIs('newsletter.subscribe') ? old('email') : '') }}"
                placeholder="Enter Your Email"
                class="smx:px-6 px-4 smx:py-4 py-2 w-full text-gray-700 placeholder-gray-500 focus:outline-none smx:border-0 border-[1px] border-[#aeaeae] smx:rounded-none rounded-full smx:mb-0 mb-2 text-lg @error('email') border-red-500 @enderror"
                style="box-shadow: none !important;"
                required />

            <!-- Subscribe Button -->
            <button
                type="submit"
                class="btn-primary min-w-[180px] px-2 py-2 rounded-full disabled:opacity-50 disabled:cursor-not-allowed"
                id="newsletter-submit-btn">
                <span id="newsletter-btn-text">Subscribe Now</span>
                <span id="newsletter-btn-loading" class="hidden">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Subscribing...
                </span>
            </button>
        </form>

    </div>
</section>


<section class="lg:py-16 py-12 px-6">

    <div class="container mx-auto">
        <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
         font-bold text-center text-gray-900 mb-12">
            Other ways to reach us
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Visit us -->
            <div class="bg-[#f6f6f6] rounded-3xl p-8 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 mx-auto mb-6 bg-secondary rounded-full flex items-center justify-center">
                    <i class="ri-map-pin-2-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Visit us</h3>
                <p class="text-gray-600 mb-4">Don Valley, Toronto, CA</p>
                <a href="#" class="text-primary font-medium hover:text-secondary inline-flex items-center gap-1">
                    View on maps <span>→</span>
                </a>
            </div>

            <!-- Via chat -->
            <div class="bg-[#f6f6f6] rounded-3xl p-8 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 mx-auto mb-6 bg-secondary rounded-full flex items-center justify-center">
                    <i class="ri-message-3-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Via chat</h3>
                <p class="text-gray-600 mb-4">Get instant answers.</p>
                <a href="#" class="text-primary font-medium hover:text-secondary inline-flex items-center gap-1">
                    Let's chat <span>→</span>
                </a>
            </div>

            <!-- Report Issue -->
            <div class="bg-[#f6f6f6] rounded-3xl p-8 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 mx-auto mb-6 bg-secondary rounded-full flex items-center justify-center">
                    <i class="ri-mail-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Report Issue</h3>
                <p class="text-gray-600 mb-4">Get priority support.</p>
                <a href="#" class="text-primary font-medium hover:text-secondary inline-flex items-center gap-1">
                    Send report <span>→</span>
                </a>
            </div>

            <!-- Our community -->
            <div class="bg-[#f6f6f6] rounded-3xl p-8 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 mx-auto mb-6 bg-secondary rounded-full flex items-center justify-center">
                    <i class="ri-group-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Our community</h3>
                <p class="text-gray-600 mb-4">Connect with users.</p>
                <a href="#" class="text-primary font-medium hover:text-secondary inline-flex items-center gap-1">
                    Join us now <span>→</span>
                </a>
            </div>
        </div>
    </div>

</section>

{{-- <x-web.faq /> --}}


@endsection
@section('scripts')


@endsection
