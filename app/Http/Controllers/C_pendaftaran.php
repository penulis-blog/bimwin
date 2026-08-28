<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\M_pendaftaran;
use Intervention\Image\ImageManager;

class C_pendaftaran extends Controller
{
    public function index($id)
    {
        $parts  = explode('+', $id);
        $before = $parts[0];
        $after  = $parts[1] ?? null;
        $data   = M_pendaftaran::get_data($after);

        if(base64_decode($before) == 99){
            $judul = 'Biodata Narasumber';
        }else{
            $judul = 'Biodata Peserta';
        }

        $view = [
            'data' => $data,
            'angkatan' => base64_decode($before),
            'judul' => $judul
        ];

        return view("frontend.formulir.fasilitator", $view);
    }

    public function provinsi()
    {
        $model  = new M_pendaftaran();
        $data   = $model->get_provinsi();

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function kabupaten($id)
    {
        $model  = new M_pendaftaran();
        $data   = $model->get_kabupaten($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function kecamatan($id)
    {
        $model  = new M_pendaftaran();
        $data   = $model->get_kecamatan($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function post(Request $request)
    {
        $photo      = $request->hasFile("files_bimwin");
        $surtug     = $request->hasFile("files_surtug");
        $id_form    = $request->input("id_kegiatan");
        $nik        = $request->input("nik_bimwin");
        $angkatan   = $request->input("id_angkatan");
        
        $model      = new M_pendaftaran();
        $peserta    = $model->get_daftar($id_form, $nik, $angkatan);
        $folder     = $model->get_folder($id_form);

        $mapFolder = [
            451 => 'bimwin',
            452 => 'brus',
            453 => 'jejaring-lokal',
            454 => 'konsultasi-dan-pendampingan-keluarga',
            455 => 'relasi-harmonis',
            456 => 'keuangan-keluarga',
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
            "id_kegiatan"    => $request->input("id_kegiatan"),
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
            "angkatan"       => $request->input("id_angkatan"),
            "is_trash"       => 17,
            "created_date"   => date("Y-m-d H:i:s"),
        ];

        $id_ = DB::table("dt_form")->insertGetId($data);

        $noSertifikat =
            "BKS/SERTIF/" .
            $id_ . "/" .
            $request->input("id_kegiatan") . "/" .
            strtoupper(uniqid() . Str::random(4)) . "/" .
            date("Y");

        DB::table("dt_sertifikat")->insert([
            "public_id"      => Str::uuid()->toString(),
            "id_form"        => $id_,
            "no_sertifikat"  => $noSertifikat,
            "is_trash"       => 1,
            "created_date"   => date("Y-m-d H:i:s"),
        ]);

        return response()->json([
            "message"        => 200,
            "no_sertifikat"  => $noSertifikat,
        ]);
    }
}