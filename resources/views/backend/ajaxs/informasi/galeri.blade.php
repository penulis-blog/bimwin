<script type="text/javascript">
    window.onload = function() {
        $('.stat_ket').hide();
        $('.tutupPhoto').hide();
        $('.tutupdetail').hide();
        $('#contentphoto').hide();
        $('#contentphoto2').hide();
    };

    $(document).ready(function () {
        $('#galeriTable').DataTable({
            fixedColumns: {
                left: 1,
                right: 1
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 415,
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Tambah Data',
                    action: function (e, dt, node, config) {
                        var tambah = {{ get_add() }};
                        if (tambah == 1) {
                            $('#tambahGaleri').modal('show').one('shown.bs.modal', function () {
                                $(this).removeAttr('tabindex');
                            });
                        } else if (tambah == 0) {
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Anda tidak diberi akses penambahan data.",
                                icon: "warning",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                }, {
                    text: 'Laporan',
                    action: function (e, dt, node, config) {
                        var laporan = {{ get_laporan() }};
                        if (laporan == 1) {
                            $('#laporanMenu').modal('show');
                        } else if (laporan == 0) {
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Anda tidak diberi akses unduh laporan.",
                                icon: "warning",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                }
            ],
            'processing': true,
            'serverSide': true,
            'deferRender': true,
            'pageLength': 9,
            "ajax": "{{ route('galeri.table') }}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "judul" },
                { "data": "deskripsi" },
                { "data": "ktgr" },
                { "data": "stat" },
                { "data": "aksi" },
            ]
        });
    });

    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_galeri");

        // Modal Loader instance (Bootstrap)
        const loaderModal = new bootstrap.Modal(document.getElementById("Loader"), {
            backdrop: "static",
            keyboard: false
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            // Validasi
            const gl_ktgr = formData.get("gl_ktgr")?.trim();
            const gl_jdl = formData.get("gl_jdl")?.trim();
            const gl_desc = formData.get("gl_desc")?.trim();
            const gl_url = formData.get("gl_url")?.trim();
            const gl_files = formData.get("gl_files");
            const token = formData.get("_token")?.trim();

            if (!gl_ktgr || gl_ktgr === "Pilih") return showError("Maaf, kategori harus dipilih.");
            if (!gl_jdl) return showError("Maaf, judul harus diisi.");
            if (!gl_desc) return showError("Maaf, deskripsi harus diisi.");
            if (!gl_url) return showError("Maaf, url/pranala harus diisi.");
            if (!gl_files?.name) return showError("Maaf, dokumen harus diisi.");
            if (!token) return showError("Token harus diisi.");

            try {

                // TUTUP modal input
                hideModal("tambahGaleri");

                // TAMPILKAN Loader modal Bootstrap
                loaderModal.show();

                const response = await fetch("{{ url('0c55e5b0-6d1b-4a98-a2a6-b5b0a3920cfe') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, '"+result.errors+"'.", "error");
                    showModal("tambahGaleri");
                } else {
                    Swal.fire("Error", result.error ?? "Terjadi kesalahan", "error");
                    showModal("tambahGaleri");
                }

            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                loaderModal.hide(); // Sembunyikan loader
            }
        });

        // FUNGSI BANTU
        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

        function showModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.show();
            }
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.hide();
            }
        }
    });

    Page.Status = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            if(val == 3){
                $('.stat_ket').show();
            }else{
                $('.stat_ket').hide();
            }
        }
    }

    Page.Edit = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            $.ajax({
                url: "{{ url('c0d7e04c-0195-4776-84c0-2d9756597b74') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#editGaleri').modal('show');
                    $('#e_gl_publicid').attr('value', response.data.public_id);
                    const validGolongan = [
                        1, 2, 3, 4
                    ];
                    if (validGolongan.includes(response.data.kategori)) {
                        document.getElementById('e_gl_ktgr').value = response.data.kategori;
                    }
                    if(response.data.kategori == 3){
                        $('.stat_ket').show();
                    }
                    $('textarea#e_gl_jdl').val(response.data.judul);
                    $('textarea#e_gl_desc').val(response.data.deskripsi);
                    $('#e_gl_url').attr('value', response.data.pranala);
                    $('#e_files_old').attr('value', response.data.files);
                    $('#lihatfile').attr('value', response.data.files);
                    const validStatus = [
                        11, 12
                    ];
                    if (validStatus.includes(response.data.is_trash)) {
                        document.getElementById('e_gl_stat').value = response.data.is_trash;
                    }
                }
            });
        }
    }

    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_edit_galeri");

        // Modal Loader instance (Bootstrap)
        const loaderModal = new bootstrap.Modal(document.getElementById("Loader"), {
            backdrop: "static",
            keyboard: false
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            // Validasi
            const e_gl_publicid = formData.get("e_gl_publicid")?.trim();
            const e_gl_ktgr = formData.get("e_gl_ktgr")?.trim();
            const e_gl_jdl = formData.get("e_gl_jdl")?.trim();
            const e_gl_desc = formData.get("e_gl_desc")?.trim();
            const e_gl_url = formData.get("e_gl_url")?.trim();
            const e_gl_files = formData.get("e_gl_files");
            const e_gl_stat = formData.get("e_gl_stat")?.trim();
            const token = formData.get("_token")?.trim();

            if (!e_gl_ktgr || e_gl_ktgr === "Pilih") return showError("Maaf, kategori harus dipilih.");
            if (!e_gl_jdl) return showError("Maaf, judul harus diisi.");
            if (!e_gl_desc) return showError("Maaf, deskripsi harus diisi.");
            if (!e_gl_url) return showError("Maaf, url/pranala harus diisi.");
            if (!e_gl_stat || e_gl_stat === "Pilih") return showError("Maaf, status data harus dipilih.");
            if (!token) return showError("Token harus diisi.");

            try {

                // TUTUP modal input
                hideModal("editGaleri");
                loaderModal.show();

                const response = await fetch("{{ url('671ad4de-a758-4161-bc7c-1673bc61acdb') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, '"+result.errors+"'.", "error");
                    showModal("editGaleri");
                } else if (result.message === 500) {
                    Swal.fire("Error", "Maaf, '"+result.errors+"'.", "error");
                    showModal("editGaleri");
                } else {
                    Swal.fire("Error", result.error ?? "Terjadi kesalahan", "error");
                    showModal("editGaleri");
                }

            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                loaderModal.hide(); // Sembunyikan loader
            }
        });

        // FUNGSI BANTU
        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

        function showModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.show();
            }
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.hide();
            }
        }
    });

    Page.EStatus = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            if(val == 3){
                $('.stat_ket').show();
            }else{
                $('.stat_ket').hide();
            }
        }
    }

    Page.Lihat = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            $('.lihatPhoto').hide();
            $('.tutupPhoto').show();
            $('#contentphoto').show('slow');
            $("#gambar_galeri").attr("src", "{{ url('storage/') }}/" + val);
        }
    }
    
    Page.LihatDetail = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            $('.lihatdetail').hide();
            $('.tutupdetail').show();
            $('#contentphoto2').show('slow');
            $("#detail_galeri").attr("src", "{{ url('storage/') }}/" + val);
        }
    }

    Page.Tutup = function()
    {
        $('.lihatPhoto').show();
        $('.tutupPhoto').hide();
        $('.lihatdetail').show();
        $('.tutupdetail').hide();
        $('#contentphoto').hide('slow');
        $('#contentphoto2').hide('slow');
    }

    Page.Detail = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            $.ajax({
                url: "{{ url('43e567cf-ccb3-4630-902e-39551611c036') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#detailGaleri').modal('show');
                    $('#d_gl_ktgr').text(response.data.ktgr);
                    $('#d_gl_jdl').text(response.data.judul);
                    $('#d_gl_desc').text(response.data.deskripsi);
                    $('#d_gl_url').text(response.data.pranala);
                    $("#d_galeri").attr('value', response.data.files);
                    $('#d_gl_stat').text(response.data.meta_tags);
                }
            });
        }
    }

    Page.Delete = function(val)
    {
        if(val == '' || val == null || val == 0){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            var a = val;
            var e = $('input[name="_token"]').val();

            Swal.fire({
                title: 'Apa Kamu Yakin?',
                text: "Data akan masuk status nonaktif.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value == true) {
                    $.ajax({
                        url: "{{ url('9d7059c3-cc02-47bf-b9d8-96f8b7da692f') }}",
                        type: 'POST',
                        data: {val:a, _token:e},
                        success: function(response){
                            if(response.message == 200){
                                Swal.fire("Berhasil", "Data berhasil di nonaktifkan.","success").then( () => {location.href = location.pathname;});
                            }else if(response.message == 201){
                                Swal.fire({
                                    title: "Informasi",
                                    text: "Maaf, Terjadi kesalahan saat menghapus.",
                                    icon: "error",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonText: "OK"
                                });
                            }
                        }
                    });
                }else{
                    Swal.fire('Informasi', 'Data tidak jadi di hapus.', 'info');
                }
            });
        }
    }

    Page.Batal = function()
    {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahGaleri').modal('hide');
                $('#detailGaleri').modal('hide');
                $('#editGaleri').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

    $(function(){
        $("input[name='gl_url']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/]/g, ''));
        });
        $("textarea[name='gl_jdl']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/|&"' ]/g, ''));
        });
        $("textarea[name='gl_desc']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/|&"' ]/g, ''));
        });
        $("input[name='e_gl_url']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/]/g, ''));
        });
        $("textarea[name='e_gl_jdl']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/|&"' ]/g, ''));
        });
        $("textarea[name='e_gl_desc']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/|&"' ]/g, ''));
        });
    });
</script>