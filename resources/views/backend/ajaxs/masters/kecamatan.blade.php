<script type="text/javascript">
    window.onload = function() {
    };

    // json data
    $(document).ready(function() {
        $('#tableKecamatan').DataTable({
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
                        $('#tambahKecamatan').modal('show');
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
            "ajax": "{{ route('kecamatan.table') }}",
            "columns": [{
                    "data": "DT_RowIndex"
                },
                {
                    "data": "id_kabupaten"
                },
                {
                    "data": "id_kecamatan"
                },
                {
                    "data": "kode_kua"
                },
                {
                    "data": "kecamatan"
                },
                {
                    "data": "latitude"
                },
                {
                    "data": "longitude"
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

    $.ajax({
        url: "{{ url('0baa8263-8ef9-45d4-87fc-b49ba190028e') }}",
        type: 'GET',
        success: function(response) {
            var sel = document.getElementById("id_kabu");
            sel.innerHTML = "";
            var defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.text = "Pilih";
            sel.add(defaultOption);
            for (var i = 0; i < response.data.length; i++) {
                var item = response.data[i];
                var opt = document.createElement("option");
                opt.value = item.id_kabupaten;
                opt.text = item.nama;
                sel.add(opt);
            }

            $('#id_kabu').select2({
                width: '100%',
                placeholder: 'Pilih',
                minimumResultsForSearch: 0,
                dropdownParent: $('#tambahKecamatan') // 🔥 INI KUNCI
            });
        }
    });

    // insert data
    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_kecamatan");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData  = new FormData(form);
            const id_kabu   = formData.get("id_kabu")?.trim();
            const nm_kec    = formData.get("nm_kec");
            const lat       = formData.get("lat");
            const long      = formData.get("long");
            const token     = formData.get("_token")?.trim();

            const fields = {
                id_kabu:   { value: id_kabu, message: "Maaf, kabupaten harus dipilih.", skipIf: 'Pilih' },
                nm_kec:    { value: nm_kec,   message: "Maaf, nama kecamatan harus diisi." },
                lat:       { value: lat,       message: "Maaf, latitude harus diisi." },
                long:      { value: long,      message: "Maaf, longitude harus diisi." },
                token:     { value: token,     message: "Token harus diisi." }
            };

            for (const key in fields) {
                const { value, message } = fields[key];
                if (!value) {
                    return showError(message);
                }
            }

            try {
                // tutup modal form
                $('#tambahKecamatan').modal('hide');

                // tampilkan loader
                showLoaderHard();

                const response = await fetch("{{ url('e3713fd9-d99c-4eb6-b645-d6dc510b0e21') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                // 🔥 PASTI MATI
                killLoader();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success")
                        .then(() => {
                            window.location.href = window.location.pathname;
                        });

                } else if (result.message === 201) {
                    Swal.fire(
                        "Gagal",
                        "Maaf, pastikan ID kecamatan dan kode kua tidak sama sebelumnya.",
                        "error"
                    ).then(() => {
                        $('#tambahKecamatan').modal('show');
                    });

                } else {
                    Swal.fire(
                        "Gagal",
                        "Terjadi kesalahan saat menyimpan.",
                        "error"
                    ).then(() => {
                        $('#tambahKecamatan').modal('show');
                    });
                }

            } catch (error) {
                killLoader();
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            }
        });

        // ===============================
        // 🔥 LOADER HARD CONTROL (FINAL)
        // ===============================

        function showLoaderHard() {
            const loader = document.getElementById("Loader");
            if (!loader) return;

            loader.style.display = "block";
            loader.classList.add("show");

            document.body.classList.add("modal-open");
            document.body.style.overflow = "hidden";

            // pastikan backdrop ada
            if (!document.querySelector(".modal-backdrop")) {
                const backdrop = document.createElement("div");
                backdrop.className = "modal-backdrop fade show";
                document.body.appendChild(backdrop);
            }
        }

        function killLoader() {
            const loader = document.getElementById("Loader");

            if (loader) {
                loader.classList.remove("show");
                loader.style.display = "none";
                loader.setAttribute("aria-hidden", "true");
            }

            // hapus semua backdrop
            document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());

            // reset body
            document.body.classList.remove("modal-open");
            document.body.style.overflow = "";
            document.body.style.paddingRight = "";
        }

        // ===============================
        // Fungsi bantu (ASLI KAMU)
        // ===============================

        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
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
            url: "{{ url('e12b62f2-5642-4224-bb44-9d82f557dd3c') }}/" + val,
            type: 'GET',
            success: function(response) {
                $('#editKecamatan').modal('show');
                $('#e_publicid').val(response.data.id);
                eKabupaten(response.data.id_kabupaten);
                $('#e_nm_kec').val(response.data.kecamatan);
                $('#e_id_kec').val(response.data.id_kecamatan);
                $('#e_id_kua').val(response.data.kode_kua);
                $('#e_lat').val(response.data.latitude);
                $('#e_long').val(response.data.longitude);
                setTimeout(() => {
                    const e_status = document.getElementById('eis_trash');
                    if (e_status) {
                        e_status.value = String(response.data.is_actived ?? '');
                    }
                }, 800);
            }
        });
    };

    function eKabupaten(val)
    {
        $.ajax({
            url: "{{ url('0baa8263-8ef9-45d4-87fc-b49ba190028e') }}/",
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("e_id_kabu");
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_kabupaten;
                    opt.text = response.data[i].nama;
                    sel.add(opt);

                    if (opt.value == val) {
                        $('select#e_id_kabu option[value="' + opt.value + '"]').attr('selected', true);
                    }
                }

                $('#e_id_kabu').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#editKecamatan') // 🔥 INI KUNCI
                });
            },
            error: function(err) {
                console.error("❌ Gagal memuat kabupaten:", err);
                reject(err);
            }
        });
    }

    // Update Data
    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_edit_kecamatan");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData    = new FormData(form);
            const e_publicid  = formData.get("e_publicid")?.trim();
            const e_id_kabu   = formData.get("e_id_kabu")?.trim();
            const e_nm_kec    = formData.get("e_nm_kec")?.trim();
            const e_id_kec    = formData.get("e_id_kec")?.trim();
            const e_id_kua    = formData.get("e_id_kua")?.trim();
            const e_lat       = formData.get("e_lat")?.trim();
            const e_long      = formData.get("e_long")?.trim();
            const eis_trash   = formData.get("eis_trash")?.trim();
            const token       = formData.get("_token")?.trim();

            const fields = {
                e_id_kabu: { value: e_id_kabu, message: "Maaf, kabupaten harus dipilih.", skipIf: 'Pilih' },
                e_nm_kec:  { value: e_nm_kec, message: "Maaf, nama kecamatan harus diisi." },
                e_id_kec:  { value: e_id_kec, message: "Maaf, ID kecamatan harus diisi." },
                e_id_kua:  { value: e_id_kua, message: "Maaf, ID KUA harus diisi." },
                e_lat:     { value: e_lat, message: "Maaf, latitude harus diisi." },
                e_long:    { value: e_long, message: "Maaf, longitude harus diisi." },
                eis_trash: { value: eis_trash, message: "Maaf, status harus dipilih.", skipIf: 'Pilih' },
                token:     { value: token, message: "Token harus diisi." }
            };

            for (const key in fields) {
                const { value, message } = fields[key];
                if (!value) {
                    return showError(message);
                }
            }

            try {
                // tutup modal form
                $('#editKecamatan').modal('hide');

                // tampilkan loader
                showLoaderHard();

                const response = await fetch("{{ url('ad14d1d5-48e4-4912-bb42-acef8d467cbd') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                // 🔥 PASTI MATI
                killLoader();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success")
                        .then(() => {
                            window.location.href = window.location.pathname;
                        });

                } else if (result.message === 201) {
                    Swal.fire(
                        "Gagal",
                        "Maaf, pastikan ID kecamatan dan satker tidak sama sebelumnya.",
                        "error"
                    ).then(() => {
                        $('#editKecamatan').modal('show');
                    });

                } else {
                    Swal.fire(
                        "Gagal",
                        "Terjadi kesalahan saat menyimpan.",
                        "error"
                    ).then(() => {
                        $('#editKecamatan').modal('show');
                    });
                }

            } catch (error) {
                killLoader();
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            }
        });

        // ===============================
        // 🔥 LOADER HARD CONTROL (FINAL)
        // ===============================

        function showLoaderHard() {
            const loader = document.getElementById("Loader");
            if (!loader) return;

            loader.style.display = "block";
            loader.classList.add("show");

            document.body.classList.add("modal-open");
            document.body.style.overflow = "hidden";

            // pastikan backdrop ada
            if (!document.querySelector(".modal-backdrop")) {
                const backdrop = document.createElement("div");
                backdrop.className = "modal-backdrop fade show";
                document.body.appendChild(backdrop);
            }
        }

        function killLoader() {
            const loader = document.getElementById("Loader");

            if (loader) {
                loader.classList.remove("show");
                loader.style.display = "none";
                loader.setAttribute("aria-hidden", "true");
            }

            // hapus semua backdrop
            document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());

            // reset body
            document.body.classList.remove("modal-open");
            document.body.style.overflow = "";
            document.body.style.paddingRight = "";
        }

        // ===============================
        // Fungsi bantu (ASLI KAMU)
        // ===============================

        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

    });

    Page.Batal = function() {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahKecamatan').modal('hide');
                $('#detailKecamatan').modal('hide');
                $('#editKecamatan').modal('hide');
                $('#listKecamatan').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
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
                url: "{{ url('0a1e72f4-dda1-4aa3-a436-cf1ec1ee1dca') }}/" + val,
                type: 'GET',
                success: function(response) {
                    $('#detailKecamatan').modal('show');
                    $('#d_kabupaten').text(response.data.kabupaten);
                    $('#d_kecamatan').text(response.data.kecamatan);
                    $('#d_id_keca').text(response.data.id_kecamatan);
                    $('#d_kua').text(response.data.kode_kua);
                    $('#d_nama').text(response.data.nama);
                    $('#d_latitude').text(response.data.latitude);
                    $('#d_longitude').text(response.data.longitude);
                    $('#d_status').text(response.data.status);
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
                        url: "{{ url('e32aaa96-a55b-42ea-a490-76ad6ddf5419') }}",
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
        $("input[name='nm_kec']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ' ]/g, ''));
        });
        $("input[name='lat']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-.,'"']/g, ''));
        });
        $("input[name='long']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-.,'"']/g, ''));
        });
        $("input[name='e_id_kec']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9' ]/g, ''));
        });
        $("input[name='e_id_kua']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9' ]/g, ''));
        });
        $("input[name='e_nm_kec']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ' ]/g, ''));
        });
        $("input[name='e_lat']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-.,'"']/g, ''));
        });
        $("input[name='e_long']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-.,'"']/g, ''));
        });
    });
</script>
