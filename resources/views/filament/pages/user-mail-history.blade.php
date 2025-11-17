<x-filament-panels::page>
        <table class="w-full text-left border" style="background-color: white;">
            <thead>
                <tr class="bg-gray-200 ml-2 text-center" style="border-bottom: 1px solid #ddd;">
                    <th class="p-2 border text-center">SL No</th>
                    <th class="p-2 border text-center">Email</th>
                    <th class="p-2 border">Subject</th>

                    <th class="p-2 border">Message</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Sent at</th>
                    <th class="p-2 border">Action</th>
                </tr>
            </thead>
          
            <tbody class="ml-2">
                @if ($this->getLogs()->isNotEmpty())
                    @foreach ($this->getLogs() as $user_mail)
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="p-2 border text-center">{{ $user_mail->email }}</td>
                            <td class="p-2 border text-center">
                            @if(strlen($user_mail->subject)> 20)
                                {{ substr($user_mail->subject, 0, 8) . '...' . substr($user_mail->subject, -8) }}
                            @else
                                {{ $user_mail->subject }}
                            @endif
                            </td>
                            <td class="p-2 border text-center">
                                @if(strlen($user_mail->message)> 30)
                                    {{ substr($user_mail->message, 0, 10) . '...' . substr($user_mail->message, -10) }}
                                @else
                                    {{ $user_mail->message }}
                                @endif
                                </td>
                            <td class="p-2 border text-center">
                                <span
                                    class="px-2 py-1 rounded text-white
                            {{ $user_mail->status == 1 ? 'bg-green-600' : 'bg-red-600' }}">
                                    {{ $user_mail->status == 1 ? 'Sent' : 'Failed' }}
                                </span>
                            </td>
                            <td class="p-2 border">{{ $user_mail->created_at->format('d M Y ') }}</td>
                            <td class="p-2 border text-center">
                            <td class="p-2 border text-center">
                                <a href="{{ url('admin/view-mail?id=' . $user_mail->id) }}"
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
</x-filament-panels::page>
