@extends('layouts.web.main-layout')

@section('title', 'home-page')

@section('content')
<style>
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        @apply h-5 w-5 rounded-full bg-white border-4 border-primary shadow-md pointer-events-auto cursor-pointer z-10;
    }

    input[type="range"]::-moz-range-thumb {
        @apply h-5 w-5 rounded-full bg-white border-4 border-primary shadow-md pointer-events-auto cursor-pointer;
    }

    .slider-thumb {
        z-index: 2;
    }

    .slider-thumb-right {
        z-index: 3;
    }

    /* Custom range thumbs */
.slider-thumb::-webkit-slider-thumb,
.slider-thumb-right::-webkit-slider-thumb {
    appearance: none;
    height: 18px;
    width: 18px;
    background: #6a36ff;   /* primary */
    border-radius: 50%;
    cursor: pointer;
    pointer-events: auto;
}

.slider-thumb::-moz-range-thumb,
.slider-thumb-right::-moz-range-thumb {
    height: 18px;
    width: 18px;
    background: #6a36ff;
    border-radius: 50%;
    cursor: pointer;
    pointer-events: auto;
}

/* To allow thumbs to be clickable */
input[type="range"] {
    pointer-events: auto !important;
}

</style>

<!-- hero section  -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background decorative circles -->
    <div class="w-full h-full absolute top-0 left-0 overflow-hidden z-[-1]">
        <div class="absolute w-[300px] h-[300px] border-secondary border-[40px] rounded-full opacity-[0.1] top-[10%] right-[29%] "></div>
        <div class="absolute bottom-10 right-10 w-24 h-24 rounded-full border-8 border-primary-light opacity-30"></div>
        <div class="absolute w-[600px] h-[600px] border-secondary border-[80px] rounded-full opacity-[0.1] bottom-[10%] left-0 transform translate-x-[-50%]"></div>
    </div>

    <div class="container mx-auto px-6 lg:px-12  flex items-center justify-center relative z-10">

        <!-- Left Section -->
        <div class=" lg:w-1/2 w-full space-y-8">
            <h1 class="text-h1-xs sm:text-h1-sm md:text-h1-md lg:text-h1-lg lgg:text-h1-lgg xl:text-h1-xl 2xl:text-h1-2xl font-bold text-gray-900 leading-tight">
                Don’t Miss<br />
                <span class="text-primary">Amazing Grocery</span><br />
                Deals & Offers
            </h1>

            <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl text-gray-600 ">
                We source and sell the very best beef, lamb and pork,<br />
                sourced with the greatest care from farmer.
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <button class="btn-primary">
                    See Pricing
                </button>
                <button class="btn-secondary">
                    Contact Us
                </button>
            </div>

            <!-- Stats -->
            <div class="flex flex-wrap gap-8 mt-12 text-center">
                <div>
                    <div class="text-4xl font-bold text-gray-900">10+</div>
                    <div class="text-sm text-gray-500">Years Experience</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">891</div>
                    <div class="text-sm text-gray-500">Cases Solved</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">263</div>
                    <div class="text-sm text-gray-500">Business Partners</div>
                </div>
            </div>
        </div>

        <!-- Right Section - Card -->
        <div class=" lg:w-1/2 w-full flex justify-center ">
            <div class="backdrop-blur-[9px]  bg-white/0  rounded-3xl shadow-2xl p-8 w-full max-w-[500px] border-t-0 border-b-0 border-l-[3px] border-r-[3px] border-primary">

                <!-- Search Bar -->
                <div class="relative mb-8">
                    <input
                        type="text"
                        placeholder="Search and Select Niche"
                        class="w-full backdrop-blur-[3px]  bg-white/0 shadow-[1px_4px_17px_#5e5d5d38]  pl-12 pr-4 py-3 rounded-full border border-secondary focus:outline-none focus:ring-2 focus:ring-primary text-gray-700" />
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Sliders -->
                <div class="space-y-10">
                    <!-- DA Slider -->
                    <div>
                        <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
                            <span>DA</span>
                            <span class="text-primary">15</span>
                            <span>90</span>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-0 h-2 bg-gray-200 rounded-full"></div>
                            <div class="absolute inset-0 h-2 bg-gradient-to-r from-primary to-primary-light rounded-full" style="width: 20%"></div>
                            <input type="range" min="15" max="90" value="25" class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none slider-thumb" />
                            <input type="range" min="15" max="90" value="90" class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none slider-thumb-right" />
                        </div>
                    </div>

                    <!-- DR Slider -->
                    <div>
                        <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
                            <span>DR</span>
                            <span class="text-primary">12</span>
                            <span>85</span>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-0 h-2 bg-gray-200 rounded-full"></div>
                            <div class="absolute inset-0 h-2 bg-gradient-to-r from-primary to-primary-light rounded-full" style="width: 75%"></div>
                            <input type="range" min="12" max="85" value="12" class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none slider-thumb" />
                            <input type="range" min="12" max="85" value="70" class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none slider-thumb-right" />
                        </div>
                    </div>

                    <!-- Traffic Slider -->
                    <div>
                        <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
                            <span>Traffic</span>
                            <span class="text-primary">10K</span>
                            <span>80K</span>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-0 h-2 bg-gray-200 rounded-full"></div>
                            <div class="absolute inset-0 h-2 bg-gradient-to-r from-primary to-primary-light rounded-full" style="width: 50%"></div>
                            <input type="range" min="10000" max="80000" value="10000" class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none slider-thumb" />
                            <input type="range" min="10000" max="80000" value="50000" class="absolute w-full h-2 bg-transparent appearance-none pointer-events-none slider-thumb-right" />
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <button class="mt-10 w-full bg-primary hover:bg-purple-800 text-white font-bold py-4 rounded-xl transition text-lg">
                    Find Now
                </button>
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
                <h2 class="text-3xl font-bold">7000+</h2>
                <p class=" mt-1 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">Success Stories and Cases</p>
            </div>

            <!-- Item 2 -->
            <div>
                <h2 class="text-3xl font-bold">50 +</h2>
                <p class=" mt-1 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">Years of Combined Experience</p>
            </div>

            <!-- Item 3 -->
            <div>
                <h2 class="text-3xl font-bold">5 Star</h2>
                <p class=" mt-1 text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">Star Customer Satisfaction</p>
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
                <h2 class="mt-2 text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
 font-bold text-gray-900">
                    SaaS Made Simple: Drive efficiency and boost performance
                </h2>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col items-start text-left hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg 
 font-semibold text-gray-900 mb-2">High Resolution</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        Introducing our revolutionary SaaS App, designed to unlock your business potential and propel you towards success.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col items-start text-left hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">High Resolution</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        Introducing our revolutionary SaaS App, designed to unlock your business potential and propel you towards success.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col items-start text-left hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">High Resolution</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        Introducing our revolutionary SaaS App, designed to unlock your business potential and propel you towards success.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col items-start text-left hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">High Resolution</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        Introducing our revolutionary SaaS App, designed to unlock your business potential and propel you towards success.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col items-start text-left hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">High Resolution</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        Introducing our revolutionary SaaS App, designed to unlock your business potential and propel you towards success.
                    </p>
                </div>
                <!-- High Resolution -->
                <div class="bg-[#eaeaea] feature-block-card rounded-xl p-6 flex flex-col items-start text-left hover:shadow-lg transition-all duration-300 ease-in-out">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary  rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-h4-xs sm:text-h4-sm md:text-h4-md lg:text-h4-lg  font-semibold text-gray-900 mb-2 ">High Resolution</h3>
                    <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg text-gray-600">
                        Introducing our revolutionary SaaS App, designed to unlock your business potential and propel you towards success.
                    </p>
                </div>


            </div>

            <!-- CTA Button -->
            <div class="text-center mt-12">
                <button class="btn-primary">
                    See All Features
                </button>
            </div>
        </div>
    </div>

