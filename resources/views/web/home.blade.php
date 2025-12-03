@extends('layouts.web.main-layout')

@section('title', 'Link Building Outreach Tool | Backlink Marketplace')
@section('description', '')
@section('keywords', 'Link Building Outreach Automation​, Outreach Automation, Link Building Outreach Tool, outreach automation tool​, automated outreach system​, backlink marketplace, backlinks websites, outreach automation tool')

@section('content')


<!-- hero section  -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden lg:py-16 py-12 px-6">
    <!-- Background decorative circles -->
    <div class="w-full h-full absolute top-0 left-0 overflow-hidden z-[-1]">
        <div class="absolute w-[300px] h-[300px] border-secondary border-[40px] rounded-full opacity-[0.1] top-[10%] right-[29%] "></div>
        <div class="absolute w-[120px] h-[120px] border-secondary border-[20px] rounded-full opacity-[0.1] top-[13%] right-[8%] "></div>
        <div class="absolute w-[80px] h-[80px] border-secondary border-[20px] rounded-full opacity-[0.1] bottom-[10%] left-[18%] "></div>

        <div class="absolute w-[600px] h-[600px] border-secondary border-[80px] rounded-full opacity-[0.1] bottom-[10%] left-0 transform translate-x-[-50%]"></div>
    </div>

    <div class="container mx-auto   flex items-center justify-center relative z-10 lg:flex-nowrap flex-wrap">

        <!-- Left Section -->
        <div class=" lg:w-1/2 w-full space-y-8 lg:text-left text-center">
            <h1 class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl font-bold text-gray-900 leading-tight">
                Best <span class="text-primary">Link Building Marketplace</span> & <span class="text-primary">Outreach Automation Tool</span>
            </h1>

            <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl text-gray-600 ">
                Our guest posting marketplace connects you with the relevant backlinks websites & skyrocket yours link-building outreach automation.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 lg:justify-start sm:justify-center items-center">
                <!-- Hero CTA -->
                <button type="button" id="see-pricing" class="btn-primary whitespace-nowrap"> See Pricing </button>
                @auth
                <form method="POST" action="{{ route('checkout') }}" class="w-full">
                    @csrf
                    <input type="hidden" name="plan" value="{{ config('paypal.trial_plan_id') }}">
                    <button type="submit" class="btn-secondary">Trial Now</button>
                </form>
                @endauth
                @guest
                <form method="POST" action="{{ route('start.trial') }}" class="w-full">
                    @csrf
                    <button type="submit" class="btn-secondary">Trial Now</button>
                </form>
                @endguest
            </div>

            <!-- Stats -->
            <div class="flex flex-wrap gap-8 xl:gap-20 mt-12 text-center lg:justify-start justify-center">
                <div>
                    <div class="text-4xl font-bold text-gray-900">7+</div>
                    <div class="text-sm text-gray-500">Years Experience</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">500+ </div>
                    <div class="text-sm text-gray-500">Agency Users</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">50K+</div>
                    <div class="text-sm text-gray-500">Blogger Partner</div>
                </div>
            </div>
        </div>

        <!-- Right Section - Card -->
        <div class=" lg:w-1/2 w-full flex justify-center lg:mt-0 mt-4">
            <div class="backdrop-blur-[9px]  bg-white/0  rounded-3xl shadow-2xl p-8 w-full max-w-[500px] border-t-0 border-b-0 border-l-[3px] border-r-[3px] border-primary">

                <!-- Search Bar -->
                <div class="relative mb-8 z-[51]">
                    <div id="selected-niches" class="flex flex-wrap gap-2 mb-2"></div>

                    <!-- Search Input -->
                    <input
                        type="text"
                        id="niche-search"
                        placeholder="Search and Select Niche"
                        autocomplete="off"
                        class="w-full backdrop-blur-[3px] bg-white/0 shadow-[1px_4px_17px_#5e5d5d38] pl-12 pr-4 py-3 rounded-full border border-secondary focus:outline-none focus:ring-2 focus:ring-primary text-gray-700" />
                    <!-- Search Icon -->
                    {{-- <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-secondary pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg> --}}

                    <!-- Dropdown Results -->
                    <div id="niche-dropdown" class="absolute top-full mt-2 w-full bg-white rounded-2xl shadow-xl border border-gray-200 max-h-64 overflow-y-auto hidden z-50">
                        <ul id="niche-list" class="py-2">
                            <!-- Items will be injected here by JavaScript -->
                        </ul>
                    </div>
                    <div id="selected-niches" class="flex flex-wrap gap-2 mb-2"></div>

                </div>

                <!-- Sliders -->
                <div class="">
                    <!-- DA Slider -->
                    <div class="mb-3">
                        <div class="flex justify-between text-2xl font-bold text-darkPrimary mb-3">
                            <span>DA</span>
                            <span class="text-purple-600 font-bold " style="display: none !important;" id="da-values">0 – 0</span>
                        </div>
                        <div class="range-slider">
                            <div class="track"></div>
                            <div class="fill" id="da-fill"></div>



                            <!-- IMPORTANT: value="0" or remove value entirely -->
                            <input type="range" min="0" max="100" value="0" class="thumb-right" id="da-max">
                            <input type="range" min="0" max="100" value="0" class="thumb-left" id="da-min">

                            <span class="tooltip left-tooltip" id="da-min-tooltip">0</span>
                            <span class="tooltip right-tooltip" id="da-max-tooltip">0</span>
                        </div>
                    </div>

                    <!-- DR Slider -->
                    <div class="mb-3">
                        <div class="flex justify-between text-2xl font-bold text-darkPrimary mb-3">
                            <span>DR</span>
                            <span class="text-purple-600 font-bold " style="display: none !important;" id="dr-values">0 – 0</span>
                        </div>
                        <div class="range-slider">
                            <div class="track"></div>
                            <div class="fill" id="dr-fill"></div>



                            <input type="range" min="0" max="100" value="0" class="thumb-right" id="dr-max">
                            <input type="range" min="0" max="100" value="0" class="thumb-left" id="dr-min">

                            <span class="tooltip left-tooltip" id="dr-min-tooltip">0</span>
                            <span class="tooltip right-tooltip" id="dr-max-tooltip">0</span>
                        </div>
                    </div>

                    <!-- Traffic Slider -->
                    <div class="mb-3">
                        <div class="flex justify-between text-2xl font-bold text-darkPrimary mb-3">
                            <span>Traffic</span>
                            <span class="text-purple-600 font-bold" id="tar-values">0</span>
                        </div>
                        <div class="range-slider single">
                            <div class="track"></div>
                            <div class="fill" id="tar-fill"></div>



                            <input type="range" min="0" max="250000" value="0" step="1000"
                                class="thumb" id="tar-single">
                            <span class="tooltip single-tooltip" id="tar-tooltip">0</span>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                {{-- <button class="mt-10 w-full bg-primary hover:bg-purple-800 text-white font-bold py-4 rounded-xl transition text-lg">
                    Find Now
                </button> --}}
                {{-- <form  action="{{ route('find.niches') }}" method="GET" > --}}
                <form id="searchForm" action="{{ route('find.niches') }}" method="GET">

                    <!-- Hidden Inputs for Niches + Filters -->
                    <input type="hidden" id="niche-values" name="niches">
                    <input type="hidden" id="da-min-input" name="da_min">
                    <input type="hidden" id="da-max-input" name="da_max">
                    <input type="hidden" id="dr-min-input" name="dr_min">
                    <input type="hidden" id="dr-max-input" name="dr_max">
                    <input type="hidden" id="traffic-min-input" name="traffic_min">
                    <input type="hidden" id="traffic-max-input" name="traffic_max">

                    <button type="submit"
                        class="mt-10 w-full bg-primary hover:bg-purple-800 text-white font-bold py-4 rounded-xl transition text-lg">
                        Find Now
                    </button>
                </form>

            </div>
        </div>
    </div>
