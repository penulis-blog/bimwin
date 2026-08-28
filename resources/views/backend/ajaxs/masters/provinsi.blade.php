<script type="text/javascript">
    window.onload = function() {
    };

    // json data
    $(document).ready(function() {
        $('#tableProvinsi').DataTable({
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
                        $('#tambahProvinsi').modal('show');
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
            "ajax": "{{ route('provinsi.table') }}",
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
                    "data": "nama"
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

    function killLoader() {
        const loader = document.getElementById('Loader');

        if (loader) {
            loader.classList.remove('show');
            loader.style.display = 'none';
            loader.setAttribute('aria-hidden', 'true');
        }

        // hapus backdrop
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

        // reset body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }

    // insert data
    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_provinsi");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData  = new FormData(form);
            const id_prov   = formData.get("id_prov")?.trim();
            const id_satker = formData.get("id_satker")?.trim();
            const nm_prov   = formData.get("nm_prov");
            const lat       = formData.get("lat");
            const long      = formData.get("long");
            const token     = formData.get("_token")?.trim();

            const fields = {
                id_prov:   { value: id_prov,   message: "Maaf, ID provinsi harus diisi." },
                id_satker: { value: id_satker, message: "Maaf, ID satker harus diisi." },
                nm_prov:   { value: nm_prov,   message: "Maaf, nama provinsi harus dipilih." },
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
                $('#tambahProvinsi').modal('hide');

                // tampilkan loader
                showLoaderHard();

                const response = await fetch("{{ url('56fb3473-7ac4-4ca9-8737-69fcd2c72c05') }}", {
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
                        "Maaf, pastikan ID provinsi dan satker tidak sama sebelumnya.",
                        "error"
                    ).then(() => {
                        $('#tambahProvinsi').modal('show');
                    });

                } else {
                    Swal.fire(
                        "Gagal",
                        "Terjadi kesalahan saat menyimpan.",
                        "error"
                    ).then(() => {
                        $('#tambahProvinsi').modal('show');
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
            url: "{{ url('1ca3381c-4373-4ba5-b2bf-3f6259763303') }}/" + val,
            type: 'GET',
            success: function(response) {
                $('#editProvinsi').modal('show');
                $('#e_publicid').val(response.data.id);
                $('#e_id_prov').val(response.data.id_provinsi);
                $('#e_id_satker').val(response.data.satker);
                $('#e_nm_prov').val(response.data.nama);
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

    function killLoader_edit() {
        const loader = document.getElementById('Loader');

        if (loader) {
            loader.classList.remove('show');
            loader.style.display = 'none';
            loader.setAttribute('aria-hidden', 'true');
        }

        // hapus backdrop
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

        // reset body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }

    // Update Data
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_edit_provinsi");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const e_publicid = formData.get("e_publicid")?.trim();
            const e_id_prov = formData.get("e_id_prov")?.trim();
            const e_id_satker = formData.get("e_id_satker")?.trim();
            const e_nm_prov = formData.get("e_nm_prov")?.trim();
            const e_lat = formData.get("e_lat")?.trim();
            const e_long = formData.get("e_long")?.trim();
            const eis_trash = formData.get("eis_trash")?.trim();
            const token = formData.get("_token")?.trim();

            const fields = {
                e_publicid:  { value: e_publicid, message: "Maaf, id form harus diisi." },
                e_id_prov:   { value: e_id_prov,   message: "Maaf, ID provinsi harus diisi." },
                e_id_satker: { value: e_id_satker, message: "Maaf, ID satker harus diisi." },
                e_nm_prov:   { value: e_nm_prov,   message: "Maaf, nama provinsi harus dipilih." },
                e_lat:       { value: e_lat,       message: "Maaf, latitude harus diisi." },
                e_long:      { value: e_long,      message: "Maaf, longitude harus diisi." },
                eis_trash:   { value: eis_trash, message: "Maaf, status harus dipilih.", skipIf: 'Pilih' },
                token:       { value: token,     message: "Token harus diisi." }
            };

            for (const key in fields) {
                const { value, message, skipIf } = fields[key];
                if (!value || value === skipIf) {
                    return showError(message);
                }
            }

            try {
                $('#editProvinsi').modal('hide');
                $('#Loader').modal('show');

                const response = await fetch("{{ url('76885c0e-b902-4d5b-a04a-43d139599bb9') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                // 🔴 PASTIKAN LOADER MATI SEBELUM APAPUN
                killLoader_edit();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success")
                        .then(() => {
                            window.location.href = window.location.pathname;
                        });

                } else if (result.message === 201) {
                    Swal.fire(
                        "Gagal",
                        "Maaf, pastikan ID provinsi dan satker tidak sama sebelumnya.",
                        "error"
                    ).then(() => {
                        $('#editProvinsi').modal('show');
                    });

                } else {
                    Swal.fire(
                        "Gagal",
                        "Terjadi kesalahan saat menyimpan.",
                        "error"
                    ).then(() => {
                        $('#editProvinsi').modal('show');
                    });
                }

            } catch (error) {
                killLoader_edit();
                console.error(error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            }
        });

        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

        function showModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                bootstrap.Modal.getOrCreateInstance(modal).show();
            }
        }

    });

    Page.Batal = function() {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahProvinsi').modal('hide');
                $('#detailProvinsi').modal('hide');
                $('#editProvinsi').modal('hide');
                $('#listProvinsi').modal('hide');
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
                url: "{{ url('87714392-841d-4c2f-829a-9a7049ece869') }}/" + val,
                type: 'GET',
                success: function(response) {
                    $('#detailProvinsi').modal('show');
                    $('#d_provinsi').text(response.data.id_provinsi);
                    $('#d_satker').text(response.data.satker);
                    $('#d_nama').text(response.data.nama);
                    $('#d_latitude').text(response.data.latitude);
                    $('#d_longitude').text(response.data.longitude);
                    if(response.data.is_actived == 1){
                        $('#d_status').text('data aktif');
                    }else{
                        $('#d_status').text('data nonaktif');
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
                        url: "{{ url('40fb583c-a66f-4b49-9c0a-6f1454b03c9e') }}",
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
        $("input[name='id_prov']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9']/g, ''));
        });
        $("input[name='id_satker']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9']/g, ''));
        });
        $("input[name='nm_prov']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ' ]/g, ''));
        });
        $("input[name='lat']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-.,'"']/g, ''));
        });
        $("input[name='long']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-.,'"']/g, ''));
        });
        $("input[name='e_id_prov']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9']/g, ''));
        });
        $("input[name='e_id_satker']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9']/g, ''));
        });
        $("input[name='e_nm_prov']").on('input', function(e) {
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
