@extends('layouts.web.main-layout')

@section('title', 'home-page')

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
                <form id="contact-us" class="space-y-6" novalidate>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="floating-label-group">

                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                placeholder=""
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                required />
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full name</label>
                        </div>

                        <!-- Phone Number -->
                        <div class="floating-label-group">

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                placeholder=""
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                                required />
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="floating-label-group">

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder=""
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                            required />
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select
                            id="subject"
                            name="subject"
                            class="w-full px-4 py-3 text-[#a8a8a8] border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                            required>
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="support">Support</option>
                            <option value="partnership">Partnership</option>
                            <option value="feedback">Feedback</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div class="floating-label-group">

                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            placeholder=""
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none"
                            required></textarea>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full btn-primary">
                        Send Message
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

        <!-- Input + Button -->
        <form class="max-w-2xl mx-auto flex items-center smx:flex-row flex-col bg-white smx:rounded-full rounded-[10px] shadow-lg overflow-hidden  smx:pe-2 smx:p-0 p-4">
            <!-- Email Input -->
            <input
                type="email"
                placeholder="Enter Your Email"
                class="smx:px-6 px-4  smx:py-4 py-2  w-full text-gray-700 placeholder-gray-500 focus:outline-none  smx:border-0 border-[1px] border-[#aeaeae] smx:rounded-none rounded-full smx:mb-0  mb-2 text-lg" style="box-shadow: none !important;"
                required />

            <!-- Subscribe Button -->
            <button
                type="submit"
                class="btn-primary min-w-[180px] px-2 py-2 rounded-full">
                Subscribe Now
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

<x-web.faq />


@endsection
@section('scripts')


@endsection