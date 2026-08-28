<div class="modal fade" id="tambahProvinsi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_provinsi">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>ID Provinsi</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="id_prov" id="id_prov">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Satker</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="id_satker" id="id_satker" maxlength="6">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Provinsi</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nm_prov" id="nm_prov">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Latitude</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="lat" id="lat">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Longitude</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="long" id="long">
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

<div class="modal fade" id="editProvinsi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_provinsi">
                    @csrf
                    <input type="hidden" class="form-control" name="e_publicid" id="e_publicid">

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>ID Provinsi</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_id_prov" id="e_id_prov">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Satker</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_id_satker" id="e_id_satker" maxlength="6">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Provinsi</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_nm_prov" id="e_nm_prov">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Latitude</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_lat" id="e_lat">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Longitude</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_long" id="e_long">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="eis_trash" id="eis_trash">
                                <option value="">Pilih</option>
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

<div class="modal fade" id="detailProvinsi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>ID Provinsi</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_provinsi"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>ID Satker</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_satker"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Nama Provinsi</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_nama"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Latitude</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_latitude"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Longitude</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_longitude"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Status</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_status"></p>
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