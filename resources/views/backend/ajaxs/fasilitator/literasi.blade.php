<script type="text/javascript">
    window.onload = function() {
        $('.lihatPhoto').hide();
        $('.tutupPhoto').hide();
        $('#contentphoto').hide();
    };

    $('#gol_bimwin').select2({
        width: '100%',
        placeholder: 'Pilih',
        minimumResultsForSearch: 0,
        dropdownParent: $('#tambahLiterasi') // 🔥 INI KUNCI
    });

    $(document).ready(function () {
        $('#literasiTable').DataTable({
            fixedColumns: {
                left: 1,
                right: 1
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 415,

            pageLength: 9,
            lengthChange: false, // Opsional

            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Tambah Data',
                    action: function (e, dt, node, config) {
                        var tambah = {{ get_add() }};
                        if (tambah == 1) {
                            $('#tambahLiterasi').modal('show');
                        } else {
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
                {
                    text: 'Laporan',
                    action: function (e, dt, node, config) {
                        var laporan = {{ get_laporan() }};
                        if (laporan == 1) {
                            $('#laporanMenu').modal('show');
                        } else {
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
                },{
                    text: 'Import',
                    action: function (e, dt, node, config) {
                        $('#importLiterasi').modal('show');
                    }
                }
            ],
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: "{{ route('literasipeserta.table') }}",
            columns: [
                { data: "DT_RowIndex" },
                { data: "judul_acara" },
                { data: "keterangan_angkatan" },
                { data: "provinsi" },
                { data: "nama" },
                { data: "aksi" }
            ]
        });
    });

    // Ambil Kegiatan Literasi Keuangan
    $.ajax({
        url: "{{ url('aed11d85-004d-43e1-af79-0616e7b51701') }}",
        type: 'GET',
        success: function(response) {
            var sel = document.getElementById("keg_bimwin");

            // Kosongkan pilihan sebelumnya
            sel.innerHTML = "";

            // Tambahkan option default
            var defaultOption = document.createElement("option");
            defaultOption.value = "";
            defaultOption.text = "Pilih";
            sel.add(defaultOption);

            // Loop data
            for (var i = 0; i < response.data.length; i++) {
                var item = response.data[i];

                if (item.kategori != 459) continue; // literasi keuangan

                var opt = document.createElement("option");
                opt.value = item.id;
                opt.text = item.judul_acara;
                sel.add(opt);
            }

            $('#keg_bimwin').select2({
                width: '100%',
                placeholder: 'Pilih',
                minimumResultsForSearch: 0,
                dropdownParent: $('#tambahLiterasi') // 🔥 INI KUNCI
            });
        }
    });

    // Ambil Provinsi
    $.ajax({
        url: "{{ url('1178abf7-1d6a-4499-88c4-0e065a204efa') }}",
        type: 'GET',
        success: function(response){
            var sel = document.getElementById("prov_bimwin");

            // Kosongkan dulu pilihan sebelumnya (opsional)
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
            }

            $('#prov_bimwin').select2({
                width: '100%',
                placeholder: 'Pilih',
                minimumResultsForSearch: 0,
                dropdownParent: $('#tambahLiterasi') // 🔥 INI KUNCI
            });
        }
    });

    function Angkatan(val) {
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
                url: "{{ url('c92c5ab9-0386-4242-b579-b3f6863b8ef8') }}/" + val, 
                type: 'GET',
                success: function(response) {
                    var selAngkatan = document.getElementById("angkatan_bimwin");

                    // kosongkan dulu
                    selAngkatan.innerHTML = "";
                    var defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih Angkatan";
                    selAngkatan.add(defaultOption);

                    // isi angkatan dari response
                    response.data.forEach(function(item) {
                        if (item.angkatan) {
                            var angkatanList = item.angkatan.split(",");

                            angkatanList.forEach(function(ang) {
                                var opt = document.createElement("option");
                                opt.value = ang.trim();

                                // kalau angkatan 0 → tulis "Untuk Peserta"
                                if (ang.trim() === "0") {
                                    opt.text = "Untuk Peserta";
                                } else {
                                    opt.text = "Untuk Peserta Angkatan " + ang.trim();
                                }

                                selAngkatan.add(opt);
                            });
                        }
                    });

                    // === Tambahkan opsi Angkatan 99 di akhir ===
                    var extraOpt = document.createElement("option");
                    extraOpt.value = "99";
                    extraOpt.text  = "Untuk Narasumber";
                    selAngkatan.add(extraOpt);
                }
            });
        }
    }

    function KabupatenBimwin(val)
    {
        $('#kab_bimwin').children('option').remove();
        $('#kec_bimwin').children('option').remove();

        $.ajax({
            url: "{{ url('612817ad-4ba7-4ccb-9a6c-c84dc0807f65') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("kab_bimwin");

                // Kosongkan dulu pilihan sebelumnya (opsional)
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_kabupaten;
                    opt.text = response.data[i].nama;
                    sel.add(opt);
                }

                $('#kab_bimwin').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#tambahLiterasi') // 🔥 INI KUNCI
                });
            }
        });
    }

    function KecamatanBimwin(val)
    {
        $('#kec_bimwin').children('option').remove();

        $.ajax({
            url: "{{ url('e720650a-53af-4b99-9e75-0740c8987d9e') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("kec_bimwin");

                // Kosongkan dulu pilihan sebelumnya (opsional)
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_kecamatan;
                    opt.text = response.data[i].nama;
                    sel.add(opt);
                }

                $('#kec_bimwin').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#tambahLiterasi') // 🔥 INI KUNCI
                });
            }
        });
    }

    // Tanggal Lahir Input
    $(function() {
        $(".lahirinput").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_brus_peserta");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const angkatan_bimwin = formData.get("angkatan_bimwin");
                const keg_bimwin = formData.get("keg_bimwin")?.trim();
                const nik_bimwin = formData.get("nik_bimwin")?.trim();
                const nama_bimwin = formData.get("nama_bimwin")?.trim();
                const tmp_bimwin = formData.get("tmp_bimwin")?.trim();
                const tgl_bimwin = formData.get("tgl_bimwin")?.trim();
                const jk_bimwin = formData.get("jk_bimwin")?.trim();
                const domisili_bimwin = formData.get("domisili_bimwin")?.trim();
                const hp_bimwin = formData.get("hp_bimwin")?.trim();
                const email_bimwin = formData.get("email_bimwin")?.trim();
                const rek_bimwin = formData.get("rek_bimwin")?.trim();
                const nm_bimwin = formData.get("nm_bimwin")?.trim();
                const npwp_bimwin = formData.get("npwp_bimwin")?.trim();
                const nip_bimwin = formData.get("nip_bimwin")?.trim();
                const prov_bimwin = formData.get("prov_bimwin")?.trim();
                const kab_bimwin = formData.get("kab_bimwin")?.trim();
                const kec_bimwin = formData.get("kec_bimwin")?.trim();
                const pegawai_bimwin = formData.get("pegawai_bimwin")?.trim();
                const jbtn_bimwin = formData.get("jbtn_bimwin")?.trim();
                const gol_bimwin = formData.get("gol_bimwin")?.trim();
                const inst_bimwin = formData.get("inst_bimwin")?.trim();
                const kantor_bimwin = formData.get("kantor_bimwin")?.trim();
                const files_bimwin = formData.get("files_bimwin");
                const files_surtug = formData.get("files_surtug");
                const token = formData.get("_token")?.trim();

                const fields = {
                    angkatan_bimwin: { value: angkatan_bimwin, message: "Maaf, angkatan harus diisi." },
                    keg_bimwin: { value: keg_bimwin, message: "Maaf, kegiatan harus dipilih.", skipIf: 'Pilih' },
                    nik_bimwin: { value: nik_bimwin, message: "Maaf, nik ktp harus diisi." },
                    nama_bimwin: { value: nama_bimwin, message: "Maaf, nama lengkap harus diisi." },
                    tmp_bimwin: { value: tmp_bimwin, message: "Maaf, tempat lahir harus diisi." },
                    tgl_bimwin: { value: tgl_bimwin, message: "Maaf, tanggal lahir harus diisi." },
                    jk_bimwin: { value: jk_bimwin, message: "Maaf, jenis kelamin harus dipilih.", skipIf: 'Pilih' },
                    domisili_bimwin: { value: domisili_bimwin, message: "Maaf, alamat rumah harus diisi." },
                    hp_bimwin: { value: hp_bimwin, message: "Maaf, nomor hp harus diisi." },
                    email_bimwin: { value: email_bimwin, message: "Maaf, alamat email harus diisi." },
                    rek_bimwin: { value: rek_bimwin, message: "Maaf, nomor rekening harus diisi." },
                    nm_bimwin: { value: nm_bimwin, message: "Maaf, nama bank harus diisi." },
                    npwp_bimwin: { value: npwp_bimwin, message: "Maaf, nomor npwp harus diisi." },
                    nip_bimwin: { value: nip_bimwin, message: "Maaf, nip pegawai harus diisi." },
                    prov_bimwin: { value: prov_bimwin, message: "Maaf, provinsi harus dipilih.", skipIf: 'Pilih' },
                    // kab_bimwin: { value: kab_bimwin, message: "Maaf, kabupaten harus dipilih.", skipIf: 'Pilih' },
                    // kec_bimwin: { value: kec_bimwin, message: "Maaf, kecamatan harus dipilih.", skipIf: 'Pilih' },
                    pegawai_bimwin: { value: pegawai_bimwin, message: "Maaf, kategori pegawai harus dipilih.", skipIf: 'Pilih' },
                    jbtn_bimwin: { value: jbtn_bimwin, message: "Maaf, jabatan harus diisi." },
                    gol_bimwin: { value: gol_bimwin, message: "Maaf, golongan harus dipilih.", skipIf: 'Pilih' },
                    inst_bimwin: { value: inst_bimwin, message: "Maaf, instansi harus diisi." },
                    kantor_bimwin: { value: kantor_bimwin, message: "Maaf, alamat kantor harus diisi." },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("tambahLiterasi");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('13b636f2-b1b1-4723-a0a2-6a0b73397e25') }}", {
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
                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, file photo tidak boleh kosong.", "error");
                    showModal("tambahLiterasi");
                } else if (result.message === 202) {
                    Swal.fire("Error", "Maaf, ukuran maksimal file photo tidak lebih 3 MB.", "error");
                    showModal("tambahLiterasi");
                } else if (result.message === 203) {
                    Swal.fire("Error", "Maaf, jenis file photo hanya .jpeg, .jpg, dan .png.", "error");
                    showModal("tambahLiterasi");
                } else if (result.message === 404) {
                    Swal.fire("Error", "Maaf, data kamu sudah tersedia di kegiatan ini.", "error");
                    showModal("tambahLiterasi");
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

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("import_kexcel");
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const doks_excel = formData.get("doks_excel");
            const token = formData.get("_token")?.trim();

            const fields = {
                doks_excel: {
                    value: doks_excel,
                    message: "Maaf, pilih terlebih dahulu dokumen excel."
                },
                token: {
                    value: token,
                    message: "Token harus diisi."
                }
            };

            for (const key in fields) {
                const { value, message, skipIf } = fields[key];
                if (!value || value === skipIf) {
                    return showError(message);
                }
            }

            // ===========================
            // Validasi file Excel
            // ===========================

            if (!(doks_excel instanceof File) || doks_excel.size === 0) {
                return showError("Maaf, pilih terlebih dahulu dokumen excel.");
            }

            const ekstensi = doks_excel.name.split(".").pop().toLowerCase();
            const allowed = ["xlsx", "xls"];
            if (!allowed.includes(ekstensi)) {
                document.getElementById("doks_excel").value = "";
                return showError("Format file harus berupa Excel (.xlsx atau .xls).");
            }

            const maxSize = 5 * 1024 * 1024;

            if (doks_excel.size > maxSize) {
                document.getElementById("doks_excel").value = "";
                return showError("Ukuran file maksimal 5 MB.");
            } try {
                hideModal("importLiterasi");
                showLoader();
                const response = await fetch("{{ url('3bcde2ae-399c-4821-9c75-6ca6b0f7a350') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    }
                });

                const result = await response.json();
                if (!response.ok) {
                    Swal.fire(
                        "Error",
                        result.error ?? "Terjadi kesalahan pada server.",
                        "error"
                    );
                    showModal("importLiterasi");
                    return;
                }

                if (result.message === 200) {
                    Swal.fire(
                        "Berhasil",
                        "Data berhasil diimport.",
                        "success"
                    ).then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 201) {
                    Swal.fire(
                        "Error",
                        "Maaf, dokumen Excel tidak boleh kosong.",
                        "error"
                    );
                    showModal("importLiterasi");
                } else if (result.message === 202) {
                    Swal.fire(
                        "Error",
                        "Ukuran file maksimal 5 MB.",
                        "error"
                    );
                    showModal("importLiterasi");
                } else {
                    Swal.fire(
                        "Gagal",
                        "Terjadi kesalahan saat mengimport data.",
                        "error"
                    );
                    showModal("importLiterasi");
                }
            } catch (error) {
                console.error(error);
                Swal.fire(
                    "Error",
                    "Terjadi kesalahan jaringan atau server.",
                    "error"
                );
                showModal("importLiterasi");
            } finally {
                hideLoader();
            }
        });

        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

        function showLoader() {
            const loader = document.getElementById("Loader");
            if (loader && typeof bootstrap !== "undefined") {
                bootstrap.Modal.getOrCreateInstance(loader).show();
            }
        }

        function hideLoader() {
            const loader = document.getElementById("Loader");
            if (loader && typeof bootstrap !== "undefined") {
                bootstrap.Modal.getOrCreateInstance(loader).hide();
            }
        }

        function showModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                bootstrap.Modal.getOrCreateInstance(modal).show();
            }
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                bootstrap.Modal.getOrCreateInstance(modal).hide();
            }
        }
    });

    Page.Batal = function()
    {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahLiterasi').modal('hide');
                $('#detailLiterasi').modal('hide');
                $('#editLiterasi').modal('hide');
                $('#importLiterasi').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
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
                url: "{{ url('28256015-2e0d-424a-8e4e-91342b6fbb51') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#editLiterasi').modal('show');
                    $('#e_publicid').attr('value', response.data.public_id);
                    Kegiatan(response.data.id_kegiatan)
                    .then(() => eAngkatan(response.data.id_kegiatan, response.data.angkatan))
                    .catch(err => console.error("❌ Error isi dropdown:", err));
                    $('#e_nik_bimwin').attr('value', response.data.nik);
                    $('#e_nama_bimwin').attr('value', response.data.nama);
                    $('#e_tmp_bimwin').attr('value', response.data.lahir);
                    $('#e_tgl_bimwin').attr('value', response.data.tgl);
                    $(function() {
                        $(".editlahirinput").datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true,
                            todayHighlight: true,
                        });
                    });
                    if (response.data.jkl == 11 || response.data.jkl == 12) {
                        document.getElementById('e_jk_bimwin').value = response.data.jkl;
                    }
                    $('textarea#e_domisili_bimwin').val(response.data.alamat_rumah);
                    $('#e_hp_bimwin').attr('value', response.data.no_hp);
                    $('#e_email_bimwin').attr('value', response.data.email);
                    $('#e_rek_bimwin').attr('value', response.data.no_rek);
                    $('#e_nm_bimwin').attr('value', response.data.nm_bank);
                    $('#e_npwp_bimwin').attr('value', response.data.npwp);
                    $('#e_nip_bimwin').attr('value', response.data.nip);
                    eProvinsi(response.data.id_provinsi)
                        .then(() => eKabupaten(response.data.id_provinsi, response.data.id_kabupaten))
                        .then(() => eKecamatan(response.data.id_kabupaten, response.data.id_kecamatan))
                        .then(() => {
                            $('#e_pegawai_bimwin').val(response.data.is_pegawai ?? '');
                            $('#e_jbtn_bimwin').val(response.data.jabatan ?? '');
                            $('#e_gol_bimwin').val(response.data.golongan ?? '');
                            $('#e_inst_bimwin').val(response.data.instansi ?? '');
                            $('textarea#e_kantor_bimwin').val(response.data.alamat_kantor ?? '');
                        })
                        .catch(err => console.error("❌ Gagal memuat dropdown wilayah:", err));
                    $('#e_jbtn_bimwin').attr('value', response.data.jabatan);
                    const validGolongan = [
                        101, 102, 103, 104, 105, 106, 107, 108, 109,110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120
                    ];
                    if (validGolongan.includes(response.data.golongan)) {
                        document.getElementById('e_gol_bimwin').value = response.data.golongan;
                        $('#e_gol_bimwin').select2({
                            width: '100%',
                            placeholder: 'Pilih',
                            minimumResultsForSearch: 0,
                            dropdownParent: $('#editLiterasi') // 🔥 INI KUNCI
                        });
                    }
                    $('#e_inst_bimwin').attr('value', response.data.instansi);
                    $('textarea#e_kantor_bimwin').val(response.data.alamat_kantor);
                    $('#e_files_old').attr('value', response.data.files);
                    $('#lihatfile').attr('value', response.data.files);
                    $('#tutupfile').attr('value', response.data.files);
                    if(response.data.files != '' || response.data.files != null){
                        $('.lihatPhoto').show();
                    }else{
                        $('.lihatPhoto').hide();
                    }
                    $('#e_files_surtug_old').attr('value', response.data.files_surtug);
                    $('#lihatfile_surtug').attr('value', response.data.files_surtug);
                    setTimeout(() => {
                        const e_status = document.getElementById('e_status');
                        if (e_status) {
                            e_status.value = String(response.data.is_trash ?? '');
                        }
                    }, 800);
                }
            });
        }
    }

    function Kegiatan(val) {
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
                reject("ID kegiatan kosong");
                return;
            }

            $.ajax({
                url: "{{ url('aed11d85-004d-43e1-af79-0616e7b51701') }}",
                type: 'GET',
                success: function (response) {
                    var sel = document.getElementById("e_keg_bimwin");
                    sel.innerHTML = "";

                    // option default
                    var defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih";
                    sel.add(defaultOption);

                    for (var i = 0; i < response.data.length; i++) {
                        var item = response.data[i];

                        if (item.kategori != 459) {
                            continue;
                        }

                        var opt = document.createElement("option");
                        opt.value = item.id;
                        opt.text = item.judul_acara;
                        sel.add(opt);

                        if (opt.value == val) {
                            opt.selected = true;
                        }
                    }
                    $('#e_keg_bimwin').select2({
                        width: '100%',
                        placeholder: 'Pilih',
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#editLiterasi') // 🔥 INI KUNCI
                    });
                    resolve();
                },
                error: function (xhr, status, error) {
                    console.error("❌ Gagal memuat kegiatan:", error);
                    reject(error);
                }
            });
        });
    }

    function eAngkatan(val, id = null) {
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
                reject("ID kegiatan kosong untuk angkatan");
                return;
            }

            $.ajax({
                url: "{{ url('c92c5ab9-0386-4242-b579-b3f6863b8ef8') }}/" + val,
                type: 'GET',
                success: function(response) {
                    const selAngkatan = document.getElementById("e_angkatan_bimwin");
                    selAngkatan.innerHTML = "";

                    // Tambah option default
                    const defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih Angkatan";
                    selAngkatan.add(defaultOption);

                    // Tambahkan data dari response
                    response.data.forEach(item => {
                        if (item.angkatan) {
                            const angkatanList = item.angkatan.split(",");
                            angkatanList.forEach(ang => {
                                const angTrim = ang.trim();
                                const opt = document.createElement("option");
                                opt.value = angTrim;
                                opt.text = (angTrim === "0")
                                    ? "Untuk Peserta"
                                    : "Untuk Peserta Angkatan " + angTrim;

                                if (id && angTrim === id.toString()) {
                                    opt.selected = true;
                                }

                                selAngkatan.add(opt);
                            });
                        }
                    });

                    // Tambahkan opsi Narasumber
                    const extraOpt = document.createElement("option");
                    extraOpt.value = "99";
                    extraOpt.text = "Untuk Narasumber";
                    if (id && id.toString() === "99") {
                        extraOpt.selected = true;
                    }
                    selAngkatan.add(extraOpt);

                    resolve(); // ✅ Selesai
                },
                error: function(xhr, status, error) {
                    console.error("❌ Gagal memuat angkatan:", error);
                    reject(error);
                }
            });
        });
    }

    function eProvinsi(val) {
        return new Promise((resolve, reject) => {
            // Validasi awal
            if (!val || val == 0) {
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID Provinsi tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
                reject("ID provinsi kosong");
                return;
            }

            // Kosongkan dropdown provinsi, kabupaten, kecamatan
            $('#e_prov_bimwin').children('option').remove();
            $('#e_kab_bimwin').children('option').remove();
            $('#e_kec_bimwin').children('option').remove();

            // Panggil data provinsi dari API
            $.ajax({
                url: "{{ url('1178abf7-1d6a-4499-88c4-0e065a204efa') }}", // endpoint data provinsi
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const sel = document.getElementById("e_prov_bimwin");
                    sel.innerHTML = "";

                    // Tambahkan option default
                    const defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih";
                    sel.add(defaultOption);

                    // Loop data provinsi dari API
                    response.data.forEach(item => {
                        const opt = document.createElement("option");
                        opt.value = item.id_provinsi;
                        opt.text = item.nama;
                        sel.add(opt);
                    });

                    // Set value yang sesuai (menandai provinsi terpilih)
                    $('#e_prov_bimwin').val(val);
                    $('#e_prov_bimwin').select2({
                        width: '100%',
                        placeholder: 'Pilih',
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#editLiterasi') // 🔥 INI KUNCI
                    });
                    resolve(); // tandai selesai
                },
                error: function(xhr, status, error) {
                    console.error("❌ Gagal memuat provinsi:", error);
                    reject(error);
                }
            });
        });
    }

    function eKabupaten(val, id) {
        return new Promise((resolve, reject) => {
            // Validasi awal
            if (!val || val == 0) {
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID Provinsi tidak tersedia untuk mengambil Kabupaten.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
                reject("ID provinsi kosong");
                return;
            }

            // Kosongkan dropdown kabupaten & kecamatan
            $('#e_kab_bimwin').children('option').remove();
            $('#e_kec_bimwin').children('option').remove();

            // Panggil data kabupaten berdasarkan ID provinsi
            $.ajax({
                url: "{{ url('612817ad-4ba7-4ccb-9a6c-c84dc0807f65') }}/" + val,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const sel = document.getElementById("e_kab_bimwin");
                    sel.innerHTML = "";

                    // Tambahkan option default
                    const defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih";
                    sel.add(defaultOption);

                    // Tambahkan data dari response
                    response.data.forEach(item => {
                        const opt = document.createElement("option");
                        opt.value = item.id_kabupaten;
                        opt.text = item.nama;
                        sel.add(opt);
                    });

                    // Set kabupaten yang sesuai
                    if (id) {
                        $('#e_kab_bimwin').val(id);
                        // console.log("✅ Kabupaten diset:", id);
                    } else {
                        console.log("⚠️ Tidak ada ID kabupaten untuk diset.");
                    }
                    $('#e_kab_bimwin').select2({
                        width: '100%',
                        placeholder: 'Pilih',
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#editLiterasi') // 🔥 INI KUNCI
                    });
                    resolve(); // tandai selesai
                },
                error: function(xhr, status, error) {
                    console.error("❌ Gagal memuat kabupaten:", error);
                    reject(error);
                }
            });
        });
    }

    function eKecamatan(val, id) {
        return new Promise((resolve, reject) => {
            $('#e_kec_bimwin').children('option').remove();

            $.ajax({
                url: "{{ url('e720650a-53af-4b99-9e75-0740c8987d9e') }}/" + val,
                type: 'GET',
                success: function(response) {
                    var sel = document.getElementById("e_kec_bimwin");
                    sel.innerHTML = "";

                    var defaultOption = document.createElement("option");
                    defaultOption.value = "";
                    defaultOption.text = "Pilih";
                    sel.add(defaultOption);

                    for (var i = 0; i < response.data.length; i++) {
                        var opt = document.createElement("option");
                        opt.value = response.data[i].id_kecamatan;
                        opt.text = response.data[i].nama;
                        sel.add(opt);

                        if (opt.value == id) {
                            $('select#e_kec_bimwin option[value="' + opt.value + '"]').attr('selected', true);
                        }
                    }
                    $('#e_kec_bimwin').select2({
                        width: '100%',
                        placeholder: 'Pilih',
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#editLiterasi') // 🔥 INI KUNCI
                    });
                    resolve(); // ✅ Selesai
                },
                error: function(err) {
                    console.error("❌ Gagal memuat kecamatan:", err);
                    reject(err);
                }
            });
        });
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
            $("#gambar_users").attr("src", "{{ url('storage/') }}/" + val);
        }
    }

    Page.DetailSurtug = function(val)
    {
        if(val == '' || val == null || val == 0 || val == 'undefined'){
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK"
            });
        }else{
            let url = "/storage/" + val;
            window.open(url, "_blank");
        }
    }

    Page.Tutup = function(val)
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
            $('.lihatPhoto').show();
            $('.tutupPhoto').hide();
            $('#contentphoto').hide('slow');
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_edit_brus_peserta");
        if (!form) return;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(form);

            // ================= VALIDASI (STRUKTUR TETAP) =================
            const fields = {
                e_publicid: { value: formData.get("e_publicid"), message: "Public ID wajib." },
                e_keg_bimwin: { value: formData.get("e_keg_bimwin"), message: "Kegiatan wajib dipilih.", skipIf: "Pilih" },
                e_angkatan_bimwin: { value: formData.get("e_angkatan_bimwin"), message: "Angkatan wajib.", skipIf: "Pilih" },
                e_nik_bimwin: { value: formData.get("e_nik_bimwin"), message: "NIK wajib." },
                e_nama_bimwin: { value: formData.get("e_nama_bimwin"), message: "Nama wajib." },
                e_tmp_bimwin: { value: formData.get("e_tmp_bimwin"), message: "Tempat lahir wajib." },
                e_tgl_bimwin: { value: formData.get("e_tgl_bimwin"), message: "Tanggal lahir wajib." },
                e_jk_bimwin: { value: formData.get("e_jk_bimwin"), message: "Jenis kelamin wajib.", skipIf: "Pilih" },
                e_domisili_bimwin: { value: formData.get("e_domisili_bimwin"), message: "Domisili wajib." },
                e_hp_bimwin: { value: formData.get("e_hp_bimwin"), message: "No HP wajib." },
                e_email_bimwin: { value: formData.get("e_email_bimwin"), message: "Email wajib." },
                e_rek_bimwin: { value: formData.get("e_rek_bimwin"), message: "Rekening wajib." },
                e_nm_bimwin: { value: formData.get("e_nm_bimwin"), message: "Nama bank wajib." },
                e_npwp_bimwin: { value: formData.get("e_npwp_bimwin"), message: "NPWP wajib." },
                e_nip_bimwin: { value: formData.get("e_nip_bimwin"), message: "NIP wajib." },
                e_prov_bimwin: { value: formData.get("e_prov_bimwin"), message: "Provinsi wajib.", skipIf: "Pilih" },
                e_pegawai_bimwin: { value: formData.get("e_pegawai_bimwin"), message: "Kategori pegawai wajib.", skipIf: "Pilih" },
                e_jbtn_bimwin: { value: formData.get("e_jbtn_bimwin"), message: "Jabatan wajib." },
                e_gol_bimwin: { value: formData.get("e_gol_bimwin"), message: "Golongan wajib.", skipIf: "Pilih" },
                e_inst_bimwin: { value: formData.get("e_inst_bimwin"), message: "Instansi wajib." },
                e_kantor_bimwin: { value: formData.get("e_kantor_bimwin"), message: "Alamat kantor wajib." }
            };

            for (const key in fields) {
                const { value, message, skipIf } = fields[key];
                if (!value || value === skipIf) {
                    toastr.error(message);
                    return;
                }
            }

            if (!formData.get("e_files_old")) {
                toastr.error("File photo wajib.");
                return;
            }

            // ================= MODAL HANDLING (KUNCI) =================
            const modalEl = document.getElementById("editLiterasi");
            const modalInstance = bootstrap.Modal.getInstance(modalEl);

            modalEl.addEventListener("hidden.bs.modal", function onHidden() {
                modalEl.removeEventListener("hidden.bs.modal", onHidden);

                showLoader();

                fetch("{{ url('1ab17070-1c01-4d3f-ae18-6d881cabffaf') }}", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(result => {
                    hideLoader();

                    if (result.message === 200) {
                        Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success")
                            .then(() => location.reload());
                    } else {
                        let msg = "Terjadi kesalahan.";
                        if (result.message === 201) msg = "File photo tidak boleh kosong.";
                        if (result.message === 202) msg = "Ukuran maksimal photo 3 MB.";
                        if (result.message === 203) msg = "Format photo hanya jpg / jpeg / png.";
                        if (result.message === 404) msg = "Tidak bisa diperbaharui jika beda kegiatan, NIK dan NIP.";

                        Swal.fire({
                            title: "Error",
                            text: msg,
                            icon: "error",
                            allowOutsideClick: false
                        }).then(() => {
                            new bootstrap.Modal(modalEl, {
                                backdrop: 'static',
                                keyboard: false
                            }).show();
                        });
                    }
                })
                .catch(() => {
                    hideLoader();
                    Swal.fire("Error", "Kesalahan server.", "error")
                        .then(() => {
                            new bootstrap.Modal(modalEl).show();
                        });
                });
            });

            // ⛔ tutup modal TERAKHIR
            modalInstance.hide();
        });

        // ================= HELPER =================
        function showLoader() {
            const el = document.getElementById("Loader");
            if (el) el.style.display = "block";
        }

        function hideLoader() {
            const el = document.getElementById("Loader");
            if (el) el.style.display = "none";
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
                url: "{{ url('f285478c-df7d-4efb-81de-d927143b1fbd') }}/" + val,
                type: 'GET',
                success: function(response){
                    let angkatan = Number(response.data.angkatan);
                    let hasil = '-'; // default

                    $('#detailLiterasi').modal('show');
                    $('#d_sertif').text(response.data.no_sertifikat);
                    $('#d_angkatan').text(response.data.keterangan_angkatan);
                    $('#d_kegiatan').text(response.data.judul_acara);
                    $('#d_nik').text(response.data.nik);
                    $('#d_nama').text(response.data.nama);
                    $('#d_tgl').text(response.data.tempat_tanggal_lahir);
                    $('#d_kelamin').text(response.data.jkl);
                    $('#d_rumah').text(response.data.alamat_rumah);
                    $('#d_hp').text(response.data.no_hp);
                    $('#d_email').text(response.data.email);
                    $('#d_rek').text(response.data.no_rek);
                    $('#d_bank').text(response.data.nm_bank);
                    $('#d_npwp').text(response.data.npwp);
                    $('#d_nip').text(response.data.nip);
                    $('#d_prov').text(response.data.provinsi);
                    $('#d_kab').text(response.data.kabupaten);
                    $('#d_kec').text(response.data.kecamatan);
                    $('#d_peg').text(response.data.pegawai);
                    $('#d_jab').text(response.data.jabatan);
                    $('#d_gol').text(response.data.golongan);
                    $('#d_inst').text(response.data.instansi);
                    $('#d_kantor').text(response.data.alamat_kantor);
                    $("#d_foto").attr("src", "{{ url('storage/') }}/" + response.data.files);
                    $('#d_stat').text(response.data.status);
                    $('#d_surtug').val(response.data.files_surtug);
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
                        url: "{{ url('b5c1deef-72a8-4d2d-abd0-c48ee01d4f67') }}",
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
        }else{
            $.ajax({
                url: "{{ url('6229715e-f850-4e34-b6c1-9b81948b531f') }}/" + val,
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
                    alert("Terjadi kesalahan saat memproses data.");
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
                    $("#Loader").modal("show");
                },
                success: function (blob) {
                    var url = window.URL.createObjectURL(blob);
                    window.open(url, "_blank");
                },
                complete: function () {
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

    $(function(){
        $("input[name='angkatan_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='nik_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='nama_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/' ]/g, ''));
        });
        $("input[name='tmp_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ., ]/g, ''));
        });
        $("input[name='tgl_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("textarea[name='domisili_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("input[name='hp_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='email_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^a-zA-Z0-9.,_!@-]/g, ''));
        });
        $("input[name='rek_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='nm_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/ ]/g, ''));
        });
        $("input[name='npwp_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='nip_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='jbtn_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/ ]/g, ''));
        });
        $("input[name='inst_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("textarea[name='kantor_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
         $("input[name='e_angkatan_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='e_nik_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='e_nama_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/' ]/g, ''));
        });
        $("input[name='e_tmp_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ., ]/g, ''));
        });
        $("input[name='e_tgl_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("textarea[name='e_domisili_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("input[name='e_hp_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='e_email_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^a-zA-Z0-9.,_!@-]/g, ''));
        });
        $("input[name='e_rek_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='e_nm_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/ ]/g, ''));
        });
        $("input[name='e_npwp_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='e_nip_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='e_jbtn_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA-zZ.,-/ ]/g, ''));
        });
        $("input[name='e_inst_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("textarea[name='e_kantor_bimwin']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
    });
