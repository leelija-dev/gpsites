<!-- Navigation Bar -->
<nav class="w-full bg-white shadow-sm relative z-[100] px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto ">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <div class="flex items-center space-x-1">
                    <!-- Purple curved shape (using SVG) -->
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="text-purple-600">
                        <path
                            d="M16 2C11.7565 2 8 5.75652 8 10V22C8 26.2435 11.7565 30 16 30C20.2435 30 24 26.2435 24 22V10C24 5.75652 20.2435 2 16 2Z"
                            fill="currentColor" />
                        <path
                            d="M16 8C13.7909 8 12 9.79086 12 12V20C12 22.2091 13.7909 24 16 24C18.2091 24 20 22.2091 20 20V12C20 9.79086 18.2091 8 16 8Z"
                            fill="white" />
                    </svg>
                    <span class="text-xl font-bold text-gray-900">Logo</span>
                </div>
            </div>

            <div class="flex gap-6 items-center">
                <!-- Desktop Navigation Links -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="/"
                        class="text-gray-700 hover:text-secondary font-medium transition-all duration-300 ease-in-out">Home</a>
                    <a href="#"
                        class="text-gray-700 hover:text-secondary font-medium transition-all duration-300 ease-in-out">Pricing</a>
                    <a href="/about"
                        class="text-gray-700 hover:text-secondary font-medium transition-all duration-300 ease-in-out">About
                        Us</a>
                    <a href="/contact"
                        class="text-gray-700 hover:text-secondary font-medium transition-all duration-300 ease-in-out">Contact
                        Us</a>
                </div>

                <!-- Desktop Login Button -->
                <div class="hidden lg:flex items-center">
                    {{-- <a href="/login" class="btn-primary px-8 py-[0.3rem] text-[17px]">
                      Login
                    </a> --}}
                    @auth
                        <!-- When user is logged in show Profile -->
                        <a href="/dashboard" class="btn-primary px-8 py-[0.3rem] text-[17px]">
                            Dashboard
                        </a>
                    @endauth

                    @guest
                        <!-- When user is NOT logged in show Login -->
                        <a href="/login" class="btn-primary px-8 py-[0.3rem] text-[17px]">
                            Login
                        </a>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button id="mobile-menu-button"
                        class="p-2 rounded-md text-gray-700 hover:text-secondary hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar Menu -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[1000] hidden ">
</div>

<div id="mobile-sidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-xl z-[1001] -translate-x-full">
    <div class="p-6">
        <!-- Close button -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-1">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="text-purple-600">
                    <path
                        d="M16 2C11.7565 2 8 5.75652 8 10V22C8 26.2435 11.7565 30 16 30C20.2435 30 24 26.2435 24 22V10C24 5.75652 20.2435 2 16 2Z"
                        fill="currentColor" />
                    <path
                        d="M16 8C13.7909 8 12 9.79086 12 12V20C12 22.2091 13.7909 24 16 24C18.2091 24 20 22.2091 20 20V12C20 9.79086 18.2091 8 16 8Z"
                        fill="white" />
                </svg>
                <span class="text-xl font-bold text-gray-900">Logo</span>
            </div>
            <button onclick="closeSidebar()" class="p-2 rounded-md hover:bg-gray-100 text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Links -->
        <nav class="space-y-2">
            <a href="/"
                class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-colors">Home</a>
            <a href="#"
                class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-colors">Pricing</a>
            <a href="/about"
                class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-colors">About
                Us</a>
            <a href="/"
                class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-colors">Contact
                Us</a>
            {{-- <a href="/login" class="block px-4 py-3 btn-primary text-center mt-6">Login</a> --}}
                    @auth
                        <!-- When user is logged in show Profile -->
                        
                        <a href="/dashboard" class="block px-4 py-3 btn-primary text-center mt-6">
                            Dashboard
                        </a>
                    @endauth

                    @guest
                        <!-- When user is NOT logged in show Login -->
                        <a href="/login" class="block px-4 py-3 btn-primary text-center mt-6">Login</a>
                    @endguest
        </nav>
    </div>
</div>

<!-- JavaScript for Sidebar Toggle with Animation -->
<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    // Add transition classes once
    sidebar.classList.add('transition-transform', 'duration-300', 'ease-in-out');
    overlay.classList.add('transition-opacity', 'duration-300', 'ease-in-out');

    // Initial state: sidebar hidden
    let isSidebarOpen = false;

    function openSidebar() {
        if (window.innerWidth >= 991) return; // Do nothing on large screens

        overlay.classList.remove('hidden');
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        // overlay.classList.add('opacity-100');

        isSidebarOpen = true;
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');

        // Wait for transition to finish before hiding overlay
        const hideOverlay = () => {
            overlay.classList.add('hidden');
            overlay.removeEventListener('transitionend', hideOverlay);
        };
        overlay.addEventListener('transitionend', hideOverlay);

        isSidebarOpen = false;
    }

    // Toggle sidebar (only on mobile)
    mobileMenuButton.addEventListener('click', (e) => {
        e.stopPropagation();
        if (isSidebarOpen) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    // Close when clicking overlay
    overlay.addEventListener('click', closeSidebar);

    // Close sidebar automatically when resizing to desktop (≥991px)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 991 && isSidebarOpen) {
            closeSidebar();
        }

        // Optional: Also close if going from desktop to mobile but sidebar was open (safety)
        if (window.innerWidth < 991 && !sidebar.classList.contains('-translate-x-full') && !isSidebarOpen) {
            // This case shouldn't happen normally, but just in case
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden', 'opacity-0');
        }
    });

    // Initial check on load (in case page loads on large screen)
    if (window.innerWidth >= 991) {
        closeSidebar(); // Ensures it's closed on desktop
    }
</script>
