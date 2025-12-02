<x-filament-panels::page>
   
      <table class="w-full text-left border" style="background-color: white; padding-left:5%">
            <thead> 
                <tr class="bg-gray-200 ml-2 text-center" style="border-bottom: 1px solid #ddd;padding-left:5%">
                    <th class="p-2 border text-center">SL No</th>
                   {{-- <th class="p-2 border text-center">Email</th> --}}
                   <th class="p-2 border text-center">Site URL</th>
                    <th class="p-2 border">Subject</th>
                    <th class="p-2 border">Message</th>
                    <th class="p-2 border">File</th>
                    <th class="p-2 border">Sent at</th>
                    
                </tr>
            </thead>
          
            <tbody class="ml-2">
                @if ($this->getLogs()->isNotEmpty())
                    @foreach ($this->getLogs() as $user_mail)
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="p-2 border text-center">{{ $user_mail->site_url  ?? ''}}</td>
                            <td class="p-2 border text-center">
                            @if(strlen($user_mail->subject) > 20)
                                {{substr($user_mail->subject, 0, 8) . '...' .  substr($user_mail->subject, -8) ?? '' }}
                            @else
                                {{ $user_mail->subject }}
                            @endif
                            </td>
                            <td class="p-2 border text-center">
                                @php $message = strip_tags($user_mail->message) @endphp
                                @if(strlen( $message )>20)
                                    {{  substr($message, 0, 8) . '...' . substr($message, -8) ?? ''  }}
                                @else
                                    {{ $message }}
                                @endif
                                </td>
                            <td class="p-2 border">
                           @if($user_mail->file)
                        @php
                            // Remove wrong public/ prefix if exists
                            $fileName = str_replace('public/', '', $user_mail->file);
                        @endphp

                        <a href="{{ asset($fileName) }}"
                        download
                        class="text-blue-600 hover:text-blue-800 underline">
                           {{$fileName}}
                        </a>
                    @else
                        <span class="text-gray-500">No File</span>
                    @endif
                                            </td>

                            <td class="p-2 border">{{ $user_mail->created_at->format('d M Y ') ?? '' }}</td> 
                                                   
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center p-4 font-semibold text-gray-600">
                            No mail history found.
                        </td>
                    </tr>


                @endif
                  </tbody>
            
        </table>
        <div class="mt-4">
   
     
</div>
  
</x-filament-panels::page>
