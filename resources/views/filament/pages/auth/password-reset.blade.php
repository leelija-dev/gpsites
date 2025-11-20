<x-filament::page>
    <div class="mb-4 text-sm text-gray-600">
        Please enter your new password.
    </div>

    {{ $this->form }}

    <div class="mt-4 flex space-x-4">
        <x-filament::button wire:click="resetPassword">
            Reset Password
        </x-filament::button>
    </div>
</x-filament::page>