</section>



<!-- scores section  -->
<section class="w-full bg-gradient-to-r from-primary to-secondary lg:py-16 py-12 px-6">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 text-center text-white gap-10">

            <!-- Item 1 -->
            <div>
                <h2 class="text-3xl font-bold">200K+</h2>
                <p class=" mt-1 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">Link Built</p>
            </div>

            <!-- Item 2 -->
            <div>
                <h2 class="text-3xl font-bold">1156+</h2>
                <p class=" mt-1 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">Happy Client</p>
            </div>

            <!-- Item 3 -->
            <div>
                <h2 class="text-3xl font-bold">100%</h2>
                <p class=" mt-1 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">Customer Satisfaction</p>
            </div>

        </div>
    </div>
</section>




<!-- feature section -->
<section class="lg:py-16 py-12 px-6">
    <div class="container mx-auto">
        <div class="max-w-7xl w-full mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit">
                    <span class="w-2 h-2 bg-primary rounded-full"></span>
                    Key Features
                    <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
                </div>
                <h2 class="mt-2 text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-bold text-gray-900">
                    Next Generation Outreach Automation with Adaptive Functionality Features
                </h2>
            </div>
            <!-- Features Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col sm:items-start items-center  sm:text-left text-center hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg font-semibold text-gray-900 mb-2"> Automate Link Building Outreach</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">By streamlining your repetitive taskflows, we help you in mass prospect outreach for increased conversions & functional efficiency.</p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col sm:items-start items-center  sm:text-left text-center hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">Bulk Outreach Management</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        We automate outreach, scale link-building, ensure consistent pitching, and connect you with more prospects efficiently, all at once.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col sm:items-start items-center  sm:text-left text-center hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">Niche-Specific Target</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        With AI, we analyze data, segment website owners, and send highly relevant & customized messages for niche-specific backlinks.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col sm:items-start items-center  sm:text-left text-center hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">Automated Follow-Ups</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        By scheduling the follow-up pitches, we help you re-engage with target bloggers without manual efforts, in case the initial one goes unnoticed.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col sm:items-start items-center  sm:text-left text-center hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">Verified Placements</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        Our automation outreach system increases link-building efficiency by securing guest post placements on pre-verified authority sites.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col sm:items-start items-center  sm:text-left text-center hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">Performance Tracking</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        Our backlink marketplace tools also provide real-time user analytics data & detailed insights into site metrics after link-building.
                    </p>
                </div>


            </div>

            <!-- CTA Button -->
            <div class="text-center mt-12">
                <a href="{{ route('contact') }}" class="btn-primary">
                    Contact Us
                </a>
            </div>
        </div>
    </div>

