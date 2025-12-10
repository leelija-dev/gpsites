@extends('layouts.web.main-layout')

@section('title', 'Find Blog')
@section('description', '')
@section('indexing', 'no')

@section('content')

    <section class="bg-white">
        <div class="  p-6 container mx-auto">
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full table-auto">
                    <thead class="bg-gradient-to-r from-primary to-purple-600 text-white text-sm">
                        <tr>
                            <th class="px-4 py-3">Sl No</th>
                            <th class="px-4 py-3"></th>
                            <th class="px-4 py-3 text-center">Metrics</th>
                            <th class="px-4 py-3">Traffic</th>
                            <th class="px-4 py-3">Mail</th>
                        </tr>
                    </thead>

                    <tbody class="text-center divide-y divide-gray-100">
                        @if ($pagination->isNotEmpty())
                            @foreach ($pagination as $blog)
                                <!-- Row -->
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        <div class="flex items-start gap-3">

                                            <div>
                                                <div class="font-semibold text-gray-900">
                                                    {{ $blog['website_name'] ?? '' }}
                                                </div>

                                                <a href="{{ $blog['site_url'] ?? '' }}"
                                                    class="text-blue-600 text-xs break-all flex items-center gap-1"
                                                target="_blank">
                                                     <img src="https://thumbs.dreamstime.com/b/chain-link-icon-isolated-white-background-chain-link-icon-trendy-design-style-chain-link-vector-icon-modern-simple-flat-183702536.jpg"
                                                        style="height:14px; width:14px;" />
                                                    {{ $blog['site_url'] ?? '' }}
                                                </a>
                                            </div>
                                        </div>
                                    {{-- <td class="px-4 py-3">
                                        {{ is_array($blog['website_niche'])
                                            ? implode(', ', $blog['website_niche'])
                                            : implode(', ', json_decode($blog['website_niche'], true) ?? []) }}
                                    </td> --}}
                                    <td class="px-4 py-4 " style="min-width: 200px;">
                                        <div class="text-xs flex flex-col  space-y-2">

                                            <!-- DA Row -->
                                            <div class="flex items-center gap-2 " style="margin-left:30%; ">
                                                <img style="height: 20px; width: 20px;"
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAMAAABF0y+mAAAAOVBMVEVNvetVv+xfwuxEuuqt3/X////z+/6/5vhmxe2o3fT5/f7M6/m54/ea2fSM1PKs4PXl9fx4y++f2vQMWunWAAAAhElEQVR4Ad3RxxXDMAwEUTCMJK7E5P57dc6mGxBu8/5tYTs75713fzJEmOblkcs8QQwPTAJWfyu/AkqfqO2qftMAUXRmLooRomyWxRihFBigagMkoFV9Y+kXvVgvvxjyBDDlMELLAmX7wgic0RIkOyNvC1nPh3xdr9brfufsgw842+mdAC4OBqWvVW0xAAAAAElFTkSuQmCC">

                                                <span class="font-medium text-gray-900">Domain Authority:</span>
                                                <strong class="blur-sm select-none no-copy">{{ $blog['moz_da'] ?? '' }}</strong>
                                            </div>

                                            <!-- DR Row -->
                                            <div class="flex items-center gap-2 " style="margin-left:30%; ">
                                                <img style="height: 20px; width: 20px;"
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAMAAABF0y+mAAAAOVBMVEVNvetVv+xfwuxEuuqt3/X////z+/6/5vhmxe2o3fT5/f7M6/m54/ea2fSM1PKs4PXl9fx4y++f2vQMWunWAAAAhElEQVR4Ad3RxxXDMAwEUTCMJK7E5P57dc6mGxBu8/5tYTs75713fzJEmOblkcs8QQwPTAJWfyu/AkqfqO2qftMAUXRmLooRomyWxRihFBigagMkoFV9Y+kXvVgvvxjyBDDlMELLAmX7wgic0RIkOyNvC1nPh3xdr9brfufsgw842+mdAC4OBqWvVW0xAAAAAElFTkSuQmCC">

                                                <span class="font-medium text-gray-900">Domain Rating:</span>
                                                <strong class="blur-sm select-none no-copy">{{ $blog['ahrefs_dr'] ?? '' }}</strong>
                                            </div>

                                        </div>
                                    </td>


                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        <div class="flex items-center gap-2 justify-center">
                                            <img src="https://t3.ftcdn.net/jpg/15/13/55/86/360_F_1513558693_ew5p2ThohA8SgdS0IiL4fHgWdrqncsmA.jpg"
                                                style="width:20px; height:20px;" alt="Icon">

                                            <span class="font-medium text-gray-900">Ahrefs Traffic:</span>

                                            <strong class="blur-sm select-none no-copy">{{ $blog['ahrefs_traffic'] ?? '' }}</strong>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        <a href="{{ route('blog.viewMail', encrypt($blog['blog_id'])) }}"><button
                                                class="bg-primary hover:bg-purple-800 text-white text-xs font-semibold px-3 py-2 rounded-xl shadow-md transition">
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
            <div class="text-center mt-2"><a href="{{ route('blog.index') }}"><button class="btn-primary">View
                        more</button></a>
            </div>
        </div>
    </section>




    </script>
@endsection
