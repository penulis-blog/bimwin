<div class="modal fade" id="editSertifikat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Edit</h1>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="form_edit_sertifikat">
                    @csrf
                    <input type="hidden" class="form-control" name="e_st_publicid" id="e_st_publicid">
                    <input type="hidden" class="form-control" name="e_verifikasi_admin" id="is_verifikasi_admin">

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="info-section">
                                <small class="info-label">
                                    Nama Kegiatan
                                </small>
                                <div class="info-value fw-semibold" id="e_kgt"></div>
                            </div>

                            <hr class="my-3">

                            <!-- Detail -->
                            <div class="row gy-3">
                                <div class="col-lg-4">
                                    <div class="info-item">
                                        <i class="fas fa-building text-primary"></i>
                                        <div>
                                            <small>Tempat</small>
                                            <div id="e_tempat"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="info-item">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                        <div>
                                            <small>Lokasi</small>
                                            <div id="e_lokasi"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="info-item">
                                        <i class="fas fa-calendar-alt text-success"></i>
                                        <div>
                                            <small>Tanggal Pelaksanaan</small>
                                            <div>
                                                <span id="e_dari"></span>
                                                <span class="mx-2 text-muted">s.d</span>
                                                <span id="e_sampai"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>NIK</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_nik" id="e_nik">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Nama Lengkap</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_nama" id="e_nama">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Tempat Lahir</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_tmp" id="e_tmp">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control editlahir_sertifikat" name="e_tgl" id="e_tgl">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Jabatan</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_jbtn" id="e_jbtn">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Utusan/Satuan Kerja</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="e_satuan" id="e_satuan">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label"><b>Photo</b></label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" name="e_ktgr" id="e_ktgr">
                                <input type="hidden" class="form-control" name="e_st_files_old" id="e_st_files_old">
                                <input type="file" class="form-control" name="e_st_files" id="e_st_files" accept=".jpg,.jpeg,.png">
                                <button class="btn btn-outline-secondary tutupPhoto" type="button" id="tutupfile" onclick="Page.Tutup(this.value)" style="background-color: #000000; color:white;"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                                <button class="btn btn-outline-secondary lihatPhoto" type="button" id="lihatfile" onclick="Page.Lihat(this.value)" style="background-color: #198754; color:white;"><i class="fa fa-eye"></i>&nbsp;Lihat</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="contentphoto">
                        <label class="col-sm-3 col-form-label">
                            {{-- <b>Preview Foto</b> --}}
                        </label>

                        <div class="col-sm-9">
                            <div class="border rounded-4 p-3 bg-light">
                                <div class="d-flex align-items-center">
                                    <img id="gambar_galeri"
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="Page.Batal()"><i class="fa fa-times"></i>&nbsp;Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i>&nbsp;Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailKiriman" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <div class="compare-card">
                    <div class="compare-header">
                        <div class="compare-icon"><i class="fa fa-exchange-alt"></i></div>

                        <div class="compare-info">
                            <h5>Perbandingan Data</h5>
                            <p>Periksa perubahan data sebelum melakukan persetujuan.</p>

                            <div class="compare-meta">
                                <div class="meta-row">
                                    <div class="meta-col">
                                        <div class="meta-label"><i class="fa fa-book text-primary"></i> Kegiatan</div>
                                        <div class="meta-value" id="p_kegiatan"></div>
                                    </div>

                                    <div class="meta-col">
                                        <div class="meta-label"><i class="fa fa-calendar text-warning"></i> Pelaksanaan</div>
                                        <div class="meta-value" id="p_pelaksanaan"></div>
                                    </div>
                                </div>

                                <div class="meta-row">
                                    <div class="meta-col">
                                        <div class="meta-label"><i class="fa fa-building text-success"></i> Tempat</div>
                                        <div class="meta-value" id="p_tempat"></div>
                                    </div>

                                    <div class="meta-col">
                                        <div class="meta-label"><i class="fa fa-map-marker-alt text-danger"></i> Lokasi</div>
                                        <div class="meta-value" id="p_lokasi"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle compare-table">
                            <thead>
                                <tr>
                                    <th width="22%">Field</th>
                                    <th width="39%" class="text-center bg-light">Sebelumnya</th>
                                    <th width="39%" class="text-center bg-primary text-white">Perbaikan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><strong>Photo</strong></td>
                                    <td class="text-center">
                                        <div class="photo-box">
                                            <img id="old_photo" class="compare-photo">
                                            <div class="photo-label" id="ket_old_photo"></div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="photo-box">
                                            <img id="new_photo" class="compare-photo">
                                            <div class="photo-label" id="ket_photo_perbaikan">Foto Perbaikan</div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>NIK KTP</strong></td>
                                    <td id="old_nik"></td>
                                    <td id="new_nik"></td>
                                </tr>

                                <tr>
                                    <td><strong>Nama Lengkap</strong></td>
                                    <td id="old_nama"></td>
                                    <td id="new_nama"></td>
                                </tr>

                                <tr>
                                    <td><strong>Jabatan</strong></td>
                                    <td id="old_jabatan"></td>
                                    <td id="new_jabatan"></td>
                                </tr>

                                <tr>
                                    <td><strong>Utusan/Satuan Kerja</strong></td>
                                    <td id="old_instansi"></td>
                                    <td id="new_instansi"></td>
                                </tr>

                                <tr>
                                    <td><strong>Tempat Lahir</strong></td>
                                    <td id="old_tmp"></td>
                                    <td id="new_tmp"></td>
                                </tr>

                                <tr>
                                    <td><strong>Tanggal Lahir</strong></td>
                                    <td id="old_tgl"></td>
                                    <td id="new_tgl"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="compare-footer">
                        <form method="post" enctype="multipart/form-data" id="form_keputusan">
                            @csrf
                            <input type="hidden" class="form-control" name="id_keputusan" id="id_keputusan">
                            <input type="hidden" class="form-control" name="nik_asli" id="nik_asli" readonly>

                            <div class="row">
                                <div class="col-md-12 mb-3" id="catatan_admin">
                                    <div class="d-flex align-items-start gap-3 p-3 border rounded-3 bg-light">
                                        <div class="text-warning fs-4">
                                            <i class="fa fa-exclamation-triangle"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold mb-1" id="keterangan_status"></div>
                                            <div class="text-muted small mb-2">
                                                <b>Jika status dikembalikan,</b> maka peserta (yang mengajukan) masih bisa memperbaharui data sertifikat
                                                sesuai dengan ketentuan/catatan dari admin. <b>Apabila status ditolak,</b> maka pengajuan perbaharui
                                                data sertifikat tidak disetujui oleh admin.
                                            </div>
                                            <div class="fw-bold mb-1" style="font-size:14px;">Catatan dari admin:</div>
                                            <div class="text-muted small mb-2" id="catatan_pengembalian">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label fw-bold">Keputusan</label>
                                    <select class="form-select" id="keputusan" name="keputusan" onclick="Page.Keputusan(this.value)">
                                        <option value="">Pilih</option>
                                        <option value="33">Kembalikan</option>
                                        <option value="34">Tolak</option>
                                        <option value="35">Setujui</option>
                                    </select>
                                </div>

                                <div class="col-md-7 mb-3" id="stat_catatan">
                                    <label class="form-label fw-bold">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukan catatan jika dikembalikan atau ditolak..."></textarea>
                                </div>
                            </div>

                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-danger me-2" onclick="Page.Batal()">
                                    <i class="fa fa-times"></i> Batal
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailSertifikat_Pengajuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3" id="catatan_admin_dtl">
                        <div class="d-flex align-items-start gap-3 p-3 border rounded-3 bg-light">
                            <div class="text-warning fs-4">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1" id="keterangan_status_dtl"></div>
                                <div class="text-muted small mb-2">
                                    <b>Jika status dikembalikan,</b> maka peserta (yang mengajukan) masih bisa memperbaharui data sertifikat
                                        sesuai dengan ketentuan/catatan dari admin. <b>Apabila status ditolak,</b> maka pengajuan perbaharui
                                        data sertifikat perlu menunggu waktu 3x24 jam untuk bisa diajukan kembali.
                                </div>
                                <div class="fw-bold mb-1" style="font-size:14px;">Catatan dari admin:</div>
                                <div class="text-muted small mb-2" id="catatan_pengembalian_dtl">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="compare-card">
                    <div class="compare-header">
                        <div class="compare-icon"><i class="fa fa-exchange-alt"></i></div>

                        <div class="compare-info">
                            <h5>Perbandingan Data</h5>
                            <p>Periksa perubahan data sebelum melakukan persetujuan.</p>

                            <div class="compare-meta">
                                <div class="meta-row">
                                    <div class="meta-col">
                                        <div class="meta-label"><i class="fa fa-book text-primary"></i> Kegiatan</div>
                                        <div class="meta-value" id="p_kegiatan_dtl"></div>
                                    </div>

                                    <div class="meta-col">
                                        <div class="meta-label"><i class="fa fa-calendar text-warning"></i> Pelaksanaan</div>
                                        <div class="meta-value" id="p_pelaksanaan_dtl"></div>
                                    </div>
                                </div>

                                <div class="meta-row">
                                    <div class="meta-col">
                                        <div class="meta-label"><i class="fa fa-building text-success"></i> Tempat</div>
                                        <div class="meta-value" id="p_tempat_dtl"></div>
                                    </div>

                                    <div class="meta-col">
                                        <div class="meta-label"><i class="fa fa-map-marker-alt text-danger"></i> Lokasi</div>
                                        <div class="meta-value" id="p_lokasi_dtl"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle compare-table">
                            <thead>
                                <tr>
                                    <th width="22%">Field</th>
                                    <th width="39%" class="text-center bg-light">Sebelumnya</th>
                                    <th width="39%" class="text-center bg-primary text-white">Perbaikan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><strong>Photo</strong></td>
                                    <td class="text-center">
                                        <div class="photo-box">
                                            <img id="old_photo_dtl" class="compare-photo">
                                            <div class="photo-label" id="ket_old_photo_dtl">Belum ada foto</div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="photo-box">
                                            <img id="new_photo_dtl" class="compare-photo">
                                            <div class="photo-label" id="ket_photo_perbaikan_dtl">Tidak ada perbaikan</div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>NIK KTP</strong></td>
                                    <td id="old_nik_dtl"></td>
                                    <td id="new_nik_dtl"></td>
                                </tr>

                                <tr>
                                    <td><strong>Nama Lengkap</strong></td>
                                    <td id="old_nama_dtl"></td>
                                    <td id="new_nama_dtl"></td>
                                </tr>

                                <tr>
                                    <td><strong>Jabatan</strong></td>
                                    <td id="old_jabatan_dtl"></td>
                                    <td id="new_jabatan_dtl"></td>
                                </tr>

                                <tr>
                                    <td><strong>Utusan/Satuan Kerja</strong></td>
                                    <td id="old_instansi_dtl"></td>
                                    <td id="new_instansi_dtl"></td>
                                </tr>

                                <tr>
                                    <td><strong>Tempat Lahir</strong></td>
                                    <td id="old_tmp_dtl"></td>
                                    <td id="new_tmp_dtl"></td>
                                </tr>

                                <tr>
                                    <td><strong>Tanggal Lahir</strong></td>
                                    <td id="old_tgl_dtl"></td>
                                    <td id="new_tgl_dtl"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="compare-footer">
                        <div class="text-end">
                            <button type="button" class="btn btn-danger me-2" onclick="Page.Batal()">
                                <i class="fa fa-times"></i> Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailSertifikat_Admin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5">Detail</h1>
            </div>

            <div class="modal-body">
                {{--  --}}
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