</section>



<!-- pricing plan section  -->
{{-- <section id="pricing" class="lg:py-16 py-12 px-6"> --}}
<section id="pricing" class="scroll-mt-24 lg:py-16 py-12 px-6">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="w-full text-center mb-12">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit">
                <span class="w-2 h-2 bg-primary rounded-full"></span>
                Our Pricing Plan
                <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
            </div>
            <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
 font-bold text-gray-900">Affordable Pricing Packages</h2>
        </div>

        <!-- Pricing Cards Wrapper -->
        <div class="max-w-7xl mx-auto lg:px-6 px-0 grid grid-cols-1 md:grid-cols-{{ $plans->count() }} gap-8 pb-16">
            @foreach($plans as $index => $plan)
            @php
            $isHighlighted = $index === 1; // Make the middle plan highlighted
            $planIcons = ['🚀', '⚙️', '👑', '💎', '⭐'];
            $planBadges = ['STARTER BOOST', 'GROWTH ACCELERATOR', 'MARKET LEADER', 'ENTERPRISE', 'PREMIUM'];
            $icon = $planIcons[$index] ?? '🚀';
            $badge = $planBadges[$index] ?? 'PLAN';
            @endphp

            <!-- Plan Card -->
            <div class="bg-{{ $isHighlighted ? 'gradient-to-br from-black to-primary text-white' : 'white' }}
            rounded-2xl {{ $isHighlighted ? 'shadow-xl' : 'shadow-md border border-gray-100' }}
            px-8 pb-8 pt-0 overflow-hidden hover:scale-[1.04] transition-all duration-300 ease-in-out
            flex flex-col h-full">
                <div class="text-center">
                    <div class="bg-{{ $isHighlighted ? 'purple-600 text-white' : 'purple-100 text-purple-600' }} relative top-[-3px] py-[7px] px-[22px] mb-[3rem] rounded-b-[10px] text-sm font-semibold inline-block">
                        {{ $badge }}
                    </div>

                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 {{ $isHighlighted ? 'bg-white/20' : 'bg-purple-50' }} rounded-full flex justify-center items-center">
                            <span class="{{ $isHighlighted ? 'text-white' : 'text-purple-600' }} text-3xl">{{ $icon }}</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold">{{ $plan->name }}</h3>
                    <p class="text-4xl font-bold mt-2">${{ number_format($plan->price) }}<span class="text-xl font-small">/</span><span class="text-base font-medium">{{ $plan->duration == 30 ? ($plan->duration / 30)
                    : ($plan->duration == 31 ? ($plan->duration / 31) : $plan->duration )}}

                            {{-- <p class="{{ $isHighlighted ? 'text-purple-200' : 'text-gray-500' }} text-sm mb-4">--}}{{$plan->duration === 30||$plan->duration === 31 ? 'Month' : 'days' }}</span></p>
                    <span class="inline-block {{ $isHighlighted ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-700' }} text-xs px-3 py-1 rounded-full mb-6">
                        {{ $plan->mail_available ?? '0' }} Mail
                    </span>
                </div>
                <div class="flex-1 mt-6">
                    @if($plan->features && $plan->features->count() > 0)
                    <ul class="space-y-3 {{ $isHighlighted ? 'text-purple-100' : 'text-gray-600' }}">
                        @foreach($plan->features->where('is_active', true) as $feature)
                        <li>• {{ $feature->feature }}</li>
                        @endforeach
                    </ul>
                    {{-- @else
                <ul class="space-y-3 {{ $isHighlighted ? 'text-purple-100' : 'text-gray-600' }}">
                    <li>• Feature 1</li>
                    <li>• Feature 2</li>
                    <li>• Feature 3</li>
                    </ul> --}}
                    @endif
                </div>

                <!-- <div class="text-center my-10">
                        <a href="{{ route('checkout') }}?plan={{ $plan->id }}" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} rounded-full w-full block">Get Started</a>
                    </div> -->

                <!-- @auth
                <a href="{{ route('checkout') }}?plan={{ $plan->id }}" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} rounded-full w-full block">Get Started</a>
                @else
                <a href="{{ route('login') }}?redirect={{ urlencode(route('checkout', ['plan' => $plan->id])) }}" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} rounded-full w-full block">Get Started</a>
                @endauth -->

                <!-- @auth
                <a href="{{ route('checkout', ['plan' => $plan->id]) }}" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} rounded-full w-full block">Get Started</a>
                @else
                <a href="{{ route('login') }}?redirect={{ urlencode(route('checkout', ['plan' => $plan->id])) }}" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} rounded-full w-full block">Get Started</a>
                @endauth -->
                <div class="mt-8">
                    @auth
                    <form method="POST" action="{{ route('checkout') }}" class="w-full">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan->id }}">
                        <button type="submit" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} rounded-full w-full block">Get Started</button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('intent.plan') }}" class="w-full">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan->id }}">
                        <button type="submit" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} rounded-full w-full block">Get Started</button>
                    </form>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Trial Plan Section -->
