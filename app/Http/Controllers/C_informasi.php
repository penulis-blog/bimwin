<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_informasi;
use Intervention\Image\ImageManager;
use PDF;

class C_informasi extends Controller
{
    public function index()
    {
        return view("backend.layouts.informasi.berita");
    }

    public function tambah(Request $request)
    {
        $model        = new M_informasi();
        $files        = $request->hasFile("b_files");
        $filenameFoto = 'default.jpg';
        $namaFolder   = 'informasi';
        $judul        = $request->input("b_judul");
        $pranala      = $request->input("b_url");
        $kategori     = $request->input("b_kategori");
        $cek          = $model->get_duplikat($judul, $pranala, $kategori);
        
        if(count($cek) > 0){
            return response()->json([
                "message" => 201
            ]);
        }else{
            if ($files) {
                $file = $request->file('b_files');
                $filenameFoto = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

                $path = storage_path('app/public/' . $namaFolder . '/' . $filenameFoto);

                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }

                // Hanya compress tanpa resize
                $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);

                // Baca file tanpa resize
                $image = $manager->read($file);

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
                "meta_keywords" => $request->input("b_key"),
                "meta_tags" => $request->input("b_tags"),
                "meta_deskripsi" => $request->input("b_desc"),
                "meta_title" => $request->input("b_title"),
                "excerpt" => $request->input("b_exc"),
                "site_name" => "Bina Keluarga Sakinah",
                "judul" => $judul,
                "tgl_post" => $request->input("b_tgl"),
                "post_by" => $request->input("b_autor"),
                "kategori" => $kategori,
                "isi" => $request->input("b_editor1"),
                "pranala" => $pranala,
                "is_trash" => $request->input("b_stat"),
                "files" => $files ? ($namaFolder . '/' . $filenameFoto) : 'default.jpg',
                "created"        => auth()->user()->id,
                "created_date"   => date("Y-m-d H:i:s"),
            ];

            DB::table('dt_berita')->insert($data);

