<script type="text/javascript">
    window.onload = function() {
        window.this_direktorat = {{ $data->id_direktorat ?? 'null' }};
        window.this_subdit = {{ $data->id_subdit ?? 'null' }};
        window.this_roles = {{ $data->id_roles ?? 'null' }};
        window.this_user = {{ auth()->user()->id }};

        Direktorat();
        Kategori_(window.this_subdit);
    };

    $('#l_kategori').select2({
        width: '100%',
        placeholder: 'Pilih',
        minimumResultsForSearch: 0,
        dropdownParent: $('#laporanJadwalKeluarga') // 🔥 INI KUNCI
    });

    // JSON Datatables
    $(document).ready(function () {
        $('#jadwalKeluargaTable').DataTable({
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
            action: function ( e, dt, node, config ) {
                var tambah = {{ get_add() }};
                if(tambah == 1){
                    $('#tambahJadwalKeluarga').modal('show');
                }else if(tambah == 0){
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
            },{
            text: 'Laporan',
            action: function ( e, dt, node, config ) {
                var laporan = {{ get_laporan() }};
                if(laporan == 1){
                    $('#laporanJadwalKeluarga').modal('show');
                }else if(laporan == 0){
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
        "ajax": "{{ route('keluargajadwal.table') }}",
        "columns": [
            {"data":"DT_RowIndex"},
            {"data":"judul_acara"},
            {"data":"tempat"},
            // {"data":"lokasi"},
            {"data":"dari"},
            {"data":"sampai"},
            {"data":"peserta"},
            {"data":"aksi"},
        ]
        });
    });

    // Dari Tanggal dan Sampai Tanggal
    $(function() {
        $(".daritanggal").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });

    $(function() {
        $(".sampaitanggal").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });

    // Ambil Template
    $.ajax({
        url: "{{ url('3dbfd96f-eaf6-4fe7-bb68-ff380858f72f') }}",
        type: 'GET',
        success: function(response){
            var sel = document.getElementById("tempt");

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

            $('#tempt').select2({
                width: '100%',
                placeholder: 'Pilih',
                minimumResultsForSearch: 0,
                dropdownParent: $('#tambahJadwalKeluarga') // 🔥 INI KUNCI
            });
        }
    });

    // Ambil Acara
    function loadAcara() 
    {
        $.ajax({
            url: "{{ url('aed11d85-004d-43e1-af79-0616e7b51701') }}",
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("l_acara");
                sel.innerHTML = "";

                // Tambahkan option default
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Loop data
                for (var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];

                    if (item.kategori != 454) continue;

                    // Role selain 1 & 12 → tampilkan hanya yang sesuai direktorat & subdit
                    if (window.this_roles != 1 && window.this_roles != 12) {
                        if (
                            item.id_direktorat == window.this_direktorat &&
                            item.id_subdit == window.this_subdit
                        ) {
                            var opt = document.createElement("option");
                            opt.value = item.id;
                            opt.text = item.judul_acara;
                            sel.add(opt);
                        }
                    } 
                    // Role 1 dan 12 → tampilkan semua data
                    else {
                        var opt = document.createElement("option");
                        opt.value = item.id;
                        opt.text = item.judul_acara;
                        sel.add(opt);
                    }
                }

                $('#l_acara').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#laporanJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    document.addEventListener("DOMContentLoaded", loadAcara);

    // Laporan
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("laporan_jadwalkeluarga");

        if (!form) return;

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const l_acara = formData.get("l_acara")?.trim();
            const l_kategori = formData.get("l_kategori")?.trim();
            const token = formData.get("_token")?.trim();

            const fields = {
                l_acara: {
                    value: l_acara,
                    message: "Maaf, jenis acara harus dipilih.",
                    skipIf: "Pilih"
                },
                l_kategori: {
                    value: l_kategori,
                    message: "Maaf, kategori laporan harus dipilih.",
                    skipIf: "Pilih"
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

            try {
                // tutup modal form terlebih dahulu
                hideModal("laporanJadwalKeluarga");

                // beri delay kecil agar modal benar-benar tertutup
                setTimeout(async () => {
                    // tampilkan loader
                    showLoader();

                    try {
                        const response = await fetch("{{ url('a37cd926-e1cf-4564-a3db-184d5cf0f6fb') }}", {
                            method: "POST",
                            body: formData,
                        });

                        const contentType = response.headers.get("content-type");

                        // jika response berupa file excel
                        if (
                            contentType &&
                            contentType.includes("application/vnd.openxmlformats")
                        ) {
                            const blob = await response.blob();
                            const url = window.URL.createObjectURL(blob);

                            const a = document.createElement("a");
                            a.href = url;
                            a.download = "laporan-keluarga.xlsx";
                            document.body.appendChild(a);
                            a.click();
                            a.remove();

                            window.URL.revokeObjectURL(url);

                            Swal.fire(
                                "Berhasil",
                                "Laporan berhasil diunduh.",
                                "success"
                            ).then(() => {
                                window.location.reload();
                            });

                        } else {
                            const result = await response.json();

                            if (result.message === 201) {
                                Swal.fire(
                                    "Error",
                                    "Maaf, data belum tersedia.",
                                    "error"
                                );

                                showModal("laporanJadwalKeluarga");

                            } else {
                                Swal.fire(
                                    "Gagal",
                                    "Terjadi kesalahan saat menyimpan.",
                                    "error"
                                );
                            }
                        }

                    } catch (error) {
                        console.error("Fetch Error:", error);

                        Swal.fire(
                            "Error",
                            "Terjadi kesalahan jaringan atau server.",
                            "error"
                        );

                    } finally {
                        // selalu tutup loader
                        hideLoader();
                    }

                }, 300);

            } catch (error) {
                console.error(error);
                hideLoader();
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Loader Modal
        |--------------------------------------------------------------------------
        */

        function showLoader() {
            const modal = document.getElementById("Loader");

            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.show();
            }
        }

        function hideLoader() {
            const modal = document.getElementById("Loader");

            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.hide();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Modal Biasa
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Error Message
        |--------------------------------------------------------------------------
        */

        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }
    });

    function Direktorat() {
        $.ajax({
            url: "{{ url('2832984d-4b10-4c4a-b2b6-0bc197ac6962') }}",
            type: 'GET',
            success: function(response) {
                var sel = document.getElementById("_direktorat");
                sel.innerHTML = "";

                // Default option
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Isi options dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_direktorat;
                    opt.text = response.data[i].nama;
                    sel.add(opt);
                }

                // Pilih direktorat aktif jika ada
                if (window.this_direktorat) {
                    $("#_direktorat").val(window.this_direktorat);
                    // Setelah direktorat terpilih, otomatis load Subdit
                    Subdit(window.this_direktorat);
                }

                // Jika role bukan 1 atau 12 → readonly tapi tetap submit
                if (![1, 12].includes(window.this_roles)) {
                    var $sel = $("#_direktorat");

                    // Tambahkan hidden input untuk submit
                    var hidden = $("<input>", {
                        type: "hidden",
                        name: $sel.attr("name"),
                        value: $sel.val(),
                        id: $sel.attr("id") + "_hidden"
                    });
                    $sel.after(hidden);

                    // Buat select tidak bisa diubah tapi tetap tampil
                    $sel.css({
                        "pointer-events": "none", // blok klik/tap
                        "background-color": "#e9ecef" // tampilan mirip disabled
                    });

                    // Update hidden input jika value berubah (opsional)
                    $sel.on("change", function() {
                        $("#" + $sel.attr("id") + "_hidden").val($sel.val());
                    });
                }

                $('#_direktorat').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#tambahJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    // Ambil Subdit
    function Subdit(val) {
        if (!val) return;

        var sel = document.getElementById("_subdit");

        // langsung tampil default dulu
        sel.innerHTML = "";
        var defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.text = "Pilih";
        sel.add(defaultOption);

        // AJAX ambil data subdit
        $.ajax({
            url: "{{ url('53b3695a-2c5d-44c6-bf63-f2ad4cc7f285') }}/" + val,
            type: 'GET',
            success: function(response) {
                // tambahkan hasil dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_subdit;
                    opt.text = response.data[i].nama;
                    sel.add(opt);
                }

                // auto pilih jika data awal ada
                if (window.this_subdit && window.this_subdit !== "null" && window.this_subdit !== "") {
                    $("#_subdit").val(window.this_subdit);
                }

                // Jika role bukan 1 atau 12 → readonly tapi tetap submit
                if (![1, 12].includes(window.this_roles)) {
                    var $sel = $("#_subdit");

                    // Tambahkan hidden input untuk submit
                    var hidden = $("<input>", {
                        type: "hidden",
                        name: $sel.attr("name"),
                        value: $sel.val(),
                        id: $sel.attr("id") + "_hidden"
                    });
                    $sel.after(hidden);

                    // Buat select tidak bisa diubah tapi tetap tampil
                    $sel.css({
                        "pointer-events": "none",
                        "background-color": "#e9ecef"
                    });

                    // Update hidden input jika value berubah (opsional)
                    $sel.on("change", function() {
                        $("#" + $sel.attr("id") + "_hidden").val($sel.val());
                    });
                }

                $('#_subdit').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#tambahJadwalKeluarga') // 🔥 INI KUNCI
                });
            },
            error: function() {
                console.error("Gagal memuat data Subdit.");
            }
        });
    }

    // Ambil Kategori
    function Kategori_(val)
    {
        $.ajax({
            url: "{{ url('c0a35031-f5e9-44f5-bb52-afdb030e1bc1') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("_kategori");

                // Kosongkan dulu pilihan sebelumnya (opsional)
                sel.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                sel.add(defaultOption);

                // Tambahkan data dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_kategori;
                    opt.text = response.data[i].nama;
                    sel.add(opt);
                }

                $('#_kategori').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#tambahJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    function TTE_(val)
    {
        $.ajax({
            url: "{{ url('4da9ed4e-95f2-4e23-b69c-c00d160bfd4c') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("_ttedirektur");

                // Kosongkan dan isi langsung default option
                sel.innerHTML = '<option value="" selected>Pilih</option>';

                // Tambahkan data
                for (var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];
                    var opt = document.createElement("option");

                    let direktur = item.direktur ?? '';
                    let kegiatan = item.kegiatan ?? '';

                    opt.text = kegiatan
                        ? direktur + ' — [' + kegiatan + ']'
                        : direktur;

                    opt.value = item.id;

                    sel.add(opt);
                }

                $('#_ttedirektur').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#tambahJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    // Input Data
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_jadwalkeluarga");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const _direktorat = formData.get("_direktorat")?.trim();
                const _subdit = formData.get("_subdit")?.trim();
                const _kategori = formData.get("_kategori")?.trim();
                const _ttedirektur = formData.get("_ttedirektur")?.trim();
                const tempt = formData.get("tempt")?.trim();
                const acara = formData.get("acara")?.trim();
                const tempat = formData.get("tempat")?.trim();
                const lokasi = formData.get("lokasi")?.trim();
                const dari = formData.get("dari")?.trim();
                const sampai = formData.get("sampai")?.trim();
                const jumlah = formData.get("jumlah")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    tempt: { value: tempt, message: "Maaf, template sertifikat harus dipilih.", skipIf: 'Pilih' },
                    acara: { value: acara, message: "Maaf, judul acara harus diisi." },
                    tempat: { value: tempat, message: "Maaf, tempat acara harus diisi." },
                    lokasi: { value: lokasi, message: "Maaf, lokasi acara harus diisi." },
                    dari: { value: dari, message: "Maaf, dari tanggal harus diisi." },
                    sampai: { value: sampai, message: "Maaf, sampai tanggal harus diisi." },
                    jumlah: { value: jumlah, message: "Maaf, jumlah angkatan harus diisi." },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("tambahJadwalKeluarga");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('e1deca24-085a-4e3e-8cc0-bce0556cf9c3') }}", {
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
                    Swal.fire("Error", "Maaf, pastikan form inputan tidak kosong.", "error");
                    showModal("tambahJadwalKeluarga");
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

    Page.Batal = function()
    {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahJadwalKeluarga').modal('hide');
                $('#detailJadwalKeluarga').modal('hide');
                $('#editJadwalKeluarga').modal('hide');
                $('#FormulirJadwalKeluarga').modal('hide');
                $('#laporanJadwalKeluarga').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

    function waitSelectValue(selector, value, callback, retry = 0) {
        const maxRetry = 20;
    
        let el = $(selector);
        let valStr = String(value ?? '').trim();
    
        let exists = el.find('option').filter(function () {
            return $(this).val().trim() === valStr;
        }).length > 0;
    
        if (exists) {
            el.val(valStr).trigger('change');
            if (callback) callback();
        } else {
            if (retry < maxRetry) {
                setTimeout(function () {
                    waitSelectValue(selector, valStr, callback, retry + 1);
                }, 200);
            } else {
                console.warn("Option tidak ditemukan:", selector, valStr);
                if (callback) callback();
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
                url: "{{ url('c54ad13e-eaa3-4fe1-ab09-b150d359977e') }}/" + val,
                type: 'GET',
                success: function(response){
    
                    let data = response.data;
    
                    $('#editJadwalKeluarga').modal('show');
    
                    // ========================
                    // FIELD BIASA
                    // ========================
                    $('#e_publicid').val(data.public_id);
                    $('textarea#e_acara').val(data.judul_acara);
                    $('#e_tempat').val(data.tempat);
                    $('#e_lokasi').val(data.lokasi);
                    $('#e_dari').val(data.in);
                    $('#e_sampai').val(data.out);
                    $('#e_jumlah').val(data.angkatan);
    
                    if(data.is_trash == 11 || data.is_trash == 12){
                        $('#e_status').val(data.is_trash);
                    }

                    $('#e_status').select2({
                        width: '100%',
                        placeholder: 'Pilih',
                        minimumResultsForSearch: 0,
                        dropdownParent: $('#editJadwalKeluarga') // 🔥 INI KUNCI
                    });
    
                    // ========================
                    // DATEPICKER
                    // ========================
                    if (!$('.e_daritanggal').hasClass('hasDatepicker')) {
                        $(".e_daritanggal").datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true,
                            todayHighlight: true,
                        });
                    }
    
                    if (!$('.e_sampaitanggal').hasClass('hasDatepicker')) {
                        $(".e_sampaitanggal").datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true,
                            todayHighlight: true,
                        });
                    }
    
                    // ========================
                    // SELECT BERURUTAN
                    // ========================
    
                    ed_Direktorat(data.id_direktorat);
    
                    waitSelectValue('#ed_direktorat', data.id_direktorat, function(){
    
                        ed_Subdit(data.id_direktorat, data.id_subdit);
    
                        waitSelectValue('#ed_subdit', data.id_subdit, function(){
    
                            ed_Kategori(data.id_subdit, data.kategori);
    
                            waitSelectValue('#e_kategori', data.kategori, function(){
    
                                // 🔥 PANGGIL SEKALI SAJA
                                ed_TTE_(data.kategori, data.id_tte);
    
                                // langsung lanjut
                                Template(data.id_template);
    
                            });
    
                        });
    
                    });
    
                }
            });
        }
    }

    function ed_Direktorat(val)
    {
        $('#ed_direktorat').children('option').remove();
        $('#ed_subdit').children('option').remove();
        $('#e_kategori').children('option').remove();

        $.ajax({
            url: "{{ url('2832984d-4b10-4c4a-b2b6-0bc197ac6962') }}",
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("ed_direktorat");

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
                    if(opt.value == val){
                        $('select option[value="' + opt.value + '"]').attr('selected', true);
                    }else{
                        null;
                    }
                }

                $('#ed_direktorat').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#editJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    function ed_Subdit(val, id)
    {
        $('#ed_subdit').children('option').remove();
        $('#e_kategori').children('option').remove();

        $.ajax({
            url: "{{ url('53b3695a-2c5d-44c6-bf63-f2ad4cc7f285') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("ed_subdit");

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
                    if(opt.value == id){
                        $('select option[value="' + opt.value + '"]').attr('selected', true);
                    }else{
                        null;
                    }
                }

                $('#ed_subdit').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#editJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    function ed_Kategori(val, id)
    {
        $('#e_kategori').children('option').remove();

        $.ajax({
            url: "{{ url('c0a35031-f5e9-44f5-bb52-afdb030e1bc1') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("e_kategori");

                // Kosongkan dulu pilihan sebelumnya
                sel.innerHTML = "";

                // Default option "Pilih" → tampil tapi tidak bisa dipilih
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Pilih";
                defaultOption.disabled = true;   // tidak bisa dipilih
                defaultOption.selected = true;   // tetap tampil pertama
                sel.add(defaultOption);

                // Tambahkan data dari response
                for (var i = 0; i < response.data.length; i++) {
                    var opt = document.createElement("option");
                    opt.value = response.data[i].id_kategori;
                    opt.text = response.data[i].nama;

                    // Pilih value sesuai id
                    if(opt.value == id){
                        opt.selected = true;
                    }

                    sel.add(opt);
                }

                $('#e_kategori').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#editJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    function ed_TTE_(val, id)
    {
        $.ajax({
            url: "{{ url('4da9ed4e-95f2-4e23-b69c-c00d160bfd4c') }}/" + val,
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("e_ttedirektur");
    
                // kosongkan
                sel.innerHTML = "";
    
                // default
                var defaultOption = new Option("Pilih", "");
                sel.add(defaultOption);
    
                // isi data
                for (var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];
    
                    let direktur = item.direktur ?? '';
                    let kegiatan = item.kegiatan ?? '';
    
                    let text = kegiatan
                        ? direktur + ' — [' + kegiatan + ']'
                        : direktur;
    
                    sel.add(new Option(text, item.id));
                }
    
                // 🔥 SET VALUE DI SINI (hanya jika ada id)
                if (id !== undefined && id !== null && id !== '') {
                    let valStr = String(id);
    
                    let exists = $('#e_ttedirektur option[value="' + valStr + '"]').length > 0;
    
                    if (exists) {
                        $('#e_ttedirektur').val(valStr).trigger('change');
                    } else {
                        console.warn('ID tidak ditemukan di option:', valStr);
                    }
                }

                $('#e_ttedirektur').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#editJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    function Template(val)
    {
        $.ajax({
            url: "{{ url('3dbfd96f-eaf6-4fe7-bb68-ff380858f72f') }}",
            type: 'GET',
            success: function(response){
                var sel = document.getElementById("e_tempt");

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
                    if(opt.value == val){
                        $('select option[value="' + opt.value + '"]').attr('selected', true);
                    }else{
                        null;
                    }
                }

                $('#e_tempt').select2({
                    width: '100%',
                    placeholder: 'Pilih',
                    minimumResultsForSearch: 0,
                    dropdownParent: $('#editJadwalKeluarga') // 🔥 INI KUNCI
                });
            }
        });
    }

    // Edit Data
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_edit_jadwalfasilitator");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const e_publicid = formData.get("e_publicid")?.trim();
                const ed_direktorat = formData.get("ed_direktorat")?.trim();
                const e_kategori = formData.get("e_kategori")?.trim();
                const ed_subdit = formData.get("ed_subdit")?.trim();
                const e_ttedirektur = formData.get("e_ttedirektur")?.trim();
                const e_tempt = formData.get("e_tempt")?.trim();
                const e_acara = formData.get("e_acara")?.trim();
                const e_tempat = formData.get("e_tempat")?.trim();
                const e_lokasi = formData.get("e_lokasi")?.trim();
                const e_dari = formData.get("e_dari")?.trim();
                const e_sampai = formData.get("e_sampai")?.trim();
                const e_jumlah = formData.get("e_jumlah")?.trim();
                const e_status = formData.get("e_status")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    e_publicid: { value: e_publicid, message: "Maaf, public id harus diisi." },
                    // e_ttedirektur: { value: e_ttedirektur, message: "Maaf, tte direktur harus dipilih.", skipIf: 'Pilih' },
                    e_tempt: { value: e_tempt, message: "Maaf, template sertifikat harus dipilih.", skipIf: 'Pilih' },
                    e_acara: { value: e_acara, message: "Maaf, judul acara harus diisi." },
                    e_tempat: { value: e_tempat, message: "Maaf, tempat acara harus diisi." },
                    e_lokasi: { value: e_lokasi, message: "Maaf, lokasi acara harus diisi." },
                    e_dari: { value: e_dari, message: "Maaf, dari tanggal harus diisi." },
                    e_sampai: { value: e_sampai, message: "Maaf, sampai tanggal harus diisi." },
                    e_jumlah: { value: e_jumlah, message: "Maaf, jumlah angkatan harus diisi." },
                    e_status: { value: e_status, message: "Maaf, status data harus dipilih.", skipIf: 'Pilih' },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("editJadwalKeluarga");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('f65db6dd-b89e-4d40-8039-9df5e29039fe') }}", {
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
                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, pastikan form inputan tidak kosong.", "error");
                    showModal("editJadwalKeluarga");
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
            let baseUrl = "{{ url('storage/') }}/";

            $.ajax({
                url: "{{ url('527ab178-803a-43cb-beb8-ee2fd1e2d621') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#detailJadwalKeluarga').modal('show');
                    $('#d_nokeg').text(response.data.id);
                    $('#d_direktur2').text(response.data.direktur + ' — ' + response.data.kegiatan);
                    $('#d_acara').text(response.data.judul_acara);
                    $('#d_tempat').text(response.data.tempat);
                    $('#d_lokasi').text(response.data.lokasi);
                    $('#d_dari').text(response.data.dari);
                    $('#d_sampai').text(response.data.sampai);
                    $('#d_pembeda').text(response.data.angkatan);
                    $('#d_status').text(response.data.status);
                    if (response.data.files_1) {
                        $("#d_templates").attr("src", baseUrl + response.data.files_1);
                        if (response.data.files_2) {
                            $("#d_templates").css("margin-bottom", "10px");
                        }
                    }

                    if (response.data.files_2) {
                        $("#d_templates_2").attr("src", baseUrl + response.data.files_2);
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
                        url: "{{ url('031b1493-9e90-44f7-bf42-55ec84d5f909') }}",
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

    function encodeId(id) {
        return btoa(id); // contoh: 3 → Mw==
    }

    function decodeId(encoded) {
        return atob(encoded); // kalau mau balikin lagi
    }

    // Lihat Formulir
    Page.Back = function(val) {
        let $tbody = $("table.table tbody");
        $tbody.empty();

        if (val == '' || val == null || val == 0) {
            let baseUrl = "{{ route('barcodebimwin.download', ':id') }}";
            let index = 1;

            // Ambil full value
            let fullVal = val.toString();

            // Ambil hanya bagian sebelum tanda +
            let parts = fullVal.split("+");
            let displayPart = parts[0];         // hanya 5,6
            let suffix = parts.length > 1 ? "+" + parts[1] : ""; // kalau ada + ikutkan

            // Split berdasarkan koma
            let arr = displayPart.split(",");

            arr.forEach(function(item) {
                let nomor = item.trim();
                if (nomor !== "") {
                    // encode tetap pakai nomor
                    let encoded = encodeId(nomor);

                    // url pakai encoded + suffix
                    let url = baseUrl.replace(':id', encoded + suffix);

                    $tbody.append(`
                        <tr>
                            <th scope="row">${index}</th>
                            <td>Formulir Biodata Diri Untuk Angkatan</td>
                            <td>${nomor}</td>
                            <td><a href="${url}" target="_blank" style="text-decoration: none;">Unduh Barcode</a></td>
                        </tr>
                    `);

                    index++;
                }
            });

            // Tambahan statis untuk Narasumber
            let staticEncoded = encodeId(99);
            let staticUrl = baseUrl.replace(':id', staticEncoded + suffix);

            $tbody.append(`
                <tr>
                    <th scope="row">${index}</th>
                    <td>Formulir Biodata Diri Untuk Narasumber</td>
                    <td>-</td>
                    <td><a href="${staticUrl}" target="_blank" style="text-decoration: none;">Unduh Barcode</a></td>
                </tr>
            `);

            $('#FormulirJadwalKeluarga').modal('show');
        } else {
            let baseUrl = "{{ route('barcodebimwin.download', ':id') }}";
            let index = 1;

            // Ambil full value
            let fullVal = val.toString();

            // Ambil hanya bagian sebelum tanda +
            let parts = fullVal.split("+");
            let displayPart = parts[0];         // hanya 5,6
            let suffix = parts.length > 1 ? "+" + parts[1] : ""; // kalau ada + ikutkan

            // Split berdasarkan koma
            let arr = displayPart.split(",");

            arr.forEach(function(item) {
                let nomor = item.trim();
                if (nomor !== "") {
                    // encode tetap pakai nomor
                    let encoded = encodeId(nomor);

                    // url pakai encoded + suffix
                    let url = baseUrl.replace(':id', encoded + suffix);

                    $tbody.append(`
                        <tr>
                            <th scope="row">${index}</th>
                            <td>Formulir Biodata Diri Untuk Angkatan</td>
                            <td>${nomor}</td>
                            <td><a href="${url}" target="_blank" style="text-decoration: none;">Unduh Barcode</a></td>
                        </tr>
                    `);

                    index++;
                }
            });

            // Tambahan statis untuk Narasumber
            let staticEncoded = encodeId(99);
            let staticUrl = baseUrl.replace(':id', staticEncoded + suffix);

            $tbody.append(`
                <tr>
                    <th scope="row">${index}</th>
                    <td>Formulir Biodata Diri Untuk Narasumber</td>
                    <td>-</td>
                    <td><a href="${staticUrl}" target="_blank" style="text-decoration: none;">Unduh Barcode</a></td>
                </tr>
            `);

            $('#FormulirJadwalKeluarga').modal('show');
        }
    }

    $(function(){
        $("textarea[name='acara']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9,''-/. ]/g, ''));
        });
        $("input[name='tempat']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9,''-/. ]/g, ''));
        });
        $("input[name='lokasi']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9,''-/. ]/g, ''));
        });
        $("input[name='dari']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("input[name='sampai']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("input[name='jumlah']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9,]/g, ''));
        });
        $("textarea[name='e_acara']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9,''-/. ]/g, ''));
        });
        $("input[name='e_tempat']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9,''-/. ]/g, ''));
        });
        $("input[name='e_lokasi']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9,''-/. ]/g, ''));
        });
        $("input[name='e_dari']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("input[name='e_sampai']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("input[name='e_jumlah']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9,]/g, ''));
        });
    });
</script>