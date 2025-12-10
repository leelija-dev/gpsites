<x-filament-panels::page>
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
                <tr class="bg-gray-200 ml-2 text-center" style="border-bottom: 1px solid #ddd;padding-left:5%">
                    <th class="p-2 border text-center">SL No</th>
                   {{-- <th class="p-2 border text-center">Email</th> --}}
                   <th class="p-2 border text-center">Site URL</th>
                    <th class="p-2 border">Subject</th>
                    <th class="p-2 border">Message</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Error</th>
                    <th class="p-2 border">File</th>
                    <th class="p-2 border">Sent Date</th>

                    
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
                             <td class="pd-2 border text-center">
                                @if((int) $user_mail->status == true)
                                    <x-filament::badge color="success">
                                        Sent
                                    </x-filament::badge>
                                @else
                                   <x-filament::badge color="warning">
                                        Failed
                                    </x-filament::badge>
                                @endif
                            </td>
                            <td class="p-2 border text-center">
                            {{ $user_mail->description ?? '' }}
                            </td>

                            <td class="p-2 border">
                           @if($user_mail->file)
                        @php
                            
                            $fileName = str_replace('public/', '', $user_mail->file);
                        @endphp
                        <x-filament::badge color="success">
                        <a href="{{ asset($fileName) }}"
                        download
                        class="text-blue-600 hover:text-blue-800 underline btn-sm">
                           Download File
                        </a>
                        </x-filament::badge>
                    @else
                        <span class="text-gray-500"></span>
                    @endif
                                            </td>

                            <td class="p-2 border">{{ $user_mail->created_at->format('d-m-Y, h:i A ') ?? '' }}</td> 
                                                   
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center p-4 font-semibold text-gray-600">
                            No mail history found.
                        </td>
                    </tr>


                @endif
                  </tbody>
            
        </table>
        
     </div>
  </x-filament::section>
</x-filament-panels::page>
