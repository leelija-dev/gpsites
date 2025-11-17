
    <x-filament::page>
   

    <table class="w-full text-left border" style="background-color: white;">
        <thead>
            <tr class="bg-gray-200 ml-2 text-center" style="border-bottom: 1px solid #ddd;">
                <th class="p-2 border text-center">SL No</th>
                <th class="p-2 border text-center">Email</th>
                <th class="p-2 border">Subject</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Message</th>
                <th class="p-2 border">Sent At</th>
                <th class="p-2 border">Action</th>
            </tr>
        </thead>
        <tbody class="ml-2">
            @foreach($this->getLogs() as $log)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                    <td class="p-2 border text-center">{{ $log->email }}</td>
                    <td class="p-2 border text-center">{{ $log->subject }}</td>
                    <td class="p-2 border text-center">{{ $log->message }}</td>
                    <td class="p-2 border text-center">
                        <span class="px-2 py-1 rounded text-white
                            {{ $log->status == 1 ? 'bg-green-600' : 'bg-red-600' }}">
                            {{ $log->status == 1 ? 'Sent' : 'Failed' }}
                        </span>
                    </td>
                    <td class="p-2 border">{{ $log->created_at->format('d M Y ') }}</td>
                    <td class="p-2 border"><i class="fa fa-eye"></i></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-filament::page>