</script>

{{-- validasi edit data baru --}}
<script>
    function e_validateBiodata() {
        let valid = true;
        if (!document.getElementById("e_keg_bimwin").value) valid = false;
        if (!document.getElementById("e_angkatan_bimwin").value) valid = false;
        if (!document.getElementById("e_nik_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_nama_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_tmp_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_tgl_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_jk_bimwin").value) valid = false;
        if (!document.getElementById("e_domisili_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_hp_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_email_bimwin").value.trim()) valid = false;

        return valid;
    }

    function e_validateAdministratif() {
        let valid = true;

        if (!document.getElementById("e_rek_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_nm_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_npwp_bimwin").value.trim()) valid = false;

        return valid;
    }

    function e_validateInstansi() {
        let valid = true;

        if (!document.getElementById("e_nip_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_prov_bimwin").value) valid = false;
        if (!document.getElementById("e_pegawai_bimwin").value) valid = false;
        if (!document.getElementById("e_jbtn_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_gol_bimwin").value) valid = false;
        if (!document.getElementById("e_inst_bimwin").value.trim()) valid = false;
        if (!document.getElementById("e_kantor_bimwin").value.trim()) valid = false;
        // if (!document.getElementById("e_files_old").value.trim()) valid = false;
        if (!document.getElementById("e_status").value) valid = false;

        return valid;
    }

    // ======================== PINDAH TAB ========================
    function nextTab(tabId) {
        let allow = false;

        if (tabId === "edit-administratif-tab") {
            allow = e_validateBiodata();
            if (!allow) { toastr.error("Harap lengkapi Biodata."); return; }
        }
        if (tabId === "edit-instansi-tab") {
            allow = e_validateAdministratif();
            if (!allow) { toastr.error("Harap lengkapi Administratif."); return; }
        }

        // aktifkan tab berikutnya
        let tabBtn = document.getElementById(tabId);
        tabBtn.classList.remove("disabled");
        tabBtn.removeAttribute("disabled");

        // tampilkan tab
        new bootstrap.Tab(tabBtn).show();
    }

    // ======================== CEGAH KLIK MANUAL ========================
    document.querySelectorAll('#wizardTab button[data-bs-toggle="tab"]').forEach(btn => {
        btn.addEventListener('show.bs.tab', function (e) {
            if (btn.id === "edit-administratif-tab" && !e_validateBiodata()) {
            toastr.error('Maaf, harap di lengkapi biodata diri.');
            e.preventDefault();
            }
            if (btn.id === "edit-instansi-tab" && !e_validateAdministratif()) {
            toastr.error('Maaf, harap di lengkapi data administratif.');
            e.preventDefault();
            }
            if (btn.id === "edit-instansi-tab" && !e_validateInstansi()) {
            toastr.error('Maaf, harap di lengkapi data instansi.');
            e.preventDefault();
            }
        });
    });