</section>



<!-- pricing plan section  -->
<section class="lg:py-16 py-12 px-6">
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
                <div class="bg-{{ $isHighlighted ? 'gradient-to-br from-black to-primary text-white' : 'white' }} rounded-2xl {{ $isHighlighted ? 'shadow-xl' : 'shadow-md border border-gray-100' }} px-8 pb-8 pt-0 overflow-hidden hover:scale-[1.04] transition-all duration-300 ease-in-out">
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
                        <p class="text-4xl font-bold mt-2">${{ number_format($plan->price) }}<span class="text-base font-medium">/{{ $plan->duration }}</span></p>
                        <p class="{{ $isHighlighted ? 'text-purple-200' : 'text-gray-500' }} text-sm mb-4">Billed {{ $plan->duration === 'month' ? 'Monthly' : 'Annually' }}</p>
                        <span class="inline-block {{ $isHighlighted ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-700' }} text-xs px-3 py-1 rounded-full mb-6">
                            {{ $plan->description ?? 'All Features Included' }}
                        </span>
                    </div>

                    @if($plan->features && $plan->features->count() > 0)
                        <ul class="space-y-3 {{ $isHighlighted ? 'text-purple-100' : 'text-gray-600' }}">
                            @foreach($plan->features->where('is_active', true) as $feature)
                                <li>• {{ $feature->feature }}</li>
                            @endforeach
                        </ul>
                    @else
                        <ul class="space-y-3 {{ $isHighlighted ? 'text-purple-100' : 'text-gray-600' }}">
                            <li>• Feature 1</li>
                            <li>• Feature 2</li>
                            <li>• Feature 3</li>
                        </ul>
                    @endif

                    <div class="text-center my-10">
                        <a href="{{ route('checkout') }}?plan={{ $plan->id }}" class="btn-{{ $isHighlighted ? 'secondary' : 'primary' }} rounded-full w-full block">Get Started</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-darkPrimary min-h-[250px] flex justify-center items-center lg:py-16 py-12 px-6 ">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between text-white">
        <!-- Left Section: Text -->
        <div class="mb-6 md:mb-0 text-center md:text-left">
            <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
 font-bold leading-tight">
                Build Websites Rapidly With<br>
                <span class="text-secondary">Trendkit Interface Blocks</span>.
            </h2>
        </div>

        <!-- Right Section: Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <button class="btn-secondary">
                Check more
            </button>
            <button class="btn-primary">
                Get trendkit
            </button>
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
                        <img class="w-full h-full object-cover" src="{{asset('images/bg-8.webp')}}" alt="">
                    </div>
                    <div class="rounded-[15px] bg-gray-500 overflow-hidden w-[45%] lg:h-[36%] h-[53%] absolute bottom-[40%] right-0">
                        <img class="w-full h-full object-cover" src="{{asset('images/bg-8.webp')}}" alt="">
                    </div>
                    <div class="rounded-[15px] bg-gray-500 overflow-hidden w-[70%] lg:h-[50%] h-[64%] absolute bottom-0 left-[16%] border-white border-[4px]">
                        <img class="w-full h-full object-cover" src="{{asset('images/bg-8.webp')}}" alt="">
                    </div>

                </div>
            </div>

            <!-- Right Section - Content -->
            <div class="w-full lg:w-1/2 p-0 lg:p-16 flex flex-col justify-center space-y-8 ">
                <div>
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit">
                        <span class="w-2 h-2 bg-primary rounded-full"></span>
                        Business Growth
                        <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
                    </div>

                    <!-- Title -->
                    <h2 class="mt-3 text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
 font-bold text-gray-900 leading-tight">
                        Connecting People And<br />Build Technology
                    </h2>
                </div>

                <!-- Description -->
                <p class="text-gray-600   text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl">
                    Energetically evisculate an expanded array of meta-services after cross-media strategic theme areas.
                    Interactively simplify interactive customer service before fully tested relationship parallel task high standards.
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
                        <p>+1012 3456 789</p>
                    </div>

                    <div class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg flex items-center gap-3">
                        <span class="">✉️</span>
                        <p>demo@gmail.com</p>
                    </div>

                    <div class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg flex items-start gap-3">
                        <span class=" mt-1">📍</span>
                        <p>
                            132 Dartmouth Street Boston, <br />
                            Massachusetts 02156 United States
                        </p>
                    </div>
                </div>

                <!-- SOCIAL ICONS -->
                <div class="flex gap-4 mt-10 items-center">
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20">🌐</a>
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20">📸</a>
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20">💬</a>
                </div>

                <!-- DECOR CIRCLE -->
                <div class="absolute bottom-0 right-0 translate-y-1/3 translate-x-1/3 opacity-20">
                    <div class="w-20 h-20 bg-[#ffffff87] rounded-full absolute top-[-21px] left-[-26px]"></div>
                    <div class="w-40 h-40 bg-gray-600 rounded-full"></div>
                </div>
            </div>

            <!-- RIGHT FORM -->
            <div class="w-full lg:w-2/3 lg:p-6 p-4">
                <form class="space-y-6">

                    <!-- NAME ROW -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700">First Name</label>
                            <input type="text" placeholder="John"
                                class="mt-1 w-full border-t-0 border-l-0  border-r-0 border-gray-300 form-input-cus outline-none py-2" />
                        </div>

                        <div>
                            <label class="block text-gray-700">Last Name</label>
                            <input type="text" placeholder="Doe"
                                class="mt-1 w-full border-t-0 border-l-0  border-r-0 border-gray-300 form-input-cus outline-none py-2" />
                        </div>
                    </div>

                    <!-- EMAIL / PHONE -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700">Email</label>
                            <input type="email" placeholder="email@example.com"
                                class="mt-1 w-full border-t-0 border-l-0  border-r-0 border-gray-300 form-input-cus outline-none py-2" />
                        </div>

                        <div>
                            <label class="block text-gray-700">Phone Number</label>
                            <input type="text" placeholder="+1 012 3456 789"
                                class="mt-1 w-full border-t-0 border-l-0  border-r-0 border-gray-300 form-input-cus outline-none py-2" />
                        </div>
                    </div>

                    <!-- SUBJECT -->
                    <div>
                        <label class="block text-gray-700">Select Subject?</label>

                        <div class="flex flex-wrap gap-4 mt-2 text-gray-700">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="subject" checked class="accent-black" /> General Inquiry
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="subject" class="accent-black" /> General Inquiry
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="subject" class="accent-black" /> General Inquiry
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="subject" class="accent-black" /> General Inquiry
                            </label>
                        </div>
                    </div>

                    <!-- MESSAGE -->
                    <div>
                        <label class="block text-gray-700">Message</label>
                        <textarea placeholder="Write your message..."
                            class="mt-1 w-full border-t-0 border-l-0 min-h-[150px] border-r-0 border-gray-300 form-input-cus outline-none py-2 h-24"></textarea>
                    </div>

                    <!-- BUTTON -->
                    <button
                        class="btn-primary mt-2">
                        Send Message
                    </button>

                </form>
            </div>
        </div>
    </div>
