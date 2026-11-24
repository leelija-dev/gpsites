<!-- Footer Section -->
@php
  $footerSocial = array_filter(config('gpsites.social', []));
  $footerSocialIcons = [
    'linkedin' => ['fa-linkedin-in', 'LinkedIn'],
    'x' => ['fa-x-twitter', 'X (Twitter)'],
    'facebook' => ['fa-facebook-f', 'Facebook'],
    'instagram' => ['fa-instagram', 'Instagram'],
    'youtube' => ['fa-youtube', 'YouTube'],
  ];
  // Read all columns: the live blogs table may not have every column listed in the
  // migrations (e.g. feature_image_alt), and naming a missing column made this query fail.
  $footerPosts = \Illuminate\Support\Facades\Cache::remember('footer_latest_posts_v2', 3600, function () {
    try {
      return \App\Models\Blogs::where('status', true)
        ->latest()
        ->limit(3)
        ->get();
    } catch (\Throwable $e) {
      \Illuminate\Support\Facades\Log::warning('Footer latest posts query failed: ' . $e->getMessage());
      return collect();
    }
  });
  $footerEmail = config('gpsites.contact_email');
@endphp
<footer class="bg-darkPrimary py-12  border-t border-gray-800 text-white pb-[5rem] md:px-0 px-4">
  <div class="container mx-auto grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-8">

    <!-- Company Info -->
    <div>
      <div class="flex items-center mb-4">
        <img class="w-[150px]" src="{{ asset('images/site-img/logo.png') }}" alt="{{ config('gpsites.brand') }}" width="150" height="42" loading="lazy">
      </div>
      <p class="text-sm md:text-md lg:text-[1rem] leading-relaxed text-white mb-6">
        GPSites helps agencies and businesses discover publishers, send outreach offers and manage orders through one link building tool. Find opportunities for guest posts, link insertions and press releases across a growing publisher network.
      </p>
      @if (count($footerSocial))
      <div class="flex space-x-3">
        @foreach ($footerSocial as $network => $url)
          @isset($footerSocialIcons[$network])
          <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="GPSites on {{ $footerSocialIcons[$network][1] }}" class="lg:w-12 lg:h-12 w-10 h-10  bg-gray-800 rounded-full flex items-center justify-center hover:bg-purple-600 transition">
            <i class="fa-brands {{ $footerSocialIcons[$network][0] }} text-md" aria-hidden="true"></i>
          </a>
          @endisset
        @endforeach
      </div>
      @endif
    </div>

    <!-- Address & Contact -->
    <div>
      <h2 class="xl:text-2xl sm:text-xl mb-4 text-lg font-semibold  text-white ">Contact</h2>
      <ul class="space-y-3 text-sm md:text-md lg:text-[1rem] leading-relaxed text-white">
        <li class="flex items-center">
          <i class="fa-solid fa-location-dot  text-secondary  mr-2" aria-hidden="true"></i>
          <p>Taki Road, Bamunmura, Barasat, <br>
            Kolkata - 700125, West Bengal, India</p>
        </li>
        <li class="flex items-center">
          <i class="fa-solid fa-phone  text-secondary  mr-2" aria-hidden="true"></i>

          <p class="flex flex-col smx:w-auto w-full gap-[5px] lg:items-center items-start">
            @foreach (config('gpsites.phones') as $phone)
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="hover:text-purple-400 transition-all duration-300 ease-in-out inline-block">
              {{ $phone }}
            </a>
            @endforeach
          </p>
        </li>
        <li class="flex items-center">
          <i class="fa-solid fa-envelope  text-secondary  mr-2" aria-hidden="true"></i>
          <a href="mailto:{{ $footerEmail }}" class="hover:text-purple-400 transition-all duration-300 ease-in-out inline-block">
            {{ $footerEmail }}
          </a>
        </li>
        <li class="flex items-center">
          <i class="fa-solid fa-clock  text-secondary  mr-2 " aria-hidden="true"></i>
          <p>Office: {{ config('gpsites.office_hours') }} (IST)</p>
        </li>
      </ul>
    </div>

    <!-- Explore GPSites -->
    <div>
      <h2 class="xl:text-2xl sm:text-xl mb-4 text-lg font-semibold  text-white ">Explore GPSites</h2>
      <ul class="space-y-2 text-sm md:text-md lg:text-[1rem] leading-relaxed text-white">
        @foreach ([
          ['How it works', url('/#how-it-works')],
          ['Features', url('/#features')],
          ['Pricing', route('pricing')],
          ['Free trial', route('start-trial.page')],
          ['FAQs', url('/#faq')],
          ['Blog', route('all-blogs.index')],
          ['About us', route('about')],
          ['Contact us', route('contact')],
        ] as [$label, $href])
        <li class="flex items-center  ">
          <i class="fa-solid fa-angle-right  text-secondary  text-xs mr-2" aria-hidden="true"></i>
          <a href="{{ $href }}" class="inline-block hover:text-purple-400 transition-all duration-300 ease-in-out">{{ $label }}</a>
        </li>
        @endforeach
      </ul>
    </div>

    <!-- Latest Posts -->
    <div>
      <h2 class="xl:text-2xl sm:text-xl mb-4 text-lg font-semibold  text-white ">Latest Posts</h2>
      <div class="space-y-4">
        @forelse ($footerPosts as $post)
        <div class="flex items-center space-x-3">
          <div class="min-w-[100px]  min-h-[65px] w-[100px]  h-[65px] overflow-hidden rounded-[10px]">
            <img src="{{ $post->feature_image ? asset('blog_images/' . $post->feature_image) : asset('images/bg-8.webp') }}"
              alt="{{ $post->feature_image_alt ?: $post->title }}" class="w-full h-full  object-cover"
              width="100" height="65" loading="lazy" decoding="async" />
          </div>
          <div>
            <p class="text-xs text-gray-300">{{ optional($post->created_at)->format('M d, Y') }}</p>
            <a href="{{ route('blog.show', $post->slug) }}" class="text-sm md:text-md lg:text-[1rem] leading-relaxed font-medium hover:text-purple-400 transition line-clamp-2">
              {{ $post->title }}
            </a>
          </div>
        </div>
        @empty
        <p class="text-sm text-gray-300"><a href="{{ route('all-blogs.index') }}" class="hover:text-purple-400">Read the GPSites blog →</a></p>
        @endforelse
      </div>
    </div>
  </div>
  <hr class="mt-8 mb-3 border-[1px] border-[#f2f2f238]">

  <!-- Newsletter Section -->
  <div class="container mx-auto   py-8">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 ">
      <div class="flex items-center">
        <div class="lg:w-16 lg:min-w-16 lg:h-16 lg:min-h-16 min-w-12 w-12 min-h-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
          <i class="fa-solid fa-bell text-white lg:text-3xl text-xl" aria-hidden="true"></i>
        </div>
        <div>
          <h2 class="lg:text-h4-lgg sm:text-h4-md text-h4-sm font-bold mb-2">Get practical outreach tips</h2>
          <p class="lg:text-p-lgg sm:text-p-md text-p-sm text-gray-300">Receive GPSites updates and guidance on publisher research, outreach and campaign management.</p>
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
        data-gtm-event="newsletter_signup"
        class="flex items-center smx:flex-row flex-col bg-white smx:rounded-full rounded-[10px] shadow-lg overflow-hidden smx:pe-2 smx:p-0 p-4">
        @csrf
        <input type="hidden" name="source" value="footer">
        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">

        <input
          type="email"
          name="email"
          value="{{ old('email', request()->routeIs('newsletter.subscribe') ? old('email') : '') }}"
          placeholder="Your email address"
          aria-label="Your email address"
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
    <p>Copyright © {{ date('Y') }} <a href="{{ route('home') }}" class="hover:text-secondary transition-all duration-300 ease-in-out">{{ config('gpsites.brand') }}</a>, a {{ config('gpsites.parent_company') }} company. All Rights Reserved.</p>
    <div class="flex justify-center items-center sm:flex-row flex-col gap-4 mt-2">
      <a href="{{route('privacy-policy')}}" class="hover:text-secondary transition-all duration-300 ease-in-out">Privacy policy</a>
      <a href="{{route('terms-of-service')}}" class="hover:text-secondary transition-all duration-300 ease-in-out">Terms of use</a>
      <a href="{{ url('/sitemap.xml') }}" class="hover:text-secondary transition-all duration-300 ease-in-out">Site map</a>
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