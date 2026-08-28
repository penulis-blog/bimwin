<style type="text/css">
    .table-scroll {
        max-height: 400px;   /* tinggi scroll */
        overflow-y: auto;
        overflow-x: auto;    /* biar tabel lebar bisa geser */
    }

    .table-scroll thead th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 10;           /* lebih tinggi dari td */
        border-bottom: 2px solid #dee2e6;
        box-shadow: 0 2px 2px rgba(0,0,0,0.05);
    }

    /* ukuran kolom */
    .table-materi th,
    .table-materi td {
        padding: 6px;
        font-size: 13px;
        white-space: nowrap;
    }

    .table-materi th:nth-child(1),
    .table-materi td:nth-child(1) {
        width: 40px;
    }

    .table-materi th:nth-child(2),
    .table-materi td:nth-child(2) {
        width: 200px;
        text-align: left !important;
    }
</style>

<div class="modal fade" id="tambahTemplate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_template">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Template</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nm_template" id="nm_template">
                        </div>
                    </div>

                    {{-- <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Yang Bertanda Tangan</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_template" id="id_template"></select>
                        </div>
                    </div> --}}

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Jumlah Files/Design</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="jm_template" id="jm_template" onchange="JumlahFiles(this.value)">
                                <option selected>Pilih</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="dokumen_1">
                        <label class="col-sm-3 col-form-label"><b>Files 1</b></label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="doks1" id="doks1" accept="image/png, image/gif, image/jpeg">
                        </div>
                    </div>

                    <div class="mb-3 row" id="dokumen_2">
                        <label class="col-sm-3 col-form-label"><b>Files 2</b></label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="doks2" id="doks2" accept="image/png, image/gif, image/jpeg">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i>&nbsp;Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="listTemplate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5 mb-0">Materi Sertifikat</h1>
                <button type="button" class="btn btn-success btn-sm id_template" id="btnTambahMateri" onclick="Page.TambahMateri(this.value)">
                    <i class="fa fa-plus"></i>&nbsp;Tambah
                </button>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_template_materi">
                    @csrf
                    <div class="table-scroll">
                        <table class="table table-striped text-center table-materi">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th style="text-align: center !important;">Materi</th>
                                    <th>JPL</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="materiBody"></tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i>&nbsp;Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editTemplate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_template">
                    @csrf
                    <input type="hidden" class="form-control" name="e_publicid" id="e_publicid">

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Template</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="enm_template" id="enm_template">
                        </div>
                    </div>

                    {{-- <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Yang Bertanda Tangan</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="eid_template" id="eid_template"></select>
                        </div>
                    </div> --}}

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Jumlah Files/Design</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="ejm_template" id="ejm_template" onchange="e_JumlahFiles(this.value)">
                                <option value="">Pilih</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edokumen_1">
                        <label class="col-sm-3 col-form-label"><b>Files 1</b></label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" name="old_edoks1" id="old_edoks1">
                                <input type="file" class="form-control" name="edoks1" id="edoks1" accept="image/png, image/gif, image/jpeg">
                                <button class="btn btn-outline-secondary tutupPhoto1" type="button" id="tutupfile1"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button class="btn btn-outline-secondary lihatPhoto1" type="button" id="lihatfile1"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                            </div>
                            <div class="form-text" id="basic-addon4" style="margin-top: -12px;">Hanya format (.jpg, .jpeg, .png).</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="contentphoto1">
                        <label class="col-sm-3 col-form-label"><b></b></label>
                        <div class="col-sm-9 text-center">
                            <img id="gambar_file1" class="rounded img-fluid">
                        </div>
                    </div>

                    <div class="mb-3 row" id="edokumen_2">
                        <label class="col-sm-3 col-form-label"><b>Files 2</b></label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" name="old_edoks2" id="old_edoks2">
                                <input type="file" class="form-control" name="edoks2" id="edoks2" accept="image/png, image/gif, image/jpeg">
                                <button class="btn btn-outline-secondary tutupPhoto2" type="button" id="tutupfile2"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button class="btn btn-outline-secondary lihatPhoto2" type="button" id="lihatfile2"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                            </div>
                            <div class="form-text" style="margin-top:-12px;">Hanya format (.jpg, .jpeg, .png).</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="contentphoto2">
                        <label class="col-sm-3 col-form-label"><b></b></label>
                        <div class="col-sm-9 text-center">
                            <img id="gambar_file2" class="rounded img-fluid">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="eis_trash" id="eis_trash">
                                <option selected>Pilih</option>
                                <option value="11">Data aktif</option>
                                <option value="12">Data nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i>&nbsp;Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailTemplate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Data</button>
                    </li>
                    <li class="nav-item" role="presentation" id="tab_files1">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">File 1</button>
                    </li>
                    <li class="nav-item" role="presentation" id="tab_files2">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">File 2</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        {{-- <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Direktorat</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_direktorat"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Subdit</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_subdit"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Direktur</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_direktur"></p>
                            </div>
                        </div> --}}

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Nama</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_kegiatan"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Status</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_status"></p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div class="col-md-12 mt-2 d-flex justify-content-center align-items-start">
                            <img id="d_foto1" class="img-thumbnail img-fluid" style="object-fit:cover;">
                        </div>
                    </div>

                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <div class="col-md-12 mt-2 d-flex justify-content-center align-items-start">
                            <img id="d_foto2" class="img-thumbnail img-fluid" style="object-fit:cover;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background-color:transparent; border:0px solid;">
            <div class="modal-body">
                <center><img src="/assets/backend/img/loader.gif" alt="" class="img-fluid d-block w-7" style="width:50px;" /></center>
            </div>
        </div>
    </div>
</div>