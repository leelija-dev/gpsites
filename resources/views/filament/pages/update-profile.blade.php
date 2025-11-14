<x-filament::page>
    

    <div class="mb-6">
        <p><strong>Name:</strong> {{ Auth::guard('admin')->user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::guard('admin')->user()->email }}</p>
        <p><strong>Joining Date:</strong> {{ Auth::guard('admin')->user()->created_at->format('d.m.Y,H:i a')  }}</p>
        
    </div>

    <div class="flex space-x-4">
        <a href="{{ url('admin/profile/edit') }}">
            <x-filament::button color="primary">Edit </x-filament::button>
        </a>

        <a href="{{url('admin/profile/password')}}">
            <x-filament::button >Update Password</x-filament::button>
        </a>
    </div>
</x-filament::page>
