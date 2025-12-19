<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <!-- Standard Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/site-img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/site-img/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/site-img/favicon.ico') }}">
    
    <!-- Apple Touch Icon (iPhone, iPad) -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/site-img/apple-touch-icon.png') }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    
    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/summer-note/summer-note.min.js')}}"></script>
    <script src="{{asset('js/sweet-alert/sweet-alert.min.js')}}"></script>




    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">


        <div class="w-full flex flex-row">

            <div class="w-fit">
                @include('web.sidebar')

            </div>

            <div id="whole-heade-wrapper" class="whole-heade-wrapper w-full">
                @include('layouts.navigation')
                <!-- Page Heading -->
                @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{-- {{ $slot }} --}}
                    @yield('content')
                </main>

            </div>

        </div>
    </div>
    
</body>

</html>