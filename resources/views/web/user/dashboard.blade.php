@extends('layouts.app')

@section('title', 'Dashboard')


@section('content')
    

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Email Verification Success Message -->
            @if(request()->has('verified') && request('verified') == 1)
            <div class="bg-green-50 border border-green-200 rounded-md p-4" data-verification-success>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">
                            Email Verified Successfully!
                        </h3>
                        <div class="mt-1 text-sm text-green-700">
                            <p>Your email address has been verified. You can now access all features of the application.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Email Verification Required Notice (for unverified users) -->
            @if(!auth()->user()->hasVerifiedEmail())
            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            Email Verification Required
                        </h3>
                        <div class="mt-1 text-sm text-yellow-700">
                            <p>Please verify your email address to access all features including checkout and purchases.</p>
                            <p class="mt-2">
                                <a href="{{ route('verification.notice') }}" class="font-medium text-yellow-700 hover:text-yellow-600 underline">
                                    Resend verification email
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Auto-hide verification success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('[data-verification-success]');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                    // Optionally remove the verified parameter from URL
                    const url = new URL(window.location);
                    url.searchParams.delete('verified');
                    window.history.replaceState({}, '', url);
                }, 5000); // 5 seconds
            }
        });
    </script>
@endsection
