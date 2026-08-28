<div class="modal fade" id="tambahBrus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Tambah</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_brus_peserta">
                    @csrf
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="wizardTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata" type="button" role="tab">Biodata Diri</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="administratif-tab" data-bs-toggle="tab" data-bs-target="#administratif" type="button" role="tab" disabled>Administratif</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="instansi-tab" data-bs-toggle="tab" data-bs-target="#instansi" type="button" role="tab" disabled>Instansi</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content border p-3 mt-2" id="wizardTabContent">
                        <!-- Biodata Diri -->
                        <div class="tab-pane fade show active" id="biodata" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Kegiatan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="keg_bimwin" id="keg_bimwin" onchange="Angkatan(this.value)"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Angkatan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="angkatan_bimwin" id="angkatan_bimwin"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>NIK KTP</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nik_bimwin" id="nik_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Nama Lengkap</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_bimwin" id="nama_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Tempat Lahir</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tmp_bimwin" id="tmp_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control lahirinput" name="tgl_bimwin" id="tgl_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Jenis Kelamin</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="jk_bimwin" id="jk_bimwin">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="11">Laki-laki</option>
                                        <option value="12">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Alamat Rumah</b></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="domisili_bimwin" id="domisili_bimwin"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>No. HP</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="hp_bimwin" id="hp_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Email</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email_bimwin" id="email_bimwin">
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button type="button" class="btn btn-secondary" onclick="nextTab('administratif-tab')">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Administratif -->
                        <div class="tab-pane fade" id="administratif" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>No. Rekening</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="rek_bimwin" id="rek_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Nama Bank</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nm_bimwin" id="nm_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>NPWP</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="npwp_bimwin" id="npwp_bimwin">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevTab('biodata-tab')"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                                <button type="button" class="btn btn-secondary" onclick="nextTab('instansi-tab')">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Instansi -->
                        <div class="tab-pane fade" id="instansi" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>NIP</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nip_bimwin" id="nip_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Provinsi</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="prov_bimwin" id="prov_bimwin" onchange="KabupatenBimwin(this.value)"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Kabupaten</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="kab_bimwin" id="kab_bimwin" onchange="KecamatanBimwin(this.value)"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Kecamatan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="kec_bimwin" id="kec_bimwin"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Status Pegawai</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="pegawai_bimwin" id="pegawai_bimwin">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="13">PNS</option>
                                        <option value="14">CPNS</option>
                                        <option value="15">PPPK</option>
                                        <option value="16">PPNPN</option>
                                        <option value="17">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Jabatan</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="jbtn_bimwin" id="jbtn_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Golongan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="gol_bimwin" id="gol_bimwin">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="101">I/a</option>
                                        <option value="102">I/b</option>
                                        <option value="103">I/c</option>
                                        <option value="104">I/d</option>
                                        <option value="105">II/a</option>
                                        <option value="106">II/b</option>
                                        <option value="107">II/c</option>
                                        <option value="108">II/d</option>
                                        <option value="109">III/a</option>
                                        <option value="110">III/b</option>
                                        <option value="111">III/c</option>
                                        <option value="112">III/d</option>
                                        <option value="113">IV/a</option>
                                        <option value="114">IV/b</option>
                                        <option value="115">IV/c</option>
                                        <option value="116">IV/d</option>
                                        <option value="117">IX</option>
                                        <option value="118">X</option>
                                        <option value="119">XI</option>
                                        <option value="120">-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Instansi</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inst_bimwin" id="inst_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Alamat Kantor</b></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="kantor_bimwin" id="kantor_bimwin"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Photo</b></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="files_bimwin" id="files_bimwin" accept="image/png, image/gif, image/jpeg">
                                    <div class="form-text" id="basic-addon4">Hanya format (.jpg, .jpeg, .png).</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Surat Tugas</b></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="files_surtug" id="files_surtug" accept=".pdf, .doc, .docx">
                                    <div class="form-text" id="basic-addon4">Hanya format (.jpg, .jpeg, .png).</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <!-- tombol kiri -->
                                <button type="button" class="btn btn-secondary" onclick="prevTab('administratif-tab')"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                                
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