            return response()->json([
                "message" => 200
            ]);
        }
    }

    public function edit($id)
    {
        $data = M_informasi::get_data($id);

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
        $model        = new M_informasi();
        $id           = $request->input("be_publicid");
        $files        = $request->hasFile("be_files");
        $filenameFoto = 'default.jpg';
        $namaFolder   = 'informasi';
        $judul        = $request->input("be_judul");
        $pranala      = $request->input("be_url");
        $kategori     = $request->be_kategori != "Pilih" ? $request->be_kategori : null;
        $cek          = $model->get_sebelumnya($judul, $kategori);
        $old          = $model->get_data($id);

        if(count($cek) > 0){
            if ($old->judul == $judul && $old->pranala == $pranala && $old->kategori == $kategori) {
                if ($files) {
                    $file = $request->file('be_files');
                    $filenameFoto = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

                    $path = storage_path('app/public/' . $namaFolder . '/' . $filenameFoto);

                    if (!file_exists(dirname($path))) {
                        mkdir(dirname($path), 0755, true);
                    }

                    // Hanya compress tanpa resize
                    $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);

                    // Baca file tanpa resize
                    $image = $manager->read($file);

                    $quality = 90;
                    $image->toJpeg($quality)->save($path);

                    // Max 850 KB
                    $targetSize = 850 * 1024;
                    while (filesize($path) > $targetSize && $quality > 10) {
                        $quality -= 5;
                        $image->toJpeg($quality)->save($path);
                    }

                    if (!empty($old->files)) {
                        $oldPath = storage_path('app/public/' . $old->files);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                }

                $data = [
                    "meta_keywords" => $request->input("be_key"),
                    "meta_tags" => $request->input("be_tags"),
                    "meta_deskripsi" => $request->input("be_desc"),
                    "meta_title" => $request->input("be_title"),
                    "excerpt" => $request->input("be_exc"),
                    "judul" => $judul,
                    "tgl_post" => $request->input("be_tgl"),
                    "post_by" => $request->input("be_autor"),
                    "kategori" => $kategori,
                    "isi" => $request->input("be_editor1"),
                    "pranala" => $pranala,
                    "is_trash" => $request->input("be_stat"),
                    "files" => $files ? ($namaFolder . '/' . $filenameFoto) : $old->files,
                    "updated"        => auth()->user()->id,
                    "updated_date"   => date("Y-m-d H:i:s"),
                ];

                DB::table('dt_berita')->where('public_id', $id)->update($data);

                return response()->json(['message' => 200]);
            } 
            
            // Jika tidak sama → berarti benar-benar duplikat data lain
            return response()->json(['message' => 201]);
        }else{
            if ($files) {
                $file = $request->file('be_files');
                $filenameFoto = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

                $path = storage_path('app/public/' . $namaFolder . '/' . $filenameFoto);

                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }

                // Hanya compress tanpa resize
                $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);

                // Baca file tanpa resize
                $image = $manager->read($file);

                $quality = 90;
                $image->toJpeg($quality)->save($path);

                // Max 850 KB
                $targetSize = 850 * 1024;
                while (filesize($path) > $targetSize && $quality > 10) {
                    $quality -= 5;
                    $image->toJpeg($quality)->save($path);
                }

                if (!empty($old->files)) {
                    $oldPath = storage_path('app/public/' . $old->files);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }

            $data = [
                "meta_keywords" => $request->input("be_key"),
                "meta_tags" => $request->input("be_tags"),
                "meta_deskripsi" => $request->input("be_desc"),
                "meta_title" => $request->input("be_title"),
                "excerpt" => $request->input("be_exc"),
                "judul" => $judul,
                "tgl_post" => $request->input("be_tgl"),
                "post_by" => $request->input("be_autor"),
                "kategori" => $kategori,
                "isi" => $request->input("be_editor1"),
                "pranala" => $pranala,
                "is_trash" => $request->input("be_stat"),
                "files" => $files ? ($namaFolder . '/' . $filenameFoto) : $old->files,
                "updated"        => auth()->user()->id,
                "updated_date"   => date("Y-m-d H:i:s"),
            ];

            DB::table('dt_berita')->where('public_id', $id)->update($data);

            return response()->json(['message' => 200]);
        }
    }

    public function detail($id)
    {
        $data = M_informasi::get_detail($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 'success',
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
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
            DB::table('dt_berita')->where('public_id', $id)->update($data);

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

    public function upload_image(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Simpan ke storage/app/public/uploads
            $file->storeAs('public/uploads', $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');

            // URL yang dibaca CKEditor harus dari public/storage/uploads
            $url = asset('storage/uploads/' . $fileName);

            $msg = 'Upload berhasil';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg');</script>";

            return response($response)->header('Content-Type', 'text/html');
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
        $permissions_icon = Permissions::this_permissions("b512f1c5-c842-4be8-b6ed-36363e2cc9c4");

        $query = DB::table("view_berita");

        // Total awal
        $recordsTotal = $query->count();

        // Search filter
        if ($search) {
            $columns = ["judul", "kategori_berita"];
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        // Total setelah filter
        $recordsFiltered = $query->count();

        // Tambahkan ORDER BY tgl DESC
        $query->orderBy('tgl_post', 'DESC');

        // Ambil data
        $data = $query->select(
                    "id",
                    "public_id",
                    "judul",
                    "kategori_berita",
                    "isi",
                    "tgl",
                    "status_berita",
                    "total",
                    "is_trash"
                )
                ->skip($start)
                ->take($length)
                ->get()
                ->map(function ($row) use ($permissions_icon, $roles, &$start) {

                    $encode = $row->public_id;
                    $start++;

                    $actionFuncs = [
                        "get_detail",
                        "get_edit",
                        "get_delete",
                        "get_password",
                        "get_agree",
                        "get_back",
                        "get_config",
                        "get_modules",
                        "get_download"
                    ];

                    $action = $row->is_trash != 12 
                        ? collect($actionFuncs)->reduce(function ($carry, $func) use ($encode, $roles, $permissions_icon) {
                            return $carry . $func($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                        }, '')
                        : get_detail($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                        . get_edit($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);

                    return [
                        "DT_RowIndex"       => $start,
                        "public_id"         => $row->public_id,
                        "judul"             => Str::words($row->judul, 7, '...'),
                        "kategori_berita"   => $row->kategori_berita,
                        "isi"               => $row->isi,
                        "tgl"               => indo_date($row->tgl),
                        "status_berita"     => $row->status_berita,
                        "total"             => $row->total,
                        "is_trash"          => $row->is_trash,
                        "aksi"              => $action,
                    ];
                });

        // Response JSON DataTables
        return response()->json([
            "draw"            => intval($request->get("draw")),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }
}