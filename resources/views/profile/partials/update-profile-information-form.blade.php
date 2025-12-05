<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex items-center gap-4">
        <div class="flex-1">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div  class="pt-6">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            @if (session('status') === 'profile-updated')
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Name updated successfully!',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                        });
                    });
                </script>
            @endif
        </div>
        </div>
    </form>
</section>
