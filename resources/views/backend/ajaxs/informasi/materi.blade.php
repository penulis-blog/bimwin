<script type="text/javascript">
    window.onload = function() {
        $('.stat_ket').hide();
        $('.tutupPhoto').hide();
        $('.tutupdetail').hide();
        $('#contentphoto').hide();
        $('#contentphoto2').hide();
    };

    $(document).ready(function () {
        $('#materiTable').DataTable({
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
                            $('#tambahMateri').modal('show').one('shown.bs.modal', function () {
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
            "ajax": "{{ route('materi.table') }}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "ktgr" },
                { "data": "judul" },
                { "data": "keterangan" },
                { "data": "pranala" },
                { "data": "stat" },
                { "data": "aksi" },
            ]
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_materi");
        const loaderModal = new bootstrap.Modal(document.getElementById("Loader"), {
            backdrop: "static",
            keyboard: false
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            // Validasi
            const mt_ktgr = formData.get("mt_ktgr")?.trim();
            const mt_jdl = formData.get("mt_jdl")?.trim();
            const mt_ktrgn = formData.get("mt_ktrgn")?.trim();
            const mt_url = formData.get("mt_url")?.trim();
            const token = formData.get("_token")?.trim();

            if (!mt_ktgr || mt_ktgr === "Pilih") return showError("Maaf, kategori harus dipilih.");
            if (!mt_jdl) return showError("Maaf, judul harus diisi.");
            if (!mt_ktrgn) return showError("Maaf, deskripsi harus diisi.");
            if (!mt_url) return showError("Maaf, url/pranala harus diisi.");
            if (!token) return showError("Token harus diisi.");

            try {

                // TUTUP modal input
                hideModal("tambahMateri");

                // TAMPILKAN Loader modal Bootstrap
                loaderModal.show();

                const response = await fetch("{{ url('297f5ccf-71f1-495d-aa65-03e70a79b5f2') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, gagal simpan data.", "error");
                    showModal("tambahMateri");
                } else {
                    Swal.fire("Error", "Maaf, terjadi kesalahan", "error");
                    showModal("tambahMateri");
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
                url: "{{ url('ab16e5cc-cba8-4c0e-a190-6441fc8da6bf') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#editMateri').modal('show');
                    $('#e_mt_publicid').attr('value', response.data.public_id);
                    const validGolongan = [
                        1, 2
                    ];
                    if (validGolongan.includes(response.data.kategori)) {
                        document.getElementById('e_mt_ktgr').value = response.data.kategori;
                    }
                    $('textarea#e_mt_jdl').val(response.data.judul);
                    $('textarea#e_mt_ktrgn').val(response.data.keterangan);
                    $('#e_mt_url').attr('value', response.data.pranala);
                    const validStatus = [
                        11, 12
                    ];
                    if (validStatus.includes(response.data.is_trash)) {
                        document.getElementById('e_mt_stat').value = response.data.is_trash;
                    }
                }
            });
        }
    }

    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_edit_materi");

        // Modal Loader instance (Bootstrap)
        const loaderModal = new bootstrap.Modal(document.getElementById("Loader"), {
            backdrop: "static",
            keyboard: false
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            // Validasi
            const e_mt_publicid = formData.get("e_mt_publicid")?.trim();
            const e_mt_ktgr = formData.get("e_mt_ktgr")?.trim();
            const e_mt_jdl = formData.get("e_mt_jdl")?.trim();
            const e_mt_ktrgn = formData.get("e_mt_ktrgn")?.trim();
            const e_mt_url = formData.get("e_mt_url")?.trim();
            const e_mt_stat = formData.get("e_mt_stat")?.trim();
            const token = formData.get("_token")?.trim();

            if (!e_mt_ktgr || e_mt_ktgr === "Pilih") return showError("Maaf, kategori harus dipilih.");
            if (!e_mt_jdl) return showError("Maaf, judul harus diisi.");
            if (!e_mt_ktrgn) return showError("Maaf, deskripsi harus diisi.");
            if (!e_mt_url) return showError("Maaf, url/pranala harus diisi.");
            if (!e_mt_stat || e_mt_stat === "Pilih") return showError("Maaf, status data harus dipilih.");
            if (!token) return showError("Token harus diisi.");

            try {

                // TUTUP modal input
                hideModal("editMateri");
                loaderModal.show();

                const response = await fetch("{{ url('2737bec7-d980-4e4a-b722-cb253691fb36') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, gagal perbaharui data.", "error");
                    showModal("editMateri");
                } else {
                    Swal.fire("Error", "Maaf, terjadi kesalahan", "error");
                    showModal("editMateri");
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
                url: "{{ url('ef06dcff-a35c-4a3c-be48-5cb0f798c576') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#detailMateri').modal('show');
                    $('#d_mt_ktgr').text(response.data.ktgr);
                    $('#d_mt_jdl').text(response.data.judul);
                    $('#d_mt_desc').text(response.data.keterangan);
                    $('#d_mt_url').text(response.data.pranala);
                    $('#d_mt_stat').text(response.data.stat);
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
                        url: "{{ url('d851b76d-53ad-4279-bc03-32f8a4e24902') }}",
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
                $('#tambahMateri').modal('hide');
                $('#detailMateri').modal('hide');
                $('#editMateri').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

    $(function(){
        $("input[name='mt_url']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/]/g, ''));
        });
        $("textarea[name='mt_jdl']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/|&"' ]/g, ''));
        });
        $("textarea[name='mt_ktrgn']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/|&"' ]/g, ''));
        });
        $("input[name='e_mt_url']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/]/g, ''));
        });
        $("textarea[name='e_mt_jdl']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/|&"' ]/g, ''));
        });
        $("textarea[name='e_mt_ktrgn']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/|&"' ]/g, ''));
        });
    });
</script>