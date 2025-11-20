<x-filament-panels::page>
  
    <div class="space-y-4 ml-2" style="background-color: white; ">
       <div style="padding-left:50px; padding-top:20px">
        <p><strong class="mt-4" >Email:</strong> {{ $mail->email }}  <span style="padding-left:45%;">{{ ($mail->created_at)->format('d M Y,h:i a') }}</span></p>
        <p style="padding-top:20px"><strong >Subject:</strong> {{ $mail->subject }}</p>
        
        <div class="ml-2 max-w-3xl pd-10" style="padding-top:20px" >
            {{-- <strong>Message:</strong> --}}
            {!! $mail->message !!}
        </div>

        

        <x-filament::button tag="a" href="{{ url()->previous() }}" color="warning" style="margin-top:20px; margin-bottom:10px;">
            Back
        </x-filament::button>
    </div>
    </div>

</x-filament-panels::page>
