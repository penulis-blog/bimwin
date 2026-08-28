<div class="modal fade" id="tambahParameters" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_parameters">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_parameters" id="nama_parameters">
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Group</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="group_parameters" id="group_parameters">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Value</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="value_parameters" id="value_parameters">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="ket_parameters" name="ket_parameters" rows="3"></textarea>
                        </div>
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

<div class="modal fade" id="editParameters" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="edit_form_parameters">
                    @csrf
                    <input type="hidden" class="form-control" name="e_id" id="e_id">

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_nama_parameters" id="e_nama_parameters">
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Group</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_group_parameters" id="e_group_parameters">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Value</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_value_parameters" id="e_value_parameters">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="e_ket_parameters" name="e_ket_parameters" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_trash">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_is_trash" id="e_is_trash">
                                <option selected>Pilih</option>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
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

<div class="modal fade" id="detailParameters" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"><b>Nama Menu</b></label>
                    <div class="col-sm-10">
                      <p class="form-control-plaintext" id="d_menu"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"><b>Icon</b></label>
                    <div class="col-sm-10">
                      <p class="form-control-plaintext" id="d_icon"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"><b>Kategori</b></label>
                    <div class="col-sm-10">
                      <p class="form-control-plaintext" id="d_ktgr"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"><b>Method</b></label>
                    <div class="col-sm-10">
                      <p class="form-control-plaintext" id="d_mtd"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"><b>Controller</b></label>
                    <div class="col-sm-10">
                      <p class="form-control-plaintext" id="d_cont"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"><b>URI</b></label>
                    <div class="col-sm-10">
                      <p class="form-control-plaintext" id="d_uri"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"><b>Systems</b></label>
                    <div class="col-sm-10">
                      <p class="form-control-plaintext" id="d_is"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"><b>Status</b></label>
                    <div class="col-sm-10">
                      <p class="form-control-plaintext" id="d_stat"></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                </div>
            </form>
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