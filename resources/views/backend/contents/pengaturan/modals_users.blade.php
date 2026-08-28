<div class="modal fade" id="tambahMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_users">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Group</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="users_roles" id="users_roles"></select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Username</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="username" id="username">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Email</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="emails" id="emails">
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

<div class="modal fade" id="detailUsers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Akun</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Biodata</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    @include('backend.contents.pengaturan._tab_akun')

                    @include('backend.contents.pengaturan._tab_biodata')
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUsers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="edit_form_users">
                    @csrf
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Akun</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Biodata</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <input type="hidden" class="form-control" name="publicid_users" id="publicid_users">

                            <div class="mb-3 mt-3 row" id="hide_group">
                                <label class="col-sm-3 col-form-label"><b>Group</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="edit_group" id="edit_group"></select>
                                </div>
                            </div>

                            <div class="mb-3 row" id="margin_username">
                                <label class="col-sm-3 col-form-label"><b>Username</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="edit_username" id="edit_username">
                                </div>
                            </div>

                            <div class="mb-3 mt-3 row" id="hide_provinsi">
                                <label class="col-sm-3 col-form-label"><b>Provinsi</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="edit_provinsi" id="edit_provinsi" onchange="Kabupaten(this.value)"></select>
                                </div>
                            </div>

                            <div class="mb-3 row" id="hide_kabupaten">
                                <label class="col-sm-3 col-form-label"><b>Kabupaten</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="edit_kabupaten" id="edit_kabupaten" onchange="Kecamatan(this.value)"></select>
                                </div>
                            </div>
                            
                            <div class="mb-3 row" id="hide_kecamatan">
                                <label class="col-sm-3 col-form-label"><b>Kecamatan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="edit_kecamatan" id="edit_kecamatan"></select>
                                </div>
                            </div>

                            <div class="mb-3 row" id="hide_direktorat">
                                <label class="col-sm-3 col-form-label"><b>Direktorat</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="edit_direktorat" id="edit_direktorat" onchange="Subdit(this.value)"></select>
                                </div>
                            </div>

                            <div class="mb-3 row" id="hide_subdit">
                                <label class="col-sm-3 col-form-label"><b>Subdit</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="edit_subdit" id="edit_subdit"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Email</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="edit_email" id="edit_email">
                                </div>
                            </div>

                            <div class="mb-3 row" id="hide_status">
                                <label class="col-sm-3 col-form-label"><b>Status</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="edit_status_users" id="edit_status_users">
                                        <option>Pilih</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <input type="hidden" class="form-control" name="publicid_profile" id="publicid_profile">

                            <div class="mb-3 mt-3 row">
                                <label class="col-sm-3 col-form-label"><b>Nama Lengkap</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="edit_nama" id="edit_nama">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control lahiredit" name="edit_tgl" id="edit_tgl">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Telepon</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="edit_tlp" id="edit_tlp">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Alamat</b></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="edit_alamat" name="edit_alamat" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Photo</b></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" name="files_old" id="files_old">
                                        <input type="file" class="form-control" name="edit_files" id="edit_files"> <!-- accept=".jpg,.jpeg,.png" -->
                                        <button class="btn btn-dark" id="tutup_files" onclick="Page.Tutup()" type="button"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                        <button class="btn btn-success class_lihat" id="lihat_files" onclick="Lihat(this.value)" type="button"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row" id="tampil_gambar">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9 text-center">
                                    <img id="gambar_users" class="rounded img-fluid">
                                </div>
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
</div>

<div class="modal fade" id="usersPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Password</h1>
            </div>

            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1.</th>
                            <td>Reset password default</td>
                            <td><button type="button" class="btn btn-sm btn-info" id="default_password" onclick="Page.DefaultPassword(this.value)"><i class="fa fa-sync-alt"></i>&nbsp;Kirim</button></td>
                        </tr>
                        <tr>
                            <th scope="row">2.</th>
                            <td>Modifikasi password</td>
                            <td><button type="button" class="btn btn-sm btn-info" id="custom_password" onclick="Page.CustomPassword(this.value)"><i class="fa fa-pencil"></i>&nbsp;Kirim</button></td>
                        </tr>
                    </tbody>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="usersCustomPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Password</h1>
            </div>

            <div class="modal-body">
                <form  method="post" enctype="multipart/form-data" id="formedit_usercustom">
                    @csrf
                    <input type="hidden" class="form-class" id="custom_iduser" name="custom_iduser">

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label"><b>Password Lama</b></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="custom_password_old" name="custom_password_old">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label"><b>Password Baru</b></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="custom_password_baru" name="custom_password_baru">
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

<div class="modal fade" id="Loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background-color:transparent; border:0px solid;">
            <div class="modal-body">
                <center><img src="/assets/backend/img/loader.gif" alt="" class="img-fluid d-block w-7" style="width:50px;" /></center>
            </div>
        </div>
    </div>
</div>