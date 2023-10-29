<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('libs/toastr/build/toastr.min.js') }}"></script>

<!-- Sweet Alerts js -->
<script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('libs/prism/prism.js') }}"></script>

<!-- Custom Script Global -->
<script>
// Logout function
function logout() {
    Swal.fire({
        icon: 'warning',
        title: 'Logout',
        text: 'Apakah kamu yakin ingin logout?',
        showCancelButton: true,
        confirmButtonText: 'Logout',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {
            // Handle the logout logic here, e.g., trigger a form submission or AJAX request
            $.ajax({
                type: 'POST',
                url: '/logout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Logout Failed',
                        text: 'An error occurred during the logout process.'
                    });
                }
            });
        }
    });
}

function modalDelete(title, name, url, redirect_link) {
    Swal.fire({
        title: `Hapus ${title}?`,
        text: `Apakah kamu yakin ingin menghapus ${name}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: 'DELETE',
            url,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_method": 'delete',
                "_token": "{{ csrf_token() }}"
            },
            success: function (data) {
                window.location.href = redirect_link;
            },
            error: function (data) {
                Swal.fire('Gagal!', 'Gagal menghapus.', 'error');
            }
        });
    }
    });
}

toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: 300,
    hideDuration: 1000,
    timeOut: 5000,
    extendedTimeOut: 1000,
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
}
</script>

@if (session('success'))
    <script>toastr["success"]("{{ session('success') }}", "Success")</script>
@elseif (session('error'))
    <script>toastr["error"]("{{ session('error') }}", "Error")</script>
@endif

<!-- Custom Script -->
@stack('script')
