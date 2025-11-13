
<x-filament::page>
    

    {{ $this->form }}

    <div class="mt-4 flex space-x-4">
        <x-filament::button wire:click="save">Save</x-filament::button>
        <a href="{{ url('admin/update-profile') }}">
            <x-filament::button color="danger">Cancel</x-filament::button>
        </a>
    </div>
</x-filament::page>
