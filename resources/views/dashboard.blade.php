<x-app-layout>

    
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Responsive Sidebar Menu</title>
    </head>
    <body>
   
    <div class="py-12">
        <div class="w-64 border-r p-4">
                    @include('web.sidebar')
                </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">

                <!-- Sidebar -->
                
               

                <!-- Main content -->
                {{-- <div class="flex-1 p-6">
                    {{ __("You're logged in!") }}
                </div> --}}

            </div>
        </div>
    </div>
     </body>
</html>
</x-app-layout>
