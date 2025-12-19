@extends('layouts.app')

@section('title','Mail Setting')
@section('content')

    <div class="min-h-screen bg-gray-50">
        <!-- Main Content -->
        <div class="p-6 lg:p-10">
            <div class="max-w-16xl mx-auto">


                <!-- Table Container -->
                <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                            <div class="px-2 py-3 sm:px-6 flex justify-end">
                               <a href="{{ route('add-mail') }}" 
                                class="btn btn-primary flex items-center justify-center" 
                                style="height: 40px; width: 150px;">
                                Add Mail
                                </a>

                            </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#f0f0f0] text-[#575757]">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">SL No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Mail</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Encryption</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Set as Primary</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                @if($emails->isNotEmpty())
                                @foreach($emails as $email)
                                <tr class="hover:bg-gray-50">
                                    
                                    <td class="px-6 py-4 text-center text-gray-600">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-left text-gray-800">
                                        <div>{{ $email->email }}</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $email->smtp_host }}
                                        </div>
                                    </td>



                                    <td class="px-6 py-4 text-center text-gray-600">
                                        <div>
                                            {{$email->smtp_encryption}}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $email->created_at->format('d-m-Y') }}
                                        </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                            class="sr-only peer primary-toggle" 
                                            data-email-id="{{ $email->id }}"
                                            data-is-primary="{{ $email->is_primary }}"
                                            {{ $email->is_primary ? 'checked' : '' }}>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer-checked:bg-green-600 
                                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                                            after:bg-white after:border-gray-300 after:border after:rounded-full 
                                                            after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                                            </label>
                                        </td>



                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex space-x-3 justify-center items-center">
                                            
                                            <a href="{{route('edit-mail-setting',base64_encode($email->id))}}" class="text-blue-500 hover:text-blue-700">
                                                <i class="fa fa-edit t"></i>
                                            </a>
                                            <a href="#"
                                                data-url="{{ route('mail-delete', base64_encode($email->id)) }}"
                                                class="text-red-500 hover:text-red-700 delete-btn">
                                                    <i class="fa fa-trash ms-4"></i>
                                                </a>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" class="p-4 text-center">Email have not been added yet!
                                    </td>
                                </tr>
                                @endif  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.primary-toggle');
    const loggedInEmailId = {{ auth()->user()->id }}; // ID of logged-in user's email

    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const emailId = this.dataset.emailId;
            const isChecked = this.checked ? 1 : 0;

            // Uncheck all other toggles if this one is checked
            if (isChecked) {
                toggles.forEach(t => {
                    if (t !== this) t.checked = false;
                });
            } else {
                // If all unchecked, check logged-in user toggle
                const anyChecked = Array.from(toggles).some(t => t.checked);
                if (!anyChecked) {
                    const userToggle = document.querySelector(`.primary-toggle[data-email-id="${loggedInEmailId}"]`);
                    if (userToggle) userToggle.checked = true;
                }
            }

            // Send AJAX request to update DB instantly
            fetch("{{ route('setPrimary') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email_id: emailId,
                    is_primary: isChecked
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
        Toast.fire({
            icon: 'success',
            title: 'Primary set successfully'
        });
    } else {
        Toast.fire({
            icon: 'error',
            title: 'Failed to set primary '
        });
    }
            })
            .catch(err => console.error(err));
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    @if (session('success'))
        Swal.fire({
            toast: true,
            icon: 'success',
            title: "{{ session('success') }}",
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if (session('error'))
        Swal.fire({
            toast: true,
            icon: 'error',
            title: "{{ session('error') }}",
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });
    @endif

    @if (session('warning'))
        Swal.fire({
            toast: true,
            icon: 'warning',
            title: "{{ session('warning') }}",
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });
    @endif

});
</script>

<script>
    
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const url = this.dataset.url;

            Swal.fire({
                title: 'Are you sure?',
                text: "This record will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Record deleted successfully',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Unable to delete record', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    });

                }
            });
        });
    });

});
</script>




@endsection