@if($trialPlan)
<section class="bg-gradient-to-br from-purple-600 to-blue-600 py-16 px-6">
    <div class="container mx-auto">
        <div class="max-w-4xl mx-auto text-center text-white">
            <div class="mb-8">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Start Your Free Trial Today
                </h2>
                <p class="text-xl text-purple-100 mb-8">
                    Experience our powerful outreach system with no commitment
                </p>
            </div>

            <!-- Trial Plan Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 mb-8 max-w-md mx-auto">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex justify-center items-center">
                        <span class="text-white text-3xl">🚀</span>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-2">{{ $trialPlan->name }}</h3>
                <div class="text-4xl font-bold mb-4">
                    ${{ number_format($trialPlan->price) }}
                    <span class="text-lg font-normal">/ {{ $trialPlan->duration }} days</span>
                </div>

                <div class="text-sm text-purple-100 mb-6">
                    {{ $trialPlan->mail_available }} Mail Credits
                </div>

                @if($trialPlan->features && $trialPlan->features->count() > 0)
                <ul class="text-left space-y-2 mb-8 text-purple-100">
                    @foreach($trialPlan->features->where('is_active', true) as $feature)
                    <li class="flex items-center">
                        <span class="text-green-400 mr-2">✓</span>
                        {{ $feature->feature }}
                    </li>
                    @endforeach
                </ul>
                @endif

                <!-- Trial Buttons -->
                <div class="space-y-3">
                    @auth
                    <form method="POST" action="{{ route('checkout') }}" class="w-full">
                        @csrf
                        <input type="hidden" name="plan" value="{{ config('paypal.trial_plan_id') }}">
                        <button type="submit" class="w-full bg-white text-purple-600 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition-all duration-300">
                            Start Your Free Trial
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('start.trial') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full bg-white text-purple-600 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition-all duration-300">
                            Start Your Free Trial
                        </button>
                    </form>
                    @endauth

                    <p class="text-sm text-purple-200">
                        No credit card required • Cancel anytime
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif


<section class="bg-darkPrimary min-h-[250px] flex justify-center items-center lg:py-16 py-12 px-6 ">
    <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between text-white">
        <!-- Left Section: Text -->
        <div class="mb-6 lg:mb-0 text-center md:text-left">
            <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-bold leading-tight">
                Outreach and Backlink Building Faster <br>
                <span class="text-secondary">with Automated Outreach System</span>.
            </h2>
        </div>

        <!-- Right Section: Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('contact') }}" class="btn-secondary">
                Get Custom Plans
            </a>
            <a href="{{ route('about') }}" class="btn-primary">
                About Us
            </a>
        </div>
    </div>
</section>


