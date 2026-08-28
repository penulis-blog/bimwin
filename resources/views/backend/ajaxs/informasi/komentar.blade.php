<script type="text/javascript">
    window.onload = function() {
        $('#induk_komentar').hide();
        $('#induk_komentar_2').hide();
    };

    $(document).ready(function () {
        $('#komentarTable').DataTable({
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
                            $('#tambahKomentar').modal('show').one('shown.bs.modal', function () {
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
            "ajax": "{{ route('komentar.table') }}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "tgl_post" },
                { "data": "judul_berita" },
                { "data": "nama" },
                { "data": "total_like" },
                { "data": "total_unlike" },
                { "data": "is_trash" },
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
                hideModal("tambahKomentar");

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
                    showModal("tambahKomentar");
                } else {
                    Swal.fire("Error", result.error ?? "Terjadi kesalahan", "error");
                    showModal("tambahKomentar");
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

    function indoDate(dateString) {
        if (!dateString) return '-';

        const bulan = [
            "Januari","Februari","Maret","April","Mei","Juni",
            "Juli","Agustus","September","Oktober","November","Desember"
        ];

        // pecah format DD-MM-YYYY
        const parts = dateString.split('-');
        if (parts.length !== 3) return dateString;

        const tgl = parseInt(parts[0]);
        const bln = bulan[parseInt(parts[1]) - 1];
        const thn = parts[2];

        return `${tgl} ${bln} ${thn}`;
    }

    function htmlToTextarea(html) {
        if (!html) return '';

        return html
            .replace(/<br\s*\/?>/gi, "\n")
            .replace(/<\/p>/gi, "\n")
            .replace(/<[^>]+>/g, '')
            .trim();
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
                url: "{{ url('5f674c22-1e3a-48b8-970b-962af84b8c22') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#editKomentar').modal('show');

                    $('#e_komentar').val(response.data.public_id);
                    $('#k_tgl').text(indoDate(response.data.tgl_berita));
                    $('#k_judul').text(response.data.judul_berita);

                    // cek child
                    if (!response.data.child) {
                        $('#induk_komentar').hide();
                        $('#induk_komentar_2').hide();
                    } else {
                        $('#induk_komentar').show();
                        $('#induk_komentar_2').show();

                        // aman dari null
                        if (response.child) {
                            $('#k_dari').text(response.child.nama || '-');
                            $('#k_isi_2').val(htmlToTextarea(response.child.pesan));
                        }
                    }

                    $('#k_oleh').text(response.data.nama);
                    $('#k_like').text(response.data.total_like);
                    $('#k_unlike').text(response.data.total_unlike);
                    $('#k_in').text(indoDate(response.data.tgl_post));
                    $('#k_isi').val(htmlToTextarea(response.data.pesan));

                    const validStatus = [1, 2, 3];
                    if (validStatus.includes(Number(response.data.is_trash))) {
                        $('#k_stat').val(response.data.is_trash);
                    }
                }
            });
        }
    }

    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_edit_komentar");

        // Modal Loader instance (Bootstrap)
        const loaderModal = new bootstrap.Modal(document.getElementById("Loader"), {
            backdrop: "static",
            keyboard: false
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            // Validasi
            const e_komentar = formData.get("e_komentar")?.trim();
            const k_isi = formData.get("k_isi")?.trim();
            const k_isi_2 = formData.get("k_isi_2")?.trim();
            const k_stat = formData.get("k_stat")?.trim();
            const token = formData.get("_token")?.trim();

            if (!e_komentar) return showError("Maaf, publi id harus diisi.");
            if (!k_isi) return showError("Maaf, komentar harus diisi.");
            if (!k_stat || k_stat === "Pilih") return showError("Maaf, status komentar harus dipilih.");
            if (!token) return showError("Token harus diisi.");

            try {

                // TUTUP modal input
                hideModal("editKomentar");
                loaderModal.show();

                const response = await fetch("{{ url('03815582-b730-4c6f-836c-08967b530f43') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, '"+result.errors+"'.", "error");
                    showModal("editKomentar");
                } else if (result.message === 500) {
                    Swal.fire("Error", "Maaf, '"+result.errors+"'.", "error");
                    showModal("editKomentar");
                } else {
                    Swal.fire("Error", result.error ?? "Terjadi kesalahan", "error");
                    showModal("editKomentar");
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
                url: "{{ url('c061e824-1016-4ccb-b6f8-632e6df115e6') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#detailKomentar').modal('show');
                    $('#d_gl_ktgr').text(response.data.ktgr || '-');
                    $('#d_berita').text(indoDate(response.data.tgl_berita));
                    $('#d_judul').text(response.data.judul_berita || '-');
                    let url = response.data.pranala;
                    if (url) {
                        if (!/^https?:\/\//i.test(url)) {
                            // pastikan tidak double slash
                            url = url.replace(/^\/+/, '');

                            // tambahkan /blog/
                            url = 'blog/' + url;

                            // gabungkan dengan origin (localhost / hosting otomatis)
                            url = new URL(url, window.location.origin).href;
                        }

                        $('#d_link')
                            .attr('href', url)
                            .attr('target', '_blank')
                            .show();

                    } else {
                        $('#d_link').hide();
                    }
                    $('#d_jumlah').text(response.hitung ?? 0);
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
                        url: "{{ url('ea455c91-fa82-4ca3-884d-27f5f31be5ba') }}",
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
                $('#tambahKomentar').modal('hide');
                $('#detailKomentar').modal('hide');
                $('#editKomentar').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

</script>