<div class="modal fade" id="editBrus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_brus_peserta">
                    @csrf
                    <input type="hidden" class="form-control" name="e_publicid" id="e_publicid">
                    
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs" id="wizardTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="edit-biodata-tab" data-bs-toggle="tab" data-bs-target="#editbiodata" type="button" role="tab">Biodata Diri</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="edit-administratif-tab" data-bs-toggle="tab" data-bs-target="#editadministratif" type="button" role="tab" disabled>Administratif</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="edit-instansi-tab" data-bs-toggle="tab" data-bs-target="#editinstansi" type="button" role="tab" disabled>Instansi</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content border p-3 mt-2" id="wizardTabContent">
                        <!-- Biodata Diri -->
                        <div class="tab-pane fade show active" id="editbiodata" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Kegiatan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_keg_bimwin" id="e_keg_bimwin" onchange="eAngkatan(this.value)"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Angkatan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_angkatan_bimwin" id="e_angkatan_bimwin"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>NIK KTP</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_nik_bimwin" id="e_nik_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Nama Lengkap</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_nama_bimwin" id="e_nama_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Tempat Lahir</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_tmp_bimwin" id="e_tmp_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control editlahirinput" name="e_tgl_bimwin" id="e_tgl_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Jenis Kelamin</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_jk_bimwin" id="e_jk_bimwin">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="11">Laki-laki</option>
                                        <option value="12">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Alamat Rumah</b></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="e_domisili_bimwin" id="e_domisili_bimwin"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>No. HP</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_hp_bimwin" id="e_hp_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Email</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_email_bimwin" id="e_email_bimwin">
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button type="button" class="btn btn-secondary" onclick="nextTab('edit-administratif-tab')">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Administratif -->
                        <div class="tab-pane fade" id="editadministratif" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>No. Rekening</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_rek_bimwin" id="e_rek_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Nama Bank</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_nm_bimwin" id="e_nm_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>NPWP</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_npwp_bimwin" id="e_npwp_bimwin">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevTab('edit-biodata-tab')"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                                <button type="button" class="btn btn-secondary" onclick="nextTab('edit-instansi-tab')">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <!-- Instansi -->
                        <div class="tab-pane fade" id="editinstansi" role="tabpanel">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>NIP</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_nip_bimwin" id="e_nip_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Provinsi</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_prov_bimwin" id="e_prov_bimwin" onchange="eKabupaten(this.value)"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Kabupaten</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_kab_bimwin" id="e_kab_bimwin" onchange="eKecamatan(this.value)"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Kecamatan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_kec_bimwin" id="e_kec_bimwin"></select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Status Pegawai</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_pegawai_bimwin" id="e_pegawai_bimwin">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="13">PNS</option>
                                        <option value="14">CPNS</option>
                                        <option value="15">PPPK</option>
                                        <option value="16">PPNPN</option>
                                        <option value="17">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Jabatan</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_jbtn_bimwin" id="e_jbtn_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Golongan</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_gol_bimwin" id="e_gol_bimwin">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="101">I/a</option>
                                        <option value="102">I/b</option>
                                        <option value="103">I/c</option>
                                        <option value="104">I/d</option>
                                        <option value="105">II/a</option>
                                        <option value="106">II/b</option>
                                        <option value="107">II/c</option>
                                        <option value="108">II/d</option>
                                        <option value="109">III/a</option>
                                        <option value="110">III/b</option>
                                        <option value="111">III/c</option>
                                        <option value="112">III/d</option>
                                        <option value="113">IV/a</option>
                                        <option value="114">IV/b</option>
                                        <option value="115">IV/c</option>
                                        <option value="116">IV/d</option>
                                        <option value="117">IX</option>
                                        <option value="118">X</option>
                                        <option value="119">XI</option>
                                        <option value="120">-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Instansi</b></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="e_inst_bimwin" id="e_inst_bimwin">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Alamat Kantor</b></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="e_kantor_bimwin" id="e_kantor_bimwin"></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Photo</b></label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="hidden" class="form-control" name="e_files_old" id="e_files_old">
                                        <input type="file" class="form-control" name="e_files_bimwin" id="e_files_bimwin" accept="image/png, image/gif, image/jpeg">
                                        <button class="btn btn-outline-secondary tutupPhoto" type="button" id="tutupfile" onclick="Page.Tutup(this.value)"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                        <button class="btn btn-outline-secondary lihatPhoto" type="button" id="lihatfile" onclick="Page.Lihat(this.value)"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                                    </div>
                                    <div class="form-text" id="basic-addon4" style="margin-top: -12px;">Hanya format (.jpg, .jpeg, .png).</div>
                                </div>
                            </div>

                            <div class="mb-3 row" id="contentphoto">
                                <label class="col-sm-3 col-form-label">
                                    {{-- <b>Preview Foto</b> --}}
                                </label>

                                <div class="col-sm-9">
                                    <div class="border rounded-4 p-3 bg-light">
                                        <div class="d-flex align-items-center">
                                            <img id="gambar_users"
                                                class="rounded-4 shadow"
                                                style="
                                                    width:140px;
                                                    height:140px;
                                                    object-fit:cover;
                                                ">

                                            <div class="ms-4">
                                                <h6 class="mb-2">
                                                    <i class="fas fa-image text-primary me-2"></i>
                                                    Photo Sebelumnya
                                                </h6>

                                                <p class="text-muted mb-2">
                                                    Photo ini akan tetap digunakan apabila kamu tidak memilih gambar baru.
                                                </p>

                                                <span class="badge bg-success">
                                                    Aktif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Surat Tugas</b></label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="hidden" class="form-control" name="e_files_surtug_old" id="e_files_surtug_old">
                                        <input type="file" class="form-control" name="e_files_surtug" id="e_files_surtug" accept=".pdf, .doc, .docx">
                                        <button class="btn btn-outline-secondary lihatSurtug" type="button" id="lihatfile_surtug" onclick="Page.LihatSurtug(this.value)"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                                    </div>
                                    <div class="form-text" id="basic-addon4" style="margin-top: -12px;">Hanya format (.pdf, .doc, .docx).</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><b>Status</b></label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="e_status" id="e_status">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="17">Data aktif</option>
                                        <option value="18">Data nonaktif</option>
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

<div class="modal fade" id="detailBrus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Biodata Diri</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Administratif</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Instansi</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    @include('backend.contents.fasilitator._tabbimwin')
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importBrus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Upload Data</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="import_kexcel">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Dokumen</b></label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="doks_excel" id="doks_excel" accept=".xlsx,.xls">
                            <div class="form-text" id="basic-addon4">Hanya format (.xlsx, .xls) atau excel.</div>
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