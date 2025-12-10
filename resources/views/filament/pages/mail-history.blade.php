
    <x-filament::page>

    <style>
        .space-y-4>*+* {
            margin-top: 1rem;
        }

        .space-y-3>*+* {
            margin-top: 0.75rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .text-muted {
            font-size: 14px;
            font-weight: 500;
        }

        .text-small {
            font-size: 14px;
        }

        /* New class for the right column layout */
        .right-column-layout {
            display: grid;
            grid-template-rows: auto auto;
            gap: 16px;
            height: fit-content;
        }

        /* Table styling for proper spacing */
        .table-proper-spacing {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-proper-spacing th,
        .table-proper-spacing td {
            padding: 12px 16px;
            text-align: left;
            vertical-align: middle;
        }

        .table-proper-spacing th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-proper-spacing td {
            border-bottom: 1px solid #e5e7eb;
        }

        .table-proper-spacing tbody tr:hover {
            background-color: #f9fafb;
        }

        .dark .table-proper-spacing th {
            background-color: #1f2937;
            border-bottom: 2px solid #374151;
            color: #d1d5db;
        }

        .dark .table-proper-spacing td {
            border-bottom: 1px solid #374151;
            color: #e5e7eb;
        }

        .dark .table-proper-spacing tbody tr:hover {
            background-color: #374151;
        }
    </style>
     <x-filament::section>
    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="table-proper-spacing">
        <thead>
            <tr >
                <th  class="min-w-[150px]">SL No</th>
                <th  class="min-w-[150px]">Email</th>
                <th  class="min-w-[150px]">Subject</th>
                
                <th class="min-w-[150px]">Message</th>
                <th class="min-w-[150px]">Status</th>
                <th class="min-w-[150px]">Sent At</th>
                <th class="min-w-[150px]">Action</th>
            </tr>
        </thead>
        <tbody class="ml-2">
            @if($this->getLogs()->isNotEmpty())
            @foreach($this->getLogs() as $promotional_mail)
                <tr >
                    <td class="truncate max-w-[150px]">{{ $loop->iteration }}</td>
                    <td class="truncate max-w-[150px]">{{ $promotional_mail->email }}</td>
                    <td class="truncate max-w-[150px]">
                        @if(strlen($promotional_mail->subject)>20)
                        {{substr($promotional_mail->subject,0,8).'...'.substr($promotional_mail->subject,-8)}}
                        @else
                        {{ $promotional_mail->subject }}
                        @endif
                    </td>
                   <td class="truncate max-w-[150px]">
                        @php $messages=strip_tags( $promotional_mail->message)   @endphp
                        @if(strlen( $messages )>20)
                        {{substr($messages ,0,10).'...'.substr( $messages,-8)}}
                        @else
                        {{ $messages  }}
                        @endif
                    </td>
                   <td class="truncate max-w-[150px]">
                        <span class="px-2 py-1 rounded text-white
                            {{ $promotional_mail->status == 1 ? 'bg-green-600' : 'bg-red-600' }}">
                            {{ $promotional_mail->status == 1 ? 'Sent' : 'Failed' }}
                        </span>
                    </td>
                    <td class="truncate max-w-[150px]">{{ $promotional_mail->created_at->format('d M Y ') }}</td>
                   
                        <td class="truncate max-w-[150px]">
                            <a href="{{ url('admin/view-mail?id=' . $promotional_mail->id) }}"
                            class="text-blue-600 hover:text-blue-800">
                                <x-filament::icon icon="heroicon-o-eye" class="w-5 h-5" />
                            </a>
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
    </div>
     </x-filament::section>

</x-filament::page>


