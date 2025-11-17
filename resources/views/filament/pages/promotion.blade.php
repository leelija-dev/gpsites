<x-filament-panels::page>
    <form wire:submit.prevent="sendPromotion">
        {{ $this->form }}
        
        <x-filament::button type="submit" class="mt-4">
           <span wire:loading.remove wire:target="sendPromotion" class="mt-4">
                Send Mail
            </span>
            <span wire:loading wire:target="sendPromotion" class="flex items-center">
                Sending...
                
            </span>
        </x-filament::button>
        
    </form>
</x-filament-panels::page>
