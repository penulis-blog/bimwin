<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
  <div class="row">
    <!-- Kolom kiri (data) -->
    <div class="col-md-9">
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>ID Sertifikat</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_sertif"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Angkatan</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_angkatan"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Kegiatan</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_kegiatan"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>NIK KTP</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_nik"></p>
        </div>
      </div>

      <!-- data lain lanjut di bawah -->
      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Nama Lengkap</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_nama"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_tgl"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Jenis Kelamin</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_kelamin"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Alamat Rumah</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_rumah"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>No. HP</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_hp"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Email</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext" id="d_email"></p>
        </div>
      </div>

      <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Surat Tugas</b></label>
        <div class="col-sm-9">
          <p class="form-control-plaintext"><button type="button" class="btn btn-sm btn-primary" id="d_surtug" onclick="Page.DetailSurtug(this.value)"><i class="fa fa-eye"></i>&nbsp;Lihat</button></p>
        </div>
      </div>
    </div>

    <!-- Kolom kanan (foto) -->
    <div class="col-md-3 mt-2 d-flex justify-content-center align-items-start">
      <img id="d_foto" class="img-thumbnail img-fluid" style="object-fit:cover;">
    </div>
  </div>
</div>


<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>No. Rekening</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_rek"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Nama Bank</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_bank"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>NPWP</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_npwp"></p>
        </div>
    </div>
</div>

<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>NIP</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_nip"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Provinsi</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_prov"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Kabupaten</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_kab"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Kecamatan</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_kec"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Status Pegawai</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_peg"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Jabatan</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_jab"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Golongan</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_gol"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Instansi</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_inst"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Alamat Kantor</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_kantor"></p>
        </div>
    </div>

    <div class="mb-3 row">
        <label class="col-sm-3 col-form-label"><b>Status Data</b></label>
        <div class="col-sm-9">
            <p class="form-control-plaintext" id="d_stat"></p>
        </div>
    </div>
</div>