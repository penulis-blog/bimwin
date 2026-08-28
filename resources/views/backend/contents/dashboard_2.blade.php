<div class="modal fade" 
     id="modalDummyData"
     tabindex="-1"
     aria-labelledby="modalDummyDataLabel"
     aria-hidden="true"
     data-bs-backdrop="static"
     data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-body text-center p-4">
                <!-- ICON -->
                <div class="mb-3">
                    <div class="dummy-icon mx-auto">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                </div>

                <!-- JUDUL -->
                <h4 class="fw-bold mb-2">
                    Informasi
                </h4>

                <!-- KETERANGAN -->
                <p class="text-secondary mb-4">
                    Data yang ditampilkan pada Dashboard V2,
                    masih berupa <strong>data dummy</strong> sampai dengan proses
                    masa pengembangan dashboard selesai menggunakan data aktual.
                </p>

                <!-- BUTTON -->
                <button type="button" 
                        class="btn btn-info px-4 rounded-3 text-white"
                        data-bs-dismiss="modal">

                    <i class="bi bi-check-circle me-1"></i>
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="card shadow-sm elevation-2 mb-3">
                                            <div class="card-body p-0">
                                                <div id="mapIndonesia"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="card elevation-2 bg-white">
                                            <div class="card-header bg-white" style="border-radius: 16px 16px 0px 0px;">
                                                <span class="info-box-text">
                                                    <center>7 Provinsi Teratas Fasilitator Semua Tahun</center>
                                                </span>
                                            </div>

                                            <div class="card-body p-3">
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Jawa Barat</strong>
                                                        <span>420</span>
                                                    </div>

                                                    <div class="progress mt-1">
                                                        <div class="progress-bar bg-primary" style="width:100%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Jawa Tengah</strong>
                                                        <span>403</span>
                                                    </div>

                                                    <div class="progress mt-1">
                                                        <div class="progress-bar bg-warning" style="width:97%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Jawa Timur</strong>
                                                        <span>395</span>
                                                    </div>

                                                    <div class="progress mt-1">
                                                        <div class="progress-bar bg-success" style="width:94%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>DKI Jakarta</strong>
                                                        <span>310</span>
                                                    </div>

                                                    <div class="progress mt-1">
                                                        <div class="progress-bar bg-danger" style="width:74%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Sumatera Utara</strong>
                                                        <span>265</span>
                                                    </div>

                                                    <div class="progress mt-1">
                                                        <div class="progress-bar bg-info" style="width:63%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Sulawesi Selatan</strong>
                                                        <span>210</span>
                                                    </div>

                                                    <div class="progress mt-1">
                                                        <div class="progress-bar bg-secondary" style="width:50%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Aceh</strong>
                                                        <span>180</span>
                                                    </div>

                                                    <div class="progress mt-1">
                                                        <div class="progress-bar bg-dark" style="width:43%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start dashboard-wrapper">
                                    <!-- =====================================================
                                        AREA KIRI
                                    ====================================================== -->
                                    <div class="dashboard-left">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="card shadow-sm border-0 rounded-4 elevation-2">
                                                    <div class="card-header bg-white"
                                                        style="border-radius:16px 16px 0 0;">
                                                        <span class="info-box-text" style="font-size:16px; font-weight:normal;">
                                                            Fasilitator dari Tahun ke Tahun
                                                        </span>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row" style="margin-top:-10px;">
                                                            <div class="col text-center">
                                                                <small class="text-muted">
                                                                    &lt; 2025
                                                                </small>

                                                                <div class="fw-bold text-secondary">
                                                                    3.100
                                                                </div>
                                                            </div>

                                                            <div class="col text-center">
                                                                <small class="fw-bold">
                                                                    2026
                                                                </small>

                                                                <div class="fw-bold text-success">
                                                                    800
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- CHART -->
                                                        <div id="expenseChart"
                                                            style="height:190px; margin-top:-10px;">
                                                        </div>

                                                        <!-- LIST TAHUN -->
                                                        <div style="margin-top:-14px;">
                                                            <div class="list-item bg1">
                                                                <span>60%</span>
                                                                <label>
                                                                    Tahun 2025
                                                                </label>

                                                                <strong>
                                                                    900
                                                                </strong>
                                                            </div>


                                                            <div class="list-item bg2">
                                                                <span>15%</span>
                                                                <label>
                                                                    Tahun 2024
                                                                </label>

                                                                <strong>
                                                                    750
                                                                </strong>
                                                            </div>


                                                            <div class="list-item bg3">
                                                                <span>12%</span>
                                                                <label>
                                                                    Tahun 2023
                                                                </label>

                                                                <strong>
                                                                    600
                                                                </strong>
                                                            </div>


                                                            <div class="list-item bg5">
                                                                <span>5%</span>
                                                                <label>
                                                                    Tahun 2021
                                                                </label>

                                                                <strong>
                                                                    530
                                                                </strong>
                                                            </div>


                                                            <!-- TAHUN SEBELUMNYA -->
                                                            <div class="tahun-sebelumnya">
                                                                <i class="fas fa-angle-double-down"></i>
                                                                <span>
                                                                    s.d.
                                                                </span>
                                                            </div>


                                                            <div class="list-item bg5">
                                                                <span>3%</span>
                                                                <label>
                                                                    Tahun 2018
                                                                </label>

                                                                <strong>
                                                                    490
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-8">
                                                <!-- =========================================
                                                    STATUS FASILITATOR
                                                ========================================== -->
                                                <div class="status-wrapper">
                                                    <div class="row g-3">
                                                        <!-- BIMWIN -->
                                                        <div class="col-lg col-md-4 col-6">
                                                            <div class="status-card elevation-2"
                                                                style="background-color:#1F5B54; color:white;">

                                                                <span style="color: white;">
                                                                    BIMWIN
                                                                </span>

                                                                <h3 title="Bimbingan Perkawinan">
                                                                    18
                                                                </h3>

                                                                <small style="font-size:10px;">
                                                                    Semua Tahun
                                                                </small>
                                                            </div>
                                                        </div>


                                                        <!-- BRUS -->
                                                        <div class="col-lg col-md-4 col-6">
                                                            <div class="status-card elevation-2"
                                                                style="background-color:#98E85D; color:white;">

                                                                <span style="color: white;">
                                                                    BRUS
                                                                </span>

                                                                <h3 title="Bimbingan Remaja Usia Sekolah">
                                                                    15
                                                                </h3>

                                                                <small style="font-size:10px;">
                                                                    Semua Tahun
                                                                </small>
                                                            </div>
                                                        </div>

                                                        <!-- BRUN -->
                                                        <div class="col-lg col-md-4 col-6">
                                                            <div class="status-card elevation-2"
                                                                style="background-color:#17A2B8; color:white;">
                                                                <span style="color: white;">
                                                                    BRUN
                                                                </span>
                                                                <h3 title="Bimbingan Remaja Usia Nikah">
                                                                    23
                                                                </h3>
                                                                <small style="font-size:10px;">
                                                                    Semua Tahun
                                                                </small>
                                                            </div>
                                                        </div>


                                                        <!-- JARLOK -->
                                                        <div class="col-lg col-md-4 col-6">
                                                            <div class="status-card elevation-2"
                                                                style="background-color:#343A40; color:white;">

                                                                <span style="color: white;">
                                                                    JEJARING
                                                                </span>
                                                                <h3 title="Jejaring Lokal">
                                                                    10
                                                                </h3>
                                                                <small style="font-size:10px;">
                                                                    Semua Tahun
                                                                </small>
                                                            </div>
                                                        </div>


                                                        <!-- RELASI HARMONIS -->
                                                        <div class="col-lg col-md-4 col-6">
                                                            <div class="status-card elevation-2"
                                                                style="background-color:#FF9AAD; color:white;">

                                                                <span style="color: white;">
                                                                    HARMONIS
                                                                </span>
                                                                <h3 title="Relasi Harmonis">
                                                                    6
                                                                </h3>
                                                                <small style="font-size:10px;">
                                                                    Semua Tahun
                                                                </small>
                                                            </div>
                                                        </div>


                                                        <!-- LITERASI KEUANGAN -->
                                                        <div class="col-lg col-md-4 col-6">
                                                            <div class="status-card elevation-2"
                                                                style="background-color:#6CDBC2; color:white;">

                                                                <span style="color: white;">
                                                                    KEUANGAN
                                                                </span>
                                                                <h3 title="Literasi Keuangan">
                                                                    6
                                                                </h3>
                                                                <small style="font-size:10px;">
                                                                    Semua Tahun
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- =========================================
                                                    GRAFIK PEGAWAI
                                                ========================================== -->
                                                <div class="card shadow-sm border-0 rounded-4 elevation-2 grafik-card">
                                                    <div class="card-body">
                                                        <div id="pegawaiChart" style="height:343px;">
                                                        </div>

                                                        <div class="text-center grafik-badge">
                                                            <span class="badge bg-info text-dark">
                                                                <small style="font-size:12px;">
                                                                    Semua Tahun
                                                                </small>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- =================================================
                                            DATATABLE
                                            LANGSUNG DI BAWAH AREA KIRI
                                        ================================================== -->
                                        <div class="card employee-card elevation-2">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table employee-table mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th width="45">
                                                                    <input type="checkbox">
                                                                </th>
                                                                <th>
                                                                    Nama Lengkap
                                                                    <i class="fas fa-sort table-sort"></i>
                                                                </th>
                                                                <th>
                                                                    NIP
                                                                    <i class="fas fa-sort table-sort"></i>
                                                                </th>
                                                                <th>
                                                                    Tanggal Lahir
                                                                    <i class="fas fa-sort table-sort"></i>
                                                                </th>
                                                                <th>
                                                                    Instansi
                                                                    <i class="fas fa-sort table-sort"></i>
                                                                </th>
                                                                <th>
                                                                    Paripurna
                                                                    <i class="fas fa-sort table-sort"></i>
                                                                </th>
                                                                <th>
                                                                    Status
                                                                    <i class="fas fa-sort table-sort"></i>
                                                                </th>
                                                                <th width="60"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox">
                                                                </td>
                                                                <td>
                                                                    <div class="employee-profile">
                                                                        <img src="https://i.pravatar.cc/100?img=12"
                                                                            class="employee-avatar"
                                                                            alt="Avatar">
                                                                        <div class="employee-info">

                                                                            <strong>
                                                                                Son Goku
                                                                            </strong>

                                                                            <small>
                                                                                randyrhima@email.com
                                                                            </small>

                                                                        </div>

                                                                    </div>

                                                                </td>


                                                                <td>

                                                                    <a href="#"
                                                                    class="employee-id">

                                                                        A01DSGN193

                                                                    </a>

                                                                </td>


                                                                <td>
                                                                    11 Juli 1987
                                                                </td>


                                                                <td>
                                                                    KUA Cibinong
                                                                </td>


                                                                <td>
                                                                    11 Agustus 2029
                                                                </td>


                                                                <td>

                                                                    <span class="status-badge status-onboarding">
                                                                        &lt; 3 Tahun
                                                                    </span>

                                                                </td>


                                                                <td class="text-center">

                                                                    <button type="button"
                                                                            class="btn btn-action">

                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                            <!-- =============================
                                                                DATA 2
                                                            ============================== -->
                                                            <tr>

                                                                <td>
                                                                    <input type="checkbox">
                                                                </td>


                                                                <td>

                                                                    <div class="employee-profile">

                                                                        <img src="https://i.pravatar.cc/100?img=47"
                                                                            class="employee-avatar"
                                                                            alt="Avatar">


                                                                        <div class="employee-info">

                                                                            <strong>
                                                                                Ultraman Tiga
                                                                            </strong>

                                                                            <small>
                                                                                rossarmar@email.com
                                                                            </small>

                                                                        </div>

                                                                    </div>

                                                                </td>


                                                                <td>

                                                                    <a href="#"
                                                                    class="employee-id">

                                                                        A02DSGN196

                                                                    </a>

                                                                </td>


                                                                <td>
                                                                    23 Januari 1982
                                                                </td>


                                                                <td>
                                                                    KUA Cakung
                                                                </td>


                                                                <td>
                                                                    25 Juni 2032
                                                                </td>


                                                                <td>

                                                                    <span class="status-badge status-active">
                                                                        &gt; 5 Tahun
                                                                    </span>

                                                                </td>


                                                                <td class="text-center">

                                                                    <button type="button"
                                                                            class="btn btn-action">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                            <!-- =============================
                                                                DATA 3
                                                            ============================== -->
                                                            <tr>

                                                                <td>
                                                                    <input type="checkbox">
                                                                </td>


                                                                <td>

                                                                    <div class="employee-profile">

                                                                        <img src="https://i.pravatar.cc/100?img=11"
                                                                            class="employee-avatar"
                                                                            alt="Avatar">


                                                                        <div class="employee-info">

                                                                            <strong>
                                                                                Spiderman
                                                                            </strong>

                                                                            <small>
                                                                                bothmancy@email.com
                                                                            </small>

                                                                        </div>

                                                                    </div>

                                                                </td>


                                                                <td>

                                                                    <a href="#"
                                                                    class="employee-id">

                                                                        A05DEVP381

                                                                    </a>

                                                                </td>


                                                                <td>
                                                                    17 Oktober 1978
                                                                </td>


                                                                <td>
                                                                    KUA Ciracas
                                                                </td>


                                                                <td>
                                                                    20 February 2025
                                                                </td>


                                                                <td>

                                                                    <span class="status-badge status-inactive">
                                                                        Paripurna Tugas
                                                                    </span>

                                                                </td>


                                                                <td class="text-center">

                                                                    <button type="button"
                                                                            class="btn btn-action">

                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                            <!-- =============================
                                                                DATA 4
                                                            ============================== -->
                                                            <tr>

                                                                <td>
                                                                    <input type="checkbox">
                                                                </td>


                                                                <td>

                                                                    <div class="employee-profile">

                                                                        <img src="https://i.pravatar.cc/100?img=32"
                                                                            class="employee-avatar"
                                                                            alt="Avatar">


                                                                        <div class="employee-info">

                                                                            <strong>
                                                                                Naruto
                                                                            </strong>

                                                                            <small>
                                                                                datarhima@email.com
                                                                            </small>

                                                                        </div>

                                                                    </div>

                                                                </td>


                                                                <td>

                                                                    <a href="#"
                                                                    class="employee-id">

                                                                        A01ASIN193

                                                                    </a>

                                                                </td>


                                                                <td>
                                                                    11 Juli 1985
                                                                </td>


                                                                <td>
                                                                    KUA Grogol
                                                                </td>


                                                                <td>
                                                                    11 Agustus 2030
                                                                </td>


                                                                <td>

                                                                    <span class="status-badge status-onboarding">
                                                                        &lt; 3 Tahun
                                                                    </span>

                                                                </td>


                                                                <td class="text-center">

                                                                    <button type="button"
                                                                            class="btn btn-action">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                            <!-- =============================
                                                                DATA 5
                                                            ============================== -->
                                                            <tr>

                                                                <td>
                                                                    <input type="checkbox">
                                                                </td>


                                                                <td>

                                                                    <div class="employee-profile">

                                                                        <img src="https://i.pravatar.cc/100?img=13"
                                                                            class="employee-avatar"
                                                                            alt="Avatar">


                                                                        <div class="employee-info">

                                                                            <strong>
                                                                                Ranger Merah
                                                                            </strong>

                                                                            <small>
                                                                                merahandyri@email.com
                                                                            </small>

                                                                        </div>

                                                                    </div>

                                                                </td>


                                                                <td>

                                                                    <a href="#"
                                                                    class="employee-id">

                                                                        A04VSPN103

                                                                    </a>

                                                                </td>


                                                                <td>
                                                                    11 Juli 1984
                                                                </td>


                                                                <td>
                                                                    KUA Sukasari
                                                                </td>


                                                                <td>
                                                                    11 Desember 2029
                                                                </td>


                                                                <td>

                                                                    <span class="status-badge status-onboarding">
                                                                        &lt; 3 Tahun
                                                                    </span>

                                                                </td>


                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-action">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- =========================================
                                                    FOOTER TABLE
                                                ========================================== -->
                                                <div class="employee-table-footer">
                                                    <div>
                                                        <select class="form-control form-control-sm record-select">
                                                            <option>10 entries</option>
                                                            <option>25 entries</option>
                                                            <option>50 entries</option>
                                                        </select>
                                                    </div>

                                                    <nav>
                                                        <ul class="pagination pagination-sm mb-0">
                                                            <li class="page-item disabled">
                                                                <a class="page-link" href="#">
                                                                    <i class="fas fa-chevron-left"></i>
                                                                </a>
                                                            </li>

                                                            <li class="page-item active">
                                                                <a class="page-link" href="#">1</a>
                                                            </li>


                                                            <li class="page-item">
                                                                <a class="page-link" href="#">2</a>
                                                            </li>


                                                            <li class="page-item">
                                                                <a class="page-link" href="#">3</a>
                                                            </li>


                                                            <li class="page-item disabled">
                                                                <a class="page-link" href="#">...</a>
                                                            </li>


                                                            <li class="page-item">
                                                                <a class="page-link" href="#">20</a>
                                                            </li>


                                                            <li class="page-item">

                                                                <a class="page-link" href="#">
                                                                    <i class="fas fa-chevron-right"></i>
                                                                </a>

                                                            </li>


                                                        </ul>

                                                    </nav>

                                                    <div class="table-total">
                                                        10 - 194
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- DATATABLE -->

                                        <!-- =================================================
                                            JUMLAH KEGIATAN SEMUA TAHUN
                                            LANGSUNG DI BAWAH AREA KIRI
                                        ================================================== -->
                                        <div class="card employee-card elevation-2">
                                            <div class="card-body p-0">
                                                <div class="card-header bg-white"
                                                        style="border-radius:16px 16px 0 0;">

                                                        <span class="info-box-text" style="font-size:16px; font-weight:normal;">
                                                            Kegiatan Fasilitator dari Tahun ke Tahun
                                                        </span>

                                                    </div>
                                                <div class="project-scroll-wrapper">
                                                    <div class="project-scroll">
                                                        <!-- =========================================
                                                            CARD 1 - BIMWIN
                                                        ========================================== -->
                                                        <div class="project-card project-blue" style="background-color: #1F5B54;">

                                                            <div class="project-top">
                                                                <h5>
                                                                    Tahun 2026
                                                                </h5>

                                                                <button type="button" class="project-menu">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                            </div>

                                                            <div class="project-progress-info">
                                                                <span>Jumlah</span>
                                                                <strong>50</strong>
                                                            </div>

                                                            <div class="project-progress">
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span></span>
                                                            </div>

                                                            <div class="project-footer">

                                                                <div class="project-users">
                                                                    <i class="fas fa-graduation-cap"></i>
                                                                    &nbsp;
                                                                    <small>Dr. H. Ahmad Zayadi, M.Pd</small>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <!-- END CARD 1 -->


                                                        <!-- =========================================
                                                            CARD 2 - BRUS
                                                        ========================================== -->
                                                        <div class="project-card project-dark">

                                                            <div class="project-top">
                                                                <h5>
                                                                    Fasilitator<br>
                                                                    BRUS
                                                                </h5>

                                                                <button type="button" class="project-menu">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                            </div>

                                                            <div class="project-progress-info">
                                                                <span>Progress</span>
                                                                <strong>70%</strong>
                                                            </div>

                                                            <div class="project-progress">
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span></span>
                                                                <span></span>
                                                            </div>

                                                            <div class="project-footer">

                                                                <div class="project-users">

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-more">
                                                                        +5
                                                                    </div>

                                                                </div>

                                                                <div class="project-date">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                    2026
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <!-- END CARD 2 -->


                                                        <!-- =========================================
                                                            CARD 3 - BRUN
                                                        ========================================== -->
                                                        <div class="project-card project-orange">

                                                            <div class="project-top">
                                                                <h5>
                                                                    Fasilitator<br>
                                                                    BRUN
                                                                </h5>

                                                                <button type="button" class="project-menu">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                            </div>

                                                            <div class="project-progress-info">
                                                                <span>Progress</span>
                                                                <strong>65%</strong>
                                                            </div>

                                                            <div class="project-progress">
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span></span>
                                                                <span></span>
                                                            </div>

                                                            <div class="project-footer">

                                                                <div class="project-users">

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-more">
                                                                        +6
                                                                    </div>

                                                                </div>

                                                                <div class="project-date">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                    2026
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <!-- END CARD 3 -->


                                                        <!-- =========================================
                                                            CARD 4 - JEJARING LOKAL
                                                        ========================================== -->
                                                        <div class="project-card project-green" style="background-color: #FF9AAD;">

                                                            <div class="project-top">
                                                                <h5>
                                                                    Jejaring<br>
                                                                    Lokal
                                                                </h5>

                                                                <button type="button" class="project-menu">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                            </div>

                                                            <div class="project-progress-info">
                                                                <span>Progress</span>
                                                                <strong>55%</strong>
                                                            </div>

                                                            <div class="project-progress">
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span></span>
                                                                <span></span>
                                                            </div>

                                                            <div class="project-footer">

                                                                <div class="project-users">

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-more">
                                                                        +4
                                                                    </div>

                                                                </div>

                                                                <div class="project-date">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                    2026
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <!-- END CARD 4 -->


                                                        <!-- =========================================
                                                            CARD 5 - RELASI HARMONIS
                                                        ========================================== -->
                                                        <div class="project-card project-purple">

                                                            <div class="project-top">
                                                                <h5>
                                                                    Relasi<br>
                                                                    Harmonis
                                                                </h5>

                                                                <button type="button" class="project-menu">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                            </div>

                                                            <div class="project-progress-info">
                                                                <span>Progress</span>
                                                                <strong>45%</strong>
                                                            </div>

                                                            <div class="project-progress">
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                            </div>

                                                            <div class="project-footer">

                                                                <div class="project-users">

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-more">
                                                                        +3
                                                                    </div>

                                                                </div>

                                                                <div class="project-date">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                    2026
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <!-- END CARD 5 -->


                                                        <!-- =========================================
                                                            CARD 6 - LITERASI KEUANGAN
                                                        ========================================== -->
                                                        <div class="project-card project-teal">

                                                            <div class="project-top">
                                                                <h5>
                                                                    Literasi<br>
                                                                    Keuangan
                                                                </h5>

                                                                <button type="button" class="project-menu">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </button>
                                                            </div>

                                                            <div class="project-progress-info">
                                                                <span>Progress</span>
                                                                <strong>40%</strong>
                                                            </div>

                                                            <div class="project-progress">
                                                                <span class="active"></span>
                                                                <span class="active"></span>
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                            </div>

                                                            <div class="project-footer">

                                                                <div class="project-users">

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-circle">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>

                                                                    <div class="user-more">
                                                                        +3
                                                                    </div>

                                                                </div>

                                                                <div class="project-date">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                    2026
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <!-- END CARD 6 -->

                                                    </div>
                                                    <!-- END project-scroll -->

                                                </div>
                                                <!-- END project-scroll-wrapper -->

                                            </div>
                                        </div><!-- KEGIATAN -->
                                    </div>
                                    <!-- END DASHBOARD LEFT -->

                                    <!-- =====================================================
                                        AREA KANAN
                                    ====================================================== -->
                                    <div class="dashboard-right">
                                        <!-- =================================================
                                            GOLONGAN FASILITATOR
                                        ================================================== -->
                                        <div class="card elevation-2 layout-kanan-atas">
                                            <div class="card-body">


                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <div>
                                                        <span class="info-box-text" style="font-size:16px; font-weight:normal;">
                                                            Kategori Golongan
                                                        </span>

                                                        <div class="education-total">
                                                            7
                                                            <span class="education-badge" style="font-size:12px;">
                                                                Semua Tahun
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>



                                                <!-- III/a -->
                                                <div class="mb-3">

                                                    <div class="d-flex justify-content-between mb-1">

                                                        <small class="fw-semibold">
                                                            III/a
                                                        </small>

                                                        <small class="text-muted">
                                                            82%
                                                        </small>

                                                    </div>

                                                    <div class="progress progress-sm">

                                                        <div class="progress-bar bg-primary"
                                                            style="width:82%">
                                                        </div>

                                                    </div>

                                                </div>



                                                <!-- III/b -->
                                                <div class="mb-3">

                                                    <div class="d-flex justify-content-between mb-1">

                                                        <small class="fw-semibold">
                                                            III/b
                                                        </small>

                                                        <small class="text-muted">
                                                            68%
                                                        </small>

                                                    </div>

                                                    <div class="progress progress-sm">

                                                        <div class="progress-bar bg-success"
                                                            style="width:68%">
                                                        </div>

                                                    </div>

                                                </div>



                                                <!-- III/d -->
                                                <div class="mb-3">

                                                    <div class="d-flex justify-content-between mb-1">

                                                        <small class="fw-semibold">
                                                            III/d
                                                        </small>

                                                        <small class="text-muted">
                                                            56%
                                                        </small>

                                                    </div>

                                                    <div class="progress progress-sm">

                                                        <div class="progress-bar bg-warning"
                                                            style="width:56%">
                                                        </div>

                                                    </div>

                                                </div>



                                                <!-- IV/a -->
                                                <div class="mb-3">

                                                    <div class="d-flex justify-content-between mb-1">

                                                        <small class="fw-semibold">
                                                            IV/a
                                                        </small>

                                                        <small class="text-muted">
                                                            43%
                                                        </small>

                                                    </div>

                                                    <div class="progress progress-sm">

                                                        <div class="progress-bar bg-danger"
                                                            style="width:43%">
                                                        </div>

                                                    </div>

                                                </div>



                                                <!-- IX -->
                                                <div>

                                                    <div class="d-flex justify-content-between mb-1">

                                                        <small class="fw-semibold">
                                                            IX
                                                        </small>

                                                        <small class="text-muted">
                                                            25%
                                                        </small>

                                                    </div>

                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-info"
                                                            style="width:25%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- =================================================
                                            PENDIDIKAN TERAKHIR
                                        ================================================== -->
                                        <div class="card elevation-2 layout-kanan-bawah">
                                            <div class="card-body">


                                                <!-- HEADER -->
                                                <div class="education-header" style="margin-top: -18px; margin-left:-18px; border:0px solid #000;">
                                                    <div>
                                                        <span class="info-box-text" style="font-size:16px; font-weight:normal;">
                                                            Kategori Pendidikan
                                                        </span>

                                                        <div class="education-total">
                                                            2.300
                                                            <span class="education-badge" style="font-size:12px;">
                                                                Semua Tahun
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>



                                                <!-- DONUT -->
                                                <div class="education-chart-wrapper">
                                                    <div id="educationChart"></div>

                                                    <div class="education-center">
                                                        <i class="fas fa-graduation-cap"></i>
                                                        <strong>
                                                            Pendidikan
                                                        </strong>

                                                        <span>
                                                            Terakhir
                                                        </span>
                                                    </div>
                                                </div>



                                                <!-- LIST -->
                                                <div class="education-list">
                                                    <div class="education-item">
                                                        <span class="education-dot edu-1"></span>
                                                        <span>S3</span>
                                                        <strong>45</strong>
                                                    </div>


                                                    <div class="education-item">
                                                        <span class="education-dot edu-2"></span>
                                                        <span>S2</span>
                                                        <strong>180</strong>
                                                    </div>


                                                    <div class="education-item">
                                                        <span class="education-dot edu-3"></span>
                                                        <span>S1</span>
                                                        <strong>620</strong>
                                                    </div>


                                                    <div class="education-item">
                                                        <span class="education-dot edu-4"></span>
                                                        <span>D4</span>
                                                        <strong>240</strong>
                                                    </div>


                                                    <div class="education-item">
                                                        <span class="education-dot edu-5"></span>
                                                        <span>D3</span>
                                                        <strong>310</strong>
                                                    </div>


                                                    <div class="education-item">
                                                        <span class="education-dot edu-6"></span>
                                                        <span>SMA/MA</span>
                                                        <strong>420</strong>
                                                    </div>


                                                    <div class="education-item">
                                                        <span class="education-dot edu-7"></span>
                                                        <span>SMK/MAK</span>
                                                        <strong>350</strong>
                                                    </div>


                                                    <div class="education-item">
                                                        <span class="education-dot edu-8"></span>
                                                        <span>SMP/MTs</span>
                                                        <strong>135</strong>
                                                    </div>
                                                </div>

                                                <!-- FOOTER -->
                                                {{-- <div class="education-footer">

                                                    <span style="font-size:10px;">

                                                        <i class="far fa-calendar-alt"></i>

                                                        Semua Tahun

                                                    </span>


                                                    <a href="#">
                                                        Lihat Detail
                                                    </a>

                                                </div> --}}
                                            </div>
                                        </div>

                                        <!-- =================================================
                                            FASILITATOR MULTI BIMBINGAN
                                        ================================================== -->
                                        <div class="card elevation-2 layout-kanan-bawah">
                                            <div class="card fasilitator-multi-card">
                                                <div class="education-header" style="border:0px solid #000;">
                                                    <div>
                                                        <span class="info-box-text" style="font-size:16px; font-weight:normal;">
                                                            Fasilitator Multi Bimbingan
                                                        </span>

                                                        <div class="education-total">
                                                            30
                                                            <span class="education-badge" style="font-size:12px;">
                                                                Semua Tahun
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- BODY -->
                                                <div class="card-body multi-list">
                                                    <!-- ITEM 1 -->
                                                    <div class="multi-item">
                                                        <div class="multi-score">
                                                            <i class="fas fa-chart-bar"></i>
                                                            9
                                                        </div>

                                                        <div class="multi-profile">
                                                            <div class="multi-avatar">
                                                                <img src="https://i.pravatar.cc/100?img=12" alt="Fasilitator">
                                                            </div>

                                                            <div class="multi-info">
                                                                <h6>Ahmad Fauzan</h6>

                                                                <small>
                                                                    199206212023211014
                                                                </small>
                                                            </div>
                                                        </div>

                                                        <div class="multi-stat">
                                                            <div>
                                                                <small>BIMWIN</small>
                                                                <strong>120 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>BRUS</small>
                                                                <strong>85 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>BRUN</small>
                                                                <strong>65 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>JEJARING LOKAL</small>
                                                                <strong>65 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>RELASI HARMONIS</small>
                                                                <strong>65 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>LITERASI KEUANGAN</small>
                                                                <strong>65 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="multi-item">
                                                        <div class="multi-score">
                                                            <i class="fas fa-chart-bar"></i>
                                                            9
                                                        </div>

                                                        <div class="multi-profile">
                                                            <div class="multi-avatar">
                                                                <img src="https://i.pravatar.cc/100?img=12" alt="Fasilitator">
                                                            </div>

                                                            <div class="multi-info">
                                                                <h6>Ahmad Fauzan</h6>

                                                                <small>
                                                                    199206212023211014
                                                                </small>
                                                            </div>
                                                        </div>

                                                        <div class="multi-stat">
                                                            <div>
                                                                <small>BIMWIN</small>
                                                                <strong>120 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>BRUS</small>
                                                                <strong>85 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>BRUN</small>
                                                                <strong>65 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>JEJARING LOKAL</small>
                                                                <strong>65 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>RELASI HARMONIS</small>
                                                                <strong>65 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>

                                                            <div>
                                                                <small>LITERASI KEUANGAN</small>
                                                                <strong>65 <i class="fas fa-arrow-up"></i></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- END DASHBOARD RIGHT -->
                                </div><!-- dashboard-wrapper -->
                            </div><!-- container-fluid -->
                        </div><!-- col-lg-12 -->
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>

<style type="text/css">
.user-photo {
    width: 128px;
    height: 128px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center;
}
</style>