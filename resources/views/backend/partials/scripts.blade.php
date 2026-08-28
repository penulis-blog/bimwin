    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <script src="/assets/backend/js/adminlte.js"></script>
    {{-- Swal 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- Datatables --}}
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    {{-- Datatables Buttons --}}
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    {{-- Timepicker --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    {{-- Font Awesome --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- CK Editor --}}
    {{-- <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
    
    {{-- Custom --}}
    <script type="text/javascript">
      var Page = {};

      Page.Keluar = function() {
        var out = $('input[name="_token"]').val();
        if (!out) return;
        Swal.fire({
            title: 'Apakah Anda ingin keluar dari aplikasi?',
            text: "Pastikan semua data sudah benar sebelum keluar dari aplikasi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {

            // ❗ gunakan isConfirmed (bukan result.value)
            if (result.isConfirmed) {

                // ✅ TAMPILKAN LOADER (Bootstrap 5)
                var loader = new bootstrap.Modal(document.getElementById('Loader'));
                loader.show();

                $.ajax({
                    url: "{{ url('a38bed7b-6a73-4e14-aa5a-730c045cc09a') }}",
                    type: 'POST',
                    data: {_token: out},

                    success: function(response) {
                        Swal.fire("Berhasil!", "Selamat, Anda telah keluar dari aplikasi.", "success")
                        .then(() => {
                            window.location.href = "{{ url('/') }}";
                        });
                    },

                    error: function() {
                        loader.hide(); // kalau gagal, baru di-hide
                        Swal.fire("Error!", "Terjadi kesalahan saat logout.", "error");
                    }
                });

            } else {
                Swal.fire({
                    title: 'Batal!',
                    text: 'Anda tidak jadi keluar dari aplikasi.',
                    icon: 'info',
                    timer: 2000,
                    showConfirmButton: false
                });
            }

        });
      };
    </script>