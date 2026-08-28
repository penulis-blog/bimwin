<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <main class="nxl-container">
                        <div class="nxl-content">
                            <div class="page-header">

                                <div class="page-header-right ms-auto">
                                    <div class="page-header-right-items">
                                        <div class="d-flex d-md-none">
                                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                                <i class="feather-arrow-left me-2"></i>
                                                <span>Back</span>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                                        </div>
                                    </div>
                                    <div class="d-md-none d-flex align-items-center">
                                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                                            <i class="feather-align-right fs-20"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="main-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card stretch stretch-full">
                                            <div class="card-body p-2">
                                                <div class="table-responsive">
                                                    <table id="jejaringTable"
                                                        class="table-striped table-hover display nowrap"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kegiatan</th>
                                                                <th>Angkatan</th>
                                                                <th>Provinsi</th>
                                                                {{-- <th>Kabupaten</th>
                                                                <th>Kecamatan</th> --}}
                                                                <th>Nama Lengkap</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    @include('backend.contents.fasilitator.modal_jejaring')
</main>
