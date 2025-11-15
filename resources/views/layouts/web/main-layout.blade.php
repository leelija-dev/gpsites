<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    


    <link rel="stylesheet" href="{{asset('web/css/staging.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/animation.css')}}">




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
    <script src="{{asset('web/js/gsap/gsap.min.js')}}"></script>
    <script src="{{asset('web/js/gsap/ScrollTrigger.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollSmoother.min.js"></script>
    <script src="{{asset('web/js/gsap/Draggable.min.js')}}"></script>


    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script> -->

    <!-- gsap smooth scrolling  -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // -----------------------------------------------------------------
            // 1. Initialise ScrollSmoother
            // -----------------------------------------------------------------
            let smoother = ScrollSmoother.create({
                wrapper: '#smooth-wrapper', // outer container
                content: '#smooth-content', // inner scrolling content
                smooth: 1, // seconds it takes to catch up
                // effects: true, // enables data-speed / data-lag
                // smoothTouch: 0.1, // optional: light smooth on mobile
                // normalizeScroll: true, // fixes iOS bounce
                // ignoreMobileResize: true
            });

            // -----------------------------------------------------------------
            // 2. (Optional) Refresh on dynamic content / AJAX
            // -----------------------------------------------------------------
            // If you load new sections via Livewire, Inertia, etc.:
            // window.addEventListener('content-updated', () => smoother.refresh());

            // -----------------------------------------------------------------
            // 3. (Optional) Pin navbar while scrolling
            // -----------------------------------------------------------------

        });
    </script>


</body>

</html>