@extends('layouts.web.main-layout')

@section('title', 'home-page')

@section('content')
<section class="lg:py-16 py-12 px-6">
    <div class="container mx-auto  grid grid-cols-1 lg:grid-cols-2 gap-12 items-center lg:text-left text-center">

        <!-- LEFT IMAGE -->
        <div class="lg:block hidden relative overflow-hidden rounded-xl shadow-md ">
            <div class="absolute top-[-185px] right-[-94px] w-[300px] h-[260px] rounded-full bg-gradient-to-t from-primary to-secondary"></div>

            <img src="{{asset('images/bg-8.webp')}}" class="h-full w-full object-cover" alt="">
        </div>

        <!-- RIGHT CONTENT -->
        <div>
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit  mb-4">
                <span class="w-2 h-2 bg-primary rounded-full"></span>
                About Us
                <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
            </div>

            <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
         font-bold text-gray-900 leading-snug mb-4">
                We are a best IT  solution provider
            </h2>

            <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl text-gray-600 mb-6">
                Since 2010 our company has been providing leading custom
                IT services to companies all over the world outsourced.
            </p>

            <!-- TABS -->
            <div class="flex gap-8 font-semibold text-gray-800 mb-4 lg:justify-start justify-center">
                <button class="tab-btn smx:text-[1.4rem] text-[1rem]   border-b-2 border-primary hover:text-secondary  transition-colors duration-300 ease-in-out" data-tab="mission">
                    Our Mission
                </button>
                <button class="tab-btn smx:text-[1.4rem] text-[1rem]   hover:text-secondary transition-colors duration-300 ease-in-out" data-tab="vision">
                    Our Vision
                </button>
                <button class="tab-btn smx:text-[1.4rem] text-[1rem]   hover:text-secondary transition-colors duration-300 ease-in-out" data-tab="history">
                    History
                </button>
            </div>

            <!-- TAB CONTENTS -->
            <p id="mission" class="tab-content text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl text-gray-600">
                At New Media Services, we aim to conquer the impossible.
                We pledge a commitment to teamwork between our staff and valued clients
                to ensure the growth and success of everyone.
            </p>

            <p id="vision" class="tab-content text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl text-gray-600 hidden">
                Our vision is to innovate cutting-edge technology solutions that empower
                businesses and create a digital future driven by excellence.
            </p>

            <p id="history" class="tab-content text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl text-gray-600 hidden">
                Since 2010, we have expanded globally, delivering IT excellence and
                building strong partnerships across multiple industries worldwide.
            </p>

            <!-- BUTTON -->
            <button class="btn-primary mt-8">
                Learn more
            </button>
        </div>
    </div>
</section>

<section class="bg-[#f5f7fb] lg:py-16 py-12 px-6">
    <div class="container mx-auto  text-center">

        <!-- Top Text -->
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit  mb-4">
            <span class="w-2 h-2 bg-primary rounded-full"></span>
            Our Numbers
            <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
        </div>

        <h2 class="ttext-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
 font-bold text-gray-900 mt-2 mb-12">
            Our success rate is <br> shown by numbers
        </h2>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

            <!-- Box 1 -->
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-4xl font-bold text-gray-900">12</h3>
                <p class="text-gray-600 mt-2">Year <br> of establishment</p>
            </div>

            <!-- Box 2 -->
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-4xl font-bold text-gray-900">75K</h3>
                <p class="text-gray-600 mt-2">Of customers <br> worldwide</p>
            </div>

            <!-- Box 3 -->
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-4xl font-bold text-gray-900">63K</h3>
                <p class="text-gray-600 mt-2">Countries with <br> active client base</p>
            </div>

            <!-- Box 4 -->
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-4xl font-bold text-gray-900">4.8</h3>
                <p class="text-gray-600 mt-2">Success rate of the <br> company this year</p>
            </div>

        </div>

    </div>
</section>


