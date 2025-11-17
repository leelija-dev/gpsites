


<!-- Navigation Bar -->
  <nav class="w-full bg-white shadow-sm relative z-[100]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">

        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
          <div class="flex items-center space-x-1">
            <!-- Purple curved shape (using SVG) -->
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-purple-600">
              <path d="M16 2C11.7565 2 8 5.75652 8 10V22C8 26.2435 11.7565 30 16 30C20.2435 30 24 26.2435 24 22V10C24 5.75652 20.2435 2 16 2Z" fill="currentColor"/>
              <path d="M16 8C13.7909 8 12 9.79086 12 12V20C12 22.2091 13.7909 24 16 24C18.2091 24 20 22.2091 20 20V12C20 9.79086 18.2091 8 16 8Z" fill="white"/>
            </svg>
            <span class="text-xl font-bold text-gray-900">Logo</span>
          </div>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="hidden md:flex items-center space-x-8">
          <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Home</a>
          <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Pricing</a>
          <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">About Us</a>
          <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">Contact Us</a>
        </div>

        <!-- Desktop Login Button -->
        <div class="hidden md:flex items-center">
          <a href="#" class="bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-2 rounded-full transition-colors">
            Login
          </a>
        </div>

        <!-- Mobile Menu Button -->
        <div class="flex items-center md:hidden">
          <button id="mobile-menu-button" class="p-2 rounded-md text-gray-700 hover:text-purple-600 hover:bg-gray-100">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Mobile Sidebar Menu -->
  <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden overlay" onclick="closeSidebar()"></div>
  <div id="mobile-sidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-xl z-50 transform -translate-x-full sidebar">
    <div class="p-6">
      <!-- Close button -->
      <div class="flex justify-between items-center mb-8">
        <div class="flex items-center space-x-1">
          <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-purple-600">
            <path d="M16 2C11.7565 2 8 5.75652 8 10V22C8 26.2435 11.7565 30 16 30C20.2435 30 24 26.2435 24 22V10C24 5.75652 20.2435 2 16 2Z" fill="currentColor"/>
            <path d="M16 8C13.7909 8 12 9.79086 12 12V20C12 22.2091 13.7909 24 16 24C18.2091 24 20 22.2091 20 20V12C20 9.79086 18.2091 8 16 8Z" fill="white"/>
          </svg>
          <span class="text-xl font-bold text-gray-900">Logo</span>
        </div>
        <button onclick="closeSidebar()" class="p-2 rounded-md hover:bg-gray-100 text-gray-600">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- Mobile Menu Links -->
      <nav class="space-y-2">
        <a href="#" class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-colors">Home</a>
        <a href="#" class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-colors">Pricing</a>
        <a href="#" class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-colors">About Us</a>
        <a href="#" class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-colors">Contact Us</a>
        <a href="#" class="block px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium text-center transition-colors mt-6">Login</a>
      </nav>
    </div>
  </div>

  <!-- JavaScript for Sidebar Toggle with Animation -->
  <script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function openSidebar() {
      sidebar.classList.remove('-translate-x-full', 'sidebar-leave-active');
      sidebar.classList.add('sidebar-enter-active');
      overlay.classList.remove('hidden', 'overlay-leave-active');
      overlay.classList.add('overlay-enter-active');
      setTimeout(() => {
        sidebar.classList.remove('sidebar-enter-active');
        overlay.classList.remove('overlay-enter-active');
      }, 300);
    }

    function closeSidebar() {
      sidebar.classList.add('sidebar-leave-active');
      overlay.classList.add('overlay-leave-active');
      setTimeout(() => {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('sidebar-leave-active');
        overlay.classList.add('hidden');
        overlay.classList.remove('overlay-leave-active');
      }, 300);
    }

    mobileMenuButton.addEventListener('click', openSidebar);
  </script>