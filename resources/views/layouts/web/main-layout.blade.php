<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <link rel="stylesheet" href="{{asset('web/css/staging.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/animation.css')}}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">





    <!-- build css -->
    <!-- <link rel="stylesheet" href="{{asset('build/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('build/assets/css/main2.css')}}"> -->


</head>

<body class="overflow-x-hidden ">

    <!-- ==== NEW WRAPPER ==== -->
    <div id="smooth-wrapper">

        <x-web.navbar />

        <div id="smooth-content">

            <main class="">
                @yield('content')
            </main>


            <x-web.footer />

        </div>
    </div>



    @yield('scripts')



    <!-- gsap animation script  -->
    <!-- <script src="{{asset('web/js/gsap/gsap.min.js')}}"></script> -->
    <!-- <script src="{{asset('web/js/gsap/ScrollTrigger.min.js')}}"></script> -->
    <!-- <script src="{{asset('web/js/gsap/Draggable.min.js')}}"></script> -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollSmoother.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   

    <!-- gsap smooth scrolling  -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // If current page is NOT checkout → enable ScrollSmoother
            if (!window.location.pathname.includes('/checkout')) {

                let smoother = ScrollSmoother.create({
                    wrapper: '#smooth-wrapper',
                    content: '#smooth-content',
                    smooth: 1,
                });

                // If dynamic content reloads
                // window.addEventListener('content-updated', () => smoother.refresh());
            }

            // Else: Do nothing → smooth scroll disabled on checkout
        });
    </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- gsap smooth scrolling  -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // If current page is NOT checkout → enable ScrollSmoother
            if (!window.location.pathname.includes('/checkout')) {
                // Your GSAP code here
            }
        });
    </script>


</body>

</html>