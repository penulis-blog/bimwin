<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_brus;
use Intervention\Image\ImageManager;
use PDF;

class C_brus extends Controller
{
    public function index()
    {
        return view("backend.layouts.fasilitator.brus");
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

    public function update(Request $request)
    {
        $id         = $request->input('e_publicid');
        $photoBaru  = $request->hasFile('e_files_bimwin');

        // ===== DATA UMUM (dipakai di dua kondisi) =====
        $baseData = [
            "id_kegiatan"    => $request->input("e_keg_bimwin") ?: null,
            "nik"            => $request->input("e_nik_bimwin"),
            "nama"           => $request->input("e_nama_bimwin") ?: null,
            "lahir"          => $request->input("e_tmp_bimwin") ?: null,
            "tgl"            => $request->input("e_tgl_bimwin") ?: null,
            "jkl"            => $request->input("e_jk_bimwin") ?: null,
            "alamat_rumah"   => $request->input("e_domisili_bimwin") ?: null,
            "no_hp"          => $request->input("e_hp_bimwin"),
            "email"          => $request->input("e_email_bimwin") ?: null,
            "no_rek"         => $request->input("e_rek_bimwin"),
            "nm_bank"        => $request->input("e_nm_bimwin") ?: null,
            "npwp"           => $request->input("e_npwp_bimwin"),
            "nip"            => $request->input("e_nip_bimwin"),
            "id_provinsi"    => $request->input("e_prov_bimwin") ?: null,
            "id_kabupaten"   => $request->input("e_kab_bimwin") ?: null,
            "id_kecamatan"   => $request->input("e_kec_bimwin") ?: null,
            "is_pegawai"     => $request->input("e_pegawai_bimwin") ?: null,
            "jabatan"        => $request->input("e_jbtn_bimwin") ?: null,
            "golongan"       => $request->input("e_gol_bimwin") ?: null,
            "instansi"       => $request->input("e_inst_bimwin") ?: null,
            "alamat_kantor"  => $request->input("e_kantor_bimwin") ?: null,
            "angkatan"       => $request->input("e_angkatan_bimwin") ?: null,
            "is_trash"       => $request->input("e_status") ?: null,
            "updated"        => auth()->user()->id,
            "updated_date"   => date("Y-m-d H:i:s"),
        ];

        // ===== TIDAK ADA FOTO BARU =====
        if ($photoBaru == false) {
            DB::table('dt_form')->where('public_id', $id)->update($baseData);
            return response()->json(['message' => 200]);
        }

        // ===== ADA FOTO BARU =====
        $oldData  = DB::table('dt_form')->where('public_id', $id)->first();
        $filename = null;

        if ($request->hasFile('e_files_bimwin')) {
            $file = $request->file('e_files_bimwin');

            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path     = storage_path('app/public/bimwin/' . $filename);

            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
            $image   = $manager->read($file)->resize(472, 709, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            $quality = 90;
            $image->toJpeg($quality)->save($path);

            $target = 850 * 1024;
            while (filesize($path) > $target && $quality > 10) {
                $quality -= 5;
                $image->toJpeg($quality)->save($path);
            }

            if (!empty($oldData->files) && file_exists(storage_path('app/public/' . $oldData->files))) {
                unlink(storage_path('app/public/' . $oldData->files));
            }
        }

        $baseData['files'] = $filename
            ? 'bimwin/' . $filename
            : $oldData->files;

        DB::table('dt_form')->where('public_id', $id)->update($baseData);

        return response()->json(['message' => 200]);
    }

    public function post(Request $request)
    {
        $id_form    = $request->input("keg_bimwin");
        $nik        = $request->input("nik_bimwin");
        $nip        = $request->input("nip_bimwin");
        $angkatan   = $request->input("angkatan_bimwin");
        $filename   = 'default.jpg';

        $model      = new M_brus();
        $peserta    = $model->get_daftar($id_form, $nik, $nip, $angkatan);

        if ($peserta) {
            return response()->json(["message" => 404]);
        }

        if ($request->hasFile('files_bimwin')) {
            $file = $request->file('files_bimwin');

            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = storage_path('app/public/bimwin/'.$filename);

            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);

            $image = $manager->read($file)->resize(472, 709, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            $quality = 90;
            $image->toJpeg($quality)->save($path);

            while (filesize($path) > (850 * 1024) && $quality > 10) {
                $quality -= 5;
                $image->toJpeg($quality)->save($path);
            }
        }

        $data = [
            "public_id"     => Str::uuid(),
            "id_kegiatan"   => $request->input("keg_bimwin"),
            "id_provinsi"   => $request->input("prov_bimwin") ?: null,
            "id_kabupaten"  => $request->input("kab_bimwin") ?: null,
            "id_kecamatan"  => $request->input("kec_bimwin") ?: null,
            "nama"          => $request->input("nama_bimwin") ?: null,
            "lahir"         => $request->input("tmp_bimwin") ?: null,
            "tgl"           => $request->input("tgl_bimwin") ?: null,
            "jkl"           => $request->input("jk_bimwin") ?: null,
            "nik"           => $request->input("nik_bimwin"),
            "nip"           => $request->input("nip_bimwin"),
            "jabatan"       => $request->input("jbtn_bimwin") ?: null,
            "golongan"      => $request->input("gol_bimwin") ?: null,
            "instansi"      => $request->input("inst_bimwin") ?: null,
            "alamat_kantor" => $request->input("kantor_bimwin") ?: null,
            "alamat_rumah"  => $request->input("domisili_bimwin") ?: null,
            "no_hp"         => $request->input("hp_bimwin"),
            "email"         => $request->input("email_bimwin") ?: null,
            "npwp"          => $request->input("npwp_bimwin"),
            "no_rek"        => $request->input("rek_bimwin"),
            "nm_bank"       => $request->input("nm_bimwin") ?: null,
            "files"         => 'bimwin/'.$filename,
            "is_pegawai"    => $request->input("pegawai_bimwin") ?: null,
            "angkatan"      => $request->input("angkatan_bimwin") ?: null,
            "is_trash"      => 17,
            "created"       => auth()->user()->id,
            "created_date"  => date("Y-m-d H:i:s")
        ];

        $id = DB::table("dt_form")->insertGetId($data);

        DB::table("dt_sertifikat")->insert([
            "public_id"      => Str::uuid(),
            "id_form"        => $id,
            "no_sertifikat"  =>
                "BKS/SERTIF/".$id."/".$request->input("keg_bimwin")."/".
                strtoupper(uniqid().Str::random(4))."/".date("Y"),
            "is_trash"       => 1,
            "created"        => auth()->user()->id,
            "created_date"   => date("Y-m-d H:i:s")
        ]);

        return response()->json(["message" => 200]);
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

        // --- Cache Permissions per user/path (30 menit) ---
        $permissions_icon = Cache::remember(
            "permissions_{$user->id}_peserta",
            1800,
            function () {
                return Permissions::this_permissions("4e07408562bedb8b60ce05c1decfe3ad16b72230967de01f640b7e4729b49fce");
            }
        );

        // --- Build query langsung ---
        $query = DB::table("view_peserta")->where('is_trash', '!=', '18');

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
        // Role 1 & 12 → semua data, tidak ada filter

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
                    "judul_acara" => $row->judul_acara,
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
