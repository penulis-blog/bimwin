{{-- <div class="modal fade" id="tambahKomentar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
</div> --}}

<div class="modal fade" id="editKomentar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_komentar">
                    @csrf
                    <input type="hidden" class="form-control" name="e_komentar" id="e_komentar">
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Tanggal Berita</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="k_tgl"></p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Judul Berita</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="k_judul"></p>
                        </div>
                    </div>

                    <div class="mb-3 row" id="induk_komentar">
                        <label class="col-sm-3 col-form-label"><b>Komentar Dari</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="k_dari"></p>
                        </div>
                    </div>

                    <div class="mb-3 row" id="induk_komentar_2">
                        <label class="col-sm-3 col-form-label"><b>Isi Komentar</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="k_isi_2" id="k_isi_2" rows="7" readonly></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Dikomentari Oleh</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="k_oleh"></p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Isi Komentar</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="k_isi" id="k_isi" rows="7"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Diberikan Like</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="k_like"></p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Diberikan Unlike</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="k_unlike"></p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Komentar Masuk</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext" id="k_in"></p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Status Komentar</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="k_stat" id="k_stat">
                                <option value="">Pilih</option>
                                <option value="1">Publish</option>
                                <option value="2">Pending</option>
                                <option value="3">Private/Delete</option>
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

<div class="modal fade" id="detailKomentar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Tanggal Berita</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_berita"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Judul Berita</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_judul"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>Jumlah Komentar</b></label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext" id="d_jumlah"></p>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"><b>URL/Pranala</b></label>
                    <div class="col-sm-9">
                        <a id="d_link" class="btn btn-sm btn-dark" target="_blank">
                            <i class="fa fa-eye"></i> Lihat
                        </a>
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