<section class="lg:py-16 py-12 px-6">
    <div class="container mx-auto  grid grid-cols-1 lg:grid-cols-2 gap-12">

        <!-- LEFT CONTENT -->
        <div class="lg:text-left text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit  mb-4">
                <span class="w-2 h-2 bg-primary rounded-full"></span>
                Our Skills
                <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
            </div>

            <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
 font-bold text-gray-900 mb-4">
                The world's best IT-solutions company
            </h2>

            <p class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl text-gray-600 mb-8">
                For efficient, knowledgeable IT support that addresses all of your
                business technology needs, from our professionals. We do things
                differently at reliable technology services.
            </p>

            <a href="/contact"><button class="btn-primary">
                Contact Us
            </button></a>
        </div>

        <!-- RIGHT PROGRESS BARS -->
        <div class="flex flex-col gap-10 justify-center">

            <!-- Software Development -->
            <div>
                <div class="flex justify-between text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg  text-gray-700 font-semibold mb-2">
                    <span>Software Development</span>
                    <span>90%</span>
                </div>
                <div class="w-full h-3 bg-gray-200 rounded-full">
                    <div class="h-3 bg-secondary rounded-full w-[90%]" ></div>
                </div>
            </div>

            <!-- Digital Marketing -->
            <div>
                <div class="flex justify-between text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg  text-gray-700 font-semibold mb-2">
                    <span>Digital Marketing</span>
                    <span>95%</span>
                </div>
                <div class="w-full h-3 bg-gray-200 rounded-full">
                    <div class="h-3 bg-secondary rounded-full w-[95%]" ></div>
                </div>
            </div>

            <!-- Web Design -->
            <div>
                <div class="flex justify-between text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg  text-gray-700 font-semibold mb-2">
                    <span>Web Design</span>
                    <span>86%</span>
                </div>
                <div class="w-full h-3 bg-gray-200 rounded-full">
                    <div class="h-3 bg-secondary rounded-full w-[86%]" ></div>
                </div>
            </div>

        </div>

    </div>
</section>


