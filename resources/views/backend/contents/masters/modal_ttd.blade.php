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

<div class="modal fade" id="tambahTtd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_tte">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Instansi/Unit</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nm_instansi" id="nm_instansi" value="Direktorat Jenderal Bimbingan Masyarakat Islam" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Direktur</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nm_direktur" id="nm_direktur">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Direktorat</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_direktorat" id="id_direktorat" onchange="Page.Subdit(this.value)"></select>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Subdit</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_subdit" id="id_subdit"></select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Tanggal TTE</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control lahirinput" name="tgl_tte" id="tgl_tte">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Lokasi TTE</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="lokasi_tte" id="lokasi_tte">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kegiatan</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="d_kegiatan" id="d_kegiatan"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Files</b></label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="files_tte" id="files_tte" accept="image/png, image/gif, image/jpeg">
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

<div class="modal fade" id="editTtd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_tte">
                    @csrf
                    <input type="hidden" class="form-control" name="e_publicid" id="e_publicid">

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Instansi/Unit</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_nm_instansi" id="e_nm_instansi" value="Direktorat Jenderal Bimbingan Masyarakat Islam" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Direktur</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_nm_direktur" id="e_nm_direktur">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Direktorat</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_id_direktorat" id="e_id_direktorat" onchange="Page.ESubdit(this.value)"></select>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Subdit</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_id_subdit" id="e_id_subdit"></select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Tanggal TTE</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control e_lahirinput" name="e_tgl_tte" id="e_tgl_tte">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Lokasi TTE</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_lokasi_tte" id="e_lokasi_tte">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kegiatan</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="e_kegiatan" id="e_kegiatan"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Files</b></label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" name="e_files_old" id="e_files_old">
                                <input type="file" class="form-control" name="e_files_tte" id="e_files_tte" accept="image/png, image/gif, image/jpeg">
                                <button class="btn btn-outline-secondary" type="button" id="tutupfile" onclick="Page.Tutup()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button class="btn btn-outline-secondary" type="button" id="lihatfile" onclick="Page.Lihat(this.value)"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                            </div>
                            <div class="form-text" id="basic-addon4" style="margin-top: -12px;">Hanya format (.jpg, .jpeg, .png).</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="contentphoto1">
                        <label class="col-sm-3 col-form-label"><b></b></label>
                        <div class="col-sm-9 text-center">
                            <img id="gambar_file" class="rounded img-fluid">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="eis_trash" id="eis_trash">
                                <option selected>Pilih</option>
                                <option value="1">Data aktif</option>
                                <option value="0">Data nonaktif</option>
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

<div class="modal fade" id="detailTtd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Files</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Instansi/Unit</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_instansi"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Nama Direktur</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_direktur"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
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
                            <label class="col-sm-3 col-form-label"><b>Tanggal TTE</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_tgl"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Lokasi TTE</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_lokasi"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Kegiatan</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d2_kegiatan"></p>
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
                        <div class="col-md-12 mt-2 mb-2 d-flex justify-content-center align-items-start">
                            <img id="d_foto1" class="img-thumbnail img-fluid" style="object-fit:cover;">
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