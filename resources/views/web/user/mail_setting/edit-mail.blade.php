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

                    <form method="POST" id="mailSettingForm" action="{{route('mail-update',base64_encode($data->id))}}" class="p-6" novalidate>
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- SMTP Host -->
                            <input type="hidden" name="user_id" value="{{ $loggedUserId }}">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">SMTP Host<sup class="text-red-500">*</sup></label>
                                <input type="text" name="smtp_host" value="{{$data->smtp_host}}" required placeholder="smtp.gmail.com"
                                    class="mt-1 w-full rounded-lg border-gray-300">
                                <span class="invalid-feedback hidden text-red-500 text-xs mt-1">SMTP host can not be blank!</span>
                            
                                @error('smtp_host')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- SMTP Port -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600">SMTP Port<sup class="text-red-500">*</sup></label>
                                <input type="number" name="smtp_port" value="{{$data->smtp_port}}" required placeholder="587"
                                    class="mt-1 w-full rounded-lg border-gray-300">
                                    <span class="invalid-feedback hidden text-red-500 text-xs mt-1">SMTP port can not be blank!</span>
                            
                                    @error('smtp_port')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                            </div>
                           
                          {{-- 
                            <!-- SMTP Username -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email (SMTP Username)</label>
                                <input type="email" name="mail_username" required
                                    class="mt-1 w-full rounded-lg border-gray-300">
                            </div> --}}
                            <!--Email -->
                             <div>
                                <label class="block text-sm font-medium text-gray-600"> Email<sup class="text-red-500">*</sup></label>
                                <input type="email" name="email" value="{{$data->email}}" required
                                    class="mt-1 w-full rounded-lg border-gray-300">
                                <span class="invalid-feedback hidden text-red-500 text-xs mt-1">Email can not be blank!</span>
                            
                                @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- SMTP Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600">
                                    Email password <sup class="text-red-500">*</sup>
                                </label>

                                <div class="relative mt-1">
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        value="{{ decrypt($data->password) }}"
                                        required
                                        class="w-full rounded-lg border-gray-300 pr-10"
                                    >

                                    <!-- Eye button -->
                                    <button
                                        type="button"
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700"
                                    >
                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                    </button>
                                </div>

                                <span class="invalid-feedback hidden text-red-500 text-xs mt-1">
                                    Password can not be blank!
                                </span>

                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                             <!-- SMTP Encryption -->
                            <div>
                                <label class="block text-sm font-medium text-gray-600">SMPTP encryption<sup class="text-red-500">*</sup></label>
                                <select name="smtp_encryption" class="mt-1 w-full rounded-lg border-gray-300">
                                    <option value="tls" {{$data->smtp_encryption == 'tls' ? 'selected' : ''}}>TLS</option>
                                    <option value="ssl" {{$data->smtp_encryption === 'ssl' ? 'selected': ''}}>SSL</option>
                                </select>
                                <span class="invalid-feedback hidden text-red-500 text-xs mt-1">Please select encryption!</span>
                            
                                @error('smtp_encryption')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600"> Name<sup class="text-red-500">*</sup></label>
                                <input type="text" name="name" value="{{$data->name}}" required
                                    class="mt-1 w-full rounded-lg border-gray-300">
                                <span class="invalid-feedback hidden text-red-500 text-xs mt-1">Name can not be blank!</span>
                            
                                @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('mailSettingForm');

    const fields = {
        smtp_host: {
            el: form.querySelector('[name="smtp_host"]'),
            validate: v => v.trim() !== '' && /^[a-zA-Z0-9.\-]+$/.test(v),
            msg: 'SMTP host cannot be blank!'
        },
        smtp_port: {
            el: form.querySelector('[name="smtp_port"]'),
            validate: v => Number.isInteger(+v) && +v > 0 && +v <= 65535,
            msg: 'Enter a valid SMTP port!'
        },
        email: {
            el: form.querySelector('[name="email"]'),
            validate: v => /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v),
            msg: 'Enter a valid email address!'
        },
        password: {
            el: form.querySelector('[name="password"]'),
            validate: v => v.trim().length > 0,
            msg: 'Password cannot be blank!'
        },
        smtp_encryption: {
            el: form.querySelector('[name="smtp_encryption"]'),
            validate: v => ['tls', 'ssl'].includes(v),
            msg: 'Please select encryption!'
        },
        name: {
            el: form.querySelector('[name="name"]'),
            validate: v => v.trim() !== '',
            msg: 'Name cannot be blank!'
        }
    };

    function showError(field, message) {
        const wrapper = field.el.closest('div');
        const span = wrapper.querySelector('.invalid-feedback');

        if (span) {
            span.textContent = message;
            span.classList.remove('hidden');
        }

        field.el.classList.add('border-red-500', 'ring-1', 'ring-red-500');
    }

    function clearError(field) {
        const wrapper = field.el.closest('div');
        const span = wrapper.querySelector('.invalid-feedback');

        if (span) {
            span.classList.add('hidden');
        }

        field.el.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
    }

    form.addEventListener('submit', function (e) {
        let isValid = true;

        Object.values(fields).forEach(field => clearError(field));

        Object.values(fields).forEach(field => {
            if (!field.validate(field.el.value)) {
                showError(field, field.msg);
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            const firstError = form.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

});
</script>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>


@endsection