<!-- about us  -->
<section class="lg:py-16 py-12 px-6">
    <div class="container mx-auto ">
        <div class="flex flex-col lg:flex-row">

            <!-- Left Section - Images -->
            <div class="w-full lg:w-1/2 p-8 smxl:block hidden">
                <div class="block-contaning-wrapper relative w-full lg:h-full h-[390px] max-w-[600px] mx-auto">
                    <div class="rounded-[15px] bg-gray-500 overflow-hidden w-[45%] lg:h-[36%] h-[53%] absolute bottom-[46%] left-0">
                        <img class="w-full h-full object-cover" src="{{asset('images/digital-marketing-planning.jpg')}}" alt="">
                        {{-- <img class="w-full h-full object-cover" src="{{asset('images/digital-marketing-planning.jpg')}}" alt=""> --}}
                    </div>
                    <div class="rounded-[15px] bg-gray-500 overflow-hidden w-[45%] lg:h-[36%] h-[53%] absolute bottom-[40%] right-0">
                        <img class="w-full h-full object-cover" src="{{asset('images/link-building-planning.jpg')}}" alt="">
                    </div>
                    <div class="rounded-[15px] bg-gray-500 overflow-hidden w-[70%] lg:h-[50%] h-[64%] absolute bottom-0 left-[16%] border-white border-[4px]">
                        <img class="w-full h-full object-cover" src="{{asset('images/outreach-planning.jpg')}}" alt="">
                    </div>

                </div>
            </div>

            <!-- Right Section - Content -->
            <div class="w-full lg:w-1/2 px-0 lg:px-16 flex flex-col justify-center space-y-8 ">
                <div class="lg:text-left text-center">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit">
                        <span class="w-2 h-2 bg-primary rounded-full"></span>
                        Business Growth
                        <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
                    </div>

                    <!-- Title -->
                    <h2 class="mt-3 text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-bold text-gray-900 leading-tight">
                        Smart Backlink Solutions <br /> Powered by AI
                    </h2>
                </div>

                <!-- Description -->
                <p class="text-gray-600   text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl lg:text-left text-center">
                    Get data-driven backlinks with our outreach automation & guest posting marketplace. Boost your site’s rankings and authority with smarter link-building solutions, automated outreach, & strategic workflow management.
                </p>

                <!-- Progress Bars -->
                <div class="space-y-3">
                    <!-- Business Security -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg font-semibold text-gray-700">Business Security</span>
                            <span class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg font-semibold text-indigo-600">65%</span>
                        </div>
                        <div class="w-full bg-white rounded-full h-4 p-[4px] border-gray-300 border-[1px]">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-full rounded-full transition-all duration-700" style="width: 49%"></div>
                        </div>
                    </div>

                    <!-- Career Development -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg font-semibold text-gray-700">Career Development</span>
                            <span class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg font-semibold text-indigo-600">88%</span>
                        </div>
                        <div class="w-full bg-white rounded-full h-4 p-[4px] border-gray-300 border-[1px]">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-full rounded-full transition-all duration-700" style="width: 88%"></div>
                        </div>
                    </div>

                    <!-- Business Innovation -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg font-semibold text-gray-700">Business Innovation</span>
                            <span class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg font-semibold text-indigo-600">90%</span>
                        </div>
                        <div class="w-full bg-white rounded-full h-4 p-[4px] border-gray-300 border-[1px]">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-full rounded-full transition-all duration-700" style="width: 67%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- contact us  -->
