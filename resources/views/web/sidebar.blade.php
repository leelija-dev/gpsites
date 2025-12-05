{{-- <button  data-drawer-target="separator-sidebar" data-drawer-toggle="separator-sidebar" aria-controls="separator-sidebar" type="button" class="text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base ms-3 mt-3 text-sm p-2 focus:outline-none inline-flex sm:hidden">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10"/>
   </svg>
</button> --}}
@php
use Illuminate\Support\Facades\Auth;
$loggedUserId = Auth::id(); // or Auth::user()->id
@endphp


{{-- resources/views/layouts/sidebar.blade.php --}}
<style>
  

   /* Sidebar width */
   [data-state="expanded"] {
      width: 256px !important;
   }

   [data-state="collapsed"] {
      width: 80px !important;
   }

   /* Hide all text instantly when collapsed */
   [data-state="collapsed"] .hide-when-collapsed {
      display: none !important;
   }

   /* Center icons when collapsed */
   [data-state="collapsed"] .px-6 {
      @apply px-3;
   }

   [data-state="collapsed"] .gap-4,
   [data-state="collapsed"] .gap-3 {
      @apply gap-0 justify-center;
   }

   /* Beautiful tooltip on hover (only when collapsed) */
   @media (min-width: 992px) {
      [data-state="collapsed"] a {
         @apply relative;
      }

     



      /* Red tooltip for Logout */
      [data-state="collapsed"] a.bg-red-600:hover .hide-when-collapsed {
         @apply bg-red-700;
      }
   }

   @media screen and (max-width:991px) {
      #whole-heade-wrapper {
         width: 100% !important;
      }
      
   }

   /* Smooth transition */
   #sidebar {
      transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
   }
</style>

