<div class="modal fade" id="tambahGaleri" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_galeri">
                    @csrf

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="gl_ktgr" id="gl_ktgr" onchange="Page.Status(this.value)">
                                <option value="">Pilih</option>
                                <option value="1">Slider</option>
                                <option value="2">Galeri</option>
                                <option value="3">Video</option>
                                <option value="4">Arsip</option>
                            </select>
                            <div class="form-text stat_ket" id="basic-addon4"><b>Untuk video, hanya link url/pranala api</b></div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Judul</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="gl_jdl" id="gl_jdl" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Deskripsi</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="gl_desc" id="gl_desc" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>URL/Pranala</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="gl_url" id="gl_url">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Files</b></label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="gl_files" id="gl_files" accept=".jpg,.jpeg,.png">
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

<div class="modal fade" id="editGaleri" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_galeri">
                    @csrf

                    <input type="hidden" class="form-control" name="e_gl_publicid" id="e_gl_publicid">

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_gl_ktgr" id="e_gl_ktgr" onchange="Page.EStatus(this.value)">
                                <option value="">Pilih</option>
                                <option value="1">Slider</option>
                                <option value="2">Galeri</option>
                                <option value="3">Video</option>
                                <option value="4">Arsip</option>
                            </select>
                            <div class="form-text stat_ket" id="basic-addon4"><b>Untuk video, hanya link url/pranala api</b></div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Judul</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="e_gl_jdl" id="e_gl_jdl" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Deskripsi</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="e_gl_desc" id="e_gl_desc" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>URL/Pranala</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_gl_url" id="e_gl_url">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Files</b></label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" name="e_gl_files_old" id="e_gl_files_old">
                                <input type="file" class="form-control" name="e_gl_files" id="e_gl_files" accept=".jpg,.jpeg,.png">
                                <button class="btn btn-outline-secondary tutupPhoto" type="button" id="tutupfile" onclick="Page.Tutup(this.value)"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button class="btn btn-outline-secondary lihatPhoto" type="button" id="lihatfile" onclick="Page.Lihat(this.value)"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="contentphoto">
                        <label class="col-sm-3 col-form-label"><b></b></label>
                        <div class="col-sm-9 text-center">
                            <img id="gambar_galeri" class="rounded img-fluid">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_gl_stat" id="e_gl_stat">
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

<div class="modal fade" id="detailGaleri" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_gl_ktgr"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Judul</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_gl_jdl"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Deskripsi</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_gl_desc"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>URL/Pranala</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_gl_url"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Files</b></label>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-sm btn-success lihatdetail" id="d_galeri" onclick="Page.LihatDetail(this.value)"><i class="fa fa-eye"></i> Lihat</button>
                        <button type="button" class="btn btn-sm btn-dark tutupdetail" onclick="Page.Tutup()"><i class="fa fa-eye"></i> Tutup</button>
                    </div>
                </div>

                <div class="mb-3 row" id="contentphoto2">
                    <label class="col-sm-3 col-form-label"><b></b></label>
                    <div class="col-sm-9 text-center">
                        <img id="detail_galeri" class="rounded img-fluid">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Status Data</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_gl_stat"></p>
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