@extends('layouts.app')

@section('title', 'Dashboard')


@section('content')
    

    <div class="py-12 px-4">
        
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

            @if($activePlansCount > 0)
            <!-- Mail Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Available Mail Today -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Available Mail Today
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $availableMailToday ?? 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sent Mail Today -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Sent Mail Today
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $sentMailToday ?? 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Spent -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Spent
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        ${{ number_format($totalSpent ?? 0, 2) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Plans -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Active Plans
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $totalActivePlans ?? 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Sections: Mail History (Right) and Random Blogs (Left) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">

                <!-- Left Side: Random Blogs -->
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Featured Blogs</h3>

                    @if(!empty($randomBlogs))
                        @foreach($randomBlogs as $blog)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <!-- Blog Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Blog Details -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg font-semibold text-gray-900 truncate">
                                            {{ $blog['website_name'] ?? 'Blog' }}
                                        </h4>

                                        <a href="{{ $blog['site_url'] ?? '#' }}"
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800 text-sm break-all flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            {{ $blog['site_url'] ?? '' }}
                                        </a>

                                        <!-- Metrics -->
                                        <div class="flex items-center gap-4 mt-3 text-sm text-gray-600">
                                            @if(isset($blog['moz_da']) && $blog['moz_da'])
                                                <div class="flex items-center gap-1">
                                                    <span class="font-medium">DA:</span>
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">{{ $blog['moz_da'] }}</span>
                                                </div>
                                            @endif

                                            @if(isset($blog['ahrefs_dr']) && $blog['ahrefs_dr'])
                                                <div class="flex items-center gap-1">
                                                    <span class="font-medium">DR:</span>
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">{{ $blog['ahrefs_dr'] }}</span>
                                                </div>
                                            @endif

                                            @if(isset($blog['ahrefs_traffic']) && $blog['ahrefs_traffic'])
                                                <div class="flex items-center gap-1">
                                                    <span class="font-medium">Traffic:</span>
                                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-semibold">{{ number_format($blog['ahrefs_traffic']) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Send Mail Button -->
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('blog.viewMail', encrypt($blog['blog_id'])) }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            Send Mail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                            <div class="text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium">No blogs available</p>
                                <p class="text-sm mt-1">Check back later for featured blogs</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Side: Mail History -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-800">Recent Mail History</h3>
                        <a href="{{ route('blog.mailHistory', encrypt(auth()->id())) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    @if($mails->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="divide-y divide-gray-200">
                                @foreach($mails as $mail)
                                <div class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <!-- Mail Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Mail Details -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ Str::limit($mail->subject, 40) }}
                                                    </p>
                                                    <a href="{{ $mail->site_url }}"
                                                       target="_blank"
                                                       class="text-blue-600 hover:text-blue-800 text-xs break-all flex items-center gap-1 mt-1">
                                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                        </svg>
                                                        {{ Str::limit($mail->site_url, 35) }}
                                                    </a>
                                                </div>

                                                <!-- Date and View Button -->
                                                <div class="flex flex-col items-end gap-2 ml-3">
                                                    <span class="text-xs text-gray-500 whitespace-nowrap">
                                                        {{ $mail->created_at->format('M d, H:i') }}
                                                    </span>
                                                    <a href="{{ route('blog.view-mail', encrypt($mail->id)) }}"
                                                       class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded transition-colors">
                                                        View
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Message Preview -->
                                            <p class="text-xs text-gray-600 mt-2 line-clamp-2">
                                                {{ Str::limit(strip_tags($mail->message), 80) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                            <div class="text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-5.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H3"></path>
                                </svg>
                                <p class="text-lg font-medium">No mail history</p>
                                <p class="text-sm mt-1">Your sent mails will appear here</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- No Active Plan Message -->
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Active Plan Found</h3>
                <p class="text-gray-600 mb-6">
                    You don't have any active plans at the moment. To access blog outreach features, please purchase a plan.
                </p>
                <a href="/"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    View Plans
                </a>
            </div>
        </div>
    </div>
    @endif

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