<!-- TITLE -->
<section class="lg:py-16 py-12 px-6">
    <div class="container mx-auto">
        <h2 class="text-4xl font-bold text-center">Contact Us</h2>
        <p class="text-gray-500 text-center mt-2 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">
            Any question or remarks? Just write us a message!
        </p>

        <!-- MAIN WRAPPER -->
        <div class="max-w-6xl mx-auto mt-10 bg-white shadow-[3px_1px_22px_#0000003d] rounded-xl   flex flex-col lg:flex-row p-3">

            <!-- LEFT SECTION -->
            <div class="bg-gradient-to-br from-black to-primary text-white rounded-xl p-8 w-full lg:w-1/3 relative overflow-hidden flex flex-col justify-between">
                <div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg font-semibold">Contact Information</h3>
                    <p class="text-gray-300 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg mt-2">Say something to start a live chat!</p>
                </div>

                <!-- CONTACT DETAILS -->
                <div class="mt-8 space-y-6">
                    <div class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg flex items-center gap-3">
                        <span class="">📞</span>
                        <p class="flex flex-col smx:w-auto w-full gap-[5px] lg:items-center items-start">

                            <a href="tel:+916290101838" class="">
                                +91 629 010 1838
                            </a>
                            <a href="tel:+913325849017" class="">
                                +91 332 584 9017
                            </a>
                        </p>
                    </div>

                    <div class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg flex items-center gap-3">
                        <span class="">✉️</span>
                        <a href="mailto:info@leelija.com" class="">
                            info@leelija.com
                        </a>
                    </div>

                    <div class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg flex items-start gap-3">
                        <span class=" mt-1">📍</span>
                        <p>
                            Taki Road, Bamunmura, Barasat, <br />
                            Kolkata - 700125, West Bengal, India
                        </p>
                    </div>
                </div>

                <!-- SOCIAL ICONS -->
                <div class="flex gap-4 mt-10 items-center">
                    <a href="#" class="min-w-12 w-12 min-h-12 h-12 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20">🌐</a>
                    <a href="#" class="min-w-12 w-12 min-h-12 h-12 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20">📸</a>
                    <a href="#" class="min-w-12 w-12 min-h-12 h-12 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20">💬</a>
                </div>

                <!-- DECOR CIRCLE -->
                <div class="absolute bottom-0 right-0 translate-y-1/3 translate-x-1/3 opacity-20">
                    <div class="w-20 h-20 bg-[#ffffff87] rounded-full absolute top-[-21px] left-[-26px]"></div>
                    <div class="w-40 h-40 bg-gray-600 rounded-full"></div>
                </div>
            </div>

            <!-- RIGHT FORM -->
            <div class="w-full lg:w-2/3 lg:p-6 p-4">
                <form id="contact-us" method="POST" action="{{ route('contact.store') }}" class="space-y-6" novalidate>

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

                    <!-- NAME ROW -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700">Full Name</label>
                            <input type="text" id="full_name" name="name" value="{{ old('name') }}" placeholder="John Doe" required
                                class="mt-1 w-full border-t-0 border-l-0 border-r-0 @error('name') border-red-500 @else border-gray-300 @enderror form-input-cus outline-none py-2 transition" />
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required
                                class="mt-1 w-full border-t-0 border-l-0 border-r-0 @error('email') border-red-500 @else border-gray-300 @enderror form-input-cus outline-none py-2 transition" />
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- SUBJECT -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select id="subject" required
                            class="w-full px-4 py-3 text-[#625e5e] border @error('subject') border-red-500 @else border-t-0 border-l-0 border-r-0 border-gray-300 @enderror transition"
                            style="box-shadow: none !important;" name="subject">
                            <option value="">Select a subject</option>
                            <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="Support" {{ old('subject') == 'Support' ? 'selected' : '' }}>Support</option>
                            <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                        </select>
                        @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- MESSAGE -->
                    <div>
                        <label class="block text-gray-700">Message</label>
                        <textarea id="message" placeholder="Write your message..." name="message" required
                            class="mt-1 w-full border-t-0 border-l-0 min-h-[150px] @error('message') border-red-500 @else border-r-0 border-gray-300 @enderror form-input-cus outline-none py-2 h-24 transition">{{ old('message') }}</textarea>
                        @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary mt-2 disabled:opacity-50 disabled:cursor-not-allowed" id="submit-btn">
                        <span id="btn-text">Send Message</span>
                        <span id="btn-loading" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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

