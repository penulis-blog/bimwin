<div class="modal fade" id="tambahMateri" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_materi">
                    @csrf

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="mt_ktgr" id="mt_ktgr">
                                <option value="">Pilih</option>
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Judul</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="mt_jdl" id="mt_jdl" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="mt_ktrgn" id="mt_ktrgn" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>URL/Pranala</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="mt_url" id="mt_url">
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

<div class="modal fade" id="editMateri" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_materi">
                    @csrf

                    <input type="hidden" class="form-control" name="e_mt_publicid" id="e_mt_publicid">

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_mt_ktgr" id="e_mt_ktgr">
                                <option value="">Pilih</option>
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Judul</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="e_mt_jdl" id="e_mt_jdl" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="e_mt_ktrgn" id="e_mt_ktrgn" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>URL/Pranala</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_mt_url" id="e_mt_url">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_mt_stat" id="e_mt_stat">
                                <option value="">Pilih</option>
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

<div class="modal fade" id="detailMateri" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_mt_ktgr"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Judul</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_mt_jdl"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_mt_desc"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>URL/Pranala</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_mt_url"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Status Data</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_mt_stat"></p>
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