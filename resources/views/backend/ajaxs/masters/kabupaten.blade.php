<script type="text/javascript">
    window.onload = function() {
    };

    // json data
    $(document).ready(function() {
        $('#tableKabupaten').DataTable({
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
                        $('#tambahKabupaten').modal('show');
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
            "ajax": "{{ route('kabupaten.table') }}",
            "columns": [{
                    "data": "DT_RowIndex"
                },
                {
                    "data": "satker"
                },
                {
                    "data": "id_provinsi"
                },
                {
                    "data": "id_kabupaten"
                },
                {
                    "data": "kabupaten"
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
        url: "{{ url('1178abf7-1d6a-4499-88c4-0e065a204efa') }}",
        type: 'GET',
        success: function(response) {
            var sel = document.getElementById("id_prov");
            sel.innerHTML = "";
            var defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.text = "Pilih";
            sel.add(defaultOption);
            for (var i = 0; i < response.data.length; i++) {
                var item = response.data[i];
                var opt = document.createElement("option");
                opt.value = item.id_provinsi;
                opt.text = item.nama;
                sel.add(opt);
            }

            $('#id_prov').select2({
                width: '100%',
                placeholder: 'Pilih',
                minimumResultsForSearch: 0,
                dropdownParent: $('#tambahKabupaten') // 🔥 INI KUNCI
            });
        }
    });

    // insert data
    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_kabupaten");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData  = new FormData(form);
            const id_prov   = formData.get("id_prov")?.trim();
            const id_satker = formData.get("id_satker")?.trim();
            const nm_kabu   = formData.get("nm_kabu");
            const lat       = formData.get("lat");
            const long      = formData.get("long");
            const token     = formData.get("_token")?.trim();

            const fields = {
                id_prov:   { value: id_prov, message: "Maaf, ID provinsi harus dipilih.", skipIf: 'Pilih' },
                id_satker: { value: id_satker, message: "Maaf, ID satker harus diisi." },
                nm_kabu:   { value: nm_kabu,   message: "Maaf, nama kabupaten harus diisi." },
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
                $('#tambahKabupaten').modal('hide');

                // tampilkan loader
                showLoaderHard();

                const response = await fetch("{{ url('f2b9e74c-98bc-475a-9aab-bcc7c3f7d610') }}", {
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
                        "Maaf, pastikan ID kabupaten dan satker tidak sama sebelumnya.",
                        "error"
                    ).then(() => {
                        $('#tambahKabupaten').modal('show');
                    });

                } else {
                    Swal.fire(
                        "Gagal",
                        "Terjadi kesalahan saat menyimpan.",
                        "error"
                    ).then(() => {
                        $('#tambahKabupaten').modal('show');
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
            url: "{{ url('f0a00157-61b1-4073-95fe-b043cbe4e512') }}/" + val,
            type: 'GET',
            success: function(response) {
                $('#editKabupaten').modal('show');
                $('#e_publicid').val(response.data.id);
                eProvinsi(response.data.id_provinsi);
                $('#e_id_kabu').val(response.data.id_kabupaten);
                $('#e_id_satker').val(response.data.satker);
                $('#e_nm_kabu').val(response.data.kabupaten);
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

    function eProvinsi(val)
    {
        $.ajax({
            url: "{{ url('1178abf7-1d6a-4499-88c4-0e065a204efa') }}/",
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("e_id_prov");
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_provinsi;
                    opt.text = response.data[i].nama;
                    sel.add(opt);

                    if (opt.value == val) {
                        $('select#e_id_prov option[value="' + opt.value + '"]').attr('selected', true);
                    }
                }

                $('#e_id_prov').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#editKabupaten') // 🔥 INI KUNCI
                });
            },
            error: function(err) {
                console.error("❌ Gagal memuat provinsi:", err);
                reject(err);
            }
        });
    }

    // Update Data
    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_edit_kabupaten");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData  = new FormData(form);
            const e_publicid   = formData.get("e_publicid")?.trim();
            const e_id_prov    = formData.get("e_id_prov")?.trim();
            const e_id_kabu    = formData.get("e_id_kabu")?.trim();
            const e_id_satker  = formData.get("e_id_satker")?.trim();
            const e_nm_kabu    = formData.get("e_nm_kabu")?.trim();
            const e_lat        = formData.get("e_lat")?.trim();
            const e_long       = formData.get("e_long")?.trim();
            const eis_trash    = formData.get("eis_trash")?.trim();
            const token        = formData.get("_token")?.trim();

            const fields = {
                e_publicid:  { value: e_publicid, message: "Maaf, id form harus diisi." },
                e_id_prov:   { value: e_id_prov, message: "Maaf, ID provinsi harus dipilih.", skipIf: 'Pilih' },
                e_id_kabu:   { value: e_id_kabu, message: "Maaf, ID kabupaten harus diisi." },
                e_id_satker: { value: e_id_satker, message: "Maaf, ID satker harus diisi." },
                e_nm_kabu:   { value: e_nm_kabu, message: "Maaf, nama kabupaten harus diisi." },
                e_lat:       { value: e_lat, message: "Maaf, latitude harus diisi." },
                e_long:      { value: e_long, message: "Maaf, longitude harus diisi." },
                eis_trash:   { value: eis_trash, message: "Maaf, status harus dipilih.", skipIf: 'Pilih' },
                token:       { value: token, message: "Token harus diisi." }
            };

            for (const key in fields) {
                const { value, message } = fields[key];
                if (!value) {
                    return showError(message);
                }
            }

            try {
                // tutup modal form
                $('#editKabupaten').modal('hide');

                // tampilkan loader
                showLoaderHard();

                const response = await fetch("{{ url('c5baa71b-7858-4af6-aa94-a286632b7e02') }}", {
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
                        "Maaf, pastikan ID kabupaten dan satker tidak sama sebelumnya.",
                        "error"
                    ).then(() => {
                        $('#editKabupaten').modal('show');
                    });

                } else {
                    Swal.fire(
                        "Gagal",
                        "Terjadi kesalahan saat menyimpan.",
                        "error"
                    ).then(() => {
                        $('#editKabupaten').modal('show');
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
                $('#tambahKabupaten').modal('hide');
                $('#detailKabupaten').modal('hide');
                $('#editKabupaten').modal('hide');
                $('#listKabupaten').modal('hide');
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
                url: "{{ url('c293c57c-7c3f-4d53-a221-696265242d07') }}/" + val,
                type: 'GET',
                success: function(response) {
                    $('#detailKabupaten').modal('show');
                    $('#d_provinsi').text(response.data.provinsi);
                    $('#d_kabupaten').text(response.data.kabupaten);
                    $('#d_id_kabu').text(response.data.id_kabupaten);
                    $('#d_satker').text(response.data.satker);
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
                        url: "{{ url('b6899aea-264c-4cfb-af7b-f7f81b2f4ae9') }}",
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
        $("input[name='id_satker']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9']/g, ''));
        });
        $("input[name='nm_kabu']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ' ]/g, ''));
        });
        $("input[name='lat']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-.,'"']/g, ''));
        });
        $("input[name='long']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-.,'"']/g, ''));
        });
        $("input[name='e_id_satker']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9']/g, ''));
        });
        $("input[name='e_id_kabu']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9']/g, ''));
        });
        $("input[name='e_nm_kabu']").on('input', function(e) {
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
