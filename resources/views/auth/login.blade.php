<x-guest-layout title="Login" description="">
    <section class="w-full min-h-screen bg-white flex items-center justify-center px-4 relative">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="w-full max-w-md relative z-10">
            <div class="bg-white rounded-2xl shadow-[0_6px_19px_#ccc] p-8 md:p-10">
        <!-- In login.blade.php, add this right after the session status -->
                @if(session('verification_message'))
                    <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h2a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('verification_message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Session Status -->
                <x-auth-session-status class="mb-mb-2 text-center" :status="session('status')" />

                <!-- Error Alert -->
                @if(session('error'))
                    <div class="mb-4 text-center text-red-600 font-medium bg-red-100 border border-red-300 p-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Welcome Back</h1>
                    <p class="mt-2 text-gray-600">Sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email address')" class="block text-sm font-medium text-gray-700" />
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="you@example.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Password with Eye Toggle -->
                    <div class="relative">
                        <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />

                        <div class="relative">
                            <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="mt-1 block w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="••••••••"
                        />

                        <!-- Eye Icon Button -->
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none mt-1"
                        >
                            <!-- Eye Open (Visible Password) -->
                            <svg id="eyeOpen" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Eye Closed (Hidden Password) -->
                            <svg id="eyeClosed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.977 9.977 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>

                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center text-sm">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="h-mt-6 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                            <span class="ml-2 text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:-translate-y-0.5">
                        {{ __('Sign in') }}
                    </button>
                </form>

                <!-- Sign Up Link -->
                <p class="mt-8 text-center text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}"
                       class="font-medium text-indigo-600 hover:text-indigo-500">
                        {{ __('Sign up') }}
                    </a>
                </p>
            </div>
        </div>
    </section>

    <!-- JavaScript for Password Toggle -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle eye icons
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });
    </script>
</x-guest-layout>