<x-web.faq :faqs="$faqs" />
<script>
    // ================================================================
    // 1. FORCE ALL SLIDERS TO 0 ON PAGE LOAD (MOST IMPORTANT PART)
    // ================================================================
    // 1. FORCE SLIDERS TO INITIAL VALUES ON PAGE LOAD
    // ================================================================
    document.addEventListener('DOMContentLoaded', function() {
        const slidersToReset = ['da-min', 'da-max', 'dr-min', 'dr-max', 'tar-single'];

        slidersToReset.forEach(id => {
            const slider = document.getElementById(id);
            if (slider) {
                // DA & DR: min = 0, max = maximum
                if (id.includes('-min')) {
                    slider.value = slider.min || 0;
                } else if (id.includes('-max')) {
                    slider.value = slider.max || 100; // fallback to 100 if no max
                }
                // Traffic: always full (200k+)
                else if (id === 'tar-single') {
                    slider.value = slider.max || 200000;
                }

                // Trigger visual update
                slider.dispatchEvent(new Event('input'));
            }
        });

        // Now initialize everything
        initDualSlider('da-min', 'da-max', 'da-values', 'da-fill', 'da-min-tooltip', 'da-max-tooltip');
        initDualSlider('dr-min', 'dr-max', 'dr-values', 'dr-fill', 'dr-min-tooltip', 'dr-max-tooltip');
        initTrafficSlider();
    });

    // ================================================================
    // 2. DUAL RANGE SLIDER – Starts FULL (0 to max) → shows "Any"
    // ================================================================
    function initDualSlider(minId, maxId, displayId, fillId, minTooltipId, maxTooltipId) {
        const minThumb = document.getElementById(minId);
        const maxThumb = document.getElementById(maxId);
        const display = document.getElementById(displayId);
        const fill = document.getElementById(fillId);
        const minTip = document.getElementById(minTooltipId);
        const maxTip = document.getElementById(maxTooltipId);

        function update() {
            let minVal = parseInt(minThumb.value);
            let maxVal = parseInt(maxThumb.value);

            // Prevent crossing
            if (minVal > maxVal) {
                if (document.activeElement === minThumb) {
                    maxVal = minVal;
                    maxThumb.value = minVal;
                } else {
                    minVal = maxVal;
                    minThumb.value = minVal;
                }
            }

            const minAtStart = minVal <= parseInt(minThumb.min);
            const maxAtEnd = maxVal >= parseInt(maxThumb.max);

            if (minAtStart && maxAtEnd) {
                display.textContent = 'Any';
            } else if (minAtStart) {
                display.textContent = `≤ ${maxVal}`;
            } else if (maxAtEnd) {
                display.textContent = `≥ ${minVal}`;
            } else {
                display.textContent = `${minVal} – ${maxVal}`;
            }

            minTip.textContent = minVal;
            maxTip.textContent = maxVal;

            const range = parseInt(minThumb.max) - parseInt(minThumb.min);
            const minPercent = ((minVal - minThumb.min) / range) * 100;
            const maxPercent = ((maxVal - minThumb.min) / range) * 100;

            minTip.style.left = `${minPercent}%`;
            maxTip.style.left = `${maxPercent}%`;
            fill.style.left = `${minPercent}%`;
            fill.style.width = `${maxPercent - minPercent}%`;

            display.classList.remove('hidden');
        }

        minThumb.addEventListener('input', update);
        maxThumb.addEventListener('input', update);

        // Tooltip logic unchanged …
        minThumb.addEventListener('input', () => {
            minTip.classList.add('active');
            maxTip.classList.remove('active');
        });
        maxThumb.addEventListener('input', () => {
            maxTip.classList.add('active');
            minTip.classList.remove('active');
        });

        const hideTooltips = () => {
            minTip.classList.remove('active');
            maxTip.classList.remove('active');
        };

        ['mouseup', 'touchend', 'mouseleave'].forEach(ev => {
            minThumb.addEventListener(ev, hideTooltips);
            maxThumb.addEventListener(ev, hideTooltips);
        });

        update(); // Initial render → fill is full, shows "Any"
    }

    // ================================================================
    // 3. TRAFFIC SINGLE SLIDER – Starts at 200k+ (full)
    // ================================================================
    function initTrafficSlider() {
        const slider = document.getElementById('tar-single');
        const display = document.getElementById('tar-values');
        const tooltip = document.getElementById('tar-tooltip');
        const fill = document.getElementById('tar-fill');

        const format = (v) => {
            if (v === 0) return '0';
            if (v >= 200000) return '200k+';
            return Math.round(v / 1000) + 'k';
        };

        function update() {
            const val = parseInt(slider.value);
            const percent = (val / slider.max) * 100;
            const text = format(val);

            display.textContent = text;
            tooltip.textContent = text;
            tooltip.style.left = `${percent}%`;
            fill.style.width = `${percent}%`;
        }

        slider.addEventListener('input', () => {
            tooltip.classList.add('active');
            update();
        });

        const hide = () => tooltip.classList.remove('active');
        ['mouseup', 'touchend', 'mouseleave'].forEach(e => slider.addEventListener(e, hide));
        ['mousemove', 'touchmove'].forEach(e => slider.addEventListener(e, () => tooltip.classList.add('active')));

        update(); // Shows "200k+" and full bar on load
    }

    // ================================================================
    // 4. NICHE SEARCH & SELECT (unchanged + safe)
    // ================================================================
    const niches_data = @json($niches_data);
    const niches = niches_data.map(n => n.niche_name).filter(n => n && n.trim() !== "");

    const searchInput = document.getElementById('niche-search');
    const dropdown = document.getElementById('niche-dropdown');
    const nicheList = document.getElementById('niche-list');
    const selectedBox = document.getElementById('selected-niches');
    const hiddenInput = document.getElementById('niche-values');

    let selectedIndex = -1;
    let selectedValues = [];

    function renderSelected() {
        selectedBox.innerHTML = '';
        selectedValues.forEach(niche => {
            const tag = document.createElement('div');
            tag.className = "flex items-center gap-2 text-white bg-primary px-3 py-1 rounded-full text-sm";
            tag.innerHTML = `${niche} <span class="cursor-pointer px-1" onclick="removeNiche('${niche.replace(/'/g, "\\'")}')">×</span>`;
            selectedBox.appendChild(tag);
        });
        hiddenInput.value = selectedValues.join(",");
    }

    window.removeNiche = (niche) => {
        selectedValues = selectedValues.filter(item => item !== niche);
        renderSelected();
    };

    function selectNiche(niche) {
        if (!selectedValues.includes(niche)) {
            selectedValues.push(niche);
            renderSelected();
        }
        searchInput.value = "";
        closeDropdown();
    }

    function renderNiches(items) {
        nicheList.innerHTML = items.length === 0 ?
            '<li class="px-6 py-3 text-gray-500 italic">No niches found</li>' :
            '';

        items.forEach((niche, i) => {
            const li = document.createElement('li');
            li.className = `px-6 py-3 hover:bg-primary/10 cursor-pointer transition-colors ${i === selectedIndex ? 'bg-primary/10 text-primary font-medium' : 'text-gray-700'}`;
            li.textContent = niche;
            li.addEventListener('click', () => selectNiche(niche));
            nicheList.appendChild(li);
        });
    }

    function filterNiches(q) {
        return q.trim() ? niches.filter(n => n.toLowerCase().includes(q.toLowerCase())) : niches;
    }

    function openDropdown() {
        dropdown.classList.remove('hidden');
        renderNiches(filterNiches(searchInput.value));
    }

    function closeDropdown() {
        dropdown.classList.add('hidden');
        selectedIndex = -1;
    }

    searchInput.addEventListener('input', () => {
        const filtered = filterNiches(searchInput.value);
        renderNiches(filtered);
        filtered.length ? openDropdown() : closeDropdown();
    });

    searchInput.addEventListener('focus', () => {
        renderNiches(niches);
        openDropdown();
    });

    document.addEventListener('click', e => {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) closeDropdown();
    });

    searchInput.addEventListener('keydown', e => {
        const items = nicheList.querySelectorAll('li');
        if (!items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = (selectedIndex + 1) % items.length;
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = selectedIndex <= 0 ? items.length - 1 : selectedIndex - 1;
        } else if (e.key === 'Enter' && selectedIndex >= 0) {
            e.preventDefault();
            selectNiche(items[selectedIndex].textContent);
        }

        items.forEach((el, i) => {
            el.classList.toggle('bg-primary/10', i === selectedIndex);
            el.classList.toggle('text-primary', i === selectedIndex);
            el.classList.toggle('font-medium', i === selectedIndex);
        });

        items[selectedIndex]?.scrollIntoView({
            block: 'nearest'
        });
    });

    // ================================================================
    // 5. FORM SUBMIT – Sync all values
    // ================================================================
    document.getElementById('searchForm')?.addEventListener('submit', function() {
        // DA
        document.getElementById('da-min-input').value = document.getElementById('da-min').value;
        document.getElementById('da-max-input').value = document.getElementById('da-max').value;

        // DR
        document.getElementById('dr-min-input').value = document.getElementById('dr-min').value;
        document.getElementById('dr-max-input').value = document.getElementById('dr-max').value;

        // Traffic
        const trafficVal = document.getElementById('tar-single').value;
        document.getElementById('traffic-min-input').value = 0;
        document.getElementById('traffic-max-input').value = trafficVal >= 200000 ? 999999 : trafficVal;
    });
