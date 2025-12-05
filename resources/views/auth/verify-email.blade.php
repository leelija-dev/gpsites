<x-guest-layout title="Verify Account" description="">
    <!-- <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div> -->

    <section class="h-screen overflow-hidden relative">

        <!-- Floating Background Shapes -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="relative z-10 h-full flex items-center justify-center px-6">
            <div class="w-full max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-0 bg-white rounded-3xl shadow-2xl overflow-hidden">

                    <!-- Left Panel - Success Message & Illustration -->
                    <div class="hidden lg:flex flex-col justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-12 text-white">
                        <div class="max-w-md">
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-8">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h1 class="text-4xl font-bold">Check your inbox</h1>
                            <p class="mt-4 text-lg text-indigo-100">
                                We've send you verification link to <span class="font-semibold">{{ $usermail }}</span>
                            </p>
                            <div class="mt-10 p-6 bg-white/10 backdrop-blur rounded-2xl">
                                <p class="text-5xl font-bold">98%</p>
                                <p class="text-indigo-200 mt-2">of users verify in under 30 seconds</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel - OTP Form -->
                    <div class="flex flex-col justify-center px-10 py-16 lg:px-20 bg-white">
                        <div class="max-w-md mx-auto w-full">

                            <!-- Mobile illustration -->
                            <div class="flex justify-center lg:hidden mb-10">
                                <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-900 text-center lg:text-left">Verify Email Address</h2>
                            <p class="mt-2 mb-3 text-sm text-center text-indigo-500 lg:hidden">
                                Mail sent to <span class="font-semibold">{{ $usermail }}</span>
                            </p>
                            <p class="mt-3 text-gray-600 text-center lg:text-left">
                                Once you verify your account, you will be able to access your account using the button below.
                            </p>


                                <!-- Submit Button -->
                                <div class="w-full mt-8 text-center">
                                    <a href="{{ route('dashboard') }}" class="m-auto py-2 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-normal text-md rounded-md shadow-lg transition-all duration-300 transform hover:scale-105 active:scale-95 disabled:cursor-not-allowed disabled:hover:scale-100">Dashboard</a>
                                </div>
                                    <!-- Resend & Timer -->
                            <div class="mt-8 text-center">
                                <p class="text-sm text-gray-600">
                                    Didn't receive the code?
                                    <button class="font-semibold text-indigo-600 hover:text-indigo-500" id="resendBtn" disabled>
                                        Resend code
                                    </button>
                                </p>
                                <p class="mt-3 text-xs text-gray-500" id="timer">Resend available in <span class="font-bold">0:59</span></p>
                            </div>

                            <div class="mt-10 text-center">
                                <p class="text-sm text-gray-500"> Back to <a class="text-indigo-500 hover:text-indigo-700" href="{{ route('register') }}">Registration</a> or <a class="text-indigo-500 hover:text-indigo-700" href="{{ route('login') }}">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        </section>
        <!-- Simple JS for OTP experience + Timer -->
        <script>
            const resendBtn = document.getElementById('resendBtn');
            const timerEl = document.getElementById('timer').querySelector('span');

            // 60-second countdown
            let seconds = 59;
            const countdown = setInterval(() => {
                timerEl.textContent = `0:${seconds.toString().padStart(2, '0')}`;
                seconds--;
                if (seconds < 0) {
                    clearInterval(countdown);
                    resendBtn.disabled = false;
                    resendBtn.classList.remove('text-gray-400');
                    resendBtn.classList.add('text-indigo-600');
                    timerEl.parentElement.textContent = 'You can now request a new link.';
                }
            }, 1000);
        </script>
</x-guest-layout>