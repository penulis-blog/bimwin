<script type="text/javascript">
    window.onload = function() {
        $('.stat_ket').hide();
        $('.tutupPhoto').hide();
        $('.tutupdetail').hide();
        $('#contentphoto').hide();
        $('#contentphoto2').hide();
        $('#div_keterangan').hide();
        $('#catatan_admin').hide();
        $('#catatan_admin_dtl').hide();
    };

    $(document).ready(function () {
        $('#sertifikatTable').DataTable({
            fixedColumns: {
                left: 1,
                right: 1
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 415,
            dom: 'Bfrtip',
            buttons: [
                @if(get_add() == 1)
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
                },
                @endif
                @if(get_laporan() == 1)
                {
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
                @endif
            ],
            'processing': true,
            'serverSide': true,
            'deferRender': true,
            'pageLength': 9,
            "ajax": "{{ route('sertifikat_pengaduan.table') }}",
            "columns": [
                {"data":"DT_RowIndex"},
                {"data":"instansi"},
                {"data":"nama"},
                {"data":"tempat_tanggal_lahir"},
                {"data":"status"},
                {"data":"aksi"},
            ]
        });
    });

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
                url: "{{ url('c2e8f810-35fa-48cc-8c32-3fab4504908d') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#editSertifikat').modal('show');
                    $('#e_st_publicid').attr('value', response.data.id);
                    $('#e_verifikasi_admin').attr('value', response.data.is_verifikasi_admin);
                    $('#e_kgt').text(response.data.judul_acara);
                    if(response.data.is_verifikasi_admin == 33 || response.data.is_verifikasi_admin == 34)
                    {
                        $('#div_keterangan').show('slow');
                        $('#e_keterangan_pengaduan').text(response.data.keterangan_pengaduan);
                    }
                    $('#e_lokasi').text(response.data.lokasi);
                    $('#e_tempat').text(response.data.tempat);
                    $('#e_dari').text(response.data.dari);
                    $('#e_sampai').text(response.data.sampai);
                    if (response.data.is_verifikasi_admin == 33 || response.data.is_verifikasi_admin == 34) {
                        let tgl = response.data.lahir_pengaduan;
                        if (tgl) {
                            let parts = tgl.split('-');
                            tgl = parts[2] + '-' + parts[1] + '-' + parts[0];
                        }
                        $('#e_nik').attr('value', response.data.nik_pengaduan);
                        $('#e_nama').attr('value', response.data.nama_pengaduan);
                        $('#e_tmp').attr('value', response.data.tempat_pengaduan);
                        $('#e_tgl').val(tgl);
                        $('#e_jbtn').attr('value', response.data.jabatan_pengaduan);
                        $('#e_satuan').attr('value', response.data.utusan_pengaduan);
                        $(function() {
                            $(".editlahir_sertifikat").datepicker({
                                format: 'dd-mm-yyyy',
                                autoclose: true,
                                todayHighlight: true,
                            });
                        });
                        $('#e_st_files_old').attr('value', response.data.files_pengaduan);
                        $('#lihatfile').attr('value', response.data.files_pengaduan);
                    } else {
                        $('#e_nik').attr('value', response.data.nik);
                        $('#e_nama').attr('value', response.data.nama);
                        $('#e_tmp').attr('value', response.data.lahir);
                        $('#e_tgl').attr('value', response.data.tgl);
                        $('#e_jbtn').attr('value', response.data.jabatan);
                        $('#e_satuan').attr('value', response.data.instansi);
                        $(function() {
                            $(".editlahir_sertifikat").datepicker({
                                format: 'dd-mm-yyyy',
                                autoclose: true,
                                todayHighlight: true,
                            });
                        });
                        $('#e_st_files_old').attr('value', response.data.files);
                        $('#lihatfile').attr('value', response.data.files);
                    }
                    $('#e_ktgr').attr('value', response.data.jenis_kategori);
                }
            });
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_edit_sertifikat");
        const loaderModal = new bootstrap.Modal(document.getElementById("Loader"), {
            backdrop: "static",
            keyboard: false
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const e_st_publicid = formData.get("e_st_publicid")?.trim();
            const is_verifikasi_admin = formData.get("is_verifikasi_admin")?.trim();
            const e_nik = formData.get("e_nik")?.trim();
            const e_nama = formData.get("e_nama")?.trim();
            const e_tmp = formData.get("e_tmp")?.trim();
            const e_tgl = formData.get("e_tgl")?.trim();
            const e_jbtn = formData.get("e_jbtn")?.trim();
            const e_satuan = formData.get("e_satuan")?.trim();
            const e_ktgr = formData.get("e_ktgr")?.trim();
            const e_st_files_old = formData.get("e_st_files_old")?.trim();
            const e_st_files = formData.get("e_st_files");
            const token = formData.get("_token")?.trim();

            if (!e_nik) return showError("Maaf, nik ktp harus diisi.");
            if (!e_nama) return showError("Maaf, nama lengkap harus diisi.");
            if (!e_tmp) return showError("Maaf, tempat lahir harus diisi.");
            if (!e_tgl) return showError("Maaf, tanggal lahir harus diisi.");
            if (!e_jbtn) return showError("Maaf, jabatan harus diisi.");
            if (!e_satuan) return showError("Maaf, utusan/satuan kerja harus diisi.");
            if (!token) return showError("Token harus diisi.");

            try {
                hideModal("editSertifikat");
                loaderModal.show();
                const response = await fetch("{{ url('b75b8370-fa76-47f6-a28f-370a2413642e') }}", {
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
                    showModal("editSertifikat");
                } else if (result.message === 500) {
                    Swal.fire("Error", "Maaf, '"+result.errors+"'.", "error");
                    showModal("editSertifikat");
                } else {
                    Swal.fire("Error", result.error ?? "Terjadi kesalahan", "error");
                    showModal("editSertifikat");
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

    Page.Agree = function(val)
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
            return;
        }

        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah kamu yakin ingin menerima permintaan perbaharui data sertifikat ini?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Terima",
            cancelButtonText: "Batal",
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: "{{ url('1de24d7a-1dc7-473a-a29b-b07f04d2e222') }}/" + val,
                    type: "GET",
                    success: function(response){
                        if(response.message == 200){
                            Swal.fire({
                                title: "Berhasil",
                                text: "Permintaan perbaharui data sertifikat telah diterima.",
                                icon: "success",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "Lanjut"
                            }).then(() => {
                                if(response.data.keterangan_pengaduan && response.data.keterangan_pengaduan.toString().trim() !== ''){
                                    $('#catatan_admin').show('slow');
                                    $('#catatan_pengembalian').text(response.data.keterangan_pengaduan);
                                } else {
                                    $('#catatan_admin').hide();
                                }
                                if (response.data.is_verifikasi_admin == 38) {
                                    $('#keterangan_status').text('Status dikembalikan');
                                } else if (response.data.is_verifikasi_admin == 34) {
                                    $('#keterangan_status').text('Status ditolak');
                                }
                                $('#detailKiriman').modal('show');
                                $('#id_keputusan').attr('value', response.data.id);
                                $('#nik_asli').attr('value', response.data.nik);
                                $('#p_kegiatan').text(response.data.judul_acara);
                                $('#p_tempat').text(response.data.tempat);
                                $('#p_lokasi').text(response.data.lokasi);
                                $('#p_pelaksanaan').text((response.data.dari ?? '-') + ' s.d. ' + (response.data.sampai ?? '-'));
                                $('#old_nik').text(response.data.nik);
                                $('#new_nik').text(response.data.nik_pengaduan);
                                $('#old_nama').text(response.data.nama);
                                $('#new_nama').text(response.data.nama_pengaduan);
                                $('#old_jabatan').text(response.data.jabatan);
                                $('#new_jabatan').text(response.data.jabatan_pengaduan);
                                $('#old_instansi').text(response.data.instansi);
                                $('#new_instansi').text(response.data.utusan_pengaduan);
                                $('#old_tmp').text(response.data.lahir);
                                $('#new_tmp').text(response.data.tempat_pengaduan);
                                $('#old_tgl').text(response.data.tgl);
                                $('#new_tgl').text(response.data.lahir_pengaduan ? response.data.lahir_pengaduan.split('-').reverse().join('-') : '-');
                                if (response.data.files != null && response.data.files != '') {
                                    $('#old_photo').attr("src", "{{ url('storage/') }}/" + response.data.files).show();
                                    $('#ket_old_photo').text('Foto Sebelumnya');
                                } else {
                                    $('#old_photo').hide();
                                    $('#ket_old_photo').text('Belum ada foto');
                                }
                                if (
                                    response.data.files_pengaduan &&
                                    response.data.files_pengaduan != 0
                                ) {
                                    $('#new_photo')
                                        .attr("src", "{{ url('storage/') }}/" + response.data.files_pengaduan)
                                        .show();
                                    $('#ket_photo_perbaikan').text('Foto Perbaikan');
                                } else {
                                    $('#new_photo').hide();
                                    $('#ket_photo_perbaikan').text('Tidak ada foto perbaikan');
                                }
                            });
                        }else{
                            Swal.fire({
                                title: "Informasi",
                                text: "Data tidak ditemukan.",
                                icon: "warning",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    },
                    error: function(){
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan pada server.",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: "OK"
                        });
                    }
                });
            }
        });
    }

    Page.Keputusan = function(val)
    {
        if(val == 35 || val == ''){
            $('#catatan').prop('disabled', true);
            $('#catatan').val('');
        }else{
            $('#catatan').prop('disabled', false);
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_keputusan");
        const loaderModal = new bootstrap.Modal(document.getElementById("Loader"), {
            backdrop: "static",
            keyboard: false
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const id_keputusan = formData.get("id_keputusan")?.trim();
            const nik_asli = formData.get("nik_asli")?.trim();
            const keputusan = formData.get("keputusan")?.trim();
            const catatan = formData.get("catatan")?.trim();
            const token = formData.get("_token")?.trim();

            if (!id_keputusan) return showError("Maaf, id pengajuan harus diisi.");
            if (!keputusan) return showError("Maaf, pilihan keputusan harus dipilih.");
            if (keputusan != 35 && !catatan) {
                return showError("Maaf, catatan keputusan harus diisi.");
            }
            if (!token) return showError("Token harus diisi.");

            try {
                hideModal("detailKiriman");
                loaderModal.show();
                const response = await fetch("{{ url('9faed2d6-74e3-4abb-851c-96e2e76d2df9') }}", {
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
                    showModal("detailKiriman");
                } else if (result.message === 500) {
                    Swal.fire("Error", "Maaf, '"+result.errors+"'.", "error");
                    showModal("detailKiriman");
                } else {
                    Swal.fire("Error", result.error ?? "Terjadi kesalahan", "error");
                    showModal("detailKiriman");
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

    function setValueCenter(id, value) {
        let kosong = value === null || value === undefined || value.toString().trim() === '';

        if (kosong) {
            $(id).text('-').css('text-align', 'center');
        } else {
            $(id).text(value).css('text-align', 'left');
        }
    }

    function formatTanggal(tanggal) {
        if (!tanggal) return null;
        const parts = tanggal.split('-');
        if (parts.length !== 3) return tanggal;
        return parts[2] + '-' + parts[1] + '-' + parts[0];
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
            var roles = {{ auth()->user()->id_roles }};

            $.ajax({
                url: "{{ url('ac21837e-3135-4c4a-9684-cb7b9d0373df') }}/" + val,
                type: 'GET',
                success: function(response){
                    if(roles == 10){
                        $('#detailSertifikat_Pengajuan').modal('show');
                        $('#p_kegiatan_dtl').text(response.data.judul_acara);
                        $('#p_pelaksanaan_dtl').text((response.data.dari ?? '-') + ' s.d. ' + (response.data.sampai ?? '-'));
                        $('#p_tempat_dtl').text(response.data.tempat);
                        $('#p_lokasi_dtl').text(response.data.lokasi);
                        if (response.data.files != null && response.data.files != '') {
                            $('#old_photo_dtl').attr("src", "{{ url('storage/') }}/" + response.data.files).show();
                            $('#ket_old_photo_dtl').text('Foto Sebelumnya');
                        } else {
                            $('#old_photo_dtl').hide();
                            $('#ket_old_photo_dtl').text('Belum ada foto');
                        }
                        if (response.data.files_pengaduan != null && response.data.files_pengaduan != '') {
                            $('#new_photo_dtl').attr("src", "{{ url('storage/') }}/" + response.data.files_pengaduan).show();
                            $('#ket_photo_perbaikan_dtl').text('Foto Perbaikan');
                        } else {
                            $('#new_photo_dtl').hide();
                            $('#ket_photo_perbaikan_dtl').text('-');
                        }
                        $('#old_nik_dtl').text(response.data.nik);
                        setValueCenter('#new_nik_dtl', response.data.nik_pengaduan);
                        $('#old_nama_dtl').text(response.data.nama);
                        setValueCenter('#new_nama_dtl', response.data.nama_pengaduan);
                        $('#old_jabatan_dtl').text(response.data.jabatan);
                        setValueCenter('#new_jabatan_dtl', response.data.jabatan_pengaduan);
                        $('#old_instansi_dtl').text(response.data.instansi);
                        setValueCenter('#new_instansi_dtl', response.data.utusan_pengaduan);
                        $('#old_tmp_dtl').text(response.data.lahir);
                        setValueCenter('#new_tmp_dtl', response.data.tempat_pengaduan);
                        $('#old_tgl_dtl').text(response.data.tgl);
                        setValueCenter('#new_tgl_dtl', formatTanggal(response.data.lahir_pengaduan));
                        if (response.data.is_verifikasi_admin == 33) {
                            $('#catatan_admin_dtl').show('slow');
                            $('#keterangan_status_dtl').text('Status dikembalikan');
                            $('#catatan_pengembalian_dtl').text(response.data.keterangan_pengaduan);
                        } else if (response.data.is_verifikasi_admin == 34) {
                            $('#catatan_admin_dtl').show('slow');
                            $('#keterangan_status_dtl').text('Status ditolak');
                            $('#catatan_pengembalian_dtl').text(response.data.keterangan_pengaduan);
                        }
                    }else if(roles == 1){
                        $('#detailSertifikat_Admin').modal('show');
                    }
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

    Page.Download = function(val)
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
                url: "{{ url('3e28b386-3b1e-4698-940e-b1ffa3ce67cb') }}/" + val,
                type: 'GET',
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function () {
                    // tampilkan modal loader
                    $("#Loader").modal("show");
                },
                success: function (blob) {
                    var url = window.URL.createObjectURL(blob);
                    window.open(url, "_blank");
                },
                complete: function () {
                    // apapun hasilnya, sembunyikan loader
                    $("#Loader").modal("hide");
                },
                error: function () {
                    Swal.fire("Perhatian", "Pastikan, TTE dan Template Sertifikat Tersedia.", "error").then(() => {
                        window.location.href = window.location.pathname;
                    });
                }
            });
        }
    }

    Page.Batal = function()
    {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#detailSertifikat').modal('hide');
                $('#detailKiriman').modal('hide');
                $('#editSertifikat').modal('hide');
                $('#detailSertifikat_Admin').modal('hide');
                $('#detailSertifikat_Pengajuan').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

    $(function(){
        $("input[name='e_nik']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='e_nama']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/' ]/g, ''));
        });
        $("input[name='e_tmp']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ., ]/g, ''));
        });
        $("input[name='e_tgl']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("input[name='e_jbtn']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/ ]/g, ''));
        });
        $("input[name='e_satuan']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^a-zA-Z0-9 -]/g, ''));
        });
        $("textarea[name='catatan']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^a-zA-Z0-9 '?\/-]/g, ''));
        });
    });
</script>