<section class="bg-[#f5f7fb] lg:py-16 py-12 px-6">
    <div class="container mx-auto px-6 text-center">

        <!-- Heading -->
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit  mb-4">
            <span class="w-2 h-2 bg-primary rounded-full"></span>
            Our Creatinve Team
            <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
        </div>

        <h2 class="text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
          font-bold text-gray-900 mt-2 mb-16 leading-tight">
            Meet our IT professional <br> team members
        </h2>

        <!-- Team Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">

            <!-- Card 1 (Highlighted) -->
            <div class="relative bg-transparent drop-shadow-[2px_2px_17px_#cecece]">
                <div class="overflow-auto rounded-xl shadow-md">
                    <img src="{{asset('images/bg-8.webp')}}" class="w-full rounded-xl" alt="team">
                </div>

                <div class=" mx-auto w-11/12 bg-white  p-5 rounded-xl relative mt-[-48px]">
                    <h3 class="text-lg font-bold text-gray-900">Kristin Watsons</h3>
                    <p class="text-sm text-gray-600">SEO Executive</p>

                    <!-- <div class="flex gap-4 mt-4 justify-center text-white text-xl">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div> -->
                </div>
            </div>
            <!-- Card 1 (Highlighted) -->
            <div class="relative bg-transparent drop-shadow-[2px_2px_17px_#cecece]">
                <div class="overflow-auto rounded-xl shadow-md">
                    <img src="{{asset('images/bg-8.webp')}}" class="w-full rounded-xl" alt="team">
                </div>

                <div class=" mx-auto w-11/12 bg-white  p-5 rounded-xl relative mt-[-48px]">
                    <h3 class="text-lg font-bold text-gray-900">Kristin Watsons</h3>
                    <p class="text-sm text-gray-600">SEO Executive</p>

                    <!-- <div class="flex gap-4 mt-4 justify-center text-white text-xl">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div> -->
                </div>
            </div>
            <!-- Card 1 (Highlighted) -->
            <div class="relative bg-transparent drop-shadow-[2px_2px_17px_#cecece]">
                <div class="overflow-auto rounded-xl shadow-md">
                    <img src="{{asset('images/bg-8.webp')}}" class="w-full rounded-xl" alt="team">
                </div>

                <div class=" mx-auto w-11/12 bg-white  p-5 rounded-xl relative mt-[-48px]">
                    <h3 class="text-lg font-bold text-gray-900">Kristin Watsons</h3>
                    <p class="text-sm text-gray-600">SEO Executive</p>

                    <!-- <div class="flex gap-4 mt-4 justify-center text-white text-xl">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div> -->
                </div>
            </div>
            <!-- Card 1 (Highlighted) -->
            <div class="relative bg-transparent drop-shadow-[2px_2px_17px_#cecece]">
                <div class="overflow-auto rounded-xl shadow-md">
                    <img src="{{asset('images/bg-8.webp')}}" class="w-full rounded-xl" alt="team">
                </div>

                <div class=" mx-auto w-11/12 bg-white  p-5 rounded-xl relative mt-[-48px]">
                    <h3 class="text-lg font-bold text-gray-900">Kristin Watsons</h3>
                    <p class="text-sm text-gray-600">SEO Executive</p>

                    <!-- <div class="flex gap-4 mt-4 justify-center text-white text-xl">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div> -->
                </div>
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
                class="smx:px-6 px-4  smx:py-4 py-2  w-full text-gray-700 placeholder-gray-500 focus:outline-none focus:shadow-none smx:border-0 border-[1px] border-[#aeaeae] smx:rounded-none rounded-full smx:mb-0  mb-2 text-lg"
                style="box-shadow: none !important;" required />

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
    <div class="container mx-auto ">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 bg-indigo-100 text-primary text-p-xs sm:text-p-sm md:text-p-md  font-semibold px-3 py-1 rounded-full w-fit  mb-4">
                <span class="w-2 h-2 bg-primary rounded-full"></span>
                Features
                <span class="w-2 h-2 bg-primary rounded-full ml-1"></span>
            </div>
            <h2 class=" text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl
           font-bold text-gray-900">
                Contains modern features<br />
                <span class="text-primary">for a better experience</span>
            </h2>
        </div>

        <div class=" mx-auto">


            <div class="flex flex-col lg:flex-row gap-5 items-center justify-center text-center">
                <div class="flex lg:flex-col smx:flex-row flex-col min-w-[250px] lg:gap-16 md:gap-6 smx:gap-4 gap-3 ">
                    <!-- Feature 1 -->
                    <div class="text-center ">
                        <div class="flex justify-center lg:justify-start">
                            <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Secure IT services</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Provide secure IT services limited have been used.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center ">
                        <div class="flex justify-center lg:justify-start">
                            <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Backup solutions</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Quickly backup and restore for information when issues.
                        </p>
                    </div>
                </div>

                <div class="w-full overflow-hidden rounded-[15px] lg:max-w-full max-w-[350px]">
                    <img class="object-cover w-full h-full" src="{{asset('images/bg-8.webp')}}" alt="">
                </div>

                <div class="flex lg:flex-col smx:flex-row flex-col min-w-[250px] lg:gap-16 md:gap-6 smx:gap-4 gap-3 ">
                    <!-- Feature 3 -->
                    <div class="text-center ">
                        <div class="flex justify-center lg:justify-start">
                            <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Fast communication</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Fast communication for best Internet service provider.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="text-center ">
                        <div class="flex justify-center lg:justify-start">
                            <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0114 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Modern technology</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Innovation of technology use computers and networks.
                        </p>
                    </div>
                </div>

            </div>



        </div>
    </div>
</section>




<script>
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {

            // Remove active state from all tabs
            tabBtns.forEach(b => b.classList.remove('border-primary', 'border-b-2'));
            tabContents.forEach(content => content.classList.add('hidden'));

            // Add active state to clicked tab
            btn.classList.add('border-primary', 'border-b-2');

            // Show target content
            const tab = btn.dataset.tab;
            document.getElementById(tab).classList.remove('hidden');
        });
    });
</script>



@endsection
@section('scripts')


@endsection