</script>

{{-- validasi input data baru --}}
<script>
    function validateBiodata() {
        let valid = true;

        // daftar field wajib di tab biodata
        let fields = [
            "keg_bimwin", "nik_bimwin", "nama_bimwin",
            "tmp_bimwin", "tgl_bimwin", "jk_bimwin",
            "domisili_bimwin", "hp_bimwin", "email_bimwin"
        ];

        fields.forEach(id => {
            let el = document.getElementById(id);
            if (!el) return;

            // khusus select, harus cek value !== ""
            if (el.tagName === "SELECT") {
                if (el.value === "") {
                    valid = false;
                }
            } else {
                if (!el.value.trim()) {
                    valid = false;
                }
            }
        });

        return valid;
    }

    function validateAdministratif() {
        let valid = true;

        let fields = [
            "rek_bimwin", "nm_bimwin", "npwp_bimwin"
        ];

        fields.forEach(id => {
            let el = document.getElementById(id);
            if (!el || !el.value.trim()) {
                valid = false;
            }
        });

        return valid;
    }

    function validateInstansi() {
        let valid = true;
        let fields = [
            "nip_bimwin", "prov_bimwin", "kab_bimwin", "kec_bimwin",
            "pegawai_bimwin", "jbtn_bimwin", "gol_bimwin", "inst_bimwin",
            "kantor_bimwin"
        ];

        fields.forEach(id => {
            let el = document.getElementById(id);
            if (!el) return;

            if (el.tagName === "SELECT") {
                if (el.value === "" || el.value === "Pilih") {
                    valid = false;
                }
            } else {
                if (!el.value.trim()) {
                    valid = false;
                }
            }
        });

        return valid;
    }

    function nextTab(tabId) {
        if (tabId === "administratif-tab") {
            if (!validateBiodata()) {
                toastr.error('Maaf, harap di lengkapi biodata diri.')
                return;
            }
            
            document.getElementById("administratif-tab").classList.remove("disabled");
            document.getElementById("administratif-tab").removeAttribute("disabled");
        }

        if (tabId === "instansi-tab") {
            if (!validateAdministratif()) {
                toastr.error('Maaf, harap di lengkapi data administratif.');
                return;
            }

            document.getElementById("instansi-tab").classList.remove("disabled");
            document.getElementById("instansi-tab").removeAttribute("disabled");
        }

        if (tabId === "submit-tab") {
            if (!validateInstansi()) {
                toastr.error('Maaf, harap di lengkapi data instansi.');
                return;
            }
        }

        var nextTab = new bootstrap.Tab(document.getElementById(tabId));
        nextTab.show();
    }

    function prevTab(tabId) {
        var prevTab = new bootstrap.Tab(document.getElementById(tabId));
        prevTab.show();
    }
</script>