<script type="text/javascript">
    window.onload = function() {
        $('#Loader').hide();
        $('#div_sertifikat').hide();
    };

    var Page = {};

    Page.Info = function()
    {
        Swal.fire("Informasi", "Mohon maaf, sedang dalam proses pengerjaan.", "info");
    }

    //---------------------------------------------------------- Pencarian Sertifikat
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("sertifikat");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const id_sertifikat = formData.get("id_sertifikat")?.trim();
            const token = formData.get("_token")?.trim();

            const fields = {
                id_sertifikat: {
                    value: id_sertifikat,
                    message: "Maaf, pastikan kolom input sudah diisi."
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

            try {
                // hideModal("tambahMenu");
                showLoader();

                const response = await fetch("{{ url('/sertifikat/unduh') }}", {
                    method: "POST",
                    body: formData,
                    headers: {},
                });

                const result = await response.json();

                if (result.message === 200) {
                    Swal.fire("Berhasil", "Data sertifikat berhasil ditemukan.", "success")
                    .then(() => {
                        $("#div_sertifikat").show();
                        $("#id_sertifikat").val('');
                        TableSertifikat(result.data);
                    });
                } else if(result.message === 201){
                    $("#sertifikat_data").html(''); 
                    $("#div_sertifikat").hide();
                    $("#id_sertifikat").val('');
                    Swal.fire("Gagal", "Maaf, pencarian data sertifikat belum tersedia.", "error");
                } else {
                    $("#sertifikat_data").html(''); 
                    $("#div_sertifikat").hide();
                    $("#id_sertifikat").val('');
                    Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                }
            } catch (error) {
                console.error("Fetch Error:", error);
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

    function TableSertifikat(val) {
        var html = '';

        // Nama bulan Indonesia
        const bulanIndo = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        // Fungsi untuk parsing format DD-MM-YYYY
        function parseTanggal(tglStr) {
            if (!tglStr) return null;
            let parts = tglStr.split("-");
            if (parts.length === 3) {
                let [d, m, y] = parts.map(p => parseInt(p));
                return new Date(y, m - 1, d); // bulan -1 karena indeks bulan dimulai dari 0
            }
            return null;
        }

        val.forEach(function(row, i) {
            let dari = parseTanggal(row.dari);
            let sampai = parseTanggal(row.sampai);
            let hasilTanggal = "";

            if (dari && sampai) {
                // Jika bulan & tahun sama → 24 s.d. 26 Juli 2025
                if (dari.getMonth() === sampai.getMonth() && dari.getFullYear() === sampai.getFullYear()) {
                    hasilTanggal = `${dari.getDate()} s.d. ${sampai.getDate()} ${bulanIndo[dari.getMonth()]} ${dari.getFullYear()}`;
                } 
                // Jika beda bulan tapi tahun sama → 24 Juli 2025 s.d. 01 Agustus 2025
                else if (dari.getFullYear() === sampai.getFullYear()) {
                    hasilTanggal = `${dari.getDate()} ${bulanIndo[dari.getMonth()]} s.d. ${sampai.getDate()} ${bulanIndo[sampai.getMonth()]} ${dari.getFullYear()}`;
                } 
                // Jika beda tahun → 24 Desember 2025 s.d. 02 Januari 2026
                else {
                    hasilTanggal = `${dari.getDate()} ${bulanIndo[dari.getMonth()]} ${dari.getFullYear()} s.d. ${sampai.getDate()} ${bulanIndo[sampai.getMonth()]} ${sampai.getFullYear()}`;
                }
            } else {
                hasilTanggal = `${row.dari} s.d. ${row.sampai}`; // fallback jika parsing gagal
            }

            html += `
                <tr>
                    <td>${i + 1}</td>
                    <td style="text-align:left !important; text-transform: capitalize;">${row.nama}</td>
                    <td style="text-align:left !important;">${row.judul_acara}</td>
                    <td>${row.tempat}</td>
                    <td>${row.lokasi}</td>
                    <td>${hasilTanggal}</td>
                    <td class="aksi" style="text-align:center; vertical-align:middle;"><button 
                        class="btn btn-sm btn-primary" onclick="DownloadSertifikat('${row.public_id}')" style="margin-top:13px; margin-left:11px;">
                        <i class="fa fa-download"></i> Download
                        </button>
                    </td>
                </tr>
            `;
        });

        $('#sertifikat_data').html(html);
    }

    function DownloadSertifikat(id) {
        if (!id) {
            Swal.fire("Error", "ID sertifikat tidak ditemukan.", "error");
            return;
        }

        $.ajax({
                url: "{{ url('sertifikat/detail') }}/" + id,
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

    $(function(){
        $("input[name='id_sertifikat']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^aA0-zZ9.,-/'']/g, ''));
        });
    });
</script>
