<x-filament::page>
    <div class="mb-4 text-sm text-gray-600">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
    </div>

    {{ $this->form }}

    <div class="mt-4 flex space-x-4">
        <x-filament::button wire:click="request">
            Send Password Reset Link
        </x-filament::button>
    </div>
</x-filament::page>