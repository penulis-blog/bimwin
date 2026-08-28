<script type="text/javascript">
    window.onload = function() {
        // --- Sembunyikan semua elemen saat pertama kali halaman dimuat ---
        $('.lihatPhoto1, .tutupPhoto1, .lihatPhoto2, .tutupPhoto2').hide();
        $('#edokumen_1, #edokumen_2').hide();
        $('#contentphoto1, #contentphoto2, #dokumen_1, #dokumen_2, #tab_files1, #tab_files2').hide();

        // Jalankan pengecekan awal file lama
        cekFileLama();

        // Jalankan ulang setelah 500ms untuk antisipasi delay render value hidden input
        setTimeout(cekFileLama, 500);
    };

    $(document).ready(function() {
        $('#templateTable').DataTable({
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
                        $('#tambahTemplate').modal('show');
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
            "ajax": "{{ route('template.table') }}",
            "columns": [{
                    "data": "DT_RowIndex"
                },
                {
                    "data": "nama"
                },
                // {
                //     "data": "direktorat"
                // },
                // {
                //     "data": "subdit"
                // },
                // {
                //     "data": "direktur"
                // },
                {
                    "data": "status"
                },
                {
                    "data": "aksi"
                },
            ]
        });
    });

    // Ambil Master TTD
    // $.ajax({
    //     url: "{{ url('3afe31df-98e4-4dd3-83b9-6f70892a349b') }}",
    //     type: 'GET',
    //     success: function(response) {
    //         var sel = document.getElementById("id_template");

    //         // Kosongkan pilihan sebelumnya
    //         sel.innerHTML = "";

    //         // Tambahkan option default
    //         var defaultOption = document.createElement("option");
    //         defaultOption.value = "";
    //         defaultOption.text = "Pilih";
    //         sel.add(defaultOption);

    //         // Loop data
    //         for (var i = 0; i < response.data.length; i++) {
    //             var item = response.data[i];
    //             var opt = document.createElement("option");

    //             let direktur = item.direktur ?? '';
    //             let kegiatan = item.kegiatan ?? '';

    //             // Format paling rapi
    //             if (kegiatan) {
    //                 opt.text = direktur + ' — [' + kegiatan + ']';
    //             } else {
    //                 opt.text = direktur;
    //             }

    //             opt.value = item.id;
    //             sel.add(opt);
    //         }
    //     }
    // });

    // insert data
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_template");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            // Helper aman: string vs file
            const getString = (key) => (formData.get(key)?.trim() || "");
            const getFile = (key) => formData.get(key);

            // Ambil semua nilai
            const nm_template = getString("nm_template");
            // const id_template = getString("id_template");
            const jm_template = getString("jm_template");
            const token = getString("_token");

            const doks1 = getFile("doks1");
            const doks2 = getFile("doks2");

            // Validasi field teks
            const fields = {
                nm_template: {
                    value: nm_template,
                    message: "Maaf, nama template harus diisi."
                },
                // id_template: {
                //     value: id_template,
                //     message: "Maaf, yang bertanda tangan harus dipilih.",
                //     skipIf: "Pilih"
                // },
                jm_template: {
                    value: jm_template,
                    message: "Maaf, jumlah files/design harus dipilih.",
                    skipIf: "Pilih"
                },
                token: {
                    value: token,
                    message: "Token harus diisi."
                }
            };

            for (const key in fields) {
                const {
                    value,
                    message,
                    skipIf
                } = fields[key];
                if (!value || value === skipIf) {
                    return showError(message);
                }
            }

            // Validasi file (opsional)
            if (!doks1 || doks1.size === 0) {
                return showError("Maaf, file dokumen 1 belum dipilih.");
            }

            // Jika jumlah file lebih dari 1 wajib isi doks2
            if (jm_template > 1 && (!doks2 || doks2.size === 0)) {
                return showError("Maaf, file dokumen 2 belum dipilih.");
            }

            try {
                hideModal("tambahTemplate");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('d01a8022-1098-41cb-8d0f-6fb98081f5cc') }}", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 203) {
                    Swal.fire("Error", "Maaf, jenis file photo hanya .jpeg, .jpg, dan .png.",
                        "error");
                    showModal("tambahTemplate");
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                hideLoader(); // sembunyikan loader jika ada
            }
        });

        function showError(msg) {
            if (typeof toastr !== "undefined") {
                toastr.error(msg, "Error");
            } else {
                Swal.fire("Error", msg, "error");
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

    Page.Batal = function() {
        $.ajax({
            type: 'GET',
            beforeSend: function() {
                $('#tambahTemplate').modal('hide');
                $('#detailTemplate').modal('hide');
                $('#editTemplate').modal('hide');
                $('#listTemplate').modal('hide');
                $('#Loader').modal('show');
            },
            complete: function(response) {
                window.location.href = window.location.pathname;
            }
        });
    }

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
            url: "{{ url('1911d9ef-4e3c-4cef-bf24-4bdf121a4d74') }}/" + val,
            type: 'GET',
            success: function(response) {
                $('#editTemplate').modal('show');
                $('#e_publicid').val(response.data.public_id);
                $('#enm_template').val(response.data.nama);
                $('#old_edoks1').val(response.data.files_1);
                $('#old_edoks2').val(response.data.files_2);
                // eTTD(response.data.id_ttd);

                const file1 = response.data.files_1 ? response.data.files_1.trim() : '';
                const file2 = response.data.files_2 ? response.data.files_2.trim() : '';

                // Tentukan jumlah file otomatis
                let fileValue = '';
                if (file1 && file2) fileValue = '2';
                else if (file1 && !file2) fileValue = '1';
                $('#ejm_template').val(fileValue).trigger('change');

                // Reset tampilan awal
                $('.lihatPhoto1, .tutupPhoto1, .lihatPhoto2, .tutupPhoto2').hide();
                $('#contentphoto1, #contentphoto2').hide();

                // Tombol file 1
                if (file1) {
                    $('.lihatPhoto1').show().off('click').on('click', function() {
                        Page.Lihat(file1, 1);
                    });
                    $('.tutupPhoto1').off('click').on('click', function() {
                        Page.Tutup(file1, 1);
                    });
                }

                // Tombol file 2
                if (file2) {
                    $('.lihatPhoto2').show().off('click').on('click', function() {
                        Page.Lihat(file2, 2);
                    });
                    $('.tutupPhoto2').off('click').on('click', function() {
                        Page.Tutup(file2, 2);
                    });
                } else {
                    $('.lihatPhoto2, .tutupPhoto2').hide();
                }

                // Sinkronkan status is_trash
                setTimeout(() => {
                    const e_status = document.getElementById('eis_trash');
                    if (e_status) e_status.value = String(response.data.is_trash ?? '');
                }, 800);

                // ✅ Jalankan cek ulang setelah data AJAX terpasang
                setTimeout(() => {
                    cekFileLama();
                }, 300);
            }
        });
    };

    function cekFileLama() {
        const oldFile1 = ($('#old_edoks1').val() || '').trim();
        const oldFile2 = ($('#old_edoks2').val() || '').trim();
        const jumlahFiles = $('#ejm_template').val();

        // --- File 1 ---
        if (oldFile1 && oldFile1 !== 'null' && oldFile1 !== 'undefined') {
            $('.lihatPhoto1').show();
        } else {
            $('.lihatPhoto1, .tutupPhoto1').hide();
        }

        // --- File 2 ---
        if (oldFile2 && oldFile2 !== 'null' && oldFile2 !== 'undefined') {
            $('.lihatPhoto2').show();
        } else {
            $('.lihatPhoto2, .tutupPhoto2').hide();
        }

        // --- Logika jumlah file (dropdown) ---
        if (jumlahFiles === '2') {
            $('#edokumen_2').show();
            if (!oldFile2 || oldFile2 === 'null' || oldFile2 === 'undefined') {
                $('.lihatPhoto2, .tutupPhoto2').hide();
            }
        } else if (jumlahFiles === '1') {
            $('#edokumen_2').hide();
        } else {
            $('#edokumen_2').hide();
        }
    }

    function e_JumlahFiles(val) {
        const fileLama2 = ($('#old_edoks2').val() || '').trim();

        if (val === "1") {
            $('#edokumen_2').hide();
        } else if (val === "2") {
            $('#edokumen_2').show();

            if (!fileLama2 || fileLama2 === 'null' || fileLama2 === 'undefined') {
                $('.lihatPhoto2, .tutupPhoto2').hide();
            } else {
                $('.lihatPhoto2').show();
            }
        } else {
            $('#edokumen_2').hide();
        }
    }

    // function eTTD(val) {
    //     if (!val || val == 0) {
    //         Swal.fire({
    //             title: "Informasi",
    //             text: "Maaf, ID tidak tersedia.",
    //             icon: "error",
    //             allowOutsideClick: false,
    //             allowEscapeKey: false,
    //             confirmButtonText: "OK"
    //         });
    //     } else {
    //         $.ajax({
    //             url: "{{ url('3afe31df-98e4-4dd3-83b9-6f70892a349b') }}",
    //             type: 'GET',
    //             success: function(response) {
    //                 var sel = document.getElementById("eid_template");

    //                 // Kosongkan pilihan sebelumnya
    //                 sel.innerHTML = "";

    //                 // Tambahkan option default
    //                 var defaultOption = document.createElement("option");
    //                 defaultOption.value = "";
    //                 defaultOption.text = "Pilih";
    //                 sel.add(defaultOption);

    //                 // Loop data
    //                 for (var i = 0; i < response.data.length; i++) {
    //                     var item = response.data[i];
    //                     var opt = document.createElement("option");

    //                     let direktur = item.direktur ?? '';
    //                     let kegiatan = item.kegiatan ?? '';

    //                     // Format tampilan
    //                     if (kegiatan) {
    //                         opt.text = direktur + ' — [' + kegiatan + ']';
    //                     } else {
    //                         opt.text = direktur;
    //                     }

    //                     opt.value = item.id;
    //                     sel.add(opt);

    //                     // Set selected jika match
    //                     if (String(item.id) === String(val)) {
    //                         opt.selected = true;
    //                     }
    //                 }
    //             }
    //         });
    //     }
    // }

    function JumlahFiles(val) {
        if (!val || val == 0) {
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

        if (val == 1) {
            $("#dokumen_1").show('slow');
            $("#dokumen_2").hide('slow');
        } else if (val == 2) {
            $("#dokumen_2").show('slow');
        } else {
            $("#dokumen_1").hide('slow');
            $("#dokumen_2").hide('slow');
        }
    }

    $(document).ready(function() {
        $('#edokumen_1, #edokumen_2').hide();
        $('.lihatPhoto1, .tutupPhoto1, .lihatPhoto2, .tutupPhoto2').hide();
        $('#contentphoto1, #contentphoto2').hide();

        // Ketika dropdown template berubah
        $('#ejm_template').on('change', function() {
            const val = $(this).val();

            // Reset semua tampilan
            $('#edokumen_1, #edokumen_2').hide();
            $('.lihatPhoto1, .tutupPhoto1, .lihatPhoto2, .tutupPhoto2').hide();
            $('#contentphoto1, #contentphoto2').hide();

            if (val === '1') {
                // Hanya edokumen 1 yang aktif
                $('#edokumen_1').show();
                $('.lihatPhoto1').show();
            } else if (val === '2') {
                // Kedua dokumen aktif
                $('#edokumen_1, #edokumen_2').show();
                $('.lihatPhoto1, .lihatPhoto2').show();
            }
        });
    });

    // Fungsi untuk lihat dokumen
    Page.Lihat = function(val, no) {
        // Cek kondisi kosong
        if (!val || val.trim() === '' || val === 'null' || val === 'undefined') {
            Swal.fire({
                title: "Informasi",
                text: "Maaf, file belum tersedia.",
                icon: "error"
            });
            return;
        }

        const storageBase = "{{ url('storage') }}";

        $('.lihatPhoto' + no).hide();
        $('.tutupPhoto' + no).show();
        $('#contentphoto' + no).show('slow');
        $("#gambar_file" + no).attr("src", storageBase + "/" + val);
    };


    Page.Tutup = function(val, no) {
        if (!val) {
            Swal.fire({
                title: "Informasi",
                text: "Maaf, ID tidak tersedia.",
                icon: "error"
            });
            return;
        }
        $('.lihatPhoto' + no).show();
        $('.tutupPhoto' + no).hide();
        $('#contentphoto' + no).hide('slow');
    };

    // Update Data
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_edit_template");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const e_publicid = formData.get("e_publicid")?.trim();
            const enm_template = formData.get("enm_template")?.trim();
            const ejm_template = formData.get("ejm_template")?.trim();
            // const eid_template = formData.get("eid_template")?.trim();
            const old_edoks1 = formData.get("old_edoks1")?.trim();
            const old_edoks2 = formData.get("old_edoks2")?.trim();
            const edoks1 = formData.get("edoks1");
            const edoks2 = formData.get("edoks2");
            const eis_trash = formData.get("eis_trash")?.trim();
            const token = formData.get("_token")?.trim();

            const fields = {
                e_publicid: {
                    value: e_publicid,
                    message: "Maaf, public id harus diisi."
                },
                enm_template: {
                    value: enm_template,
                    message: "Maaf, nama template harus diisi."
                },
                // eid_template: {
                //     value: eid_template,
                //     message: "Maaf, angkatan harus dipilih.",
                //     skipIf: 'Pilih'
                // },
                eis_trash: {
                    value: eis_trash,
                    message: "Maaf, status harus dipilih.",
                    skipIf: 'Pilih'
                },
                token: {
                    value: token,
                    message: "Token harus diisi."
                }
            };

            for (const key in fields) {
                const {
                    value,
                    message,
                    skipIf
                } = fields[key];
                if (!value || value === skipIf) {
                    return showError(message);
                }
            }

            hideModal("editTemplate");

            // tunggu modal editTemplate benar-benar tertutup baru tampilkan loader
            setTimeout(() => {
                showLoader();
            }, 400);

            try {
                hideModal("editTemplate");
                showLoader(); // tampilkan loading modal jika ada

                const response = await fetch("{{ url('520a3bcf-c659-4c4d-a3a3-3f6cf561b111') }}", {
                    method: "POST",
                    body: formData,
                    headers: {},
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil diperbaharui.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 203) {
                    Swal.fire("Error", "Maaf, jenis file photo hanya .jpeg, .jpg, dan .png.",
                        "error");
                    showModal("tambahTemplate");
                } else {
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
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
                url: "{{ url('bb70b99b-54e7-441c-8dbc-8f0603b11a0a') }}/" + val,
                type: 'GET',
                success: function(response) {
                    $('#detailTemplate').modal('show');

                    // isi data lain
                    $('#d_direktorat').text(response.data.direktorat);
                    $('#d_subdit').text(response.data.subdit);
                    $('#d_direktur').text(response.data.direktur);
                    $('#d_kegiatan').text(response.data.nama);
                    $('#d_status').text(response.data.status);

                    if (response.data.files_1) {
                        $("#d_foto1").attr("src", "{{ url('storage/') }}/" + response.data.files_1);
                    } else {
                        $("#d_foto1").attr("src", "");
                    }

                    if (response.data.files_2) {
                        $("#d_foto2").attr("src", "{{ url('storage/') }}/" + response.data.files_2);
                    } else {
                        $("#d_foto2").attr("src", "");
                    }

                    // 🔹 Atur visibilitas tab berdasarkan data
                    if (response.data.files_1 && response.data.files_2) {
                        // Jika dua-duanya ada → tampilkan dua tab
                        $('#tab_files1').show();
                        $('#tab_files2').show();
                    } else if (response.data.files_1 && !response.data.files_2) {
                        // Jika hanya file_1 → tampilkan tab 1 saja
                        $('#tab_files1').show();
                        $('#tab_files2').hide();
                    } else if (!response.data.files_1 && response.data.files_2) {
                        // Jika hanya file_2 → tampilkan tab 2 saja
                        $('#tab_files1').hide();
                        $('#tab_files2').show();
                    } else {
                        // Jika dua-duanya kosong → sembunyikan semua
                        $('#tab_files1').hide();
                        $('#tab_files2').hide();
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
                        url: "{{ url('2884c5a6-0cb4-49a4-b5d5-7d074675ef73') }}",
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

    Page.Materi = function(val) {
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
                url: "{{ url('ae47aca8-b10a-45e8-b8b7-ec4aaa0b594a') }}/" + val,
                type: 'GET',
                success: function(response) {
                    if (response.message == 200) {
                        $('.id_template').val(val);
                        $('#listTemplate').modal('show');
                        createTable(response.data);
                    } 
                    else if (response.message == 400) {
                        Swal.fire("Error", "List materi sertifikat masih kosong, segera dilengkapi..", "error");
                        $('.id_template').val(val);
                        $('#listTemplate').modal('show');
                    } 
                    else if (response.message == 404) {
                        Swal.fire("Informasi", "List materi belum tersedia untuk template ini.", "info");
                        $('.id_template').val(val);
                        $('#listTemplate').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    Swal.fire("Gagal", "Terjadi kesalahan koneksi atau URL tidak ditemukan.", "error");
                }
            });
        }
    }

    function createTable(data) {
        var html = '';

        data.forEach(function(row, i) {
            // Gunakan i sebagai index (bukan index yang belum dideklarasikan)
            const idValue = row.public_id ? row.public_id : `new_${i}`;
            const isDatabase = row.public_id ? true : false;

            html += `
                <tr id="row_${idValue}">
                    <input type="hidden" name="e_id_template[]" value="${row.id_template || ''}"/>
                    <input type="hidden" name="e_public_id[]" value="${row.public_id || ''}"/>
                    <td class="text-center align-middle row-number">${i + 1}</td>
                    <td style="width:85%;">
                        <input type="text" name="e_materi[]" class="form-control" value="${row.judul || ''}">
                    </td>
                    <td style="width:7%; text-align:center;">
                        <input type="text" name="e_jpl[]" class="form-control" value="${row.total || ''}" style="text-align:center;">
                    </td>
                    <td class="text-center" style="width:80px; vertical-align:middle;">
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="Page.HapusMateri('${idValue}', ${isDatabase})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        $('#materiBody').html(html);
    }

    let uniqueId = 0;

    Page.TambahMateri = function(val) {
        uniqueId++;
        const id = uniqueId;

        const rowHtml = `
            <tr id="row_${id}">
                <td class="text-center row-number" style="width:5%; vertical-align:middle;"></td>
                <td style="width:75%; vertical-align:middle;">
                    <input type="hidden" name="id_template[]" value="${val}">
                    <input type="text" name="materi[]" class="form-control" placeholder="Nama Materi">
                </td>
                <td style="width:10%; text-align:center; vertical-align:middle;">
                    <input type="text" name="jpl[]" class="form-control text-center" placeholder="JPL">
                </td>
                <td class="text-center" style="width:10%; vertical-align:middle;">
                    <button type="button" class="btn btn-danger btn-sm" onclick="Page.HapusMateri('${id}', false)">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#materiBody').append(rowHtml);
        Page.ReorderRows();

        // Fokus otomatis ke input materi pada baris baru
        $(`#row_${id} input[name="materi[]"]`).focus();
    };

    $(document).on('input', 'input[name="jpl[]"]', function() {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
    $(document).on('input', 'input[name="materi[]"]', function() {
        $(this).val($(this).val().replace(/[^A-Za-z.,\/\- ]/g, ''));
    });

    Page.HapusMateri = function(id, isDatabase) {
        if (isDatabase) {
            Swal.fire({
                title: "Yakin hapus?",
                text: "Data ini akan dihapus permanen dari database.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    var a = id;
                    $.ajax({
                        url: "{{ url('6e1a6004-f789-45e3-b642-56fb291e0680') }}",
                        type: "POST",
                        data: {
                            id: a,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.message == 200) {
                                Swal.fire("Berhasil", "Data berhasil dihapus.", "success").then(() => {
                                    $(`#row_${id}`).remove(); // hapus baris berdasarkan ID yang dikirim
                                    Page.ReorderRows();
                                });
                            } else {
                                Swal.fire("Gagal", response.message || "Tidak dapat menghapus data.", "error");
                            }
                        },
                        error: function(xhr) {
                            Swal.fire("Error", "Gagal terhubung ke server.", "error");
                        }
                    });
                }
            });
        } else {
            // 🟡 Hapus baris di tabel saja
            $(`#row_${id}`).remove();
            Page.ReorderRows();
        }
    };

    Page.ReorderRows = function() {
        $('#materiBody tr').each(function(index) {
            // index mulai dari 0 => nomor = index+1
            $(this).find('.row-number').text(index + 1);
        });
    };

    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("form_template_materi");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            // Buat ulang FormData supaya selalu fresh
            const formData = new FormData(form);

            // Ambil token dan id
            const token = formData.get("_token")?.trim();
            const id_template = formData.get("id_template")?.trim();

            // Ambil semua nilai input dari tabel dinamis
            const materi = [
                ...Array.from(document.querySelectorAll('input[name="materi[]"]')),
                ...Array.from(document.querySelectorAll('input[name="e_materi[]"]'))
            ].map(el => el.value.trim());

            const jpl = [
                ...Array.from(document.querySelectorAll('input[name="jpl[]"]')),
                ...Array.from(document.querySelectorAll('input[name="e_jpl[]"]'))
            ].map(el => el.value.trim());

            // ✅ Validasi CSRF token
            if (!token) {
                return showError("Token tidak ditemukan. Silakan refresh halaman dan coba lagi.");
            }

            // ✅ Validasi minimal satu baris
            if (materi.length === 0) {
                return showError("Harap tambahkan minimal satu materi.");
            }

            // ✅ Validasi setiap baris
            for (let i = 0; i < materi.length; i++) {
                if (!materi[i]) return showError(`Materi ke-${i + 1} harus diisi.`);
                if (!jpl[i]) return showError(`JPL untuk materi ke-${i + 1} harus diisi.`);
            }

            // ✅ Hapus field lama agar tidak dobel
            formData.delete("materi[]");
            formData.delete("jpl[]");

            // ✅ Tambahkan ulang array ke FormData
            materi.forEach((v) => formData.append("materi[]", v));
            jpl.forEach((v) => formData.append("jpl[]", v));

            try {
                // 🔹 Tutup dulu modal form supaya loader tampil di depan
                $('#listTemplate').modal('hide');

                // 🔹 Tampilkan loader
                $('#Loader').modal('show');

                const response = await fetch("{{ url('21731523-861d-4913-8f6e-8de014cf69c3') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": token
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data berhasil disimpan.", "success").then(() => {
                        window.location.href = window.location.pathname;
                    });
                } else if (result.message === 400) {
                    Swal.fire("Error", "Pastikan kolom input tidak ada yang kosong.", "error");
                } else {
                    Swal.fire("Gagal", result.message || "Terjadi kesalahan saat menyimpan.", "error");
                }

            } catch (error) {
                Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
            } finally {
                // 🔹 Tutup loader dengan cara yang benar
                $('#Loader').modal('hide');
                setTimeout(() => {
                    $('#Loader').modal('show');
                }, 300);
            }
        });

        // ✅ Hanya izinkan angka di input JPL
        $(document).on("input", 'input[name="jpl[]"]', function() {
            $(this).val($(this).val().replace(/[^0-9]/g, ""));
        });

        // ✅ Hanya izinkan huruf, angka, dan tanda baca umum di Materi
        $(document).on("input", 'input[name="materi[]"]', function() {
            $(this).val($(this).val().replace(/[^A-Za-z0-9.,\/\- ]/g, ""));
        });

        // =====================
        // 🔧 Fungsi bantu umum
        // =====================
        function showError(msg) {
            if (typeof toastr !== "undefined") toastr.error(msg, "Error");
            else Swal.fire("Error", msg, "error");
        }

        function showLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "block";
        }

        function hideLoader() {
            const loader = document.getElementById("Loader");
            if (loader) loader.style.display = "none";
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            if (modal && typeof bootstrap !== "undefined") {
                const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                bsModal.hide();
            }
        }
    });

    $(function() {
        $("input[name='nm_template']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/' ]/g, ''));
        });
        $("input[name='e_nm_template']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/' ]/g, ''));
        });
    });
</script>
