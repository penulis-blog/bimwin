<div class="modal fade" id="tambahJadwalJejaring" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_jadwaljejaring">
                    @csrf
                    {{-- @if(in_array(auth()->user()->id_roles, [1, 12])) --}}
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Direktorat</b></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="_direktorat" id="_direktorat" onchange="Subdit(this.value)"></select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Subdit</b></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="_subdit" id="_subdit" onchange="Kategori_(this.value)"></select>
                            </div>
                        </div>
                    {{-- @endif --}}

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kategori Kegiatan</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="_kategori" id="_kategori" onchange="TTE_(this.value)"></select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>TTE Direktur</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="_ttedirektur" id="_ttedirektur"></select>
                            <div class="form-text" id="basic-addon4"><b>Perhatian:</b><br>
                                <ol>
                                    <li>Jika TTE belum tersedia, jangan diisi atau lewati saja.</b></li>
                                    <li><b>Jika TTE sudah tersedia, tambah di menu master -> TTE Direktur.</b></li>
                                    <li>Jangan lupa, edit data jadwal dan pilih TTE yang telah ditambah.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Template Sertifikat</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="tempt" id="tempt"></select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Acara</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="acara" id="acara"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Tempat</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tempat" id="tempat">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Lokasi</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="lokasi" id="lokasi">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Dari Tanggal</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control daritanggal" name="dari" id="dari">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Sampai Tanggal</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control sampaitanggal" name="sampai" id="sampai">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Pembeda/Sebut Angkatan</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="jumlah" id="jumlah">
                            <div class="form-text" id="basic-addon4"><b>Contoh:</b><br>
                                <ol>
                                    <li>Angkatan 1 dan 2, <b>Tuliskan hanya angka dan koma sebagai pemisah tanpa tanda kurung buka tutup --> 1,2</b></li>
                                    <li><b>Jika tidak ada angkatan, </b> ketik angka 0 saja --> <b>0</b></li>
                                </ol>
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

<div class="modal fade" id="editJadwalJejaring" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_jadwaljejaring">
                    @csrf
                    <input type="hidden" class="form-control" name="e_publicid" id="e_publicid">

                    @if(in_array(auth()->user()->id_roles, [1, 12]))
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Direktorat</b></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="ed_direktorat" id="ed_direktorat" onchange="ed_Subdit(this.value)"></select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Subdit</b></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="ed_subdit" id="ed_subdit" onchange="ed_Kategori(this.value)"></select>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kategori Kegiatan</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_kategori" id="e_kategori" onchange="ed_TTE_(this.value)"></select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>TTE Direktur</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_ttedirektur" id="e_ttedirektur"></select>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Template Sertifikat</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_tempt" id="e_tempt" onchange="Template(this.value)"></select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Acara</b></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="e_acara" id="e_acara"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Tempat</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_tempat" id="e_tempat">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Lokasi</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_lokasi" id="e_lokasi">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Dari Tanggal</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control e_daritanggal" name="e_dari" id="e_dari">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Sampai Tanggal</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control e_sampaitanggal" name="e_sampai" id="e_sampai">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Pembeda/Sebut Angkatan</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_jumlah" id="e_jumlah">
                            <div class="form-text" id="basic-addon4"><b>Contoh:</b><br>
                                <ol>
                                    <li>Angkatan 1 dan 2, <b>Tuliskan hanya angka dan koma sebagai pemisah tanpa tanda kurung buka tutup --> 1,2</b></li>
                                    <li><b>Jika tidak ada angkatan, </b> ketik angka 0 saja --> <b>0</b></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Status</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="e_status" id="e_status">
                                <option value="" selected disabled>Pilih</option>
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

<div class="modal fade" id="detailJadwalJejaring" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Template Sertifikat</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>No. Kegiatan</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_nokeg"></p>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>TTE Direktur</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_direktur2"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Acara</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_acara"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Tempat</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_tempat"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Lokasi</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_lokasi"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Dari Tanggal</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_dari"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Sampai Tanggal</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_sampai"></p>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"><b>Pembeda/Sebut Angkatan</b></label>
                            <div class="col-sm-9">
                                <p class="form-control-plaintext" id="d_pembeda"></p>
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
                        <div class="mb-3 row">
                            <div class="col-sm-12 mt-2">
                                <img id="d_templates" class="img-thumbnail img-fluid" style="object-fit:cover;">
                                <img id="d_templates_2" class="img-thumbnail img-fluid" style="object-fit:cover;">
                            </div>
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

<div class="modal fade" id="laporanJadwalJejaring" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Laporan</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="laporan_jadwaljejaring">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Acara</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="l_acara" id="l_acara"></select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Kategori</b></label>
                        <div class="col-sm-9">
                            <select class="form-select" name="l_kategori" id="l_kategori">
                                <option value="" selected disabled>Pilih</option>
                                <option value="170">Absen</option>
                                <option value="171">Perlengkapan</option>
                                <option value="172">Cek Rekening</option>
                                <option value="173">Peserta</option>
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

<div class="modal fade" id="FormulirJadwalJejaring" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Link Formulir</h1>
            </div>

            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Angkatan</th>
                        <th scope="col">Barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>John</td>
                        <td>Doe</td>
                        <td>@social</td>
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

<div class="modal fade" id="Loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 999999;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background-color:transparent; border:0px solid;">
            <div class="modal-body">
                <center><img src="/assets/backend/img/loader.gif" alt="" class="img-fluid d-block w-7" style="width:50px;" /></center>
            </div>
        </div>
    </div>
</div>