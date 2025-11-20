
    <x-filament::page>
   

    <table class="w-full text-left border" style="background-color: white;">
        <thead>
            <tr class="bg-gray-200 ml-2 text-center" style="border-bottom: 1px solid #ddd;">
                <th class="p-2 border text-center">SL No</th>
                <th class="p-2 border text-center">Email</th>
                <th class="p-2 border">Subject</th>
                
                <th class="p-2 border">Message</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Sent At</th>
                <th class="p-2 border">Action</th>
            </tr>
        </thead>
        <tbody class="ml-2">
            @if($this->getLogs()->isNotEmpty())
            @foreach($this->getLogs() as $promotional_mail)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                    <td class="p-2 border text-center">{{ $promotional_mail->email }}</td>
                    <td class="p-2 border text-center">
                        @if(strlen($promotional_mail->subject)>20)
                        {{substr($promotional_mail->subject,0,8).'...'.subdtr($promotional_mail->subject,-8)}}
                        @else
                        {{ $promotional_mail->subject }}
                        @endif
                    </td>
                    <td class="p-2 border text-center">
                        @php $messages=strip_tags( $promotional_mail->message)   @endphp
                        @if(strlen( $messages )>20)
                        {{substr($messages ,0,10).'...'.substr( $messages,-8)}}
                        @else
                        {{ $messages  }}
                        @endif
                    </td>
                    <td class="p-2 border text-center">
                        <span class="px-2 py-1 rounded text-white
                            {{ $promotional_mail->status == 1 ? 'bg-green-600' : 'bg-red-600' }}">
                            {{ $promotional_mail->status == 1 ? 'Sent' : 'Failed' }}
                        </span>
                    </td>
                    <td class="p-2 border">{{ $promotional_mail->created_at->format('d M Y ') }}</td>
                    <td class="p-2 border text-center">
                        <td class="p-2 border text-center">
                            <a href="{{ url('admin/view-mail?id=' . $promotional_mail->id) }}"
                            class="text-blue-600 hover:text-blue-800">
                                <x-filament::icon icon="heroicon-o-eye" class="w-5 h-5" />
                            </a>
                        </td>


                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="7" class="p-4 text-center">No mail history found.</td>
                </tr>
            @endif
        </tbody>
    </table>

</x-filament::page>


