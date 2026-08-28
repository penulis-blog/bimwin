<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_galeri;
use Intervention\Image\ImageManager;

class C_galeri extends Controller
{
    public function index()
    {
        $model = new M_galeri();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.informasi.galeri", $data);
    }

    public function tambah(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gl_files' => [
                'required',
                'file',
                'max:30720',
                'mimetypes:image/jpeg,image/png,video/mp4,video/quicktime,video/x-msvideo,video/x-matroska'
            ],
        ], [
            'gl_files.required' => 'File wajib diunggah.',
            'gl_files.mimetypes' => 'Format file harus JPG, JPEG, PNG, atau VIDEO (MP4/MOV/AVI/MKV).',
            'gl_files.max' => 'Ukuran file maksimal 30MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 201,
                'errors' => $validator->errors()
            ], 201);
        }

        $filename = null; 
        $folder = 'informasi'; 

        if ($request->hasFile('gl_files')) {

            $file = $request->file('gl_files');
            $ext  = strtolower($file->getClientOriginalExtension());

            $filename = Str::uuid() . '.' . $ext;
            $path = storage_path("app/public/$folder/$filename");

            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            $isImage = in_array($ext, ['jpg', 'jpeg', 'png']);
            $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'mkv']);

            if (!$isImage && !$isVideo) {
                return response()->json([
                    'message' => 400,
                    'error' => 'Format file tidak didukung.'
                ], 400);
            }

            // ---------- IMAGE ----------
            if ($isImage) {

                $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
                $image = $manager->read($file);

                $quality = 90;
                $image->toJpeg($quality)->save($path);

                $targetSize = 850 * 1024;
                while (filesize($path) > $targetSize && $quality > 10) {
                    $quality -= 5;
                    $image->toJpeg($quality)->save($path);
                }
            }

            // ---------- VIDEO ----------
            else if ($isVideo) {
                $ffmpeg = base_path('ffmpeg/ffmpeg.exe');
                $inputVideo = $file->getRealPath();
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $outputPath = storage_path("app/public/informasi/" . $filename);
                if (!file_exists(dirname($outputPath))) {
                    mkdir(dirname($outputPath), 0777, true);
                }
                $cmd = "$ffmpeg -i \"$inputVideo\" -vf scale=-2:720 -vcodec libx264 -crf 28 -preset fast \"$outputPath\" -y";
                $result = shell_exec($cmd . " 2>&1");

                if (!file_exists($outputPath)) {
                    return response()->json([
                        'message' => 500,
                        'error' => 'FFmpeg error: ' . $result
                    ]);
                }

                $path = "informasi/" . $filename;
            }
        }

        $data = [
            'public_id'      => Str::uuid()->toString(),
            'judul'          => $request->input('gl_jdl'),
            'deskripsi'      => $request->input('gl_desc'),
            'kategori'       => $request->input('gl_ktgr'),
            'pranala'        => $request->input('gl_url'),
            'files'          => $filename ? ("$folder/$filename") : null,
            'is_trash'       => 11,
            'created'        => auth()->user()->id,
            'created_date'   => date("Y-m-d H:i:s")
        ];

        DB::table('dt_galeri')->insert($data);

        return response()->json([
            "message" => 200
        ]);
    }

    public function edit($id)
    {
        $data = M_galeri::get_data($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 200,
            ], 200)
            : response()->json([
                'message' => 404,
            ], 404);
    }

    public function detail($id)
    {
        $data = M_galeri::get_galeri($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 200,
            ], 200)
            : response()->json([
                'message' => 404,
            ], 404);
    }

    public function update(Request $request)
    {
        $id        = $request->input('e_gl_publicid');
        $photoBaru = $request->hasFile('e_gl_files');
        $photoLama = $request->input('e_gl_files_old');

        // Ambil data lama
        $oldData = DB::table('dt_galeri')->where('public_id', $id)->first();

        if (!$oldData) {
            return response()->json([
                'message' => 400,
                'error'   => 'Data tidak ditemukan.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'e_gl_files' => [
                $photoBaru ? 'required' : 'nullable',
                'file',
                'max:30720',
                'mimetypes:image/jpeg,image/png,video/mp4,video/quicktime,video/x-msvideo,video/x-matroska'
            ],
        ], [
            'e_gl_files.required' => 'File wajib diunggah.',
            'e_gl_files.mimetypes' => 'Format file harus JPG, PNG, atau VIDEO.',
            'e_gl_files.max' => 'Ukuran file maksimal 30MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 201,
                'errors'  => $validator->errors()
            ]);
        }

        $folder   = "informasi";
        $filename = $oldData->files;

        if ($photoBaru) {

            $file = $request->file('e_gl_files');
            $ext  = strtolower($file->getClientOriginalExtension());

            // nama file baru
            $newFilename = Str::uuid() . "." . $ext;
            $fullPath    = storage_path("app/public/$folder/$newFilename");

            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            $isImage = in_array($ext, ['jpg', 'jpeg', 'png']);
            $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'mkv']);

            if ($isImage) {
                $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
                $image   = $manager->read($file);

                $quality = 90;
                $image->toJpeg($quality)->save($fullPath);

                // compress ulang jika > 850kb
                $targetSize = 850 * 1024;
                while (filesize($fullPath) > $targetSize && $quality > 10) {
                    $quality -= 5;
                    $image->toJpeg($quality)->save($fullPath);
                }
            }

            else if ($isVideo) {

                $ffmpeg = base_path('ffmpeg/ffmpeg.exe'); // sesuaikan
                $inputVideo = $file->getRealPath();

                $cmd = "$ffmpeg -i \"$inputVideo\" -vf scale=-2:720 -vcodec libx264 -crf 28 -preset fast \"$fullPath\" -y";
                $result = shell_exec($cmd . " 2>&1");

                if (!file_exists($fullPath)) {
                    return response()->json([
                        'message' => 500,
                        'error'   => 'FFmpeg error: ' . $result
                    ]);
                }
            }

            // Ambil file lama dari DB (misal: informasi/xxx.png)
            $oldFile = $oldData->files;  

            // Buat path absolut file lama
            $oldFilePath = storage_path("app/public/" . $oldFile);

            // Hapus file lama jika ada file baru
            if ($photoBaru && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Simpan nama file baru ke database
            $filename = "$folder/$newFilename";
        }

        DB::table('dt_galeri')->where('public_id', $id)->update([
            'judul'        => $request->input('e_gl_jdl'),
            'deskripsi'    => $request->input('e_gl_desc'),
            'kategori'     => $request->input('e_gl_ktgr'),
            'pranala'      => $request->input('e_gl_url'),
            'files'        => $filename,
            'is_trash'     => $request->input('e_gl_stat'),
            'updated'      => auth()->user()->id,
            'updated_date' => date("Y-m-d H:i:s"),
        ]);

        return response()->json([
            "message" => 200
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
            DB::table('dt_galeri')->where('public_id', $id)->update($data);

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
        $permissions_icon = Permissions::this_permissions("0fa89003-7679-4482-83ac-a3930fc82e2f");
        $query = DB::table("view_galeri");

        $recordsTotal = $query->count();

        if ($search) {
            $columns = ["judul", "ktgr"];
            $query->where(function($q) use ($columns, $search) {
                foreach ($columns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        $data = $query->select(
                    "id",
                    "public_id",
                    "judul",
                    "ktgr",
                    "deskripsi",
                    "stat",
                    "is_trash"
                )
                ->skip($start)
                ->take($length)
                ->get()
                ->map(function($row) use ($permissions_icon, $roles, &$start) {
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
                        ? collect($actionFuncs)->reduce(function($carry, $func) use ($encode, $roles, $permissions_icon) {
                            return $carry . $func($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                        }, '')
                        : get_detail($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                        . get_edit($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);

                    return [
                        "DT_RowIndex"   => $start,
                        "public_id"     => $row->public_id,
                        "judul"         => Str::words($row->judul, 7, '...'),
                        "ktgr"          => $row->ktgr,
                        "deskripsi"     => Str::words($row->deskripsi, 7, '...'),
                        "stat"          => $row->stat,
                        "is_trash"      => $row->is_trash,
                        "aksi"          => $action,
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