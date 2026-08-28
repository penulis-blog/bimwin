<div class="modal fade" id="tambahMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_menu">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Group</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_roles" id="nama_roles">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="keterangan_roles" id="keterangan_roles" rows="3"></textarea>
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

<div class="modal fade" id="detailRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Nama Group</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="group"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="keterangan"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Status</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="status"></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="edit_form_roles">
                    @csrf
                    <input type="hidden" class="form-control" name="publicid_roles" id="publicid_roles">

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Group</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_nama_roles" id="edit_nama_roles">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Keterangan</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="edit_keterangan_roles" id="edit_keterangan_roles" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_status_roles" id="edit_status_roles">
                                <option>Pilih</option>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
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

<style>
    .table-scroll {
  max-height: 400px;   /* tinggi scroll */
  overflow-y: auto;
  overflow-x: auto;    /* biar tabel lebar bisa geser */
}

/* fix sticky header */
.table-scroll thead th {
  position: sticky;
  top: 0;
  background: #f8f9fa;
  z-index: 10;           /* lebih tinggi dari td */
  border-bottom: 2px solid #dee2e6;
  box-shadow: 0 2px 2px rgba(0,0,0,0.05);
}

/* ukuran kolom */
.table-permissions th,
.table-permissions td {
  padding: 6px;
  font-size: 13px;
  white-space: nowrap;
}

.table-permissions th:nth-child(1),
.table-permissions td:nth-child(1) {
  width: 40px;
}

.table-permissions th:nth-child(2),
.table-permissions td:nth-child(2) {
  width: 200px;
  text-align: left !important;
}

</style>

<div class="modal fade" id="permissionsRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Permissions Menu</h1>
            </div>

            <div class="modal-body menupermissions">
                <form method="post">
                    @csrf
                    <div class="table-scroll">
                        <table class="table table-striped text-center table-permissions">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th style="text-align: center !important;">Menu</th>
                                    <th>Lihat</th>
                                    <th>Tambah</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                    <th>Laporan</th>
                                    <th>Password</th>
                                    <th>Setujui</th>
                                    <th>Kembali</th>
                                    <th>Permissions</th>
                                    <th>Modules</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody id="permission_data">
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="Page.SavePermissions()"><i class="fa-solid fa-circle-check"></i>&nbsp;Simpan</button>
                    </div>
                </form>
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