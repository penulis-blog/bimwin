<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_bimwin;
use Intervention\Image\ImageManager;
use PDF;

class C_bimwin extends Controller
{
    //------------------------------- Di bawah ini BIMWIN -------------------------------
    public function index()
    {
        return view("backend.layouts.fasilitator.bimwin");
    }

    public function angkatan($id)
    {
        $model  = new M_bimwin();
        $data   = $model->get_angkatan($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function jadwal()
    {
        $roles = new M_bimwin();
        $data = $roles->get_jadwal();

        $result = [
            "data" => $data,
        ];

        return response()->json($result);
    }

    public function unduh($id)
    {
        $data    = M_bimwin::get_sertifikat($id);

        if(!empty($data)){
            $rincian = M_bimwin::get_sertifikat_rincian($data->id_template);
            $total   = $rincian->sum('total');

            $pdf = \PDF::loadView('backend.contents.fasilitator.report.bimwin.sertifikat', [
                'peserta' => $data,
                'rincian' => $rincian,
                'total' => $total
            ], [], [
                'format' => 'A4',
                'orientation' => 'L',
                'margin_left'   => 0,
                'margin_right'  => 0,
                'margin_top'    => 0,
                'margin_bottom' => 0,
            ]);

            return $pdf->stream('sertifikat-' . $data->nama . '.pdf');
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function report($id)
    {
        $peserta = M_bimwin::get_report($id);

        $pdf = \PDF::loadView('backend.contents.fasilitator.report.bimwin.peserta', [
            'peserta' => $peserta
        ], [], [
            'format' => [210, 330]
        ]);

        return $pdf->stream('document.pdf');
    }

    public function detail($id)
    {
        $data = M_bimwin::get_view($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 'success',
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
    }

    public function edit($id)
    {
        $data = M_bimwin::get_data($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 'success',
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
    }

    public function __update(Request $request)
    {
        $id          = $request->input('e_publicid');
        $photo_baru  = $request->hasFile('e_files_bimwin');
        $photo_lama  = $request->input('e_files_old');
        $surtug_baru = $request->hasFile('e_files_surtug');
        $surtug_lama = $request->input('e_files_surtug_old');
        $ekeg        = $request->input("e_keg_bimwin");
        $enik        = $request->input("e_nik_bimwin");
        $eang        = $request->input("e_angkatan_bimwin");

        $_models    = new M_bimwin();
        $_data_     = $_models->get_data($id);
        $extends    = $_models->get_daftar($ekeg, $enik, $eang);

        if($ekeg == $_data_->id_kegiatan && $enik == $_data_->nik && $eang == $_data_->angkatan){
            if($photo_baru == false && $surtug_baru == false){
                $data = [
                    "id_kegiatan" => $request->input("e_keg_bimwin") ?: null,
                    "nik" => $request->input("e_nik_bimwin"),
                    "nama" => $request->input("e_nama_bimwin"),
                    "lahir" => $request->input("e_tmp_bimwin") ?: null,
                    "tgl" => $request->input("e_tgl_bimwin") ?: null,
                    "jkl" => $request->input("e_jk_bimwin") ?: null,
                    "alamat_rumah" => $request->input("e_domisili_bimwin") ?: null,
                    "no_hp" => $request->input("e_hp_bimwin"),
                    "email" => $request->input("e_email_bimwin") ?: null,
                    "no_rek" => $request->input("e_rek_bimwin"),
                    "nm_bank" => $request->input("e_nm_bimwin") ?: null,
                    "npwp" => $request->input("e_npwp_bimwin"),
                    "nip" => $request->input("e_nip_bimwin"),
                    "id_provinsi" => $request->input("e_prov_bimwin") ?: null,
                    "id_kabupaten" => $request->input("e_kab_bimwin") ?: null,
                    "id_kecamatan" => $request->input("e_kec_bimwin") ?: null,
                    "is_pegawai" => $request->input("e_pegawai_bimwin") ?: null,
                    "jabatan" => $request->input("e_jbtn_bimwin") ?: null,
                    "golongan" => $request->input("e_gol_bimwin") ?: null,
                    "instansi" => $request->input("e_inst_bimwin") ?: null,
                    "alamat_kantor" => $request->input("e_kantor_bimwin") ?: null,
                    "angkatan" => $request->input("e_angkatan_bimwin"),
                    "is_trash" => $request->input("e_status") ?: null,
                    "updated" => auth()->user()->id,
                    "updated_date" => date("Y-m-d H:i:s"),
                ];

                if(!empty($data)){
                    DB::table('dt_form')->where('public_id', $id)->update($data);

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }
            }else{
                // Ambil data lama dulu
                $oldData = DB::table('dt_form')->where('public_id', $id)->first();

                $filename = null;
                $surtug_filename = null;

                if ($request->hasFile('e_files_bimwin')) {
                    $file = $request->file('e_files_bimwin');

                    // nama unik file
                    $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                    $path = storage_path('app/public/bimwin/' . $filename);

                    // bikin folder kalau belum ada
                    if (!file_exists(dirname($path))) {
                        mkdir(dirname($path), 0755, true);
                    }

                    // pakai ImageManager (v3)
                    $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
                    $image = $manager->read($file)->resize(472, 709, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    // simpan file baru
                    $quality = 90;
                    $image->toJpeg($quality)->save($path);

                    // kompresi ke target 850 KB
                    $targetSize = 850 * 1024;
                    while (filesize($path) > $targetSize && $quality > 10) {
                        $quality -= 5;
                        $image->toJpeg($quality)->save($path);
                    }

                    // Hapus foto lama kalau ada
                    if (!empty($oldData->files) && file_exists(storage_path('app/public/' . $oldData->files))) {
                        unlink(storage_path('app/public/' . $oldData->files));
                    }
                }

                if ($surtug_baru) {

                    $file_s = $request->file('e_files_surtug');

                    // nama unik
                    $surtug_filename = Str::uuid()->toString() . '.' . $file_s->getClientOriginalExtension();
                    $surtug_path = storage_path('app/public/bimwin/' . $surtug_filename);

                    // bikin folder kalau belum ada
                    if (!file_exists(dirname($surtug_path))) {
                        mkdir(dirname($surtug_path), 0755, true);
                    }

                    // Simpan file langsung (bukan gambar, jadi tidak resize)
                    file_put_contents($surtug_path, file_get_contents($file_s));

                    // hapus file lama jika ada
                    if (!empty($oldData->files_surtug) && file_exists(storage_path('app/public/' . $oldData->files_surtug))) {
                        unlink(storage_path('app/public/' . $oldData->files_surtug));
                    }
                }

                $data = [
                    "id_kegiatan" => $request->input("e_keg_bimwin") ?: null,
                    "nik" => $request->input("e_nik_bimwin"),
                    "nama" => $request->input("e_nama_bimwin"),
                    "lahir" => $request->input("e_tmp_bimwin") ?: null,
                    "tgl" => $request->input("e_tgl_bimwin") ?: null,
                    "jkl" => $request->input("e_jk_bimwin") ?: null,
                    "alamat_rumah" => $request->input("e_domisili_bimwin") ?: null,
                    "no_hp" => $request->input("e_hp_bimwin"),
                    "email" => $request->input("e_email_bimwin") ?: null,
                    "no_rek" => $request->input("e_rek_bimwin"),
                    "nm_bank" => $request->input("e_nm_bimwin") ?: null,
                    "npwp" => $request->input("e_npwp_bimwin"),
                    "nip" => $request->input("e_nip_bimwin"),
                    "id_provinsi" => $request->input("e_prov_bimwin") ?: null,
                    "id_kabupaten" => $request->input("e_kab_bimwin") ?: null,
                    "id_kecamatan" => $request->input("e_kec_bimwin") ?: null,
                    "is_pegawai" => $request->input("e_pegawai_bimwin") ?: null,
                    "jabatan" => $request->input("e_jbtn_bimwin") ?: null,
                    "golongan" => $request->input("e_gol_bimwin") ?: null,
                    "instansi" => $request->input("e_inst_bimwin") ?: null,
                    "alamat_kantor" => $request->input("e_kantor_bimwin") ?: null,
                    "files" => $filename ? 'bimwin/' . $filename : $oldData->files, // tetap pakai foto lama kalau tidak upload baru
                    "files_surtug" => $surtug_filename ? 'bimwin/' . $surtug_filename : $oldData->files_surtug,
                    "angkatan" => $request->input("e_angkatan_bimwin"),
                    "is_trash" => $request->input("e_status") ?: null,
                    "updated" => auth()->user()->id,
                    "updated_date" => date("Y-m-d H:i:s"),
                ];

                DB::table('dt_form')->where('public_id', $id)->update($data);

                return response()->json(['message' => 200]);
            }
        }else{
            if($extends){
                $result = [
                    "message" => 404,
                ];

                return response()->json($result);
            }else{
                if($photo_baru == false){
                    $data = [
                        "id_kegiatan" => $request->input("e_keg_bimwin") ?: null,
                        "nik" => $request->input("e_nik_bimwin"),
                        "nama" => $request->input("e_nama_bimwin"),
                        "lahir" => $request->input("e_tmp_bimwin") ?: null,
                        "tgl" => $request->input("e_tgl_bimwin") ?: null,
                        "jkl" => $request->input("e_jk_bimwin") ?: null,
                        "alamat_rumah" => $request->input("e_domisili_bimwin") ?: null,
                        "no_hp" => $request->input("e_hp_bimwin"),
                        "email" => $request->input("e_email_bimwin") ?: null,
                        "no_rek" => $request->input("e_rek_bimwin"),
                        "nm_bank" => $request->input("e_nm_bimwin") ?: null,
                        "npwp" => $request->input("e_npwp_bimwin"),
                        "nip" => $request->input("e_nip_bimwin"),
                        "id_provinsi" => $request->input("e_prov_bimwin") ?: null,
                        "id_kabupaten" => $request->input("e_kab_bimwin") ?: null,
                        "id_kecamatan" => $request->input("e_kec_bimwin") ?: null,
                        "is_pegawai" => $request->input("e_pegawai_bimwin") ?: null,
                        "jabatan" => $request->input("e_jbtn_bimwin") ?: null,
                        "golongan" => $request->input("e_gol_bimwin") ?: null,
                        "instansi" => $request->input("e_inst_bimwin") ?: null,
                        "alamat_kantor" => $request->input("e_kantor_bimwin") ?: null,
                        "angkatan" => $request->input("e_angkatan_bimwin"),
                        "is_trash" => $request->input("e_status") ?: null,
                        "updated" => auth()->user()->id,
                        "updated_date" => date("Y-m-d H:i:s"),
                    ];

                    if(!empty($data)){
                        DB::table('dt_form')->where('public_id', $id)->update($data);

                        $result = [
                            'message' => 200
                        ];

                        return response()->json($result);
                    }
                }else{
                    // Ambil data lama dulu
                    $oldData = DB::table('dt_form')->where('public_id', $id)->first();

                    $filename = null;

                    if ($request->hasFile('e_files_bimwin')) {
                        $file = $request->file('e_files_bimwin');

                        // nama unik file
                        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                        $path = storage_path('app/public/bimwin/' . $filename);

                        // bikin folder kalau belum ada
                        if (!file_exists(dirname($path))) {
                            mkdir(dirname($path), 0755, true);
                        }

                        // pakai ImageManager (v3)
                        $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
                        $image = $manager->read($file)->resize(472, 709, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        // simpan file baru
                        $quality = 90;
                        $image->toJpeg($quality)->save($path);

                        // kompresi ke target 850 KB
                        $targetSize = 850 * 1024;
                        while (filesize($path) > $targetSize && $quality > 10) {
                            $quality -= 5;
                            $image->toJpeg($quality)->save($path);
                        }

                        // Hapus foto lama kalau ada
                        if (!empty($oldData->files) && file_exists(storage_path('app/public/' . $oldData->files))) {
                            unlink(storage_path('app/public/' . $oldData->files));
                        }
                    }

                    $data = [
                        "id_kegiatan" => $request->input("e_keg_bimwin") ?: null,
                        "nik" => $request->input("e_nik_bimwin"),
                        "nama" => $request->input("e_nama_bimwin"),
                        "lahir" => $request->input("e_tmp_bimwin") ?: null,
                        "tgl" => $request->input("e_tgl_bimwin") ?: null,
                        "jkl" => $request->input("e_jk_bimwin") ?: null,
                        "alamat_rumah" => $request->input("e_domisili_bimwin") ?: null,
                        "no_hp" => $request->input("e_hp_bimwin"),
                        "email" => $request->input("e_email_bimwin") ?: null,
                        "no_rek" => $request->input("e_rek_bimwin"),
                        "nm_bank" => $request->input("e_nm_bimwin") ?: null,
                        "npwp" => $request->input("e_npwp_bimwin"),
                        "nip" => $request->input("e_nip_bimwin"),
                        "id_provinsi" => $request->input("e_prov_bimwin") ?: null,
                        "id_kabupaten" => $request->input("e_kab_bimwin") ?: null,
                        "id_kecamatan" => $request->input("e_kec_bimwin") ?: null,
                        "is_pegawai" => $request->input("e_pegawai_bimwin") ?: null,
                        "jabatan" => $request->input("e_jbtn_bimwin") ?: null,
                        "golongan" => $request->input("e_gol_bimwin") ?: null,
                        "instansi" => $request->input("e_inst_bimwin") ?: null,
                        "alamat_kantor" => $request->input("e_kantor_bimwin") ?: null,
                        "files" => $filename ? 'bimwin/' . $filename : $oldData->files, // tetap pakai foto lama kalau tidak upload baru
                        "angkatan" => $request->input("e_angkatan_bimwin"),
                        "is_trash" => $request->input("e_status") ?: null,
                        "updated" => auth()->user()->id,
                        "updated_date" => date("Y-m-d H:i:s"),
                    ];

                    DB::table('dt_form')->where('public_id', $id)->update($data);

                    return response()->json(['message' => 200]);
                }
            }
        }
    }

    public function update(Request $request)
    {
        $id          = $request->input('e_publicid');
        $photo_baru  = $request->hasFile('e_files_bimwin');
        $surtug_baru = $request->hasFile('e_files_surtug');

        $ekeg = $request->input("e_keg_bimwin");
        $enik = $request->input("e_nik_bimwin");
        $enip = $request->input("e_nip_bimwin");
        $eang = $request->input("e_angkatan_bimwin");

        $_models = new M_bimwin();
        $_data_  = $_models->get_data($id);

        // if (
        //     $ekeg != $_data_->id_kegiatan ||
        //     $enik != $_data_->nik ||
        //     $enip != $_data_->nip
        // ) {
        //     return response()->json(['message' => 404]);
        // }

        $exists = DB::table('dt_form')
            ->where('nik', $enik)
            ->where('id', '!=', $_data_->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 404]);
        }

        $baseData = [
            "id_kegiatan"   => $ekeg ?: null,
            "nik"           => $enik,
            "nama"          => $request->input("e_nama_bimwin"),
            "lahir"         => $request->input("e_tmp_bimwin") ?: null,
            "tgl"           => $request->input("e_tgl_bimwin") ?: null,
            "jkl"           => $request->input("e_jk_bimwin") ?: null,
            "alamat_rumah"  => $request->input("e_domisili_bimwin") ?: null,
            "no_hp"         => $request->input("e_hp_bimwin"),
            "email"         => $request->input("e_email_bimwin") ?: null,
            "no_rek"        => $request->input("e_rek_bimwin"),
            "nm_bank"       => $request->input("e_nm_bimwin") ?: null,
            "npwp"          => $request->input("e_npwp_bimwin"),
            "nip"           => $request->input("e_nip_bimwin"),
            "id_provinsi"   => $request->input("e_prov_bimwin") ?: null,
            "id_kabupaten"  => $request->input("e_kab_bimwin") ?: null,
            "id_kecamatan"  => $request->input("e_kec_bimwin") ?: null,
            "is_pegawai"    => $request->input("e_pegawai_bimwin") ?: null,
            "jabatan"       => $request->input("e_jbtn_bimwin") ?: null,
            "golongan"      => $request->input("e_gol_bimwin") ?: null,
            "instansi"      => $request->input("e_inst_bimwin") ?: null,
            "alamat_kantor" => $request->input("e_kantor_bimwin") ?: null,
            "angkatan"      => $eang,
            "is_trash"      => $request->input("e_status") ?: null,
            "updated"       => auth()->user()->id,
            "updated_date"  => date("Y-m-d H:i:s"),
        ];

        if ($ekeg == $_data_->id_kegiatan && $enik == $_data_->nik && $eang == $_data_->angkatan) {

            if (!$photo_baru && !$surtug_baru) {
                DB::table('dt_form')->where('public_id', $id)->update($baseData);
                return response()->json(['message' => 200]);
            }

            $oldData = DB::table('dt_form')->where('public_id', $id)->first();
            $filename = null;
            $surtug_filename = null;

            // === FOTO ===
            if ($photo_baru) {
                $file = $request->file('e_files_bimwin');
                $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
                $path = storage_path('app/public/bimwin/'.$filename);

                if (!file_exists(dirname($path))) mkdir(dirname($path),0755,true);

                $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
                $image = $manager->read($file)->resize(472,709,function($c){
                    $c->aspectRatio(); $c->upsize();
                });

                $quality = 90;
                $image->toJpeg($quality)->save($path);

                while (filesize($path) > 850*1024 && $quality > 10) {
                    $quality -= 5;
                    $image->toJpeg($quality)->save($path);
                }

                if ($oldData->files && file_exists(storage_path('app/public/'.$oldData->files))) {
                    unlink(storage_path('app/public/'.$oldData->files));
                }
            }

            // === SURTUG ===
            if ($surtug_baru) {
                $file = $request->file('e_files_surtug');
                $surtug_filename = Str::uuid().'.'.$file->getClientOriginalExtension();
                $path = storage_path('app/public/bimwin/'.$surtug_filename);

                if (!file_exists(dirname($path))) mkdir(dirname($path),0755,true);

                file_put_contents($path, file_get_contents($file));

                if ($oldData->files_surtug && file_exists(storage_path('app/public/'.$oldData->files_surtug))) {
                    unlink(storage_path('app/public/'.$oldData->files_surtug));
                }
            }

            $baseData['files'] = $filename ? 'bimwin/'.$filename : $oldData->files;
            $baseData['files_surtug'] = $surtug_filename ? 'bimwin/'.$surtug_filename : $oldData->files_surtug;

            DB::table('dt_form')->where('public_id', $id)->update($baseData);
            return response()->json(['message' => 200]);
        }

        if (!$photo_baru) {
            DB::table('dt_form')->where('public_id', $id)->update($baseData);
            return response()->json(['message' => 200]);
        }

        $oldData = DB::table('dt_form')->where('public_id', $id)->first();
        $filename = null;

        if ($photo_baru) {
            $file = $request->file('e_files_bimwin');
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = storage_path('app/public/bimwin/'.$filename);

            if (!file_exists(dirname($path))) mkdir(dirname($path),0755,true);

            $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
            $image = $manager->read($file)->resize(472,709,function($c){
                $c->aspectRatio(); $c->upsize();
            });

            $image->toJpeg(90)->save($path);

            if ($oldData->files && file_exists(storage_path('app/public/'.$oldData->files))) {
                unlink(storage_path('app/public/'.$oldData->files));
            }
        }

        $baseData['files'] = $filename ? 'bimwin/'.$filename : $oldData->files;
        DB::table('dt_form')->where('public_id', $id)->update($baseData);

        return response()->json(['message' => 200]);
    }

    public function post(Request $request)
    {
        $photo      = $request->hasFile("files_bimwin");
        $surtug     = $request->hasFile("files_surtug");
        $id_form    = $request->input("keg_bimwin");
        $nik        = $request->input("nik_bimwin");
        $nip        = $request->input("nip_bimwin");
        $angkatan   = $request->input("angkatan_bimwin");
        
        $model      = new M_bimwin();
        $peserta    = $model->get_daftar($id_form, $nik, $nip, $angkatan);
        $folder     = $model->get_folder($id_form);

        $mapFolder = [
            451 => 'bimwin',
            452 => 'brus',
            453 => 'jejaring-lokal',
            454 => 'konsultasi-dan-pendampingan-keluarga',
            455 => 'relasi-harmonis',
            456 => 'keuangan-keluarga',
            457 => 'peer-educator',
            458 => 'cegah-kawin-anak',
            459 => 'literasi-keuangan',
        ];

        if ($peserta) {
            return response()->json(["message" => 404]);
        }

        // Folder untuk penyimpanan
        $folderId   = $folder ? $folder->kategori : null;
        $namaFolder = $mapFolder[$folderId] ?? 'bimwin';

        // Default hasil upload
        $filenameFoto   = 'default.jpg';
        $filenameSurtug = null;

        if ($surtug) {
            $fileSurtug = $request->file('files_surtug');
            $ext = strtolower($fileSurtug->getClientOriginalExtension());
            $allowed = ['pdf', 'doc', 'docx'];

            if (!in_array($ext, $allowed)) {
                return response()->json([
                    "message" => 400,
                    "error"   => "Surat tugas harus PDF/DOC/DOCX"
                ]);
            }

            $filenameSurtug = Str::uuid()->toString() . '.' . $ext;

            $fileSurtug->storeAs(
                $namaFolder,
                $filenameSurtug,
                'public'
            );
        }

        if ($photo) {
            $file = $request->file('files_bimwin');
            $filenameFoto = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

            $path = storage_path('app/public/' . $namaFolder . '/' . $filenameFoto);

            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            // Resize & compress
            $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);

            $image = $manager->read($file)->resize(472, 709, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $quality = 90;
            $image->toJpeg($quality)->save($path);

            // Max 850 KB
            $targetSize = 850 * 1024;
            while (filesize($path) > $targetSize && $quality > 10) {
                $quality -= 5;
                $image->toJpeg($quality)->save($path);
            }
        }

        $data = [
            "public_id"      => Str::uuid()->toString(),
            "id_kegiatan"    => $request->input("keg_bimwin"),
            "id_provinsi"    => $request->input("prov_bimwin") ?: null,
            "id_kabupaten"   => $request->input("kab_bimwin") ?: null,
            "id_kecamatan"   => $request->input("kec_bimwin") ?: null,
            "nama"           => $request->input("nama_bimwin") ?: null,
            "lahir"          => $request->input("tmp_bimwin") ?: null,
            "tgl"            => $request->input("tgl_bimwin") ?: null,
            "jkl"            => $request->input("jk_bimwin") ?: null,
            "nik"            => $request->input("nik_bimwin"),
            "nip"            => $request->input("nip_bimwin"),
            "jabatan"        => $request->input("jbtn_bimwin") ?: null,
            "golongan"       => $request->input("gol_bimwin") ?: null,
            "instansi"       => $request->input("inst_bimwin") ?: null,
            "alamat_kantor"  => $request->input("kantor_bimwin") ?: null,
            "alamat_rumah"   => $request->input("domisili_bimwin") ?: null,
            "no_hp"          => $request->input("hp_bimwin"),
            "email"          => $request->input("email_bimwin") ?: null,
            "npwp"           => $request->input("npwp_bimwin"),
            "no_rek"         => $request->input("rek_bimwin"),
            "nm_bank"        => $request->input("nm_bimwin") ?: null,

            // FOTO (default, upload, atau resize)
            "files" => $photo ? ($namaFolder . '/' . $filenameFoto) : 'default.jpg',

            // SURAT TUGAS (boleh null)
            "files_surtug"   => $filenameSurtug ? ($namaFolder . '/' . $filenameSurtug) : null,

            "is_pegawai"     => $request->input("pegawai_bimwin") ?: null,
            "angkatan"       => $request->input("angkatan_bimwin"),
            "is_trash"       => 17,
            "created"        => auth()->user()->id,
            "created_date"   => date("Y-m-d H:i:s"),
        ];

        $id_ = DB::table("dt_form")->insertGetId($data);

        $noSertifikat =
            "BKS/SERTIF/" .
            $id_ . "/" .
            $request->input("keg_bimwin") . "/" .
            strtoupper(uniqid() . Str::random(4)) . "/" .
            date("Y");

        DB::table("dt_sertifikat")->insert([
            "public_id"      => Str::uuid()->toString(),
            "id_form"        => $id_,
            "no_sertifikat"  => $noSertifikat,
            "is_trash"       => 1,
            "created"        => auth()->user()->id,
            "created_date"   => date("Y-m-d H:i:s"),
        ]);

        return response()->json([
            "message"        => 200,
            "no_sertifikat"  => $noSertifikat,
        ]);
    }

    public function delete(Request $request)
    {
        $id     = $request->input('val');
        $data   = [
            'is_trash' => 18,
            'deleted' => auth()->user()->id,
            'deleted_date' => date('Y-m-d H:i:s')
        ];

        if (!empty($id) && !empty($data)) {
            DB::table('dt_form')->where('public_id', $id)->update($data);

            $result = [
                'message' => 200
            ];

            return response()->json($result);
        } else {
            $result = [
                'message' => 201
            ];

            return response()->json($result);
        }
    }

    public function json(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $this_ = Permissions::id_data();
        $model = new M_bimwin();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Hapus cache setelah update DB ---
        Permissions::forget_cache($publicId);

        $query = DB::table("view_peserta")->where([['is_trash', '!=', '18'], ['kategori', '=', '451']]); // bimwin

        // --- Filter role ---
        if (!in_array($roles, [1, 12])) {
            // Hanya tampil data sesuai id_direktorat dan id_subdit user, jika ada
            if ($exec->id_direktorat) {
                $query->where("id_direktorat", $exec->id_direktorat);
            }
            if ($exec->id_subdit) {
                $query->where("id_subdit", $exec->id_subdit);
            }
        }

        $cacheKeyTotal = "peserta_total_{$roles}_{$exec->id_direktorat}_{$exec->id_subdit}";
        $recordsTotal = Cache::remember($cacheKeyTotal, 300, fn() => $query->count());

        // --- Filter search ---
        if ($search) {
            $searchColumns = ["nama", "judul_acara", "provinsi"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
            ->select("id", "public_id", "judul_acara", "keterangan_angkatan", "provinsi", "kabupaten", "kecamatan", "nama", "is_trash")
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function($row) use ($permissions_icon, $roles, &$start) {
                $start++;

                $actionFuncs = [
                    "get_detail","get_edit","get_delete","get_password",
                    "get_agree","get_back","get_config","get_modules","get_download"
                ];

                $action = $row->is_trash == 18
                    ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                        return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    }, '');

                return [
                    "DT_RowIndex" => $start,
                    "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                    "keterangan_angkatan" => $row->keterangan_angkatan,
                    "provinsi"    => $row->provinsi,
                    "kabupaten"   => $row->kabupaten,
                    "kecamatan"   => $row->kecamatan,
                    "nama"        => $row->nama,
                    "aksi"        => $action,
                ];
            });

        return response()->json([
            "draw"            => intval($request->get("draw")),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

    //------------------------------- Di bawah ini LAYANAN KONSULTASI dan PENDAMPINGAN KELUARGA -------------------------------
    public function index_keluarga()
    {
        return view("backend.layouts.fasilitator.keluarga");
    }

    public function json_keluarga(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $this_ = Permissions::id_data();
        $model = new M_bimwin();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "27233f1c-bde2-4d61-9ae5-607a55c438a1";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Hapus cache setelah update DB ---
        Permissions::forget_cache($publicId);

        // --- Build query langsung ---
        $query = DB::table("view_peserta")->where([['is_trash', '!=', '18'], ['kategori', '=', '454']]); // layanan konsultasi dan pendampingan keluarga

        // --- Filter role ---
        if (!in_array($roles, [1, 12])) {
            // Hanya tampil data sesuai id_direktorat dan id_subdit user, jika ada
            if ($exec->id_direktorat) {
                $query->where("id_direktorat", $exec->id_direktorat);
            }
            if ($exec->id_subdit) {
                $query->where("id_subdit", $exec->id_subdit);
            }
        }

        // --- Caching total records tanpa filter (5 menit) ---
        $cacheKeyTotal = "peserta_total_{$roles}_{$exec->id_direktorat}_{$exec->id_subdit}";
        $recordsTotal = Cache::remember($cacheKeyTotal, 300, fn() => $query->count());

        // --- Filter search ---
        if ($search) {
            $searchColumns = ["nama", "judul_acara", "provinsi"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
            ->select("id", "public_id", "judul_acara", "keterangan_angkatan", "provinsi", "kabupaten", "kecamatan", "nama", "is_trash")
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function($row) use ($permissions_icon, $roles, &$start) {
                $start++;

                $actionFuncs = [
                    "get_detail","get_edit","get_delete","get_password",
                    "get_agree","get_back","get_config","get_modules","get_download"
                ];

                $action = $row->is_trash == 18
                    ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                        return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    }, '');

                return [
                    "DT_RowIndex" => $start,
                    "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                    "keterangan_angkatan" => $row->keterangan_angkatan,
                    "provinsi"    => $row->provinsi,
                    "kabupaten"   => $row->kabupaten,
                    "kecamatan"   => $row->kecamatan,
                    "nama"        => $row->nama,
                    "aksi"        => $action,
                ];
            });

        return response()->json([
            "draw"            => intval($request->get("draw")),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

    //------------------------------- Di bawah ini LITERASI KEUANGAN -------------------------------
    public function index_literasi()
    {
        return view("backend.layouts.fasilitator.literasi");
    }

    public function json_literasi(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $this_ = Permissions::id_data();
        $model = new M_bimwin();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "3001d448-f003-4036-ab60-2a75bbb1cd55";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Hapus cache setelah update DB ---
        Permissions::forget_cache($publicId);

        // --- Build query langsung ---
        $query = DB::table("view_peserta")->where([['is_trash', '!=', '18'], ['kategori', '=', '459']]); // literasi keuangan

        // --- Filter role ---
        if (!in_array($roles, [1, 12])) {
            // Hanya tampil data sesuai id_direktorat dan id_subdit user, jika ada
            if ($exec->id_direktorat) {
                $query->where("id_direktorat", $exec->id_direktorat);
            }
            if ($exec->id_subdit) {
                $query->where("id_subdit", $exec->id_subdit);
            }
        }

        // --- Caching total records tanpa filter (5 menit) ---
        $cacheKeyTotal = "peserta_total_{$roles}_{$exec->id_direktorat}_{$exec->id_subdit}";
        $recordsTotal = Cache::remember($cacheKeyTotal, 300, fn() => $query->count());

        // --- Filter search ---
        if ($search) {
            $searchColumns = ["nama", "judul_acara", "provinsi"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
            ->select("id", "public_id", "judul_acara", "keterangan_angkatan", "provinsi", "kabupaten", "kecamatan", "nama", "is_trash")
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function($row) use ($permissions_icon, $roles, &$start) {
                $start++;

                $actionFuncs = [
                    "get_detail","get_edit","get_delete","get_password",
                    "get_agree","get_back","get_config","get_modules","get_download"
                ];

                $action = $row->is_trash == 18
                    ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                        return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    }, '');

                return [
                    "DT_RowIndex" => $start,
                    "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                    "keterangan_angkatan" => $row->keterangan_angkatan,
                    "provinsi"    => $row->provinsi,
                    "kabupaten"   => $row->kabupaten,
                    "kecamatan"   => $row->kecamatan,
                    "nama"        => $row->nama,
                    "aksi"        => $action,
                ];
            });

        return response()->json([
            "draw"            => intval($request->get("draw")),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

    //------------------------------- Di bawah ini BRUS -------------------------------
    public function index_brus()
    {
        return view("backend.layouts.fasilitator.brus");
    }

    public function json_brus(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $this_ = Permissions::id_data();
        $model = new M_bimwin();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "95b14b0d-2312-4907-8e96-d7db14f2919c";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Hapus cache setelah update DB ---
        Permissions::forget_cache($publicId);

        // --- Build query langsung ---
        $query = DB::table("view_peserta")->where([['is_trash', '!=', '18'], ['kategori', '=', '452']]); // brus

        // --- Filter role ---
        if (!in_array($roles, [1, 12])) {
            // Hanya tampil data sesuai id_direktorat dan id_subdit user, jika ada
            if ($exec->id_direktorat) {
                $query->where("id_direktorat", $exec->id_direktorat);
            }
            if ($exec->id_subdit) {
                $query->where("id_subdit", $exec->id_subdit);
            }
        }

        // --- Caching total records tanpa filter (5 menit) ---
        $cacheKeyTotal = "peserta_total_{$roles}_{$exec->id_direktorat}_{$exec->id_subdit}";
        $recordsTotal = Cache::remember($cacheKeyTotal, 300, fn() => $query->count());

        // --- Filter search ---
        if ($search) {
            $searchColumns = ["nama", "judul_acara", "provinsi"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
            ->select("id", "public_id", "judul_acara", "keterangan_angkatan", "provinsi", "kabupaten", "kecamatan", "nama", "is_trash")
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function($row) use ($permissions_icon, $roles, &$start) {
                $start++;

                $actionFuncs = [
                    "get_detail","get_edit","get_delete","get_password",
                    "get_agree","get_back","get_config","get_modules","get_download"
                ];

                $action = $row->is_trash == 18
                    ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                        return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    }, '');

                return [
                    "DT_RowIndex" => $start,
                    "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                    "keterangan_angkatan" => $row->keterangan_angkatan,
                    "provinsi"    => $row->provinsi,
                    "kabupaten"   => $row->kabupaten,
                    "kecamatan"   => $row->kecamatan,
                    "nama"        => $row->nama,
                    "aksi"        => $action,
                ];
            });

        return response()->json([
            "draw"            => intval($request->get("draw")),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

    //------------------------------- Di bawah ini JEJARING LOKAL -------------------------------
    public function index_jejaring()
    {
        return view("backend.layouts.fasilitator.jejaring");
    }

    public function json_jejaring(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $this_ = Permissions::id_data();
        $model = new M_bimwin();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "10d32286-7ccf-4edc-90b0-769a88a6e0f0";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Hapus cache setelah update DB ---
        Permissions::forget_cache($publicId);

        // --- Build query langsung ---
        $query = DB::table("view_peserta")->where([['is_trash', '!=', '18'], ['kategori', '=', '453']]); // jejaring lokal

        // --- Filter role ---
        if (!in_array($roles, [1, 12])) {
            // Hanya tampil data sesuai id_direktorat dan id_subdit user, jika ada
            if ($exec->id_direktorat) {
                $query->where("id_direktorat", $exec->id_direktorat);
            }
            if ($exec->id_subdit) {
                $query->where("id_subdit", $exec->id_subdit);
            }
        }

        // --- Caching total records tanpa filter (5 menit) ---
        $cacheKeyTotal = "peserta_total_{$roles}_{$exec->id_direktorat}_{$exec->id_subdit}";
        $recordsTotal = Cache::remember($cacheKeyTotal, 300, fn() => $query->count());

        // --- Filter search ---
        if ($search) {
            $searchColumns = ["nama", "judul_acara", "provinsi"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
            ->select("id", "public_id", "judul_acara", "keterangan_angkatan", "provinsi", "kabupaten", "kecamatan", "nama", "is_trash")
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function($row) use ($permissions_icon, $roles, &$start) {
                $start++;

                $actionFuncs = [
                    "get_detail","get_edit","get_delete","get_password",
                    "get_agree","get_back","get_config","get_modules","get_download"
                ];

                $action = $row->is_trash == 18
                    ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                        return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    }, '');

                return [
                    "DT_RowIndex" => $start,
                    "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                    "keterangan_angkatan" => $row->keterangan_angkatan,
                    "provinsi"    => $row->provinsi,
                    "kabupaten"   => $row->kabupaten,
                    "kecamatan"   => $row->kecamatan,
                    "nama"        => $row->nama,
                    "aksi"        => $action,
                ];
            });

        return response()->json([
            "draw"            => intval($request->get("draw")),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

    //------------------------------- Di bawah ini RELASI HARMONIS -------------------------------
    public function index_harmonis()
    {
        return view("backend.layouts.fasilitator.relasi");
    }

    public function json_harmonis(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $this_ = Permissions::id_data();
        $model = new M_bimwin();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "30081b57-6c90-43ca-9f0f-803dd817029e";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Hapus cache setelah update DB ---
        Permissions::forget_cache($publicId);

        // --- Build query langsung ---
        $query = DB::table("view_peserta")->where([['is_trash', '!=', '18'], ['kategori', '=', '455']]); // relasi harmonis

        // --- Filter role ---
        if (!in_array($roles, [1, 12])) {
            // Hanya tampil data sesuai id_direktorat dan id_subdit user, jika ada
            if ($exec->id_direktorat) {
                $query->where("id_direktorat", $exec->id_direktorat);
            }
            if ($exec->id_subdit) {
                $query->where("id_subdit", $exec->id_subdit);
            }
        }

        // --- Caching total records tanpa filter (5 menit) ---
        $cacheKeyTotal = "peserta_total_{$roles}_{$exec->id_direktorat}_{$exec->id_subdit}";
        $recordsTotal = Cache::remember($cacheKeyTotal, 300, fn() => $query->count());

        // --- Filter search ---
        if ($search) {
            $searchColumns = ["nama", "judul_acara", "provinsi"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
            ->select("id", "public_id", "judul_acara", "keterangan_angkatan", "provinsi", "kabupaten", "kecamatan", "nama", "is_trash")
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function($row) use ($permissions_icon, $roles, &$start) {
                $start++;

                $actionFuncs = [
                    "get_detail","get_edit","get_delete","get_password",
                    "get_agree","get_back","get_config","get_modules","get_download"
                ];

                $action = $row->is_trash == 18
                    ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                        return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    }, '');

                return [
                    "DT_RowIndex" => $start,
                    "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                    "keterangan_angkatan" => $row->keterangan_angkatan,
                    "provinsi"    => $row->provinsi,
                    "kabupaten"   => $row->kabupaten,
                    "kecamatan"   => $row->kecamatan,
                    "nama"        => $row->nama,
                    "aksi"        => $action,
                ];
            });

        return response()->json([
            "draw"            => intval($request->get("draw")),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

}