<aside id="sidebar"
   class=" lg:sticky fixed z-[51] top-0 left-0  h-screen bg-white shadow-2xl border-r border-gray-200
              lg:translate-x-0 -translate-x-full
              transition-all duration-300 ease-in-out"
   data-state="expanded" style="transition: 0.2s all ease-in-out !important;">
   <!-- Your existing sidebar content (unchanged) -->
   <div class="h-full flex flex-col overflow-y-auto">
      <!-- Header -->
      <div class="flex items-center justify-between px-6 pt-5 pb-3 border-b border-gray-100 min-h-[73px]">
         <div class="flex items-center space-x-3 transition-all duration-300 hide-when-collapsed">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
               <x-application-logo class="h-10 w-10 fill-current text-blue-600 flex-shrink-0" />
               <span class="text-xl font-bold text-gray-800 sidebar-text ">Gpts</span>
            </a>
         </div>

         <div class="flex items-center gap-3">
            <button type="button" id="shrink-sidebar" class="hidden lg:block text-gray-500 hover:text-gray-700 transition">
               <svg id="shrink-icon" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
               </svg>
            </button>

            <button type="button" id="close-sidebar" class="lg:hidden text-gray-500 hover:text-gray-700">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
               </svg>
            </button>
         </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 space-y-1">
         <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
               <a href="{{ route('dashboard') }}"
                  class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all group
                              {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                  <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                  <span class="sidebar-text whitespace-nowrap hide-when-collapsed">Dashboard</span>
               </a>
            </li>

            <!-- Blog -->
            <li>
               <a href="{{ route('blog.index') }}"
                  class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all group
                              {{ request()->routeIs('blog.index','blog.viewMail','find.niches') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                  <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('blog.index','blog.viewMail','find.niches') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V9l-7-5-7 5v11a2 2 0 002 2h14z" />
                  </svg>
                  <span class="sidebar-text whitespace-nowrap hide-when-collapsed">Blog</span>
               </a>
            </li>

            <!-- Mail History -->
            <li>
               <a href="{{ route('blog.mailHistory', encrypt($loggedUserId)) }}"
                  class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all group
                              {{ request()->routeIs('blog.mailHistory','blog.view-mail') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                  <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('blog.mailHistory','blog.view-mail') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                  </svg>
                  <span class="sidebar-text whitespace-nowrap hide-when-collapsed">Mail History</span>
               </a>
            </li>

            @auth
            @if(Auth::user()->hasVerifiedEmail())
            <li>
               <a href="{{ route('my-orders') }}"
                  class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all group
                                      {{ request()->routeIs('my-orders','view-my-order') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                  <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('my-orders','view-my-order') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                  </svg>
                  <span class="sidebar-text whitespace-nowrap hide-when-collapsed">My Orders</span>
               </a>
            </li>

            <li>
               <a href="{{ route('order-billing') }}"
                  class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all group
                                      {{ request()->routeIs('order-billing') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                  <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('order-billing') ? 'text-blue-600' : 'text-gray-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  <span class="sidebar-text whitespace-nowrap hide-when-collapsed">Billing</span>
               </a>
            </li>
            @endif
            @endauth
         </ul>
      </nav>

      <!-- Footer Links -->
      <div class="border-t border-gray-200 px-4 py-5 space-y-1">
         <a href="/logout" class="inline-flex w-full justify-center items-center gap-2 px-5 py-2 border border-red-500 hover:bg-red-500 hover:text-white text-red-500 font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-red-300">
            <span class="sidebar-text hide-when-collapsed">Logout</span>
            <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 flex-shrink-0"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
            </svg>
         </a>

      </div>
   </div>
</aside>

<!-- Backdrop (Mobile Only) -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>



<script>
   document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      const shrinkBtn = document.getElementById('shrink-sidebar');
      const shrinkIcon = document.getElementById('shrink-icon');
      const backdrop = document.getElementById('sidebar-backdrop');
      const openBtn = document.getElementById('open-sidebar');
      const closeBtn = document.getElementById('close-sidebar');
      const wholeHeaderWrapper = document.getElementById('whole-heade-wrapper');

      // === MOBILE: Open Sidebar ===
      const openSidebar = () => {
         
         sidebar.classList.remove('-translate-x-full');
         backdrop.classList.remove('hidden');
         document.body.style.overflow = 'hidden';
         
          // Prevent background scroll
      };

      // === MOBILE: Close Sidebar ===
      const closeSidebar = () => {
         
         sidebar.classList.add('-translate-x-full');
         backdrop.classList.add('hidden');
         document.body.style.overflow = 'auto';
      };

      // === DESKTOP: Shrink / Expand Sidebar ===
      shrinkBtn?.addEventListener('click', () => {
         const currentState = sidebar.getAttribute('data-state');

         if (currentState === 'collapsed') {
            wholeHeaderWrapper.style.width = 'calc(100% - 256px)';
            // Expand it
            sidebar.setAttribute('data-state', 'expanded');
            shrinkIcon.style.transform = 'rotate(0deg)';
            localStorage.setItem('sidebarState', 'expanded');
         } else {
            wholeHeaderWrapper.style.width = 'calc(100% - 80px)';
            // Collapse it
            sidebar.setAttribute('data-state', 'collapsed');
            shrinkIcon.style.transform = 'rotate(180deg)';
            localStorage.setItem('sidebarState', 'collapsed');
         }
      });

      // === Load Saved Preference on Page Load (Desktop Only) ===
      if (window.innerWidth >= 992) {
         const savedState = localStorage.getItem('sidebarState');
         if (savedState === 'collapsed') {
            wholeHeaderWrapper.style.width = 'calc(100% - 80px)';
            sidebar.setAttribute('data-state', 'collapsed');
            shrinkIcon.style.transform = 'rotate(180deg)';
         } else {
            wholeHeaderWrapper.style.width = 'calc(100% - 256px)';
            sidebar.setAttribute('data-state', 'expanded');
            shrinkIcon.style.transform = 'rotate(0deg)';
         }
      }

      // === Mobile Controls ===
      openBtn?.addEventListener('click', openSidebar);
      closeBtn?.addEventListener('click', closeSidebar);
      backdrop?.addEventListener('click', closeSidebar);

      // Close mobile sidebar when clicking a link (on mobile)
      document.querySelectorAll('#sidebar a').forEach(link => {
         link.addEventListener('click', () => {
            if (window.innerWidth < 992) {
               closeSidebar();
            }
         });
      });

      // Auto-close mobile sidebar when resizing to desktop
      window.addEventListener('resize', () => {
         if (window.innerWidth >= 992) {
            closeSidebar();
         }
      });

      // Optional: Close mobile sidebar with Escape key
      document.addEventListener('keydown', (e) => {
         if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            closeSidebar();
         }
      });
   });
</script>




{{-- <div class="p-4 sm:ml-64">
   <div class="p-4 border-1 border-default border-dashed rounded-base">
      <div class="grid grid-cols-3 gap-4 mb-4">
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
      </div>
      <div class="flex items-center justify-center h-48 rounded-base bg-neutral-secondary-soft mb-4">
         <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
         </p>
      </div>
      <div class="grid grid-cols-2 gap-4 mb-4">
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
      </div>
      <div class="flex items-center justify-center h-48 rounded-base bg-neutral-secondary-soft mb-4">
         <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
         </p>
      </div>
      <div class="grid grid-cols-2 gap-4">
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
         <div class="flex items-center justify-center h-24 rounded-base bg-neutral-secondary-soft">
            <p class="text-fg-disabled">
               <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg>
            </p>
         </div>
      </div>
   </div>
</div> --}}