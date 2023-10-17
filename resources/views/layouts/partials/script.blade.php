<script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>

<!-- Sweet Alerts js -->
<script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>

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
</script>

<!-- Custom Script -->
@stack('script')
