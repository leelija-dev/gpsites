<x-filament-panels::page>
    {{-- Page content --}}
    {{ $this->form }}
    <div class="mt-4">
        <x-filament::button type="submit" wire:click="sendEmail" color="primary">
            Send mail
        </x-filament::button>
    </div>
</x-filament-panels::page>
