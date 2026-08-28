<script type="text/javascript">
    window.onload = function() {
        var superadmin = "{{ auth()->user()->id_roles; }}";
        
        if (superadmin != 1 && superadmin != 12) {
            $('#hide_group').hide();
            $('#hide_status').hide();
            $('#hide_provinsi').hide();
            $('#hide_kabupaten').hide();
            $('#hide_kecamatan').hide();
            $('#hide_direktorat').hide();
            $('#hide_subdit').hide();
            $('#margin_username').css('margin-top', '15px');
        }

        $('#tutup_files').hide();
        $('#lihat_files').hide();
        $('#tampil_gambar').hide();
    };

    $(document).ready(function () {
        $('#usersTable').DataTable({
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
                            $('#tambahMenu').modal('show');
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
            "ajax": "{{ route('users.table') }}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "nama" },
                { "data": "username" },
                // { "data": "password" },
                { "data": "mails" },
                { "data": "verifikasi" },
                { "data": "status" },
                { "data": "aksi" },
            ]
        });
    });

    $.ajax({
        url: "{{ url('539dfeed-030f-4dad-b4ff-6b13286c6ce7') }}",
        type: 'GET',
        success: function(response){
            var sel = document.getElementById("users_roles");

            // Kosongkan dulu pilihan sebelumnya (opsional)
            sel.innerHTML = "";

            var defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.text = "Pilih";
            sel.add(defaultOption);

            // Tambahkan data dari response
            for (var i = 0; i < response.data.length; i++) {
                var opt = document.createElement("option");
                opt.value = response.data[i].id;
                opt.text = response.data[i].nama;
                sel.add(opt);
            }
        }
    });

    // proses tambah
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_users");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const group = formData.get("users_roles")?.trim();
                const nama = formData.get("username")?.trim();
                const keterangan = formData.get("emails")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    group: { value: group, message: "Maaf, group harus dipilih.", skipIf: 'Pilih' },
                    nama: { value: nama, message: "Maaf, username harus diisi." },
                    keterangan: { value: keterangan, message: "Maaf, email harus diisi." },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("tambahMenu");
                showLoader();

                const response = await fetch("{{ url('4e8954cf-2197-422f-b484-2238b7f24398') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    },
                });

                const result = await response.json();

                if (result.message === 200) {
                    hideModal("tambahMenu");
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else if(result.message === 201) {
                    Swal.fire("Gagal", "Maaf, username sudah tersedia.", "error");
                    showModal("tambahMenu");
                } else if(result.message === 202) {
                    Swal.fire("Gagal", "Maaf, pastikan ekstensi email sudah benar.", "error");
                    showModal("tambahMenu");
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                    showModal("tambahMenu");
                }
            } catch (error) {
                // console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
                showModal("tambahMenu");
            } finally {
                hideLoader();
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
        if (!val) {
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
            url: "{{ url('13d8cabe-aec5-4f47-b5cb-9154ff24d0ff') }}/" + val,
            type: 'GET',
            success: function(response) {
                if (response.message == 200) {
                    const data = response.data[0];
                    $('#editUsers').modal('show');

                    // Akun
                    $('#publicid_users').val(data.public_id);
                    $('#edit_username').val(data.username);
                    $('#edit_email').val(data.mails);
                    $('#edit_status_users').val(data.is_trash);

                    // Profile
                    $('#publicid_profile').val(data.public_id_profile);
                    $('#edit_nama').val(data.pemilik);
                    $('#edit_tgl').val(data.tgl);
                    $('#edit_tlp').val(data.tlp);
                    $('#files_old').val(data.photo);
                    $('.class_lihat').val(data.photo);
                    $('textarea#edit_alamat').val(data.alamat);
                    $('#lihat_files').toggle(!!data.photo);

                    $(".lahiredit").datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayHighlight: true,
                    });

                    // Panggil dropdown berurutan
                    Provinsi(data.id_provinsi, function() {
                        // console.log("✅ Provinsi Selesai");
                        Kabupaten(data.id_provinsi, data.id_kabupaten, function() {
                            // console.log("✅ Kabupaten Selesai");
                            Kecamatan(data.id_kabupaten, data.id_kecamatan, function() {
                                // console.log("✅ Kecamatan Selesai");
                                Direktorat(data.id_direktorat, function() {
                                    // console.log("✅ Direktorat Selesai");
                                    Subdit(data.id_direktorat, data.id_subdit, function() {
                                        // console.log("✅ Subdit Selesai — harusnya lanjut ke Roles");
                                        Roles(data.id_roles, function() {
                                            // console.log("✅ Roles selesai diisi dan diset:", $("#edit_group").val());
                                        });
                                    });
                                });
                            });
                        });
                    });
                } else {
                    Swal.fire({
                        title: "Informasi",
                        text: "Maaf, Data tidak ditemukan.",
                        icon: "error",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("[Edit] Gagal memuat data:", error);
            }
        });
    };

    function Roles(selectedId, callback) {
        // console.log("%c[Roles] Dipanggil dengan id:", "color:orange", selectedId);

        $.ajax({
            url: "{{ url('539dfeed-030f-4dad-b4ff-6b13286c6ce7') }}", // API roles
            type: "GET",
            dataType: "json",
            success: function(response) {
                // console.log("%c[Roles] Success AJAX!", "color:green", response);
                
                const dropdown = $('#edit_group');
                dropdown.empty().append('<option value="">Pilih</option>');

                let rolesData = [];
                if (Array.isArray(response)) {
                    rolesData = response;
                } else if (response.data && Array.isArray(response.data)) {
                    rolesData = response.data;
                }

                // console.log("%c[Roles] Data diterima:", "color:green", rolesData);

                rolesData.forEach(role => {
                    dropdown.append(`<option value="${String(role.id)}">${role.nama}</option>`);
                });

                const stringSelectedId = String(selectedId);

                setTimeout(() => {
                    // console.log("%c[Roles] Mencoba set dropdown ke:", "color:blue", stringSelectedId);
                    dropdown.val(stringSelectedId).trigger('change');

                    if (dropdown.val() !== stringSelectedId) {
                        dropdown.find(`option[value="${stringSelectedId}"]`).attr("selected", true);
                    }

                    // console.log("%c[Roles] Setelah diset, nilai dropdown:", "color:purple", dropdown.val());

                    if (typeof callback === "function") {
                        // console.log("%c[Roles] Memanggil callback()", "color:red");
                        callback();
                    }
                }, 100);
            },
            error: function(xhr, status, error) {
                console.error("[Roles] Gagal memuat data:", error);
                if (typeof callback === "function") {
                    // console.log("%c[Roles] Callback tetap dipanggil di blok error", "color:red");
                    callback();
                }
            }
        });
    }

    // Pastikan value baru diset setelah modal muncul
    $('#editUsers').on('shown.bs.modal', function () {
        const dropdown = $('#edit_group');
        const selectedId = dropdown.data('selected');

        if (selectedId) {
            // hapus semua selected lama
            dropdown.find('option').prop('selected', false);

            // set baru
            dropdown.val(String(selectedId)).trigger('change');

            // jika tidak berhasil, paksa manual
            if (dropdown.val() != String(selectedId)) {
                dropdown.find(`option[value="${selectedId}"]`).prop('selected', true);
            }

            // console.log("Modal ditampilkan -> Set dropdown ke:", selectedId, "=> hasil:", dropdown.val());
            // console.log("Option aktif:", dropdown.find('option:selected').text());
        }
    });

    function Provinsi(val, callback)
    {
        $('#edit_provinsi').children('option').remove();
        $('#edit_kabupaten').children('option').remove();
        $('#edit_kecamatan').children('option').remove();

        $.ajax({
            url: "{{ url('1178abf7-1d6a-4499-88c4-0e065a204efa') }}",
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("edit_provinsi");

                // Kosongkan dulu pilihan sebelumnya
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_provinsi;
                    opt.text = response.data[i].nama;
                    sel.add(opt);
                    if (String(opt.value) === String(val)) {
                        $(opt).attr("selected", true);
                    }
                }

                // ✅ Jalankan callback kalau ada
                if (typeof callback === "function") callback();
            },
            error: function(xhr, status, error) {
                // console.error("[Provinsi] Gagal memuat data:", error);
                if (typeof callback === "function") callback();
            }
        });
    }

    function Kabupaten(val, id, callback)
    {
        $('#edit_kabupaten').children('option').remove();
        $('#edit_kecamatan').children('option').remove();

        $.ajax({
            url: "{{ url('612817ad-4ba7-4ccb-9a6c-c84dc0807f65') }}/" + val,
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("edit_kabupaten");

                // Kosongkan dulu pilihan sebelumnya
                sel.innerHTML = "";

                // Opsi default
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                if (response && response.data && Array.isArray(response.data)) {
                    for (var i = 0; i < response.data.length; i++) {
                        var opt = document.createElement("option");
                        opt.value = response.data[i].id_kabupaten;
                        opt.text = response.data[i].nama;
                        sel.add(opt);

                        if (opt.value == id) {
                            $('select#edit_kabupaten option[value="' + opt.value + '"]').attr('selected', true);
                        }
                    }
                }

                // Panggil callback jika ada
                if (typeof callback === "function") {
                    callback();
                }
            },
            error: function(xhr, status, error) {
                // console.error("Gagal memuat kabupaten:", error);
                if (typeof callback === "function") {
                    callback(error);
                }
            }
        });
    }

    function Kecamatan(val, id, callback)
    {
        $('#edit_kecamatan').children('option').remove();

        $.ajax({
            url: "{{ url('e720650a-53af-4b99-9e75-0740c8987d9e') }}/" + val,
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("edit_kecamatan");

                // Kosongkan dulu pilihan sebelumnya
                sel.innerHTML = "";

                // Opsi default
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                if (response && response.data && Array.isArray(response.data)) {
                    for (var i = 0; i < response.data.length; i++) {
                        var opt = document.createElement("option");
                        opt.value = response.data[i].id_kecamatan;
                        opt.text = response.data[i].nama;
                        sel.add(opt);

                        if (opt.value == id) {
                            $('select#edit_kecamatan option[value="' + opt.value + '"]').attr('selected', true);
                        }
                    }
                }

                // Jalankan callback jika disediakan
                if (typeof callback === "function") {
                    callback();
                }
            },
            error: function(xhr, status, error) {
                // console.error("Gagal memuat kecamatan:", error);
                if (typeof callback === "function") {
                    callback(error);
                }
            }
        });
    }

    function Direktorat(val, callback) {
        $('#edit_direktorat').children('option').remove();
        $('#edit_subdit').children('option').remove();

        $.ajax({
            url: "{{ url('2832984d-4b10-4c4a-b2b6-0bc197ac6962') }}",
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("edit_direktorat");

                // Kosongkan pilihan sebelumnya
                sel.innerHTML = "";

                // Tambah opsi default
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambah data dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_direktorat;
                    opt.text = response.data[i].nama;
                    sel.add(opt);

                    // Auto select jika cocok
                    if (opt.value == val) {
                        $(opt).attr('selected', true);
                    }
                }

                // ✅ Jalankan callback jika ada
                if (typeof callback === 'function') {
                    callback();
                }
            },
            error: function() {
                // console.error("Gagal memuat data direktorat");
                if (typeof callback === 'function') {
                    callback(); // tetap panggil supaya alur tidak terhenti
                }
            }
        });
    }

    function Subdit(val, id, callback) {
        $('#edit_subdit').children('option').remove();

        $.ajax({
            url: "{{ url('53b3695a-2c5d-44c6-bf63-f2ad4cc7f285') }}/" + val,
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("edit_subdit");

                // Kosongkan pilihan sebelumnya
                sel.innerHTML = "";

                // Tambahkan opsi default
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

                    // Auto select jika cocok
                    if (opt.value == id) {
                        $(opt).attr('selected', true);
                    }
                }

                // ✅ Jalankan callback jika ada
                if (typeof callback === 'function') {
                    callback();
                }
            },
            error: function() {
                // console.error("Gagal memuat data subdit");
                if (typeof callback === 'function') {
                    callback(); // tetap dipanggil agar alur tidak terhenti
                }
            }
        });
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
                url: "{{ url('5b4dedc9-1d14-47fc-8e37-bafff56e89d1') }}/" + val,
                type: 'GET',
                success: function(response){
                    if(response.message == 200){
                        $('#detailUsers').modal('show');
                        $('#d_group').text(response.data[0].nama);
                        $('#d_username').text(response.data[0].username);
                        $('#d_mails').text(response.data[0].mails);
                        if(response.data[0].id_roles == 1 || response.data[0].id_roles == 12 || response.data[0].id_roles == 13) // superadmin - admin - tamu
                        {
                            $('#d_cakupan').text('semua data');
                            $('#d_nama').text(response.data[0].pemilik);
                            $('#d_tgl').text(response.data[0].tanggal);
                            $('#d_usia').text(response.data[0].usia + ' Tahun');
                            $('#d_tlp').text(response.data[0].tlp);
                            $('#d_alamat').text(response.data[0].alamat);
                        }else{
                            if(response.data[0].id_roles == 2){ // provinsi
                                $('#d_cakupan').text(response.data[0].provinsi);
                                $('#d_nama').text(response.data[0].pemilik);
                                $('#d_tgl').text(response.data[0].tanggal);
                                $('#d_usia').text(response.data[0].usia + ' Tahun');
                                $('#d_tlp').text(response.data[0].tlp);
                                $('#d_alamat').text(response.data[0].alamat);
                            }else if(response.data[0].id_roles == 3){ // kabupaten
                                $('#d_cakupan').text(response.data[0].kabupaten);
                                $('#d_nama').text(response.data[0].pemilik);
                                $('#d_tgl').text(response.data[0].tanggal);
                                $('#d_usia').text(response.data[0].usia + ' Tahun');
                                $('#d_tlp').text(response.data[0].tlp);
                                $('#d_alamat').text(response.data[0].alamat);
                            }else if(response.data[0].id_roles == 4){ // kecamatan
                                $('#d_cakupan').text(response.data[0].kecamatan);
                                $('#d_nama').text(response.data[0].pemilik);
                                $('#d_tgl').text(response.data[0].tanggal);
                                $('#d_usia').text(response.data[0].usia + ' Tahun');
                                $('#d_tlp').text(response.data[0].tlp);
                                $('#d_alamat').text(response.data[0].alamat);
                            }else if(response.data[0].id_roles == 6 || response.data[0].id_roles == 7){ // sekretariat - direktorat
                                $('#d_cakupan').text(response.data[0].direktorat);
                                $('#d_nama').text(response.data[0].pemilik);
                                $('#d_tgl').text(response.data[0].tanggal);
                                $('#d_usia').text(response.data[0].usia + ' Tahun');
                                $('#d_tlp').text(response.data[0].tlp);
                                $('#d_alamat').text(response.data[0].alamat);
                            }else if(response.data[0].id_roles == 8){ // subdit
                                $('#d_cakupan').text(response.data[0].subdit);
                                $('#d_nama').text(response.data[0].pemilik);
                                $('#d_tgl').text(response.data[0].tanggal);
                                $('#d_usia').text(response.data[0].usia + ' Tahun');
                                $('#d_tlp').text(response.data[0].tlp);
                                $('#d_alamat').text(response.data[0].alamat);
                            }else if(response.data[0].id_roles == 10){ // umum
                                $('#d_cakupan').text('umum, sesuai ID');
                                $('#d_nama').text(response.data[0].pemilik);
                                $('#d_tgl').text(response.data[0].tanggal);
                                $('#d_usia').text(response.data[0].usia + ' Tahun');
                                $('#d_tlp').text(response.data[0].tlp);
                                $('#d_alamat').text(response.data[0].alamat);
                            }
                        }
                        $('#d_status').text(response.data[0].status);
                    }else if(response.message == 404){
                        Swal.fire({
                            title: "Informasi",
                            text: "Maaf, Data tidak ditemukan.",
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

    // proses update
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("edit_form_users");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const eakun = formData.get("publicid_users")?.trim();
                const eprofile = formData.get("publicid_profile")?.trim();
                const egroup = formData.get("edit_group")?.trim();
                const eusername = formData.get("edit_username")?.trim();
                const emails = formData.get("edit_email")?.trim();
                const estatus = formData.get("edit_status_users")?.trim();
                const eprovinsi = formData.get("edit_provinsi")?.trim();
                const ekabupaten = formData.get("edit_kabupaten")?.trim();
                const ekecamatan = formData.get("edit_kecamatan")?.trim();
                const edirektorat = formData.get("edit_direktorat")?.trim();
                const esubdit = formData.get("edit_subdit")?.trim();
                const enama = formData.get("edit_nama")?.trim();
                const etgl = formData.get("edit_tgl")?.trim();
                const etlp = formData.get("edit_tlp")?.trim();
                const ealamat = formData.get("edit_alamat")?.trim();
                const ephoto = formData.get("edit_files");
                const eold = formData.get("files_old")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    eakun: { value: eakun, message: "Maaf, id akun harus diisi." },
                    eprofile: { value: eprofile, message: "Maaf, id profile harus diisi." },
                    egroup: { value: egroup, message: "Maaf, group harus dipilih.", skipIf: 'Pilih' },
                    eusername: { value: eusername, message: "Maaf, username harus diisi." },
                    emails: { value: emails, message: "Maaf, email harus diisi." },
                    estatus: { value: estatus, message: "Maaf, status data harus dipilih.", skipIf: 'Pilih' },
                    enama: { value: enama, message: "Maaf, nama lengkap harus diisi." },
                    etgl: { value: etgl, message: "Maaf, tanggal lahir harus diisi." },
                    etlp: { value: etlp, message: "Maaf, nomor telepon harus diisi." },
                    ealamat: { value: ealamat, message: "Maaf, alamat lengkap harus diisi." },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("editUsers");
                showLoader();

                const response = await fetch("{{ url('dc430709-2cad-4343-9dfa-2c64cf91e5b2') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    },
                });

                const result = await response.json();
                
                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else if(result.message === 202){
                    Swal.fire("Gagal", "Ukuran file, tidak lebih dari 3 MB.", "error");
                    showModal("editUsers");
                } else if(result.message === 203){
                    Swal.fire("Gagal", "Type file di ijinkan, hanya jpg, jpeg, dan png.", "error");
                    showModal("editUsers");
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                // console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                hideLoader();
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
                        url: "{{ url('b3ee64f3-d3fa-4913-8252-40def4af0711') }}",
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
                $('#tambahMenu').modal('hide');
                $('#detailUsers').modal('hide');
                $('#editUsers').modal('hide');
                $('#usersPassword').modal('hide');
                $('#usersCustomPassword').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

    Page.Tutup = function()
    {
        $('#lihat_files').show('slow');
        $('#tutup_files').hide();
        $('#tampil_gambar').hide('slow');
    }

    Page.Password = function(val)
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
            $('#usersPassword').modal('show');
            $('#default_password').attr('value', val);
            $('#custom_password').attr('value', val);
        }
    }

    Page.DefaultPassword = function(val)
    {
        if(val == '' || val == 0 || val == null){
            Swal.fire("Error", "Maaf, ID tidak ditemukan.", "error");
        }else{
            $.ajax({
                url: "{{ url('7d205af0-d79a-479e-b9d6-37b8658c0886') }}/" + val,
                type: 'GET',
                beforeSend: function() {
                    $("#Loader").modal('show');
                    $('#usersPassword').modal('hide');
                },
                complete: function(response) {
                    if(response.responseJSON.message == 201){
                        Swal.fire("Error", "Maaf, terjadi kesalahan perbaharui data.", "error");
                        $('#usersPassword').modal('show');
                        $('#Loader').hide();
                    }else{
                        $('#Loader').hide();
                        $('#usersPassword').modal('hide');
                    }
                },
                success: function(response){
                    if(response.message == 200){
                        Swal.fire("Berhasil", "Password berhasil di perbaharui.","success").then( () => {location.href = location.pathname;});
                    }
                }
            });
        }
    }

    Page.CustomPassword = function(val)
    {
        if(val == '' || val == 0 || val == null){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            $('#usersCustomPassword').modal('show');
            $('#usersPassword').modal('hide');
            $('#custom_iduser').attr('value', val);
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("formedit_usercustom");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const eid = formData.get("custom_iduser")?.trim();
                const ecustom = formData.get("custom_password_old")?.trim();
                const enew = formData.get("custom_password_baru")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    eid: { value: eid, message: "Maaf, id harus diisi." },
                    ecustom: { value: ecustom, message: "Maaf, password lama harus diisi." },
                    enew: { value: enew, message: "Maaf, password baru harus diisi." },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("usersCustomPassword");
                showLoader();

                const response = await fetch("{{ url('728bf49f-90ce-4dbc-a87e-1cacf452310b') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                    },
                });

                const result = await response.json();
                
                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success").then(() => {
                    window.location.href = window.location.pathname;
                    });
                } else if(result.message === 202){
                    Swal.fire("Gagal", "Password lama tidak sesuai.", "error");
                    showModal("usersCustomPassword");
                } else if(result.message === 201){
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                    showModal("usersCustomPassword");
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                // console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                hideLoader();
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

    function Lihat(val)
    {
        $('#lihat_files').hide();
        $('#tutup_files').show('slow');
        $('#tampil_gambar').show('slow');
        $("#gambar_users").attr("src", "{{ url('storage/') }}/" + val);
    }

    $(function(){
        $("input[name='username']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9-]/g, ''));
        });
        $("input[name='emails']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^a-zA-Z0-9.,_!@-]/g, ''));
        });
        $("input[name='edit_username']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9-]/g, ''));
        });
        $("input[name='edit_email']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^a-zA-Z0-9.,_!@-]/g, ''));
        });
        $("input[name='edit_nama']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9., ]/g, ''));
        });
        $("input[name='edit_tgl']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("input[name='edit_tlp']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("textarea[name='edit_alamat']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("input[name='custom_password_old']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9!.,/-]/g, ''));
        });
        $("input[name='custom_password_baru']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9!.,/-]/g, ''));
        });
    });
</script>