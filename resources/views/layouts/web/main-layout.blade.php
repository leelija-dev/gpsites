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

    <link rel="stylesheet" href="{{asset('css/floating-label/floating-label.css')}}">



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


    <!-- Contact Form Validation Script -->
    <script>
        // Universal Contact Form Validation + SweetAlert2 Success Toast
        document.addEventListener('DOMContentLoaded', function() {
                    // Toast configuration (top-right, auto-dismiss)
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });

                    document.querySelectorAll('form[id*="contact"], form.contact-form').forEach(form => {
                        form.setAttribute('novalidate', true);

                        const fields = [{
                                el: form.querySelector('#full_name, #first_name'),
                                type: 'name',
                                required: true
                            },
                            {
                                el: form.querySelector('#phone'),
                                type: 'phone',
                                required: true
                            },
                            {
                                el: form.querySelector('#email'),
                                type: 'email',
                                required: true
                            },
                            {
                                el: form.querySelector('#subject'),
                                type: 'subject',
                                required: true
                            },
                            {
                                el: form.querySelector('#message'),
                                type: 'message',
                                required: true
                            }
                        ].filter(f => f.el);

                        function showError(input, message) {
                            clearError(input);
                            const error = document.createElement('p');
                            error.className = 'error-message text-red-600 text-sm mt-1 font-medium';
                            error.textContent = message;
                            input.parentNode.appendChild(error);
                            input.classList.add('border-red-500', 'focus:ring-red-500');
                            input.classList.remove('border-green-500', 'focus:ring-green-500');
                        }

                        function clearError(input) {
                            const existing = input.parentNode.querySelector('.error-message');
                            if (existing) existing.remove();
                            input.classList.remove('border-red-500', 'focus:ring-red-500');
                            if (input.value.trim() && isFieldValid(input)) {
                                input.classList.add('border-green-500', 'focus:ring-green-500');
                            }
                        }

                        function isFieldValid(input) {
                            const value = input.value.trim();
                            if (!value && input.hasAttribute('required')) return false;
                            if (input.id.includes('name')) return value.length >= 2;
                            if (input.id === 'email') return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                            if (input.id === 'phone') {
                                const digits = value.replace(/\D/g, '');
                                return digits.length >= 10;
                            }
                            if (input.id === 'subject') return value !== '';
                            if (input.id === 'message') return value.length >= 10;
                            return true;
                        }

                        // Real-time validation
                        fields.forEach(field => {
                            const input = field.el;

                            if (input.id === 'phone') {
                                input.addEventListener('input', function() {
                                    this.value = this.value.replace(/[^0-9+\-\s]/g, '');
                                });
                            }

                            input.addEventListener('input', function() {
                                clearError(this);
                                if (this.value.trim() && !isFieldValid(this) && this.id === 'message') {
                                    showError(this, `Message too short (${this.value.length}/10)`);
                                }
                            });

                            input.addEventListener('blur', function() {
                                if (!this.value.trim() && field.required) {
                                    showError(this, 'This field is required');
                                } else if (this.value.trim() && !isFieldValid(this)) {
                                    if (this.id.includes('name')) showError(this, 'Please enter your full name');
                                    if (this.id === 'email') showError(this, 'Please enter a valid email');
                                    if (this.id === 'phone') showError(this, 'Enter a valid phone number (min 10 digits)');
                                    if (this.id === 'message') showError(this, 'Message must be at least 10 characters');
                                } else {
                                    clearError(this);
                                }
                            });
                        });

                        // Form Submit
                        //     form.addEventListener('submit', function(e) {
                        //         e.preventDefault();
                        //         let isValid = true;
                        //         let firstErrorField = null;

                        //         fields.forEach(field => {
                        //             const input = field.el;
                        //             clearError(input);

                        //             if (!input.value.trim() && field.required) {
                        //                 showError(input, 'This field is required');
                        //                 if (!firstErrorField) firstErrorField = input;
                        //                 isValid = false;
                        //             } else if (input.value.trim() && !isFieldValid(input)) {
                        //                 if (input.id.includes('name')) showError(input, 'Please enter your full name');
                        //                 if (input.id === 'email') showError(input, 'Please enter a valid email');
                        //                 if (input.id === 'phone') showError(input, 'Enter a valid phone number (min 10 digits)');
                        //                 if (input.id === 'message') showError(input, 'Message must be at least 10 characters');
                        //                 if (!firstErrorField) firstErrorField = input;
                        //                 isValid = false;
                        //             }
                        //         });

                        //         if (isValid) {
                        //             // Beautiful top-right success toast
                        //             Toast.fire({
                        //                 icon: 'success',
                        //                 title: 'Message sent successfully!',
                        //                 background: '#10b981', // emerald green
                        //                 color: 'white',
                        //                 iconColor: 'white'
                        //             });

                        //             console.log('Form Submitted:', {
                        //                 name: form.querySelector('#full_name, #first_name')?.value.trim(),
                        //                 phone: form.querySelector('#phone')?.value.trim(),
                        //                 email: form.querySelector('#email')?.value.trim(),
                        //                 subject: form.querySelector('#subject')?.value,
                        //                 message: form.querySelector('#message')?.value.trim()
                        //             });

                        //             // form.submit(); // Uncomment for real submission
                        //             // form.reset();   // Uncomment to clear form after send
                        //         } else if (firstErrorField) {
                        //             firstErrorField.scrollIntoView({
                        //                 behavior: 'smooth',
                        //                 block: 'center'
                        //             });
                        //         }
                        //     });
                        // });

                        form.addEventListener('submit', function(e) {
                            let isValid = true;
                            let firstErrorField = null;

                            // Clear any existing errors first
                            fields.forEach(field => {
                                clearError(field.el);
                            });

                            // Validate all fields
                            fields.forEach(field => {
                                const input = field.el;

                                if (!input.value.trim() && field.required) {
                                    showError(input, 'This field is required');
                                    if (!firstErrorField) firstErrorField = input;
                                    isValid = false;
                                } else if (input.value.trim() && !isFieldValid(input)) {
                                    if (input.id.includes('name')) showError(input, 'Please enter your full name');
                                    if (input.id === 'email') showError(input, 'Please enter a valid email');
                                    if (input.id === 'phone') showError(input, 'Enter a valid phone number (min 10 digits)');
                                    if (input.id === 'message') showError(input, 'Message must be at least 10 characters');
                                    if (!firstErrorField) firstErrorField = input;
                                    isValid = false;
                                }
                            });

                            if (!isValid) {
                                // Prevent form submission if validation fails
                                e.preventDefault();

                                // Scroll to first error field
                                if (firstErrorField) {
                                    firstErrorField.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'center'
                                    });
                                    firstErrorField.focus();
                                }

                                // Show error toast
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Please fix the errors below',
                                    background: '#ef4444',
                                    color: 'white',
                                    iconColor: 'white'
                                });

                                return false;
                            }

                            // If validation passes, allow form to submit normally
                            // Show loading state
                            const submitBtn = form.querySelector('button[type="submit"]');
                            if (submitBtn) {
                                submitBtn.disabled = true;
                                const originalText = submitBtn.innerHTML;
                                submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sending...
                        `;

                                // Store original text for potential restoration on error
                                submitBtn.setAttribute('data-original-text', originalText);
                            }
                            

                            // Form will submit normally to the server
                            // Success/error handling will be done via server response and page reload
                        });
                    });
                });
    </script>




</body>

</html>