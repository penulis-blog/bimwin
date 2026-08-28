<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_template;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class C_template extends Controller
{
    public function index()
    {
        return view("backend.layouts.masters.template");
    }

    public function ttd()
    {
        $data = new M_template();
        $exec = $data->get_jadwal();

        $result = [
            "data" => $exec,
        ];

        return response()->json($result);
    }

    public function listMateri(Request $request)
    {
        $model  = new M_template();
        $id     = $request->input('id_template') ?? ($request->input('e_id_template')[0] ?? null);
        $data   = $model->get_data($id);

        $materi = $request->input('materi'); // array baru (tambah)
        $jpl    = $request->input('jpl');

        // --- Bagian EDIT ---
        $e_public_id    = $request->input('e_public_id');
        $e_id_template  = $request->input('e_id_template');
        $e_materi       = $request->input('e_materi');
        $e_jpl          = $request->input('e_jpl');

        \Log::info('listMateri called', [
            'id_template' => $id,
            'has_materi' => is_array($materi),
            'has_e_public_id' => is_array($e_public_id),
        ]);

        DB::beginTransaction();
        try {
            // ===== UPDATE (EDIT) =====
            if (is_array($e_public_id) && count($e_public_id) > 0) {
                foreach ($e_public_id as $indexe => $publicId) {
                    $idTemplate = $e_id_template[$indexe] ?? null;
                    $emateri    = $e_materi[$indexe] ?? null;
                    $ejpl       = $e_jpl[$indexe] ?? null;

                    if (!empty($publicId) && !empty($emateri)) {
                        DB::table('mst_template_materi')
                            ->where('public_id', $publicId)
                            ->update([
                                "id_template"   => $idTemplate,
                                "judul"         => $emateri,
                                "total"         => $ejpl,
                                "updated"       => auth()->user()->id,
                                "updated_date"  => date("Y-m-d H:i:s"),
                            ]);
                    }
                }
            }

            // ===== INSERT (TAMBAH) =====
            $dataInsert = [];

            // Guard: hanya lanjutkan jika ada array materi/jpl dan setidaknya 1 baris non-empty
            $hasNewValid = false;
            if (is_array($materi) && is_array($jpl) && count($materi) > 0) {
                foreach ($materi as $i => $namaMateri) {
                    $nilaiJpl = $jpl[$i] ?? null;
                    if (!empty($namaMateri) && $nilaiJpl !== null && $nilaiJpl !== '') {
                        $hasNewValid = true;
                        break;
                    }
                }
            }

            if ($hasNewValid) {
                foreach ($materi as $i => $namaMateri) {
                    $nilaiJpl = $jpl[$i] ?? null;

                    // ✅ skip hanya jika kosong benar-benar, bukan nilai 0
                    if (trim($namaMateri) === '' || $nilaiJpl === '' || $nilaiJpl === null) {
                        continue;
                    }

                    $templateIdForRow = $data->id ?? $id;

                    $exists = DB::table('mst_template_materi')
                        ->where('id_template', $templateIdForRow)
                        ->where('judul', $namaMateri)
                        ->exists();

                    if ($exists) {
                        \Log::info('skip insert duplicate', [
                            'id_template' => $templateIdForRow,
                            'judul' => $namaMateri,
                        ]);
                        continue;
                    }

                    $dataInsert[] = [
                        "public_id"      => Str::uuid()->toString(),
                        "id_template"    => $templateIdForRow,
                        "judul"          => $namaMateri,
                        "total"          => $nilaiJpl,
                        "is_trash"       => 11,
                        "created"        => auth()->user()->id,
                        "created_date"   => date("Y-m-d H:i:s"),
                    ];
                }

                if (!empty($dataInsert)) {
                    DB::table('mst_template_materi')->insert($dataInsert);
                    \Log::info('Inserted new materi rows', ['count' => count($dataInsert)]);
                } else {
                    \Log::info('No new insertable materi rows found (all duplicates or empty).');
                }
            } else {
                \Log::info('No new valid materi rows to insert.');
            }

            DB::commit();

            return response()->json([
                'message' => 200,
                'status'  => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('listMateri error: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 500,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    public function editmateri($id)
    {
        $model  = new M_template();
        $data   = $model->get_data($id);
        $materi = $model->get_listmateri($data->id);
        
        if(count($materi) > 0){
            $result = [
                'data' => $materi,
                'message' => 200
            ];

            return response()->json($result);
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function post(Request $request)
    {
        $dokumen1 = $request->hasFile('doks1');
        $dokumen2 = $request->hasFile('doks2');

        // Jika tidak ada file sama sekali
        if (!$dokumen1 && !$dokumen2) {
            return response()->json([
                'message' => 'Minimal satu dokumen harus diunggah.'
            ], 400);
        }

        // Inisialisasi ImageManager
        $manager = new ImageManager(new Driver());

        $path1 = null;
        $path2 = null;

        // Fungsi bantu untuk validasi ekstensi & mime
        $isValidImage = function ($file) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $allowedMime = ['image/jpeg', 'image/png'];
            $ext = strtolower($file->getClientOriginalExtension());
            $mime = $file->getMimeType();

            return in_array($ext, $allowedExtensions) && in_array($mime, $allowedMime);
        };

        try {
            // === Upload dokumen1 ===
            if ($dokumen1) {
                $file1 = $request->file('doks1');

                if (!$isValidImage($file1)) {
                    $result = [
                        "message" => 203,
                    ];

                    return response()->json($result);
                }

                $namaFile1 = Str::uuid()->toString() . '.' . $file1->getClientOriginalExtension();
                $path1 = storage_path('app/public/' . $namaFile1);

                // Kompres tanpa ubah dimensi
                $image1 = $manager->read($file1->getRealPath());

                // Sesuaikan tingkat kompresi agar ukuran akhir sekitar 500KB–1MB
                // (Semakin kecil angka, semakin kecil ukuran file)
                $image1->save($path1, 70); // 70% kualitas = kompres sedang
            }

            // === Upload dokumen2 ===
            if ($dokumen2) {
                $file2 = $request->file('doks2');

                if (!$isValidImage($file2)) {
                    if ($path1 && file_exists($path1)) unlink($path1);

                    return response()->json([
                        'message' => 'Format dokumen2 tidak valid. Hanya JPG, JPEG, dan PNG yang diperbolehkan.'
                    ], 422);
                }

                $namaFile2 = Str::uuid()->toString() . '.' . $file2->getClientOriginalExtension();
                $path2 = storage_path('app/public/' . $namaFile2);

                $image2 = $manager->read($file2->getRealPath());
                $image2->save($path2, 70);
            }

            // === Simpan ke database ===
            $masuk = [
                'id_ttd' => null,
                // $request->input("id_template"),
                'public_id' => Str::uuid()->toString(),
                'key_private' => Str::uuid()->toString(),
                'key_public' => Str::uuid()->toString(),
                'nama' => $request->input("nm_template"),
                'is_trash' => 11,
                'files_1' => $path1 ? str_replace(storage_path('app/public/'), '', $path1) : null,
                'files_2' => $path2 ? str_replace(storage_path('app/public/'), '', $path2) : null,
                "created"        => auth()->user()->id,
                "created_date"   => date("Y-m-d H:i:s")
            ];

            DB::table("mst_template")->insert($masuk);

            $result = [
                "message" => 200,
            ];

            return response()->json($result);

        } catch (\Exception $e) {
            if ($path1 && file_exists($path1)) unlink($path1);
            if ($path2 && file_exists($path2)) unlink($path2);

            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = M_template::get_data($id);

        return $data
            ? response()->json([
                'data' => $data,
                'lokal' => $data,
                'message' => 'success',
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
    }

    public function detail($id)
    {
        $data = M_template::get_view($id);

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
        $file_lama1 = $request->input('old_edoks1');
        $file_lama2 = $request->input('old_edoks2');
        $file_baru1 = $request->hasFile('edoks1');
        $file_baru2 = $request->hasFile('edoks2');
        $total_file = $request->input('ejm_template');

        $manager = new ImageManager(new Driver());
        $path1   = null;
        $path2   = null;

        $isValidImage = function ($file) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $allowedMime = ['image/jpeg', 'image/png'];
            $ext = strtolower($file->getClientOriginalExtension());
            $mime = $file->getMimeType();
            return in_array($ext, $allowedExtensions) && in_array($mime, $allowedMime);
        };

        // === CASE 1: file_baru1 ada, file_baru2 tidak ===
        if ($file_baru1 && !$file_baru2) {
            $file1 = $request->file('edoks1');

            if (!$isValidImage($file1)) {
                return response()->json(["message" => 203]);
            }

            $namaFile1 = Str::uuid()->toString() . '.' . $file1->getClientOriginalExtension();
            $path1 = storage_path('app/public/' . $namaFile1);
            $manager->read($file1->getRealPath())->save($path1, 70);

            // 🔥 Hapus file lama jika ada
            if ($file_lama1 && file_exists(storage_path('app/public/' . $file_lama1))) {
                unlink(storage_path('app/public/' . $file_lama1));
            }

            $path2 = $file_lama2 ? storage_path('app/public/' . $file_lama2) : null;

        // === CASE 2: file_baru2 ada, file_baru1 tidak ===
        } elseif ($file_baru2 && !$file_baru1) {
            $file2 = $request->file('edoks2');

            if (!$isValidImage($file2)) {
                return response()->json(["message" => 203]);
            }

            $namaFile2 = Str::uuid()->toString() . '.' . $file2->getClientOriginalExtension();
            $path2 = storage_path('app/public/' . $namaFile2);
            $manager->read($file2->getRealPath())->save($path2, 70);

            // 🔥 Hapus file lama jika ada
            if ($file_lama2 && file_exists(storage_path('app/public/' . $file_lama2))) {
                unlink(storage_path('app/public/' . $file_lama2));
            }

            $path1 = $file_lama1 ? storage_path('app/public/' . $file_lama1) : null;

        // === CASE 3: dua-duanya ada ===
        } elseif ($file_baru1 && $file_baru2) {
            $file1 = $request->file('edoks1');
            $file2 = $request->file('edoks2');

            if (!$isValidImage($file1) || !$isValidImage($file2)) {
                return response()->json(["message" => 203]);
            }

            $namaFile1 = Str::uuid()->toString() . '.' . $file1->getClientOriginalExtension();
            $path1 = storage_path('app/public/' . $namaFile1);
            $manager->read($file1->getRealPath())->save($path1, 70);

            $namaFile2 = Str::uuid()->toString() . '.' . $file2->getClientOriginalExtension();
            $path2 = storage_path('app/public/' . $namaFile2);
            $manager->read($file2->getRealPath())->save($path2, 70);

            if ($file_lama1 && file_exists(storage_path('app/public/' . $file_lama1))) {
                unlink(storage_path('app/public/' . $file_lama1));
            }
            if ($file_lama2 && file_exists(storage_path('app/public/' . $file_lama2))) {
                unlink(storage_path('app/public/' . $file_lama2));
            }

        // === CASE 4: dua-duanya tidak ada ===
        } else {
            $path1 = $file_lama1 ? storage_path('app/public/' . $file_lama1) : null;
            $path2 = $file_lama2 ? storage_path('app/public/' . $file_lama2) : null;
        }

        // === 🔥 Tambahan logika penghapusan berdasarkan total file ===
        if ($total_file == 1) {
            // Jika hanya 1 file, hapus file lama ke-2
            if (!empty($file_lama2) && $file_lama2 !== 'null' && file_exists(storage_path('app/public/' . $file_lama2))) {
                unlink(storage_path('app/public/' . $file_lama2));
                $path2 = null;
            }
        } elseif (is_null($total_file) || $total_file === '') {
            // Jika tidak memilih jumlah file → hapus keduanya
            if (!empty($file_lama1) && $file_lama1 !== 'null' && file_exists(storage_path('app/public/' . $file_lama1))) {
                unlink(storage_path('app/public/' . $file_lama1));
                $path1 = null;
            }
            if (!empty($file_lama2) && $file_lama2 !== 'null' && file_exists(storage_path('app/public/' . $file_lama2))) {
                unlink(storage_path('app/public/' . $file_lama2));
                $path2 = null;
            }
        }

        // === Simpan ke DB ===
        $data = [
            'id_ttd'       => null, 
            // $request->input('eid_template'),
            'nama'         => $request->input('enm_template'),
            'files_1'      => $path1 ? str_replace(storage_path('app/public/'), '', $path1) : null,
            'files_2'      => $path2 ? str_replace(storage_path('app/public/'), '', $path2) : null,
            'is_trash'     => $request->input('eis_trash'),
            "updated"      => auth()->user()->id,
            "updated_date" => date("Y-m-d H:i:s"),
        ];

        DB::table('mst_template')->where('public_id', $id)->update($data);

        return response()->json([
            'message' => 200,
            'success' => true
        ]);
    }

    public function delete(Request $request)
    {
        $id     = $request->input('val');
        $data   = [
            'is_trash' => 12,
            'deleted' => auth()->user()->id,
            'deleted_date' => date('Y-m-d H:i:s')
        ];

        if (!empty($id) && !empty($data)) {
            DB::table('mst_template')->where('public_id', $id)->update($data);

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

    public function delete_live(Request $request)
    {
        $id     = $request->input('id');
        $data   = [
            'is_trash' => 12,
            'deleted' => auth()->user()->id,
            'deleted_date' => date('Y-m-d H:i:s')
        ];

        if (!empty($id) && !empty($data)) {
            DB::table('mst_template_materi')->where('public_id', $id)->update($data);

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
        $model = new M_template();
        $exec  = $model->get_group($roles, $user->id);

        // --- Cache Permissions per user/path (30 menit) ---
        $permissions_icon = Cache::remember(
            "permissions_{$user->id}_peserta",
            1800,
            function () {
                return Permissions::this_permissions("3dcd2904-433b-407f-adfa-a4f2e5840a47");
            }
        );

        // --- Build query langsung ---
        $query = DB::table("view_template");

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
            $searchColumns = ["nama", "direktorat", "subdit"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
            ->select("id", "public_id", "nama", "direktur", "direktorat", "subdit", "status", "is_trash")
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function($row) use ($permissions_icon, $roles, &$start) {
                $start++;

                $actionFuncs = [
                    "get_detail","get_edit","get_delete","get_password",
                    "get_agree","get_back","get_config","get_modules","get_download"
                ];

                $encode = $row->public_id;
                $button = '<a href="javascript:;" onclick="Page.Materi(\'' . $encode . '\')" data-bs-toggle="tooltip" data-bs-placement="top" title="List Materi"><span class="badge bg-success"><i class="fa fa-file-excel"></i></span></a> ';

                $action = $row->is_trash == 12
                    ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . $button // tambahkan di sini
                    : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                        return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    }, '') . $button; // juga tambahkan di sini

                return [
                    "DT_RowIndex" => $start,
                    "nama" => $row->nama,
                    "direktur" => $row->direktur,
                    "direktorat"    => $row->direktorat,
                    "subdit"   => $row->subdit,
                    "status"   => $row->status,
                    "is_trash"        => $row->is_trash,
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