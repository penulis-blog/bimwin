<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir {{ $judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
  <style>
    .wizard-step {
        display: none;
    }
    .wizard-step.active {
        display: block;
    }
    .card-header {
        background: linear-gradient(135deg, #006400, #228B22); /* hijau tua ke hijau terang */
        color: white;
        text-align: center;
        /* padding: 2rem 1rem; */
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .card-header img {
        display: block;
        margin: 0 auto 1rem auto;
    }
    .card-header h5,
    .card-header p {
        color: white; /* pastikan teks tetap putih */
    }
    .blurred {
        filter: blur(2px);
        pointer-events: none;
        opacity: 0.6;
        transition: all 0.3s ease;
    }

    /* Teks loading */
    #loadingText {
        display: none;
        text-align: center;
        font-weight: bold;
        color: #0d6efd;
        margin-bottom: 10px;
    }
  </style>
</head>
<body>
<div class="container my-2">
  <div class="card shadow-sm">
    <div id="loadingText">⏳ Mengirim data, mohon tunggu...</div>

    <div class="modal fade" id="LoaderIng" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background-color:transparent; border:0px solid;">
                <div class="modal-body">
                    <center><img src="/assets/backend/img/loader.gif" alt="" class="img-fluid d-block w-7" style="width:50px;" /></center>
                </div>
            </div>
        </div>
    </div>

    <div class="card-header">
        <img src="{{ asset('assets/backend/img/bi-kemag.png') }}" width="100" alt="Logo BI-Kemenag" />
        <h5 class="mb-3">
        DIREKTORAT JENDERAL BIMBINGAN MASYARAKAT ISLAM<br>
        DIREKTORAT BINA KUA DAN KELUARGA SAKINAH<br>
        </h5>
        <h5 class="mb-3"><b>{{ strtoupper($data->judul_acara) }}</b></h5>
        <p>{{ ucwords($data->tempat) }}, {{ ucwords($data->lokasi) }}, {{ indo_periode($data->in, $data->out) }}</p>
        <p><b>{{ strtoupper($judul) }} @if($angkatan != 99 && $angkatan != 0) ANGKATAN {{ $angkatan }} @endif</b></p>
    </div>

    <div class="card-body">
        @if($data->is_trash == 11)
            <ul class="nav nav-pills justify-content-center mb-4">
                <li class="nav-item">
                <button class="nav-link active" id="tab-1" type="button">1. Biodata Diri</button>
                </li>

                <li class="nav-item">
                <button class="nav-link" id="tab-2" type="button">2. Administratif</button>
                </li>

                <li class="nav-item">
                <button class="nav-link" id="tab-3" type="button">3. Instansi</button>
                </li>
            </ul>

            <form id="formulir_peserta" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id_kegiatan" name="id_kegiatan" class="form-control required" value="{{ $data->id }}">
                <input type="hidden" id="id_angkatan" name="id_angkatan" class="form-control required" value="{{ $angkatan }}">

                <!-- Step 1 -->
                <div class="wizard-step active" id="step-1">
                    <div class="mb-3">
                        <label class="form-label">NIK KTP <span class="text-danger">*</span></label>
                        <input type="text" id="nik_bimwin" name="nik_bimwin" class="form-control required" placeholder="Masukkan NIK KTP">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" id="nama_bimwin" name="nama_bimwin" class="form-control required" placeholder="Masukkan Nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" id="tmp_bimwin" name="tmp_bimwin" class="form-control required" placeholder="Masukkan Tempat Lahir">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="text" id="tgl_bimwin" name="tgl_bimwin" class="form-control lahirinput required" placeholder="Masukkan Tanggal Lahir">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select required" id="jk_bimwin" name="jk_bimwin">
                            <option value="" selected disabled>Pilih</option>
                            <option value="11">Laki-laki</option>
                            <option value="12">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                        <textarea id="domisili_bimwin" name="domisili_bimwin" class="form-control required" placeholder="Masukkan Alamat Rumah"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. HP <span class="text-danger">*</span></label>
                        <input type="text" id="hp_bimwin" name="hp_bimwin" class="form-control required" placeholder="Masukkan Nomor HP">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="text" id="email_bimwin" name="email_bimwin" class="form-control required" placeholder="Masukkan Email">
                    </div>

                    <button class="btn btn-primary float-end next-btn">Selanjutnya</button>
                </div>

                <!-- Step 2 -->
                <div class="wizard-step" id="step-2">
                    <div class="mb-3">
                    <label class="form-label">No. Rekening <span class="text-danger">*</span></label>
                    <input type="text" id="rek_bimwin" name="rek_bimwin" class="form-control required" placeholder="Masukkan No. Rekening">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Nama Bank <span class="text-danger">*</span></label>
                    <input type="text" id="nm_bimwin" name="nm_bimwin" class="form-control required" placeholder="Masukkan Nama Bank">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">NPWP <span class="text-danger">*</span></label>
                    <input type="text" id="npwp_bimwin" name="npwp_bimwin" class="form-control required" placeholder="Masukkan NPWP">
                    </div>

                    <button class="btn btn-secondary prev-btn">Sebelumnya</button>
                    <button class="btn btn-primary float-end next-btn">Selanjutnya</button>
                </div>

                <!-- Step 3 -->
                <div class="wizard-step" id="step-3">
                    <div class="mb-3">
                        <label class="form-label">NIP <span class="text-danger">*</span></label>
                        <input type="text" id="nip_bimwin" name="nip_bimwin" class="form-control required" placeholder="Masukkan NIP">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                        <select class="form-select required" id="prov_bimwin" name="prov_bimwin" onchange="Kabupaten(this.value)"></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kabupaten <span class="text-danger">*</span></label>
                        <select class="form-select required" id="kab_bimwin" name="kab_bimwin" onchange="Kecamatan(this.value)"></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                        <select class="form-select required" id="kec_bimwin" name="kec_bimwin"></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pegawai <span class="text-danger">*</span></label>
                        <select class="form-select required" id="pegawai_bimwin" name="pegawai_bimwin">
                            <option value="" selected disabled>Pilih</option>
                            <option value="13">PNS</option>
                            <option value="14">CPNS</option>
                            <option value="15">PPPK</option>
                            <option value="16">PPNPN</option>
                            <option value="17">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" id="jbtn_bimwin" name="jbtn_bimwin" class="form-control required" placeholder="Masukkan Jabatan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Golongan <span class="text-danger">*</span></label>
                        <select class="form-select" name="gol_bimwin" id="gol_bimwin">
                            <option value="" selected disabled>Pilih</option>
                            <option value="101">I/a</option>
                            <option value="102">I/b</option>
                            <option value="103">I/c</option>
                            <option value="104">I/d</option>
                            <option value="105">II/a</option>
                            <option value="106">II/b</option>
                            <option value="107">II/c</option>
                            <option value="108">II/d</option>
                            <option value="109">III/a</option>
                            <option value="110">III/b</option>
                            <option value="111">III/c</option>
                            <option value="112">III/d</option>
                            <option value="113">IV/a</option>
                            <option value="114">IV/b</option>
                            <option value="115">IV/c</option>
                            <option value="116">IV/d</option>
                            <option value="117">IX</option>
                            <option value="118">X</option>
                            <option value="119">XI</option>
                            <option value="120">-</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instansi <span class="text-danger">*</span></label>
                        <input type="text" id="inst_bimwin" name="inst_bimwin" class="form-control required" placeholder="Masukkan Instansi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Kantor <span class="text-danger">*</span></label>
                        <textarea id="kantor_bimwin" name="kantor_bimwin" class="form-control required" placeholder="Masukkan Alamat Kantor"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo <span class="text-danger"></span></label>
                        <input type="file" id="files_bimwin" name="files_bimwin" class="form-control" placeholder="Masukkan File Photo" accept="image/png, image/gif, image/jpeg">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Surat Tugas <span class="text-danger"></span></label>
                        <input type="file" id="files_surtug" name="files_surtug" class="form-control" placeholder="Masukkan File Photo" accept=".pdf, .doc, .docx">
                    </div>
                    <div class="form-text" id="basic-addon4" style="margin-top: -12px;">Hanya format (.jpg, .jpeg, .png).</div><br>

                    <button class="btn btn-secondary prev-btn">Sebelumnya</button>
                    <button class="btn btn-success float-end" type="submit">Kirim</button>
                </div>
            </form>
        @elseif($data->is_trash == 12)
            <div class="alert alert-info text-center">
                <b>Mohon maaf, formulir sudah ditutup oleh admin.</b>
            </div>
        @else
            <div class="alert alert-danger text-center">
                <b>Mohon maaf, status tidak dikenali.</b>
            </div>
        @endif
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- Swal 2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.onload = function() {
        $('#LoaderIng').hide();
    };

    const steps = document.querySelectorAll(".wizard-step");
    const tabs = document.querySelectorAll(".nav-link");
    const nextBtns = document.querySelectorAll(".next-btn");
    const prevBtns = document.querySelectorAll(".prev-btn");

    let currentStep = 0;

    function showStep(index) {
        steps.forEach((step, i) => step.classList.toggle("active", i === index));
        tabs.forEach((tab, i) => tab.classList.toggle("active", i === index));
        currentStep = index;
    }

    // Validasi sebelum pindah step
    function validateStep(stepIndex) {
        const inputs = steps[stepIndex].querySelectorAll(".required");
        let valid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add("is-invalid");
                valid = false;
            } else {
                input.classList.remove("is-invalid");
            }
        });

        return valid;
    }

    nextBtns.forEach(btn => btn.addEventListener("click", () => {
        if (validateStep(currentStep)) {
            if (currentStep < steps.length - 1) showStep(currentStep + 1);
        }
    }));

    prevBtns.forEach(btn => btn.addEventListener("click", () => {
        if (currentStep > 0) showStep(currentStep - 1);
    }));

    tabs.forEach((tab, i) => {
        tab.addEventListener("click", () => {
            if (i <= currentStep || validateStep(currentStep)) {
                showStep(i);
            }
        });
    });

    // validasi saat submit form
    document.querySelector("form").addEventListener("submit", function(e) {
        let valid = true;

        // cek semua input required
        this.querySelectorAll(".required").forEach(input => {
            if (!input.value.trim()) {
                input.classList.add("is-invalid");
                valid = false;
            } else {
                input.classList.remove("is-invalid");
            }
        });

        if (!valid) {
            e.preventDefault();
            toastr.error('Maaf, pastikan inputan tidak ada yang kosong.');
        }
    });

    // Tanggal Lahir Input
    $(function() {
        $(".lahirinput").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });

    // Ambil Provinsi
    $.ajax({
        url: "{{ url('82d60bff-2819-49bb-af87-07cbd7b159e9') }}",
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
        }
    });

    // Ambil Kabupaten
    function Kabupaten(val)
    {
        if(val == '' || val == null || val == 0){
            toastr.error('Maaf, kesalahan saat pengambilan data kabupaten.');
        }else{
            $('#kab_bimwin').children('option').remove();
            $('#kec_bimwin').children('option').remove();

            $.ajax({
                url: "{{ url('3062082a-e2a9-438e-8674-5b36445be8ff') }}/" + val,
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
                }
            });
        }
    }

    // Ambil Kecamatan
    function Kecamatan(val)
    {
        if(val == '' || val == null || val == 0){
            toastr.error('Maaf, kesalahan saat pengambilan data kecamatan.');
        }else{
            $('#kec_bimwin').children('option').remove();

            $.ajax({
                url: "{{ url('7db0cc3a-ef13-48b8-9978-71ecb3fc6d5f') }}/" + val,
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
                }
            });
        }
    }

    // Submit Data
    document.querySelector("#formulir_peserta").addEventListener("submit", function(e) {
        e.preventDefault();

        let form = this;
        let valid = true;

        // Validasi input required
        form.querySelectorAll(".required").forEach(input => {
            if (!input.value.trim()) {
                input.classList.add("is-invalid");
                valid = false;
            } else {
                input.classList.remove("is-invalid");
            }
        });

        if (!valid) {
            toastr.error('Maaf, pastikan inputan tidak ada yang kosong.');
            return false;
        }

        // Siapkan data form
        let formData = new FormData(form);
        let loadingText = document.getElementById("loadingText");

        $.ajax({
            url: "{{ url('433fc0ba-23b4-45a4-85da-0043b28abc59') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // Disable tombol dan ubah teks
                $(".btn[type=submit]").prop("disabled", true).text("Mengirim...");

                // Tampilkan teks loading dan blur form
                loadingText.style.display = "block";
                form.classList.add("blurred");
            },
            success: function(res) {
                // Hapus efek loading
                loadingText.style.display = "none";
                form.classList.remove("blurred");

                if (res.message == 200) {
                    Swal.fire({
                        title: "Berhasil!",
                        html: `
                            Simpan untuk unduh/download secara mandiri di website.<br><br>
                            <strong>ID Sertifikat:</strong><br>
                            <span style="font-size:18px; color:#2b7cff;">
                                ${res.no_sertifikat}
                            </span>
                        `,
                        icon: "success",

                        // Tidak bisa ditutup sembarang
                        backdrop: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: true,

                        confirmButtonText: "OK",
                        confirmButtonColor: "#3085d6",
                    }).then(() => {
                        form.reset();
                        if (typeof showStep === "function") {
                            showStep(0);
                        }

                        // reload jika memang dibutuhkan
                        setTimeout(() => location.reload(), 500);
                    });
                } 
                else if (res.message == "202" || res.message == 202) {
                    toastr.error('Maaf, ukuran maksimal file photo tidak lebih dari 3 MB.');
                } 
                else if (res.message == "203" || res.message == 203) {
                    toastr.error('Maaf, jenis file photo hanya .jpeg, .jpg, dan .png.');
                } 
                else if (res.message == "400" || res.message == 400) {
                    toastr.error('Maaf, hanya file pdf dan word yang diijinkan.');
                }
                else if (res.message == "404" || res.message == 404) {
                    toastr.error('Maaf, data kamu sudah tersedia di kegiatan ini.');
                } 
                else {
                    toastr.warning('Respon tidak dikenali.');
                }
            },
            error: function(xhr) {
                toastr.error("Terjadi kesalahan, coba lagi.");
            },
            complete: function() {
                // Aktifkan tombol kembali
                $(".btn[type=submit]").prop("disabled", false).text("Kirim");

                // Pastikan efek blur & teks loading hilang
                loadingText.style.display = "none";
                form.classList.remove("blurred");
            }
        });
    });

    $(function(){
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
</body>
</html>
