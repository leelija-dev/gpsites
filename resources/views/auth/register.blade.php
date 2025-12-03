<x-guest-layout>
    <body class="h-screen bg-gray-50 overflow-hidden relative">

    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="relative z-10 h-full flex items-center justify-center px-6 lg:px-8">
        <div class="w-full max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-0 bg-white rounded-3xl shadow-2xl overflow-hidden card-hover">

                <!-- Left Panel – Branding -->
                <div class="hidden lg:flex flex-col justify-between bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-12 text-white">
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight">
                            Welcome to <span class="block text-5xl mt-2">{{ config('app.name', 'YourApp') }}</span>
                        </h1>
                        <p class="mt-6 text-lg leading-relaxed text-indigo-100">
                            Join thousands of professionals who trust us to deliver exceptional results every day.
                        </p>

                        <ul class="mt-10 space-y-4">
                            <li class="flex items-center gap-4">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span class="text-indigo-50">Real-time collaboration</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span class="text-indigo-50">Bank-grade encryption</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span class="text-indigo-50">24/7 dedicated support</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span class="text-indigo-50">Email verification required</span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-16">
                        <p class="text-3xl font-bold">10,000+</p>
                        <p class="text-indigo-200">Active users worldwide</p>
                    </div>
                </div>

                <!-- Right Panel – Registration Form -->
                <div class="flex flex-col justify-center px-10 py-16 lg:px-20 bg-white">
                    <div class="max-w-md mx-auto w-full">

                        <!-- Mobile Logo -->
                        <div class="flex justify-center lg:hidden mb-10">
                            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                        </div>

                        <h2 class="text-3xl font-bold text-gray-900 text-center lg:text-left">Create your account</h2>
                        <p class="mt-3 text-gray-600 text-center lg:text-left">Start your journey today — it's free forever.</p>

                        <!-- Global Error (e.g. email already taken) -->
                        @error('error')
                            <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                <p class="text-sm text-red-700 font-medium">{{ $message }}</p>
                            </div>
                        @enderror

                        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                            @csrf

                            <!-- Name -->
                            <div>
                                <input type="text" name="name" placeholder="Full Name" required autofocus
                                       value="{{ old('name') }}"
                                       class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition @error('name') border-red-500 @enderror" />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <input type="email" name="email" placeholder="Work Email" required
                                       value="{{ old('email') }}"
                                       class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition @error('email') border-red-500 @enderror" />
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Field with Eye Toggle -->
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Create Password" 
                                    required 
                                    minlength="8"
                                    class="w-full px-5 py-4 pr-14 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition @error('password') border-red-500 @enderror" 
                                />
                                <button type="button" onclick="togglePassword('password', 'eye1')" class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-indigo-600 transition">
                                    <svg id="eye1Open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eye1Closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.977 9.977 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password Field with Eye Toggle -->
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="Confirm Password" 
                                    required
                                    class="w-full px-5 py-4 pr-14 border border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition" 
                                />
                                <button type="button" onclick="togglePassword('password_confirmation', 'eye2')" class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-indigo-600 transition">
                                    <svg id="eye2Open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eye2Closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.977 9.977 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="flex items-start gap-3">
                                <input type="checkbox" id="terms" name="terms" required class="mt-1 w-5 h-5 text-indigo-600 rounded border-gray-300"/>
                                <label for="terms" class="text-sm text-gray-600">
                                    I agree to the <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Terms</a> and
                                    <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="w-full mt-6 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold text-lg rounded-xl shadow-lg transform transition hover:scale-105 active:scale-95">
                                Create Free Account
                            </button>
                        </form>

                        <p class="mt-8 text-center text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Toggle Script -->
    <script>
        function togglePassword(inputId, eyeIdPrefix) {
            const input = document.getElementById(inputId);
            const eyeOpen = document.getElementById(eyeIdPrefix + 'Open');
            const eyeClosed = document.getElementById(eyeIdPrefix + 'Closed');

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
</x-guest-layout>