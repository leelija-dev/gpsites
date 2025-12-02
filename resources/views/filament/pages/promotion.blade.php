<x-filament-panels::page>
    <form wire:submit.prevent="sendPromotion">
        {{ $this->form }}
        <div class="mt-6" style="padding-top:10px">
        <x-filament::button type="submit" class="mt-4">
           <span wire:loading.remove wire:target="sendPromotion" class="mt-4">
                Send Mail
            </span>
            
            <span wire:loading wire:target="sendPromotion" class="flex items-center">
                Sending...
                
            </span>
        </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
