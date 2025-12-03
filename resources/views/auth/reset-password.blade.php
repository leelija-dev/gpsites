<x-guest-layout>
    <section class="w-full min-h-screen bg-gray-50 flex items-center justify-center px-6 py-12 relative overflow-hidden">

        <!-- Floating Background Shapes -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">
            <div class="bg-white rounded-3xl shadow-xl p-10 border border-gray-100">

                <!-- Logo / Icon -->
                <div class="flex justify-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Reset Your Password</h2>
                    <p class="mt-2 text-gray-600">Enter your new password below</p>
                </div>

                <!-- Success Message -->
                @if (session('status'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Hidden Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            :value="old('email', $request->email)"
                            required
                            autofocus
                            autocomplete="username"
                            class="mt-2 block w-full px-5 py-4 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition"
                            placeholder="you@example.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- New Password + Eye Toggle -->
                    <div class="relative">
                        <x-input-label for="password" :value="__('New Password')" class="text-gray-700 font-medium" />
                        <div class="mt-2 relative">
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                class="block w-full px-5 py-4 pr-14 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition"
                                placeholder="Enter new password (min. 8 characters)"
                            />
                            <button type="button" onclick="togglePass('password', 'eye1')"
                                    class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-indigo-600 transition">
                                <svg id="eye1Open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye1Closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.977 9.977 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Confirm Password + Eye Toggle -->
                    <div class="relative">
                        <x-input-label for="password_confirmation" :value="__('Confirm New Password')" class="text-gray-700 font-medium" />
                        <div class="mt-2 relative">
                            <x-text-input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                class="block w-full px-5 py-4 pr-14 border border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition"
                                placeholder="Confirm your password"
                            />
                            <button type="button" onclick="togglePass('password_confirmation', 'eye2')"
                                    class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-indigo-600 transition">
                                <svg id="eye2Open" class="w-5 h-5 hidden" fill="none stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye2Closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.977 9.977 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold text-lg rounded-xl shadow-lg transform transition hover:scale-105 active:scale-95 mt-8">
                        Reset Password
                    </button>
                </form>

                <!-- Back to Login -->
                <p class="mt-8 text-center text-gray-600">
                    Remember your password?
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>

        <!-- Password Toggle Script -->
        <script>
            function togglePass(inputId, eyePrefix) {
                const input = document.getElementById(inputId);
                const eyeOpen = document.getElementById(eyePrefix + 'Open');
                const eyeClosed = document.getElementById(eyePrefix + 'Closed');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                } else {
                    input.type = 'password';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                }
            }
        </script>
    </section>
</x-guest-layout>