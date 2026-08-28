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
                        <label class="col-sm-3 col-form-label"><b></b></label>
                        <div class="col-sm-9">
                            <input class="form-check-input" type="checkbox" value="" name="id_checkbox" id="id_checkbox">
                            <label class="form-check-label">Klik untuk membuat induk menu atau proses query</label>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_systems">
                        <label class="col-sm-3 col-form-label"><b>Systems</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_systems" id="id_systems" onchange="IS_Systems(this.value)">
                                <option selected>Pilih</option>
                                <option value="1">Proses Validasi/Query</option>
                                <option value="0">Hanya Menu</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_kategori">
                        <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_kategori" id="id_kategori" onchange="IS_Kategori(this.value
                            )">
                                <option selected>Pilih</option>
                                <option value="1">Frontend</option>
                                <option value="2">Backend</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_induk">
                        <label class="col-sm-3 col-form-label"><b>Induk</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_induk" id="id_induk" onchange="ParentMenu(this.value)"></select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_parent">
                        <label class="col-sm-3 col-form-label"><b>Parent</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_parent" id="id_parent" onchange="ChildParent(this.value)"></select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_subparent">
                        <label class="col-sm-3 col-form-label"><b>Sub Parent</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_child" id="id_child"></select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_number">
                        <label class="col-sm-3 col-form-label"><b>Urutan Menu</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_urutan_menu" id="id_urutan_menu"></select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_nama">
                        <label class="col-sm-3 col-form-label"><b>Nama Menu</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_menu" id="nama_menu">
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_icon">
                        <label class="col-sm-3 col-form-label"><b>Icon</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="icon_menu" id="icon_menu">
                            <div class="form-text" id="basic-addon4">Untuk referensi icon (https://icons.getbootstrap.com/icons/gear/)</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_method">
                        <label class="col-sm-3 col-form-label"><b>Method</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="id_method" id="id_method">
                                <option selected>Pilih</option>
                                <option value="1">GET</option>
                                <option value="2">POST</option>
                                <option value="3">PUT</option>
                                <option value="4">DELETE</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_pranala">
                        <label class="col-sm-3 col-form-label"><b>Pranala</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="uri_pranala" id="uri_pranala">
                            <div class="form-text" id="basic-addon4">Untuk url atau link yang di tentukan</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_controller">
                        <label class="col-sm-3 col-form-label"><b>Controller</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="controller" id="controller">
                            <div class="form-text" id="basic-addon4">Untuk nama class controller</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_action">
                        <label class="col-sm-3 col-form-label"><b>Action</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="action" id="action">
                            <div class="form-text" id="basic-addon4">Untuk nama function di controller</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_alias">
                        <label class="col-sm-3 col-form-label"><b>Alias Name Route</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name_route" id="name_route">
                            <div class="form-text" id="basic-addon4">Untuk nama alias route (umum penggunaan di login dan datatables)</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="class_middleware">
                        <label class="col-sm-3 col-form-label"><b>Middleware</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="middleware" id="middleware">
                            <div class="form-text" id="basic-addon4">Untuk akses, apakah harus login atau publik (auth, guest, verified)</div>
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

<div class="modal fade" id="editMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="edit_form_menu">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b></b></label>
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" name="edit_public" id="edit_public">
                            <input class="form-check-input" type="checkbox" value="" name="edit_id_checkbox" id="edit_id_checkbox" disabled>
                            <label class="form-check-label">Klik untuk membuat induk menu atau proses query</label>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_systems">
                        <label class="col-sm-3 col-form-label"><b>Systems</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_id_systems" id="edit_id_systems" onchange="Edit_IS_Systems(this.value)" disabled>
                                <option selected>Pilih</option>
                                <option value="1">Proses Validasi/Query</option>
                                <option value="0">Hanya Menu</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_kategori">
                        <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_id_kategori" id="edit_id_kategori" onchange="Edit_IS_Kategori(this.value
                            )" disabled>
                                <option selected>Pilih</option>
                                <option value="1">Frontend</option>
                                <option value="2">Backend</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_induk">
                        <label class="col-sm-3 col-form-label"><b>Induk</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_id_induk" id="edit_id_induk" onchange="Edit_ParentMenu(this.value)" disabled></select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_parent">
                        <label class="col-sm-3 col-form-label"><b>Parent</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_id_parent" id="edit_id_parent" onchange="Edit_ChildParent(this.value)" disabled></select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_subparent">
                        <label class="col-sm-3 col-form-label"><b>Sub Parent</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_id_child" id="edit_id_child" disabled></select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_number">
                        <label class="col-sm-3 col-form-label"><b>Urutan Menu</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_id_urutan_menu" id="edit_id_urutan_menu"></select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_nama">
                        <label class="col-sm-3 col-form-label"><b>Nama Menu</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_nama_menu" id="edit_nama_menu">
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_icon">
                        <label class="col-sm-3 col-form-label"><b>Icon</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_icon_menu" id="edit_icon_menu">
                            <div class="form-text" id="basic-addon4">Untuk referensi icon (https://icons.getbootstrap.com/icons/gear/)</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_icon_child">
                        <label class="col-sm-3 col-form-label"><b>Icon Parent Child</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_icon_menu_child" id="edit_icon_menu_child">
                            <div class="form-text" id="basic-addon4">Untuk referensi icon (https://icons.getbootstrap.com/icons/gear/)</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_method">
                        <label class="col-sm-3 col-form-label"><b>Method</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_id_method" id="edit_id_method">
                                <option selected>Pilih</option>
                                <option value="1">GET</option>
                                <option value="2">POST</option>
                                <option value="3">PUT</option>
                                <option value="4">DELETE</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_pranala">
                        <label class="col-sm-3 col-form-label"><b>Pranala</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_uri_pranala" id="edit_uri_pranala">
                            <div class="form-text" id="basic-addon4">Untuk url atau link yang di tentukan</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_controller">
                        <label class="col-sm-3 col-form-label"><b>Controller</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_controller" id="edit_controller">
                            <div class="form-text" id="basic-addon4">Untuk nama class controller</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_action">
                        <label class="col-sm-3 col-form-label"><b>Action</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_action" id="edit_action">
                            <div class="form-text" id="basic-addon4">Untuk nama function di controller</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_alias">
                        <label class="col-sm-3 col-form-label"><b>Alias Name Route</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_name_route" id="edit_name_route">
                            <div class="form-text" id="basic-addon4">Untuk nama alias route (umum penggunaan di login dan datatables)</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_class_middleware">
                        <label class="col-sm-3 col-form-label"><b>Middleware</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="edit_middleware" id="edit_middleware">
                            <div class="form-text" id="basic-addon4">Untuk akses, apakah harus login atau publik (auth, guest, verified)</div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="edit_trash">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="edit_is_trash" id="edit_is_trash">
                                <option selected>Pilih</option>
                                <option value="1">Aktif</option>
                                <option value="2">Nonaktif</option>
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

<div class="modal fade" id="detailMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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