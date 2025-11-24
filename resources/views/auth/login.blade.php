<x-guest-layout>


    <section class="w-full min-h-screen bg-white flex items-center justify-center px-4 relative">

    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
        <div class="w-full max-w-md relative z-10">
            <div class="bg-white rounded-2xl shadow-[0_6px_19px_#ccc] p-8 md:p-10">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4 text-center" :status="session('status')" />
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

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center text-sm">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
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
</x-guest-layout>