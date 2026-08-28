<script type="text/javascript">
    window.onload = function() {
    };

    $(document).ready(function () {
        $('#parametersTable').DataTable({
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
                            $('#tambahParameters').modal('show');
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
            "ajax": "{{ route('parameters.table') }}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "name" },
                { "data": "group" },
                { "data": "value" },
                { "data": "keterangan" },
                { "data": "status" },
                { "data": "aksi" },
            ]
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_parameters");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const nama = formData.get("nama_parameters")?.trim();
                const group = formData.get("group_parameters")?.trim();
                const value = formData.get("value_parameters")?.trim();
                const keterangan = formData.get("ket_parameters")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    nama: { value: nama, message: "Maaf, nama harus diisi." },
                    group: { value: group, message: "Maaf, group harus diisi." },
                    value: { value: value, message: "Maaf, value harus diisi." },
                    keterangan: { value: keterangan, message: "Maaf, keterangan harus diisi." },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("tambahParameters");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('5fefaab8-3603-47c0-a526-375b9d85f198') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    // Jangan set Content-Type saat pakai FormData
                    // CSRF token sudah ada di formData
                    },
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                hideLoader(); // sembunyikan loader jika ada
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
                url: "{{ url('42f60380-be95-4c7c-9354-bd186095e697') }}/" + val,
                type: 'GET',
                success: function(response){
                    if(response.message == 200){
                        $('#editParameters').modal('show');
                        $('#e_id').attr('value', response.data[0].public_id);
                        $('#e_nama_parameters').attr('value', response.data[0].name);
                        $('#e_group_parameters').attr('value', response.data[0].group);
                        $('#e_value_parameters').attr('value', response.data[0].value);
                        $('textarea#e_ket_parameters').val(response.data[0].keterangan);
                        if(response.data[0].is_trash == 1){
                            document.getElementById('e_is_trash').value = response.data[0].is_trash;
                        }else if(response.data[0].is_trash == 0){
                            document.getElementById('e_is_trash').value = response.data[0].is_trash;
                        }
                    }else{
                        Swal.fire({
                            title: "Informasi",
                            text: "Maaf, Data tidak tersedia.",
                            icon: "error",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: "OK"
                        });
                    }
                }
            });
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("edit_form_parameters");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const public = formData.get("e_id")?.trim();
                const e_nama = formData.get("e_nama_parameters")?.trim();
                const e_group = formData.get("e_group_parameters")?.trim();
                const e_value = formData.get("e_value_parameters")?.trim();
                const e_keterangan = formData.get("e_ket_parameters")?.trim();
                const e_is_trash = formData.get("e_is_trash")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    public: { value: public, message: "Maaf, id form tidak boleh kosong." },
                    e_nama: { value: e_nama, message: "Maaf, nama harus diisi." },
                    e_group: { value: e_group, message: "Maaf, group harus diisi." },
                    e_value: { value: e_value, message: "Maaf, value harus diisi." },
                    e_keterangan: { value: e_keterangan, message: "Maaf, keterangan harus diisi." },
                    e_is_trash: { value: e_is_trash, message: "Maaf, status data harus dipilih.", skipIf: 'Pilih' },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("editParameters");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('307da404-605e-42c6-9d33-69ee568130a5') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    // Jangan set Content-Type saat pakai FormData
                    // CSRF token sudah ada di formData
                    },
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else if(result.message === 201){
                    //
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                hideLoader(); // sembunyikan loader jika ada
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
                        url: "{{ url('3ff5199e-27db-4cfe-9304-24c11a43d85a') }}",
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
                $('#tambahParameters').modal('hide');
                $('#editParameters').modal('hide');
                $('#detailParameters').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                setTimeout(function() {
                    window.location.href = window.location.pathname;
                }, 1000);
            }
        });
    }

    $(function(){
        $("input[name='nama_parameters']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9 ]/g, ''));
        });
        $("input[name='group_parameters']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-= ]/g, ''));
        });
        $("input[name='value_parameters']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,!=@""''/-]/g, ''));
        });
        $("textarea[name='ket_parameters']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9., ]/g, ''));
        });
        $("input[name='e_nama_parameters']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9 ]/g, ''));
        });
        $("input[name='e_group_parameters']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-= ]/g, ''));
        });
        $("input[name='e_value_parameters']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,!=@""''/-]/g, ''));
        });
        $("textarea[name='e_ket_parameters']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9., ]/g, ''));
        });
    });
</script>