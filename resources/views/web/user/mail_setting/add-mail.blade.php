@php 
    use Illuminate\Support\Facades\Auth;
    $loggedUserId = Auth::id();
@endphp
@extends('layouts.app')

@section('title', 'Mail Setting')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="p-6 lg:p-10">
            <div class="max-w-8xl mx-auto">


                <div class="bg-white shadow-xl rounded-xl border border-gray-200">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-700">
                            Mail Configuration
                        </h2>
                    </div>

                    <form id="mailSettingForm" method="POST" action="{{route('mail-store')}}" class="p-6" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- SMTP Host -->
                            <input type="hidden" name="user_id" value="{{ $loggedUserId }}">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">SMTP Host<sup class="text-red-500">*</sup></label>
                                <input type="text" name="smtp_host"  placeholder="smtp.gmail.com"
                                    class="mt-1 w-full rounded-lg border-gray-300" required>
                                <span class="invalid-feedback text-red-500 text-xs mt-1 hidden">SMTP host can not be blank!</span>
                            
                                @error('smtp_host')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- SMTP Port -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600">SMTP Port<sup class="text-red-500">*</sup></label>
                                <input type="number" name="smtp_port" required placeholder="587"
                                    class="mt-1 w-full rounded-lg border-gray-300" required>
                                    <span class="invalid-feedback text-red-500 text-xs mt-1 hidden">SMTP port can not be blank!</span>
                                @error('smtp_port')
                                  <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                                                       
                              <!-- From Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email<sup class="text-red-500">*</sup></label>
                                <input type="email" name="email" required placeholder="exapmle@gmail.com"
                                    class="mt-1 w-full rounded-lg border-gray-300">
                                <span class="invalid-feedback text-red-500 text-xs mt-1 hidden">Please enter a valid email address!</span>
                            
                                @error('email')
                                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Email Password -->
                            <div>
                            <label class="block text-sm font-medium text-gray-600">
                                Email web password <sup class="text-red-500">*</sup>
                            </label>

                            <div class="relative mt-1">
                                <input type="password" name="password" id="password"
                                    required placeholder="Password"
                                    class="w-full rounded-lg border-gray-300 pr-10">

                                <!-- Eye Button -->
                                <button type="button"
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700">
                                    <i id="eyeIcon" class="fa fa-eye"></i>
                                </button>
                            </div>

                           <span class="invalid-feedback text-red-500 text-xs mt-1 hidden">
                                Password can not be blank!
                            </span>

                            @error('password')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                            <!-- Encryption -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600">SMTP encryption<sup class="text-red-500">*</sup></label>
                                <select name="smtp_encryption" class="mt-1 w-full rounded-lg border-gray-300">
                                    <option value="tls">TLS</option>
                                    <option value="ssl">SSL</option>
                                </select>
                                <span class="invalid-feedback" style="display:none ">Please select encryption! </span>
                            
                                @error('smtp_encryption')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                             <!-- SMTP Username -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Name<sup class="text-red-500">*</sup></label>
                                <input type="text" name="name" required placeholder="name"
                                    class="mt-1 w-full rounded-lg border-gray-300" required>
                                    <span class="invalid-feedback text-red-500 text-xs mt-1 hidden">Please enter name!</span>
                                @error('name')
                                  <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="flex justify-end mt-6">
                            <button class="px-6 py-2 bg-indigo-600 text-white rounded-lg">
                                Save 
                            </button>
                        </div>

                    </form>


                </div>

            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="{{route('mail-store')}}"]');
        const smtpHost = form.querySelector('input[name="smtp_host"]');
        const smtpPort = form.querySelector('input[name="smtp_port"]');
        const encryption = form.querySelector('select[name="smtp_encryption"]');
        const password = form.querySelector('input[name="password"]');
        const email = form.querySelector('input[name="email"]');
        const name =form.querySelector('input[name="name"]');

        function showError(el, msg){
            const span = el.parentElement.querySelector('.invalid-feedback');
            if(span){ span.textContent = msg; span.style.display = 'block'; }
            el.classList.add('border-red-500');
        }
        function clearError(el){
            const span = el.parentElement.querySelector('.invalid-feedback');
            if(span){ span.style.display = 'none'; }
            el.classList.remove('border-red-500');
        }

        form.addEventListener('submit', function(e){
            let valid = true;
            // clear previous
            [smtpHost, smtpPort, encryption, password, email].forEach(clearError);

            const hostVal = smtpHost.value.trim();
            if(!hostVal || !/^[a-zA-Z0-9.\-]+$/.test(hostVal)){
                showError(smtpHost, 'SMTP host can not be blank!');
                valid = false;
            }

            const portVal = Number(smtpPort.value);
            if(!Number.isInteger(portVal) || portVal < 1 || portVal > 65535){
                showError(smtpPort, 'SMPT port can not be blank!');
                valid = false;
            }

            const encVal = encryption.value;
            if(!['tls','ssl'].includes(encVal)){
                showError(encryption, 'Encryption must be tls or ssl');
                valid = false;
            }

            if(!password.value.trim()){
                showError(password, 'Password cannot be blank!');
                valid = false;
            }
            if(!name.value.trim()){
                showError(name, 'Please enter name!');
                valid = false;
            }

            // Use browser validation for email pattern then stricter check
            const emailVal = email.value.trim();
            const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
            if(!emailVal || !emailRegex.test(emailVal)){
                showError(email, 'Please enter a valid email address!');
                valid = false;
            }

            if(!valid){
                e.preventDefault();
                const firstInvalid = form.querySelector('.border-red-500');
                if(firstInvalid) firstInvalid.focus();
            }
        });
    });
    </script>
   <script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>

@endsection
