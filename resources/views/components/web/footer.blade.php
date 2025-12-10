<!-- Footer Section -->
<footer class="bg-darkPrimary py-12  border-t border-gray-800 text-white pb-[5rem] md:px-0 px-4">
  <div class="container mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-8">

    <!-- Company Info -->
    <div>
      <div class="flex items-center mb-4">
        <img class="w-[150px]" src="{{ asset('images/site-img/logo.png') }}" alt="{{ config('app.name') }}">
      </div>
      <p class="text-sm md:text-md lg:text-[1rem] leading-relaxed text-white mb-6">
        Convert your quality prospects through GPsites’ automation & streamline your personalized outreach workflow. 
      </p>
      <div class="flex space-x-3">
        <a href="#" class="lg:w-12 lg:h-12 w-10 h-10  bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
          <i class="fa-brands fa-facebook-f text-md"></i>
        </a>
        <a href="#" class="lg:w-12 lg:h-12 w-10 h-10  bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
          <i class="fa-brands fa-x-twitter text-md"></i>
        </a>
        <a href="#" class="lg:w-12 lg:h-12 w-10 h-10  bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
          <i class="fa-brands fa-instagram text-md"></i>
        </a>
        <a href="#" class="lg:w-12 lg:h-12 w-10 h-10  bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
          <i class="fa-brands fa-linkedin-in text-md"></i>
        </a>
      </div>
    </div>

    <!-- Address & Contact -->
    <div>
      <h4 class="xl:text-2xl sm:text-xl mb-4 text-lg font-semibold  text-white ">Address Company</h4>
      <ul class="space-y-3 text-sm md:text-md lg:text-[1rem] leading-relaxed text-white">
        <li class="flex items-center">
          <i class="fa-solid fa-location-dot  text-secondary  mr-2"></i>
          <p>Taki Road, Bamunmura, Barasat, <br>
            Kolkata - 700125, West Bengal, India</p>
        </li>
        <li class="flex items-center">
          <i class="fa-solid fa-phone  text-secondary  mr-2"></i>

          <p class="flex flex-col smx:w-auto w-full gap-[5px] lg:items-center items-start">

            <a href="tel:+916290101838" class="hover:text-purple-400 transition-all duration-300 ease-in-out inline-block">
              +91 629 010 1838
            </a>
            <a href="tel:+913325849017" class="hover:text-purple-400 transition-all duration-300 ease-in-out inline-block">
              +91 332 584 9017
            </a>

          </p>
        </li>
        <li class="flex items-center">
          <i class="fa-solid fa-envelope  text-secondary  mr-2"></i>
          <a href="mailto:info@leelija.com" class="hover:text-purple-400 transition-all duration-300 ease-in-out inline-block">
            info@leelija.com
          </a>
        </li>
        <li class="flex items-center">
          <i class="fa-solid fa-clock  text-secondary  mr-2 "></i>
          <p class="hover:text-purple-400 transition-all duration-300 ease-in-out inline-block">Office : 10:00 AM - 6:30 PM</p>
        </li>
      </ul>
    </div>

    <!-- Our Services -->
    <div>
      <h4 class="xl:text-2xl sm:text-xl mb-4 text-lg font-semibold  text-white ">Our Services</h4>
      <ul class="space-y-2 text-sm md:text-md lg:text-[1rem] leading-relaxed text-white">
        <li class="flex items-center  ">
          <i class="fa-solid fa-angle-right  text-secondary  text-xs mr-2"></i>
          <a href="#" class="inline-block hover:text-purple-400 transition-all duration-300 ease-in-out"> Database Solution</a>
        </li>
        <li class="flex items-center  ">
          <i class="fa-solid fa-angle-right  text-secondary  text-xs mr-2"></i>
          <a href="#" class="inline-block hover:text-purple-400 transition-all duration-300 ease-in-out"> Data Protection</a>
        </li>
        <li class="flex items-center  ">
          <i class="fa-solid fa-angle-right  text-secondary  text-xs mr-2"></i>
          <a href="#" class="inline-block hover:text-purple-400 transition-all duration-300 ease-in-out"> App Development</a>
        </li>
        <li class="flex items-center  ">
          <i class="fa-solid fa-angle-right  text-secondary  text-xs mr-2"></i>
          <a href="#" class="inline-block hover:text-purple-400 transition-all duration-300 ease-in-out"> Machine Learning</a>
        </li>
        <li class="flex items-center  ">
          <i class="fa-solid fa-angle-right  text-secondary  text-xs mr-2"></i>
          <a href="#" class="inline-block hover:text-purple-400 transition-all duration-300 ease-in-out"> Helpdesk Services</a>
        </li>
      </ul>
    </div>

    <!-- Latest Posts -->
    <div>
      <h4 class="xl:text-2xl sm:text-xl mb-4 text-lg font-semibold  text-white ">Latest Posts</h4>
      <div class="space-y-4">
        <!-- Post 1 -->
        <div class="flex items-center space-x-3">
          <div class="min-w-[100px]  min-h-[65px] w-[100px]  h-[65px] overflow-hidden rounded-[10px]">
            <img src="{{asset('images/bg-8.webp')}}" alt="Post 1" class="w-full h-full  object-cover" />
          </div>
          <div>
            <p class="text-xs text-gray-500">15th Dec, 2025</p>
            <p class="text-sm md:text-md lg:text-[1rem] leading-relaxed font-medium hover:text-purple-400 transition cursor-pointer line-clamp-2">
              Why Your Business Needs Small Business Essentials
            </p>
            <a href="#" class="text-xs text-purple-400 hover:underline">Read More →</a>
          </div>
        </div>
        <!-- Post 2 -->
        <div class="flex items-center space-x-3">
          <div class="min-w-[100px]  min-h-[65px] w-[100px]  h-[65px] overflow-hidden rounded-[10px]">
            <img src="{{asset('images/bg-8.webp')}}" alt="Post 1" class="w-full h-full  object-cover" />
          </div>
          <div>
            <p class="text-xs text-gray-500">15th Dec, 2025</p>
            <p class="text-sm md:text-md lg:text-[1rem] leading-relaxed font-medium hover:text-purple-400 transition cursor-pointer line-clamp-2">
              Small Business Essentials
            </p>
            <a href="#" class="text-xs text-purple-400 hover:underline">Read More →</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr class="mt-8 mb-3 border-[1px] border-[#f2f2f238]">

  <!-- Newsletter Section -->
  <div class="container mx-auto   py-8">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 ">
      <div class="flex items-center">
        <div class="lg:w-16 lg:min-w-16 lg:h-16 lg:min-h-16 min-w-12 w-12 min-h-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
          <i class="fa-solid fa-bell text-white lg:text-3xl text-xl"></i>
        </div>
        <div>
          <h3 class="lg:text-h4-lgg sm:text-h4-md text-h4-sm font-bold mb-2">Sign Up To Our Newsletters.</h3>
          <p class="lg:text-p-lgg sm:text-p-md text-p-sm text-gray-400">Subscribe to our Newsletter & Event Right Now to be Updated</p>
        </div>
      </div>
      <!-- <form class="flex items-center smx:flex-row flex-col bg-white smx:rounded-full rounded-[10px] shadow-lg overflow-hidden  smx:pe-2 smx:p-0 p-4">
      
        <input
          type="email"
          placeholder="Enter Your Email"
          class="smx:px-6 px-4  smx:py-4 py-2  w-full text-gray-700 placeholder-gray-500 focus:outline-none focus:shadow-none smx:border-0 border-[1px] border-[#aeaeae] smx:rounded-none rounded-full smx:mb-0  mb-2 text-lg"
          style="box-shadow: none !important;" required />

        
        <button
          type="submit"
          class="btn-primary min-w-[180px] px-2 py-2 rounded-full">
          Subscribe Now
        </button>
      </form> -->

      <form 
        method="POST"
        action="{{ route('newsletter.subscribe') }}"
        id="footer-newsletter-form"
        class="flex items-center smx:flex-row flex-col bg-white smx:rounded-full rounded-[10px] shadow-lg overflow-hidden smx:pe-2 smx:p-0 p-4">
        @csrf
        <input type="hidden" name="source" value="footer">
        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">

        <input
          type="email"
          name="email"
          value="{{ old('email', request()->routeIs('newsletter.subscribe') ? old('email') : '') }}"
          placeholder="Enter Your Email"
          class="smx:px-6 px-4 smx:py-4 py-2 w-full text-gray-700 placeholder-gray-500 focus:outline-none focus:shadow-none smx:border-0 border-[1px] border-[#aeaeae] smx:rounded-none rounded-full smx:mb-0 mb-2 text-lg @error('email') border-red-500 @enderror"
          style="box-shadow: none !important;"
          required />

        <button
          type="submit"
          class="btn-primary min-w-[180px] px-2 py-2 rounded-full disabled:opacity-50 disabled:cursor-not-allowed">
          <span class="footer-newsletter-btn-text">Subscribe Now</span>
          <span class="footer-newsletter-btn-loading hidden">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Subscribing...
          </span>
        </button>
      </form>
    </div>
  </div>
  <hr class="my-3 border-[1px] border-[#f2f2f238]">

  <!-- Copyright -->
  <div class="container mx-auto  text-center text-lg text-white  pt-6 flex lg:flex-row lg:justify-between flex-col items-center gap-2  ">
    <p>Copyright © {{ date('Y') }} <a href="{{ route('home') }}" class="hover:text-secondary transition-all duration-300 ease-in-out">{{ config('app.name') }}</a> All Rights Reserved.</p>
    <div class="flex justify-center items-center sm:flex-row flex-col gap-4 mt-2">
      <a href="#" class="hover:text-secondary transition-all duration-300 ease-in-out">Privacy policy</a>
      <a href="#" class="hover:text-secondary transition-all duration-300 ease-in-out">Terms of use</a>
      <a href="#" class="hover:text-secondary transition-all duration-300 ease-in-out">Site map</a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('newsletter_success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session('newsletter_success') }}',
    // timer: 2000,
    // showConfirmButton: false
    confirmButtonText: 'OK',
    confirmButtonColor: '#F59E0B',
});
</script>
@endif

@if(session('newsletter_error'))
<script>
Swal.fire({
    icon: 'warning',
    title: 'Already Subscribed',
    text: '{{ session('newsletter_error') }}',
    //timer: 2500,
     confirmButtonText: 'OK',
     confirmButtonColor: '#F59E0B',
    //showConfirmButton: false
});
</script>
@endif

</footer>