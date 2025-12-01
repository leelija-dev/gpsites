@extends('layouts.web.main-layout')

@section('title', 'home-page')

@section('content')

<div class="bg-white shadow-xl rounded-xl p-6">
    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="min-w-full table-auto">
            <thead class="bg-gradient-to-r from-primary to-purple-600 text-white text-sm">
                <tr>
                    
                    {{-- <th class="px-4 py-3">ID</th> --}}
                    <th class="px-4 py-3">Website Name</th>
                    <th class="px-4 py-3">Site URL</th>
                    <th class="px-4 py-3">Niche</th>
                    <th class="px-4 py-3">DA</th>
                    <th class="px-4 py-3">DR</th>
                    <th class="px-4 py-3">Traffic</th>
                    <th class="px-4 py-3">Mail</th>
                </tr>
            </thead>

            <tbody class="text-center divide-y divide-gray-100">
                @if ($pagination->isNotEmpty())
                    @foreach ($pagination as $blog)
                        <!-- Row -->
                        <tr class="hover:bg-gray-50 transition">
                            
                           

                            {{-- <td class="px-4 py-3 font-semibold text-gray-900">
                                #{{ $blog['blog_id'] }}
                            </td> --}}

                            <td class="px-4 py-3 font-medium text-gray-700">
                                {{ $blog['website_name'] ?? '' }}
                            </td>

                            <td class="px-4 py-3">
                                 {{ $blog['site_url'] ?? '' }}
                            </td>

                            <td class="px-4 py-3">{{ $blog['website_niche'] ?? '' }}</td>
                            <td class="px-4 py-3 blur-sm">{{ $blog['moz_da'] ?? '' }}</td>
                            <td class="px-4 py-3 blur-sm">{{ $blog['ahrefs_dr'] ?? '' }}</td>
                            <td class="px-4 py-3 blur-sm">{{ $blog['ahrefs_traffic'] ?? '' }}</td>

                            <td class="px-4 py-3" >
                            
                                <a href="{{ route('blog.viewMail', encrypt($blog['blog_id'])) }}" ><button class="bg-primary hover:bg-purple-800 text-white text-xs font-semibold px-3 py-2 rounded-xl shadow-md transition">
                                    Send Mail
                                </button></a>
                            </td>
                        </tr>
                        

                       

                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center py-6 text-gray-600 font-semibold">
                            No blogs found.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
    <div class="text-center mt-2"><a href="{{route('blog.index')}}"><button class="btn-primary">View more</button></a>
                        </div></div>
        
    


</script>
@endsection
