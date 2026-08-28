<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Helpers\Permissions;
use App\Models\M_ttd;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class C_ttd extends Controller
{
    public function index()
    {
        return view("backend.layouts.masters.ttd");
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files_tte' => 'required|file|mimes:jpg,jpeg,png|max:2048', // max 2MB (optional)
            'id_direktorat' => 'required',
        ], [
            'files_tte.required' => 'File gambar wajib diunggah.',
            'files_tte.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
            'files_tte.max' => 'Ukuran file maksimal 2MB.',
            'id_direktorat.required' => 'ID Direktorat wajib diisi.',
        ]);

        // Jika validasi gagal → hentikan proses
        if ($validator->fails()) {
            return response()->json([
                'message' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        // --- Proses upload ---
        if ($request->hasFile('files_tte')) {
            $file = $request->file('files_tte');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);

            try {
                // Gunakan ImageManager (v3)
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);

                // Simpan gambar dalam kualitas tinggi (HD)
                $quality = 95;
                $image->toJpeg($quality)->save($path);

                // Batasi ukuran file (maks 850KB)
                $targetSize = 850 * 1024;
                while (filesize($path) > $targetSize && $quality > 10) {
                    $quality -= 5;
                    $image->toJpeg($quality)->save($path);
                }

                // Insert ke DB
                DB::table("mst_ttd")->insert([
                    "public_id"     => Str::uuid()->toString(),
                    "id_direktorat" => $request->input("id_direktorat"),
                    "id_subdit"     => $request->input("id_subdit") ?: null,
                    "eselon_1"      => $request->input("nm_instansi") ?: null,
                    "lokasi_ttd"    => $request->input("lokasi_tte") ?: null,
                    "kegiatan"      => $request->input("d_kegiatan") ?: null,
                    "tgl_ttd"       => $request->input("tgl_tte") ?: null,
                    "direktur"      => $request->input("nm_direktur") ?: null,
                    "files"         => $filename,
                    "is_trash"      => 1,
                    "created"       => auth()->user()->id,
                    "created_date"  => now(),
                ]);

                return response()->json([
                    "message" => 200
                ]);

            } catch (\Exception $e) {
                // Jika gagal menyimpan file (misal corrupt), hapus file dan batalkan insert
                if (file_exists($path)) {
                    unlink($path);
                }

                return response()->json([
                    "message" => 500
                ], 500);
            }
        }

        return response()->json([
            "message" => 400
        ], 400);
    }

    public function edit($id)
    {
        $data = M_ttd::get_data($id);

        return $data
            ? response()->json([
                'data' => $data,
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
    }

    public function detail($id)
    {
        $data = M_ttd::get_data($id);

        return $data
            ? response()->json([
                'data' => $data,
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
    }

    public function update(Request $request)
    {
        $id         = $request->input('e_publicid');
        $photo_baru = $request->hasFile('e_files_tte');
        $photo_lama = $request->input('e_files_old');

        if($photo_baru == false){
            DB::table("mst_ttd")->where('public_id', $id)->update([
                "id_direktorat" => $request->input("e_id_direktorat"),
                "id_subdit"     => $request->input("e_id_subdit") ?: null,
                "lokasi_ttd"    => $request->input("e_lokasi_tte") ?: null,
                "kegiatan"      => $request->input("e_kegiatan") ?: null,
                "tgl_ttd"       => $request->input("e_tgl_tte"),
                "direktur"      => $request->input("e_nm_direktur") ?: null,
                "is_trash"      => $request->input("eis_trash"),
                "updated"       => auth()->user()->id,
                "updated_date"  => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                "message" => 200
            ]);
        }else{
            $oldData = DB::table('mst_ttd')->where('public_id', $id)->first();

            if (!$oldData) {
                return response()->json([
                    'message' => 404,
                ], 404);
            }

            // --- Validasi input dan file ---
            $validator = Validator::make($request->all(), [
                'e_files_tte'    => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'e_id_direktorat' => 'required',
            ], [
                'e_files_tte.required' => 'File gambar wajib diunggah.',
                'e_files_tte.mimes'    => 'Format file harus JPG, JPEG, atau PNG.',
                'e_files_tte.max'      => 'Ukuran file maksimal 2MB.',
                'e_id_direktorat.required' => 'ID Direktorat wajib diisi.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 400,
                    'errors' => $validator->errors(),
                ], 400);
            }

            $file = $request->file('e_files_tte');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);

            try {
                // Gunakan ImageManager
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);

                // Simpan gambar HD
                $quality = 95;
                $image->toJpeg($quality)->save($path);

                // Batasi ukuran 850KB
                $targetSize = 850 * 1024;
                while (filesize($path) > $targetSize && $quality > 10) {
                    $quality -= 5;
                    $image->toJpeg($quality)->save($path);
                }

                // --- Update data ---
                DB::table('mst_ttd')->where('public_id', $id)->update([
                    'id_direktorat' => $request->input('e_id_direktorat'),
                    'id_subdit'     => $request->input('e_id_subdit') ?: null,
                    'lokasi_ttd'    => $request->input('e_lokasi_tte') ?: null,
                    'tgl_ttd'       => $request->input('e_tgl_tte'),
                    'direktur'      => $request->input('e_nm_direktur') ?: null,
                    'files'         => $filename,
                    'is_trash'      => $request->input('eis_trash') ?: 1,
                    'updated'       => auth()->user()->id,
                    'updated_date'  => now(),
                ]);

                // --- Hapus file lama jika ada ---
                $oldPath = storage_path('app/public/' . $oldData->files);
                if (!empty($oldData->files) && file_exists($oldPath)) {
                    unlink($oldPath);
                }

                return response()->json([
                    'message' => 200
                ]);

            } catch (\Exception $e) {
                // Jika error, hapus file baru yang gagal disimpan
                if (file_exists($path)) {
                    unlink($path);
                }

                return response()->json([
                    'message' => 500,
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }

    public function delete(Request $request)
    {
        $id     = $request->input('val');
        $data   = [
            'is_trash' => 0,
            'deleted' => auth()->user()->id,
            'deleted_date' => date('Y-m-d H:i:s')
        ];

        if (!empty($id) && !empty($data)) {
            DB::table('mst_ttd')->where('public_id', $id)->update($data);

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
        $model = new M_ttd();
        $exec  = $model->get_group($roles, $user->id);

        // --- Cache Permissions per user/path (30 menit) ---
        $permissions_icon = Cache::remember(
            "permissions_{$user->id}_peserta",
            1800,
            function () {
                return Permissions::this_permissions("283fc5d1-3b7f-4aa4-b701-e0dac0d86c24");
            }
        );

        // --- Build query langsung ---
        $query = DB::table("view_ttd");

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
            $searchColumns = ["direktur", "direktorat", "subdit", "kegiatan"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
        ->select("id", "public_id", "direktur", "direktorat", "subdit", "kegiatan", "status", "is_trash")
        ->skip($start)
        ->take($length)
        ->get()
        ->values()
        ->map(function($row, $i) use ($permissions_icon, $roles, $start) {

            $DT_RowIndex = $start + $i + 1;

            $perihal = \Illuminate\Support\Str::words(
                $row->kegiatan,
                15,
                "..."
            );

            $actionFuncs = [
                "get_detail","get_edit","get_delete","get_password",
                "get_agree","get_back","get_config","get_modules","get_download"
            ];

            $action = $row->is_trash == 0
                ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                    return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                }, '');

            return [
                "DT_RowIndex" => $DT_RowIndex,
                "direktur"    => $row->direktur,
                "direktorat"  => Str::words($row->direktorat, 3, '...'),
                "subdit"      => $row->subdit,
                "kegiatan"    => $row->kegiatan,
                "perihal"     => $perihal,
                "status"      => $row->status,
                "is_trash"    => $row->is_trash,
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