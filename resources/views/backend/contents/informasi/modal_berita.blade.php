<style type="text/css">
/* .cke_dialog {
    z-index: 200000 !important;
}
.cke_dialog_background_cover {
    z-index: 199999 !important;
}
.cke {
    z-index: 12000 !important;
} */
#b_title, #be_title {
    border-width: 2px;
    transition: border-color 0.3s; /* efek transisi halus */
}
#b_desc, #be_desc {
    border-width: 2px;
    transition: border-color 0.3s; /* efek transisi halus */
}
#b_exc, #be_exc {
    border-width: 2px;
    transition: border-color 0.3s; /* efek transisi halus */
}
/* .modal-backdrop {
  z-index: 1040 !important;
}
.modal {
  z-index: 1050 !important;
}
#editBimwin {
  z-index: 9999 !important;
} */
/* #editBimwin .modal-content {
  pointer-events: auto !important;
} */
.swal2-container {
    z-index: 999999 !important;
}
#cke_notifications_area_editor1, #cke_notifications_area_editor1_{
    visibility: hidden;
}
</style>

<div class="modal fade" id="tambahBerita" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_berita_">
                    @csrf
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="wizardTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata" type="button" role="tab">Content</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="administratif-tab" data-bs-toggle="tab" data-bs-target="#administratif" type="button" role="tab" disabled>Meta Browser</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="instansi-tab" data-bs-toggle="tab" data-bs-target="#instansi" type="button" role="tab" disabled>Penulis</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content border p-3 mt-2" id="wizardTabContent">
                        <!-- Biodata Diri -->
                        <div class="tab-pane fade show active" id="biodata" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Kategori</b></label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="b_kategori" id="b_kategori">
                                        <option selected>Pilih</option>
                                        <option value="1">Berita</option>
                                        <option value="2">Opini</option>
                                        <option value="3">Tokoh</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Judul</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="b_judul" id="b_judul">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Content/Isi</b></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="b_editor1" id="editor1" rows="7"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>URL/Pranala</b></label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon3">{{ url('/') }}/</span>
                                        <input type="text" class="form-control" name="b_url" id="b_url">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Gambar</b></label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="b_files" id="b_files" accept="image/png, image/gif, image/jpeg">
                                    <div class="form-text" id="basic-addon4">Hanya format (.jpg, .jpeg, .png).</div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button type="button" class="btn btn-secondary" onclick="nextTab('administratif-tab')">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Meta Browser -->
                        <div class="tab-pane fade" id="administratif" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Meta Keywords</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="b_key" id="b_key">
                                    Jika keyword lebih dari satu, pisahkan dengan tanda koma (,)
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Meta Title</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="b_title" id="b_title">
                                    <div class="form-text" id="basic-title">Maksimal 55 s.d 60 karakter</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Meta Deskripsi</b></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="b_desc" id="b_desc"></textarea>
                                    <div class="form-text" id="basic-deskripsi">Maksimal 120 s.d 155 karakter dan memuat kata kunci serta CTA</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Meta Tags</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="b_tags" id="b_tags">
                                    <div class="form-text" id="basic-addon4">Jika tag lebih dari satu, pisahkan dengan tanda koma (,)</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Excerpt/Ringkasan</b></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="b_exc" id="b_exc"></textarea>
                                    <div class="form-text" id="basic-excerpt">Maksimal 120 s.d 160 karakter, sebelum readmore</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevTab('biodata-tab')"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                                <button type="button" class="btn btn-secondary" onclick="nextTab('instansi-tab')">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Penulis -->
                        <div class="tab-pane fade" id="instansi" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Nama/Sumber URL</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="b_autor" id="b_autor">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Tgl. Publish</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control tglpost" name="b_tgl" id="b_tgl">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Status Berita</b></label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="b_stat" id="b_stat">
                                        <option selected>Pilih</option>
                                        <option value="11">Publish</option>
                                        <option value="12">Tidak Aktif</option>
                                        <option value="13">Pending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevTab('administratif-tab')"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                                <div>
                                    <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i> Simpan</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBerita" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_berita_">
                    @csrf
                    <input type="hidden" class="form-control" name="be_publicid" id="be_publicid">
                    
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="wizardTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="edit-biodata-tab" data-bs-toggle="tab" data-bs-target="#editbiodata" type="button" role="tab">Content</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-administratif-tab" data-bs-toggle="tab" data-bs-target="#editadministratif" type="button" role="tab">Meta Browser</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-instansi-tab" data-bs-toggle="tab" data-bs-target="#editinstansi" type="button" role="tab">Penulis</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content border p-3 mt-2" id="wizardTabContent">
                        <!-- Content -->
                        <div class="tab-pane fade show active" id="editbiodata" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Kategori</b></label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="be_kategori" id="be_kategori">
                                        <option value="" selected>Pilih</option>
                                        <option value="1">Berita</option>
                                        <option value="2">Opini</option>
                                        <option value="3">Tokoh</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Judul</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="be_judul" id="be_judul">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Content/Isi</b></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="be_editor1" id="editor1_" rows="7"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>URL/Pranala</b></label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon3">{{ url('/') }}/</span>
                                        <input type="text" class="form-control" name="be_url" id="be_url">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Gambar</b></label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <input type="hidden" class="form-control" name="be_files_old" id="be_files_old">
                                        <input type="file" class="form-control" name="be_files" id="be_files" accept="image/png, image/gif, image/jpeg">
                                        <button class="btn btn-dark buttontutup" type="button" id="btntutup" onclick="Page.Tutup()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                        <button class="btn btn-success buttonlihat" type="button" id="btnlihat" onclick="Page.Lihat(this.value)"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                                    </div>
                                    <div class="form-text" id="basic-addon4">Hanya format (.jpg, .jpeg, .png).</div>
                                </div>
                            </div>

                            <div class="mb-3 row" id="contentphoto">
                                <label class="col-sm-2 col-form-label"><b></b></label>
                                <div class="col-sm-10 text-center">
                                    <img id="gambar_berita" class="rounded img-fluid">
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button type="button" class="btn btn-secondary" onclick="nextTab('edit-administratif-tab')">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Meta Browser -->
                        <div class="tab-pane fade" id="editadministratif" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Meta Keywords</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="be_key" id="be_key">
                                    Jika keyword lebih dari satu, pisahkan dengan tanda koma (,)
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Meta Title</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="be_title" id="be_title">
                                    <div class="form-text" id="basic-title">Maksimal 55 s.d 60 karakter</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Meta Deskripsi</b></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="be_desc" id="be_desc"></textarea>
                                    <div class="form-text" id="basic-deskripsi">Maksimal 120 s.d 155 karakter dan memuat kata kunci serta CTA</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Meta Tags</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="be_tags" id="be_tags">
                                    <div class="form-text" id="basic-addon4">Jika tag lebih dari satu, pisahkan dengan tanda koma (,)</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Excerpt/Ringkasan</b></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="be_exc" id="be_exc"></textarea>
                                    <div class="form-text" id="basic-excerpt">Maksimal 120 s.d 160 karakter, sebelum readmore</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevTab('edit-biodata-tab')"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                                <button type="button" class="btn btn-secondary" onclick="nextTab('edit-instansi-tab')">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Penulis -->
                        <div class="tab-pane fade" id="editinstansi" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Nama/Sumber URL</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="be_autor" id="be_autor">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Tgl. Publish</b></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control tglpost_" name="be_tgl" id="be_tgl">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label"><b>Status Berita</b></label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="be_stat" id="be_stat">
                                        <option value="" selected>Pilih</option>
                                        <option value="11">Publish</option>
                                        <option value="12">Tidak Aktif</option>
                                        <option value="13">Pending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <!-- tombol kiri -->
                                <button type="button" class="btn btn-secondary" onclick="prevTab('edit-administratif-tab')"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                                
                                <!-- tombol kanan (dibungkus div biar sejajar) -->
                                <div>
                                    <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i> Simpan</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailBerita" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Content</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Meta Browser</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Penulis</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    @include('backend.contents.informasi._tabberita')
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