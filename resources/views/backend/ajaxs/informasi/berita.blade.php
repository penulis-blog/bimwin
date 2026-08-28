<script type="text/javascript">
    window.onload = function() {
        $('.buttontutup').hide();
        $('#contentphoto').hide();
        $('#Loader_Proses').hide();
    };

    CKEDITOR.plugins.addExternal(
        'uploadimage',
        '/assets/ckeditor/plugins/uploadimage/',
        'plugin.js'
    );

    CKEDITOR.replace('editor1', {
        extraPlugins: 'uploadimage',   // gunakan uploadimage saja
        removePlugins: '',             // JANGAN remove image
        filebrowserUploadUrl: "{{ route('upload.image') }}?_token={{ csrf_token() }}",
        filebrowserUploadMethod: 'form'
    });

    // CSRF upload patch
    CKEDITOR.on('instanceReady', function (ev) {
        ev.editor.on('fileUploadRequest', function (evt) {
            var xhr = evt.data.fileLoader.xhr;
            var formData = new FormData();

            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('upload', evt.data.fileLoader.file, evt.data.fileLoader.fileName);

            xhr.send(formData);

            evt.stop();
            evt.cancel();
        });
    });

    $(document).ready(function () {
        $('#beritaTable').DataTable({
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
                            $('#tambahBerita').modal('show').one('shown.bs.modal', function () {
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
            "ajax": "{{ route('berita.table') }}",
            "columns": [
                { "data": "DT_RowIndex" },
                { "data": "tgl" },
                { "data": "kategori_berita" },
                { "data": "judul" },
                { "data": "status_berita" },
                { "data": "total" },
                { "data": "aksi" },
            ]
        });
    });

    $(function() {
        $(".tglpost").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });

    // cek karakter
    function setupInputColor(inputId, minTarget, maxTarget) {
        const input = document.getElementById(inputId);
        input.style.borderColor = 'red'; // default

        input.addEventListener('input', () => {
            const len = input.value.length;

            if (len >= minTarget && len <= maxTarget) {
                input.style.borderColor = 'green';
            } else {
                input.style.borderColor = 'red';
            }
        });
    }

    // Terapkan ke masing-masing input
    setupInputColor('b_title', 55, 60);   // hijau 55-60, merah <55 atau >60
    setupInputColor('b_desc', 120, 155);  // hijau 120-155, merah <120 atau >155
    setupInputColor('b_exc', 120, 160);   // hijau 120-160, merah <120 atau >160

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_berita_");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                if (CKEDITOR.instances.editor1) {
                    CKEDITOR.instances.editor1.updateElement();
                }

                const formData = new FormData(form);
                const b_kategori = formData.get("b_kategori");
                const b_judul = formData.get("b_judul")?.trim();
                const b_editor1 = formData.get("b_editor1")?.trim();
                const b_url = formData.get("b_url")?.trim();
                const b_files = formData.get("b_files");
                const b_key = formData.get("b_key")?.trim();
                const b_title = formData.get("b_title")?.trim();
                const b_desc = formData.get("b_desc")?.trim();
                const b_tags = formData.get("b_tags")?.trim();
                const b_exc = formData.get("b_exc")?.trim();
                const b_autor = formData.get("b_autor")?.trim();
                const b_tgl = formData.get("b_tgl")?.trim();
                const b_stat = formData.get("b_stat")?.trim();
                const token = formData.get("_token")?.trim();

                const fields = {
                    b_kategori: { value: b_kategori, message: "Maaf, kategori berita harus dipilih.", skipIf: 'Pilih' },
                    b_judul: { value: b_judul, message: "Maaf, judul harus diisi." },
                    // b_editor1: { value: b_editor1, message: "Maaf, content/isi harus diisi." },
                    b_url: { value: b_url, message: "Maaf, nama/sumber harus diisi." },
                    b_key: { value: b_key, message: "Maaf, kata kunci harus diisi." },
                    b_title: { value: b_title, message: "Maaf, title seo harus diisi." },
                    b_desc: { value: b_desc, message: "Maaf, deskripsi seo harus diisi." },
                    b_tags: { value: b_tags, message: "Maaf, tag seo harus diisi." },
                    b_exc: { value: b_exc, message: "Maaf, ringkasan/excerpt harus diisi." },
                    b_autor: { value: b_autor, message: "Maaf, nama/sumber harus diisi." },
                    b_tgl: { value: b_tgl, message: "Maaf, tanggal publish harus diisi." },
                    b_stat: { value: b_stat, message: "Maaf, status berita harus dipilih.", skipIf: 'Pilih' },
                    token: { value: token, message: "Token harus diisi." }
                };

                for (const key in fields) {
                    const { value, message, skipIf } = fields[key];
                    if (!value || value === skipIf) {
                        return showError(message);
                    }
                }

            try {
                hideModal("tambahBerita");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('9f3028a2-291d-40f2-97e3-e9ccd1d7cc36') }}", {
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
                    Swal.fire("Error", "Maaf, berita dengan judul/pranala itu sudah tersedia.", "error");
                    showModal("tambahBerita");
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

    function applyColorChecker(inputId, minTarget, maxTarget) {
        const input = document.getElementById(inputId);

        // Set warna default
        input.style.borderColor = 'red';

        // Listener saat user mengetik
        input.addEventListener('input', () => {
            checkLength();
        });

        // Fungsi pengecek panjang karakter
        function checkLength() {
            const len = input.value.length;

            if (len >= minTarget && len <= maxTarget) {
                input.style.borderColor = 'green';
            } else {
                input.style.borderColor = 'red';
            }
        }

        // Jalankan pengecekan pertama kali (saat edit)
        checkLength();
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
                url: "{{ url('4e5c3e5d-ea01-4f99-b985-26b76b83e103') }}/" + val,
                type: 'GET',
                success: function(response){
                    $('#editBerita').modal('show');
                    $('#be_publicid').attr('value', response.data.public_id);
                    const validGolongan = [
                        1, 2, 3
                    ];
                    if (validGolongan.includes(response.data.kategori)) {
                        document.getElementById('be_kategori').value = response.data.kategori;
                    }
                    $('#be_judul').attr('value', response.data.judul);
                    if (CKEDITOR.instances['editor1_']) {
                        CKEDITOR.instances['editor1_'].setData(response.data.isi);
                    } else {
                        CKEDITOR.replace('editor1_');
                        CKEDITOR.instances['editor1_'].setData(response.data.isi);
                    }
                    $('#be_files_old').attr('value', response.data.files);
                    $('#be_url').attr('value', response.data.pranala);
                    $('#btnlihat').attr('value', response.data.files);
                    $('#be_key').attr('value', response.data.meta_keywords);
                    $('#be_title').attr('value', response.data.meta_title);
                    $('textarea#be_desc').val(response.data.meta_deskripsi);
                    $('#be_tags').attr('value', response.data.meta_tags);
                    $('textarea#be_exc').val(response.data.excerpt);
                    $('#be_autor').attr('value', response.data.post_by);
                    $('#be_tgl').attr('value', response.data.tgl_post);
                    $(function() {
                        $(".tglpost_").datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true,
                            todayHighlight: true,
                        });
                    });
                    const validStatus = [
                        11, 12, 13
                    ];
                    if (validStatus.includes(response.data.is_trash)) {
                        document.getElementById('be_stat').value = response.data.is_trash;
                    }
                    applyColorChecker('be_title', 55, 60);
                    applyColorChecker('be_desc', 120, 155);
                    applyColorChecker('be_exc', 120, 160);
                }
            });
        }
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
            $('.buttonlihat').hide();
            $('.buttontutup').show();
            $('#contentphoto').show('slow');
            $("#gambar_berita").attr("src", "{{ url('storage/') }}/" + val);
        }
    }

    Page.Tutup = function()
    {
        $('.buttonlihat').show();
        $('.buttontutup').hide();
        $('#contentphoto').hide('slow');
    }

    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("form_edit_berita_");

        let canShowEditModalAgain = false; // flag jika error 201

        // Ketika modal editBerita benar-benar tertutup
        document.getElementById("editBerita").addEventListener("hidden.bs.modal", function () {
            if (canShowEditModalAgain) {
                // tampilkan modal lagi
                const modal = bootstrap.Modal.getOrCreateInstance('#editBerita');
                modal.show();
                canShowEditModalAgain = false;
            } else {
                // modal tertutup benar-benar => tampilkan loader
                showLoader();
            }
        });

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            if (CKEDITOR.instances.editor1_) {
                CKEDITOR.instances.editor1_.updateElement();
            }

            const formData = new FormData(form);
            const be_publicid = formData.get("be_publicid")?.trim();
            const be_kategori = formData.get("be_kategori")?.trim();
            const be_judul = formData.get("be_judul")?.trim();
            const be_editor1 = formData.get("be_editor1")?.trim();
            const be_url = formData.get("be_url")?.trim();
            const be_key = formData.get("be_key")?.trim();
            const be_title = formData.get("be_title")?.trim();
            const be_desc = formData.get("be_desc")?.trim();
            const be_tags = formData.get("be_tags")?.trim();
            const be_exc = formData.get("be_exc")?.trim();
            const be_autor = formData.get("be_autor")?.trim();
            const be_tgl = formData.get("be_tgl")?.trim();
            const be_stat = formData.get("be_stat")?.trim();
            const token = formData.get("_token")?.trim();

            const fields = {
                be_publicid: { value: be_publicid, message: "Maaf, public id harus diisi." },
                be_kategori: { value: be_kategori, message: "Maaf, kategori berita harus dipilih.", skipIf: 'Pilih' },
                be_judul: { value: be_judul, message: "Maaf, judul harus diisi." },
                be_url: { value: be_url, message: "Maaf, nama/sumber harus diisi." },
                be_key: { value: be_key, message: "Maaf, kata kunci harus diisi." },
                be_title: { value: be_title, message: "Maaf, title seo harus diisi." },
                be_desc: { value: be_desc, message: "Maaf, deskripsi seo harus diisi." },
                be_tags: { value: be_tags, message: "Maaf, tag seo harus diisi." },
                be_exc: { value: be_exc, message: "Maaf, ringkasan/excerpt harus diisi." },
                be_autor: { value: be_autor, message: "Maaf, nama/sumber harus diisi." },
                be_tgl: { value: be_tgl, message: "Maaf, tanggal publish harus diisi." },
                be_stat: { value: be_stat, message: "Maaf, status berita harus dipilih.", skipIf: 'Pilih' },
                token: { value: token, message: "Token harus diisi." }
            };

            // Validasi input
            for (const key in fields) {
                const { value, message, skipIf } = fields[key];
                if (!value || value === skipIf) {
                    return showError(message);
                }
            }

            // Tutup modal edit
            hideModal("editBerita");

            try {
                const response = await fetch("{{ url('8cb4efff-ec7d-4bf2-9e23-8be8378cd276') }}", {
                    method: "POST",
                    body: formData,
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });

                } else if (result.message === 201) {
                    Swal.fire("Error", "Maaf, berita dengan judul/pranala itu sudah tersedia.", "error");
                    canShowEditModalAgain = true; // modal akan muncul kembali setelah hidden selesai

                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }

            } catch (error) {
                console.error("Fetch Error:", error);
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");

            } finally {
                hideLoader();
            }
        });

        // === Fungsi bantu ===

        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                alert(msg);
            }
        }

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
            if (modalInstance) modalInstance.hide();
        }

        function showModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.show();
            }
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
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
                url: "{{ url('47605a1a-6c96-462d-bf3d-a323c5f507c7') }}/" + val,
                type: 'GET',
                success: function(response){
                    let angkatan = Number(response.data.angkatan);
                    let hasil = '-'; // default

                    $('#detailBerita').modal('show');
                    let baseUrl = "{{ url('/') }}/";
                    $('#dtl_kategori').text(response.data.kategori_berita);
                    $('#dtl_judul').text(response.data.judul);
                    $('#dtl_url').text(baseUrl + response.data.pranala);
                    $('#dtl_isi').html(response.data.isi);
                    $("#d_foto").attr("src", "{{ url('storage/') }}/" + response.data.files);
                    $('#dtl_keywords').text(response.data.meta_keywords);
                    $('#dtl_title').text(response.data.meta_title);
                    $('#dtl_desc').text(response.data.meta_deskripsi);
                    $('#dtl_tags').text(response.data.meta_tags);
                    $('#dtl_exc').text(response.data.excerpt);
                    $('#dtl_nama').text(response.data.post_by);
                    $('#dtl_tgl').text(response.data.tgl);
                    $('#dtl_stat').text(response.data.status_berita);
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
                        url: "{{ url('5a9d8e1e-22fe-42b1-867c-16b4fe76b0d7') }}",
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
                $('#tambahBerita').modal('hide');
                $('#detailBerita').modal('hide');
                $('#editBerita').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

    $(function(){
        $("input[name='b_url']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9-]/g, ''));
        });
        $("input[name='b_judul']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'' ]/g, ''));
        });
        $("input[name='b_autor']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'' ]/g, ''));
        });
        $("input[name='b_key']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'' ]/g, ''));
        });
        $("input[name='b_tgl']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("input[name='b_title']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'' ]/g, ''));
        });
        $("input[name='b_tags']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9, ]/g, ''));
        });
        $("textarea[name='b_desc']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("textarea[name='b_editor1']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("textarea[name='b_exc']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("input[name='be_url']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9-]/g, ''));
        });
        $("input[name='be_judul']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'' ]/g, ''));
        });
        $("input[name='be_autor']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'' ]/g, ''));
        });
        $("input[name='be_key']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'' ]/g, ''));
        });
        $("input[name='be_tgl']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9-]/g, ''));
        });
        $("input[name='be_title']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'' ]/g, ''));
        });
        $("input[name='be_tags']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9, ]/g, ''));
        });
        $("textarea[name='be_desc']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("textarea[name='be_editor1']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
        $("textarea[name='be_exc']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/ ]/g, ''));
        });
    });