</script>


@endsection
@section('scripts')


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('see-pricing');
        const target = document.getElementById('pricing');

        if (!btn || !target) return;

        btn.addEventListener('click', function() {
            const nav = document.querySelector('nav');
            const navHeight = nav ? nav.offsetHeight : 0;

            const offset = target.getBoundingClientRect().top +
                window.pageYOffset -
                navHeight;

            window.scrollTo({
                top: offset,
                behavior: 'smooth'
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const pricingSection = document.getElementById('pricing');

        // If URL contains #pricing and we are on home page -> auto scroll
        if (pricingSection && window.location.hash === '#pricing') {
            setTimeout(() => {
                const nav = document.querySelector('nav');
                const navHeight = nav ? nav.offsetHeight : 0;

                const offset = pricingSection.getBoundingClientRect().top +
                    window.pageYOffset -
                    navHeight;

                window.scrollTo({
                    top: offset,
                    behavior: 'smooth'
                });
            }, 200);

            // Remove hash so URL stays clean
            history.replaceState(null, null, ' ');
        }

        // When clicking Pricing while already on Home page
        const navPricing = document.getElementById('nav-pricing');
        if (navPricing && pricingSection) {
            navPricing.addEventListener('click', function(e) {
                e.preventDefault();
                const nav = document.querySelector('nav');
                const navHeight = nav ? nav.offsetHeight : 0;

                const offset = pricingSection.getBoundingClientRect().top +
                    window.pageYOffset -
                    navHeight;

                window.scrollTo({
                    top: offset,
                    behavior: 'smooth'
                });

                history.replaceState(null, null, ' ');
            });
        }
    });
</script>







@endsection