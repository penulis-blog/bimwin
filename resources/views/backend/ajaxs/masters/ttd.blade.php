<script type="text/javascript">
    window.onload = function() {
        $('#tutupfile, #contentphoto1').hide();
    };

    // json data
    $(document).ready(function() {
        $('#templateTtd').DataTable({
            fixedColumns: {
                left: 1,
                right: 1
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 415,
            dom: 'Bfrtip',
            buttons: [{
                text: 'Tambah Data',
                action: function(e, dt, node, config) {
                    var tambah = {{ get_add() }};
                    if (tambah == 1) {
                        $('#tambahTtd').modal('show');
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
                action: function(e, dt, node, config) {
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
            }],
            'processing': true,
            'serverSide': true,
            'deferRender': true,
            'pageLength': 9,
            "ajax": "{{ route('tte.table') }}",
            "columns": [{
                    "data": "DT_RowIndex"
                },
                {
                    "data": "direktorat"
                },
                {
                    "data": "direktur"
                },
                {
                    "data": "kegiatan"
                },
                {
                    "data": "status"
                },
                {
                    "data": "aksi"
                },
            ]
        });
    });

    // Ambil Direktorat
    $.ajax({
        url: "{{ url('2832984d-4b10-4c4a-b2b6-0bc197ac6962') }}",
        type: 'GET',
        success: function(response){
            var sel = document.getElementById("id_direktorat");

            // Kosongkan dulu pilihan sebelumnya (opsional)
            sel.innerHTML = "";

            var defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.text = "Pilih";
            sel.add(defaultOption);

            // Tambahkan data dari response
            for (var i = 0; i < response.data.length; i++) {
                var opt = document.createElement("option");
                opt.value = response.data[i].id_direktorat;
                opt.text = response.data[i].nama;
                sel.add(opt);
            }

            $('#id_direktorat').select2({
                width: '100%',
                placeholder: 'Pilih',
                minimumResultsForSearch: 0,
                dropdownParent: $('#tambahTtd') // 🔥 INI KUNCI
            });
        }
    });

    Page.Subdit = function(val)
    {
        $.ajax({
            url: "{{ url('53b3695a-2c5d-44c6-bf63-f2ad4cc7f285') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("id_subdit");

                // Kosongkan dulu pilihan sebelumnya (opsional)
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_subdit;
                    opt.text = response.data[i].nama;
                    sel.add(opt);
                }

                $('#id_subdit').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#tambahTtd') // 🔥 INI KUNCI
                });
            }
        });
    }

    // Tanggal TTE
    $(function() {
        $(".lahirinput").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });

    // insert data
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_tte");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const nm_instansi = formData.get("nm_instansi")?.trim();
                const nm_direktur = formData.get("nm_direktur")?.trim();
                const id_direktorat = formData.get("id_direktorat");
                const id_subdit = formData.get("id_subdit")?.trim();
                const tgl_tte = formData.get("tgl_tte")?.trim();
                const lokasi_tte = formData.get("lokasi_tte")?.trim();
                const d_kegiatan = formData.get("d_kegiatan")?.trim();
                const files_tte = formData.get("files_tte");
                const token = formData.get("_token")?.trim();

                const fields = {
                    nm_instansi: { value: nm_instansi, message: "Maaf, instansi/unit harus diisi." },
                    nm_direktur: { value: nm_direktur, message: "Maaf, nama direktur harus diisi." },
                    id_direktorat: { value: id_direktorat, message: "Maaf, direktorat harus dipilih.", skipIf: 'Pilih' },
                    id_subdit: { value: id_subdit, message: "Maaf, subdit harus dipilih.", skipIf: 'Pilih' },
                    tgl_tte: { value: tgl_tte, message: "Maaf, tanggal tte harus diisi." },
                    lokasi_tte: { value: lokasi_tte, message: "Maaf, lokasi tte harus diisi." },
                    d_kegiatan: { value: d_kegiatan, message: "Maaf, kegiatan harus diisi." },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

                if (!files_tte || files_tte.size === 0) {
                    return showError("Maaf, file tte harus dipilih.");
                }
            try {
                $('#tambahTtd').modal('hide');
                $('#Loader').modal('show');

                const response = await fetch("{{ url('3c1b8c22-96be-4d21-ae7d-bf0084a6dca3') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    },
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else if (result.message === 400) {
                    Swal.fire("Gagal", result.errors || "Terjadi kesalahan saat menyimpan.", "error");
                    showModal("tambahTtd");
                } else if (result.message === 500) {
                    Swal.fire("Gagal", result.errors || "Terjadi kesalahan saat menyimpan.", "error");
                    showModal("tambahTtd");
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                    showModal("tambahTtd");
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                $('#Loader').modal('hide');
            }
        });

        // Fungsi bantu
        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

        function showLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "block";
        }

        function hideLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "none";
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

    Page.Edit = function(val) {
        if (val == '' || val == null || val == 0) {
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

        $.ajax({
            url: "{{ url('e272573c-efef-49c1-a392-58e6cbe4ea00') }}/" + val,
            type: 'GET',
            success: function(response) {
                $('#editTtd').modal('show');
                $('#e_publicid').val(response.data.public_id);
                $('#e_nm_direktur').val(response.data.direktur);
                EDirektorat(response.data.id_direktorat)
                    .then(() => Page.ESubdit(response.data.id_direktorat, response.data.id_subdit))
                    .catch(err => console.error("❌ Error isi dropdown:", err));
                $('#e_tgl_tte').val(response.data.tgl_ttd);
                $('#e_lokasi_tte').val(response.data.lokasi_ttd);
                $('#e_kegiatan').val(response.data.kegiatan);
                $('#e_files_old').val(response.data.files);
                $('#lihatfile').attr('value', response.data.files);
                setTimeout(() => {
                    const e_status = document.getElementById('eis_trash');
                    if (e_status) {
                        e_status.value = String(response.data.is_trash ?? '');
                    }
                }, 800);
            }
        });
    };

    function EDirektorat(val)
    {
        return new Promise((resolve, reject) => {
            if (!val || val === '' || val === 0) {
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
                reject("ID Direktorat kosong");
                return;
            }

            $.ajax({
                url: "{{ url('2832984d-4b10-4c4a-b2b6-0bc197ac6962') }}",
                type: 'GET',
                success: function(response) {
                    var sel = document.getElementById("e_id_direktorat");
                    sel.innerHTML = "";

                    // Tambah option default
                    var defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih";
                    sel.add(defaultOption);

                    // Tambah data direktorat
                    for (var i = 0; i < response.data.length; i++) {
                        var opt = document.createElement("option");
                        opt.value = response.data[i].id_direktorat;
                        opt.text = response.data[i].nama;
                        sel.add(opt);
                        if (opt.value == val) {
                            opt.selected = true;
                        }
                    }
                    $('#e_id_direktorat').select2({
                        width: '100%',
                        placeholder: 'Pilih',
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#editTtd') // 🔥 INI KUNCI
                    });
                    resolve(); // selesai
                },
                error: function(xhr, status, error) {
                    console.error("❌ Gagal memuat direktorat:", error);
                    reject(error);
                }
            });
        });
    }

    Page.ESubdit = function(val, id)
    {
        return new Promise((resolve, reject) => {
            if (!val) {
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
                reject("ID subdit kosong");
                return;
            }

            $.ajax({
                url: "{{ url('53b3695a-2c5d-44c6-bf63-f2ad4cc7f285') }}/" + val,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const sel = document.getElementById("e_id_subdit");
                    sel.innerHTML = "";

                    // Tambahkan option default
                    const defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih";
                    sel.add(defaultOption);

                    // Tambahkan data dari response
                    response.data.forEach(item => {
                        const opt = document.createElement("option");
                        opt.value = item.id_subdit;
                        opt.text = item.nama;
                        sel.add(opt);
                    });

                    // Set kabupaten yang sesuai
                    if (id) {
                        $('#e_id_subdit').val(id);
                    }
                    $('#e_id_subdit').select2({
                        width: '100%',
                        placeholder: 'Pilih',
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#editTtd') // 🔥 INI KUNCI
                    });
                    resolve(); // tandai selesai
                },
                error: function(xhr, status, error) {
                    console.error("❌ Gagal memuat subdit:", error);
                    reject(error);
                }
            });
        });
    }

    Page.Batal = function() {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahTtd').modal('hide');
                $('#detailTtd').modal('hide');
                $('#editTtd').modal('hide');
                $('#listTtd').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

    Page.Lihat = function(val) {
        if (!val || val.trim() === '' || val === 'null' || val === 'undefined') {
            Swal.fire({
                title: "Informasi",
                text: "Maaf, file belum tersedia.",
                icon: "error"
            });
            return;
        }

        const storageBase = "{{ url('storage') }}";

        $('#lihatfile').hide();
        $('#tutupfile').show();
        $('#contentphoto1').show('slow');
        $("#gambar_file").attr("src", storageBase + "/" + val);
    };


    Page.Tutup = function() {
        $('#lihatfile').show();
        $('#tutupfile').hide();
        $('#contentphoto1').hide('slow');
    };

    // Update Data
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_edit_tte");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const e_publicid = formData.get("e_publicid")?.trim();
                const e_nm_direktur = formData.get("e_nm_direktur")?.trim();
                const e_id_direktorat = formData.get("e_id_direktorat");
                const e_id_subdit = formData.get("e_id_subdit")?.trim();
                const e_tgl_tte = formData.get("e_tgl_tte")?.trim();
                const e_lokasi_tte = formData.get("e_lokasi_tte")?.trim();
                const e_kegiatan = formData.get("e_kegiatan")?.trim();
                const e_files_old = formData.get("e_files_old");
                const e_files_tte = formData.get("e_files_tte");
                const eis_trash = formData.get("eis_trash")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    e_publicid: { value: e_publicid, message: "Maaf, id form harus diisi." },
                    e_nm_direktur: { value: e_nm_direktur, message: "Maaf, nama direktur harus diisi." },
                    e_id_direktorat: { value: e_id_direktorat, message: "Maaf, direktorat harus dipilih.", skipIf: 'Pilih' },
                    e_id_subdit: { value: e_id_subdit, message: "Maaf, subdit harus dipilih.", skipIf: 'Pilih' },
                    e_tgl_tte: { value: e_tgl_tte, message: "Maaf, tanggal tte harus diisi." },
                    e_lokasi_tte: { value: e_lokasi_tte, message: "Maaf, lokasi tte harus diisi." },
                    e_kegiatan: { value: e_kegiatan, message: "Maaf, kegiatan harus diisi." },
                    eis_trash: { value: eis_trash, message: "Maaf, status harus dipilih.", skipIf: 'Pilih' },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }
            try {
                $('#editTtd').modal('hide');
                $('#Loader').modal('show');

                const response = await fetch("{{ url('97d38fe7-78e3-4da7-abb9-c3d1dd90ea80') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    },
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else if (result.message === 400) {
                    Swal.fire("Gagal", result.errors || "Terjadi kesalahan saat menyimpan.", "error");
                    showModal("editTtd");
                } else if (result.message === 500) {
                    Swal.fire("Gagal", result.errors || "Terjadi kesalahan saat menyimpan.", "error");
                    showModal("editTtd");
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                    showModal("editTtd");
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                $('#Loader').modal('hide');
            }
        });

        // Fungsi bantu
        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

        function showLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "block";
        }

        function hideLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "none";
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

    function showLoader() {
        const loaderModal = new bootstrap.Modal(document.getElementById('Loader'), {
            backdrop: 'static',
            keyboard: false
        });
        loaderModal.show();
    }

    function hideLoader() {
        const modalElement = document.getElementById('Loader');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }
    }

    Page.Detail = function(val) {
        if (val == '' || val == null || val == 0) {
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        } else {
            $.ajax({
                url: "{{ url('fc061f4c-4dd3-4dfd-87b1-8f768f482bfd') }}/" + val,
                type: 'GET',
                success: function(response) {
                    $('#detailTtd').modal('show');
                    $('#d_instansi').text(response.data.eselon_1);
                    $('#d_direktur').text(response.data.direktur);
                    $('#d_direktorat').text(response.data.direktorat);
                    $('#d_subdit').text(response.data.subdit);
                    $('#d_tgl').text(response.data.tgl);
                    $('#d_lokasi').text(response.data.lokasi_ttd);
                    $('#d2_kegiatan').text(response.data.kegiatan);
                    $('#d_status').text(response.data.status);

                    if (response.data.files) {
                        $("#d_foto1").attr("src", "{{ url('storage/') }}/" + response.data.files);
                    } else {
                        $("#d_foto1").attr("src", "");
                    }
                }
            });
        }
    }

    Page.Delete = function(val) {
        if (val == '' || val == null || val == 0) {
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        } else {
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
                        url: "{{ url('e90c127d-cf7c-4f7b-a67f-94ff43ba3b3c') }}",
                        type: 'POST',
                        data: {
                            val: a,
                            _token: e
                        },
                        success: function(response) {
                            if (response.message == 200) {
                                Swal.fire("Berhasil", "Data berhasil di nonaktifkan.",
                                    "success").then(() => {
                                    location.href = location.pathname;
                                });
                            } else if (response.message == 201) {
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
                } else {
                    Swal.fire('Informasi', 'Data tidak jadi di hapus.', 'info');
                }
            });
        }
    }

    $(function() {
        $("input[name='nm_direktur']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/ ' ]/g, ''));
        });
        $("input[name='lokasi_tte']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ., ' ]/g, ''));
        });
        $("input[name='tgl_tte']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-' ]/g, ''));
        });
        $("input[name='e_nm_direktur']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/ ' ]/g, ''));
        });
        $("input[name='e_lokasi_tte']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ., ' ]/g, ''));
        });
        $("input[name='e_tgl_tte']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-' ]/g, ''));
        });
    });
</script>