</script>

{{-- validasi edit data baru --}}
<script>
    function e_validateBiodata() {
        let valid = true;

        const kategori = document.getElementById("be_kategori").value;
        const judul = document.getElementById("be_judul").value;
        const url = document.getElementById("be_url").value;

        // Ambil data CKEditor
        const ckData = CKEDITOR.instances['editor1_'].getData().trim();

        // Hilangkan HTML kosong seperti <p>&nbsp;</p>
        const plainText = ckData.replace(/<[^>]+>/g, '').trim();

        if (kategori === "" || kategori === "Pilih") valid = false;
        if (!judul) valid = false;
        if (!plainText) valid = false;  // ← VALIDASI CKEDITOR YANG BENAR
        if (!url) valid = false;

        return valid;
    }

    function e_validateAdministratif() {
        let valid = true;

        if (!document.getElementById("be_key").value.trim()) valid = false;
        if (!document.getElementById("be_title").value.trim()) valid = false;
        if (!document.getElementById("be_desc").value.trim()) valid = false;
        if (!document.getElementById("be_tags").value.trim()) valid = false;
        if (!document.getElementById("be_exc").value.trim()) valid = false;
        return valid;
    }

    function e_validateInstansi() {
        let valid = true;

        if (!document.getElementById("be_autor").value.trim()) valid = false;
        if (!document.getElementById("be_tgl").value) valid = false;
        const be_stat = document.getElementById("be_stat").value;

        if (be_stat === "" || be_stat === "Pilih") valid = false;

        return valid;
    }

    // ======================== PINDAH TAB ========================
    function nextTab(tabId) {
        let allow = false;

        if (tabId === "edit-administratif-tab") {
            allow = e_validateBiodata();
            if (!allow) { toastr.error("Maaf, harap di lengkapi tab content."); return; }
        }
        if (tabId === "edit-instansi-tab") {
            allow = e_validateAdministratif();
            if (!allow) { toastr.error("Maaf, harap di lengkapi tab meta browser."); return; }
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
            toastr.error('Maaf, harap di lengkapi tab content.');
            e.preventDefault();
            }
            if (btn.id === "edit-instansi-tab" && !e_validateAdministratif()) {
            toastr.error('Maaf, harap di lengkapi tab meta browser.');
            e.preventDefault();
            }
            if (btn.id === "edit-instansi-tab" && !e_validateInstansi()) {
            toastr.error('Maaf, harap di lengkapi tab penulis.');
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
            "b_kategori", "b_judul", "b_editor1",
            "b_url", "b_files"
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
            "b_key", "b_title", "b_desc", "b_tags",
            "b_exc"
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
            "b_autor", "b_tgl", "b_stat"
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
                toastr.error('Maaf, harap di lengkapi tab content.')
                return;
            }
            
            document.getElementById("administratif-tab").classList.remove("disabled");
            document.getElementById("administratif-tab").removeAttribute("disabled");
        }

        if (tabId === "instansi-tab") {
            if (!validateAdministratif()) {
                toastr.error('Maaf, harap di lengkapi tab meta browser.');
                return;
            }

            document.getElementById("instansi-tab").classList.remove("disabled");
            document.getElementById("instansi-tab").removeAttribute("disabled");
        }

        if (tabId === "submit-tab") {
            if (!validateInstansi()) {
                toastr.error('Maaf, harap di lengkapi tab penulis.');
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