</section>

<x-web.faq />

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const sliders = document.querySelectorAll(".slider-container");

    sliders.forEach(container => {
        const minSlider = container.querySelector(".slider-thumb");
        const maxSlider = container.querySelector(".slider-thumb-right");
        const fill = container.querySelector(".slider-fill");
        const minText = container.querySelector(".min-value");
        const maxText = container.querySelector(".max-value");

        function updateSlider() {
            let minVal = parseInt(minSlider.value);
            let maxVal = parseInt(maxSlider.value);

            if (minVal > maxVal) {
                // Swap values
                [minSlider.value, maxSlider.value] = [maxVal, minVal];
                minVal = parseInt(minSlider.value);
                maxVal = parseInt(maxSlider.value);
            }

            const minRange = minSlider.min;
            const maxRange = minSlider.max;

            const percent1 = ((minVal - minRange) / (maxRange - minRange)) * 100;
            const percent2 = ((maxVal - minRange) / (maxRange - minRange)) * 100;

            fill.style.left = percent1 + "%";
            fill.style.width = (percent2 - percent1) + "%";

            minText.textContent = minVal >= 1000 ? Math.round(minVal/1000)+"K" : minVal;
            maxText.textContent = maxVal >= 1000 ? Math.round(maxVal/1000)+"K" : maxVal;
        }

        minSlider.addEventListener("input", updateSlider);
        maxSlider.addEventListener("input", updateSlider);

        updateSlider(); // initialize
    });
});

</script>
@endsection
@section('scripts')


@endsection