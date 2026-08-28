<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_pengaduan;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use PDF;

class C_pengaduan extends Controller
{
    public function index()
    {
        return view("backend.layouts.informasi.sertifikat");
    }

    public function detail($id)
    {
        $data  = M_pengaduan::get_data($id);

        if ($data) {
            return response()->json([
                'message' => 200,
                'data'    => $data
            ]);
        }

        return response()->json(['message' => 201]);
    }

    public function terima_sertifikat($id) //--- ini tugas admin
    {
        $get  = M_pengaduan::get_data($id);
        $data = [
            'is_verifikasi_user' => 32,
            'updated' => auth()->user()->id,
            'updated_date' => date('Y-m-d H:i:s')
        ];

        DB::table('dt_pengaduan')->where('id_dtform', $get->id)->update($data);

        $logs = [
            "id_dtform"      => $get->id,
            "id_dtpengaduan" => $get->id_pengaduan,
            "public_id"      => Str::uuid()->toString(),
            "is_trash"       => 32,
            "created"        => auth()->user()->id,
            "created_date"   => date('Y-m-d H:i:s'),
        ];

        $pengaduan_logs = DB::table('dt_pengaduan_logs')->insert($logs);

        return response()->json([
            'message' => 200,
            'data' => $get
        ]);
    }

    public function update_allsertifikat(Request $request) //--- ini tugas admin
    {
        $id   = $request->input('id_keputusan');
        $nik  = $request->input('nik_asli');
        $kpts = $request->input('keputusan');
        $byid = M_pengaduan::get_by_id($id);

        $dt_form = [
            "nik"                 => $byid->nik,
            "nama"                => $byid->nama ?: null,
            "lahir"               => $byid->tmp_lhr ?: null,
            "tgl"                 => $byid->tgl_lhr ?: null,
            "jabatan"             => $byid->jabatan ?: null,
            "instansi"            => $byid->utusan ?: null,
            "files"               => $byid->files ?: null,
            "updated"             => auth()->user()->id,
            "updated_date"        => date('Y-m-d H:i:s'),
        ];

        $dt_pengaduan = [
            "is_verifikasi_user"  => $kpts,
            "is_verifikasi_admin" => $kpts,
            "keterangan"          => $request->filled('catatan') ? trim($request->input('catatan')) : null,
            "updated"             => auth()->user()->id,
            "updated_date"        => date('Y-m-d H:i:s'),
        ];

        $logs = [
            "public_id"      => Str::uuid()->toString(),
            "id_dtform"      => $id,
            "id_dtpengaduan" => $byid->id,
            "is_trash"       => $kpts,
            "created"        => auth()->user()->id,
            "created_date"   => date('Y-m-d H:i:s'),
        ];

        DB::beginTransaction();
        try {
            if ($kpts == 33 || $kpts == 34) {
                // dt_form tidak di-update
                $form = true;
            } else {
                $form = DB::table('dt_form')
                    ->where('id', $id)
                    ->update($dt_form);
            }

            $pengaduan = DB::table('dt_pengaduan')
                ->where('id_dtform', $id)
                ->update($dt_pengaduan);
            
            $pengaduan_logs = DB::table('dt_pengaduan_logs')
                ->insert($logs);

            DB::commit();

            return response()->json([
                "message" => 200
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                "message" => 201,
                "error" => $e->getMessage()
            ]);
        }

        // DB::beginTransaction();
        // try {
        //     $form = DB::table('dt_form')
        //         ->where('id', $id)
        //         ->update($dt_form);

        //     $pengaduan = DB::table('dt_pengaduan')
        //         ->where('id_dtform', $id)
        //         ->update($dt_pengaduan);
            
        //     $pengaduan_logs = DB::table('dt_pengaduan_logs')->insert($logs);

        //     DB::commit();
        //     return response()->json([
        //         "message" => 200
        //     ]);
        // } catch (\Throwable $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         "message" => 201,
        //         "error" => $e->getMessage()
        //     ]);
        // }
    }

    public function edit_sertifikat($id)
    {
        $data = M_pengaduan::get_data($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 200,
            ], 200)
            : response()->json([
                'message' => 404,
            ], 404);
    }

    public function update_sertifikat(Request $request) //--- ini tugas peserta
    {
        $id           = $request->input('e_st_publicid');
        $kategori     = Str::slug($request->input('e_ktgr'));
        $photo_lama   = $request->input('e_st_files_old');
        $photo_baru   = $request->hasFile('e_st_files');
        $verifikasi   = $request->input('is_verifikasi_admin') ?: null;
        $filenameFoto = null;
        $get_update   = M_pengaduan::get_by_id($id);

        if ($request->hasFile('e_st_files')) {
            $file = $request->file('e_st_files');
            $filenameFoto = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $folder = $kategori;
            $path = storage_path('app/public/' . $folder . '/' . $filenameFoto);

            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            $manager = new ImageManager(\Intervention\Image\Drivers\Gd\Driver::class);
            $image = $manager->read($file)->resize(472, 709, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $quality = 90;
            $image->toJpeg($quality)->save($path);
            $targetSize = 850 * 1024;

            while (filesize($path) > $targetSize && $quality > 10) {
                $quality -= 5;
                $image->toJpeg($quality)->save($path);
            }
        }

        $data = [
            "public_id"             => Str::uuid()->toString(),
            "kategori"              => 1,
            "id_dtform"             => $request->input("e_st_publicid"),
            "nik"                   => $request->input("e_nik"),
            "nama"                  => $request->input("e_nama") ?: null,
            "tmp_lhr"               => $request->input("e_tmp") ?: null,
            "tgl_lhr"               => $request->filled('e_tgl') ? Carbon::createFromFormat('d-m-Y', $request->input('e_tgl'))->format('Y-m-d') : null,
            "jabatan"               => $request->input("e_jbtn") ?: null,
            "utusan"                => $request->input("e_satuan") ?: null,
            "is_verifikasi_user"    => $request->input("is_verifikasi_admin") ?: 31,
            "is_verifikasi_admin"   => $request->input("is_verifikasi_admin") ?: 37,
            "created"               => auth()->user()->id,
            "created_date"          => date('Y-m-d H:i:s'),
        ];

        if ($filenameFoto !== null) {
            $data["files"] = $kategori . '/' . $filenameFoto;
            $ulang["files"] = $kategori . '/' . $filenameFoto;
        }

        try {
            $pengaduan = DB::transaction(function () use ($data, $id, $get_update, $request, $filenameFoto, $kategori) {
            if ($get_update && in_array((int) $get_update->is_verifikasi_admin, [33, 34])) {

                $ulang = [
                    "nik"                   => $request->input("e_nik"),
                    "nama"                  => $request->input("e_nama") ?: null,
                    "tmp_lhr"               => $request->input("e_tmp") ?: null,
                    "tgl_lhr"               => $request->filled('e_tgl') ? Carbon::createFromFormat('d-m-Y', $request->input('e_tgl'))->format('Y-m-d') : null,
                    "jabatan"               => $request->input("e_jbtn") ?: null,
                    "utusan"                => $request->input("e_satuan") ?: null,
                    "is_verifikasi_user"    => $request->input("is_verifikasi_admin") ?: 38,
                    "is_verifikasi_admin"   => $request->input("is_verifikasi_admin") ?: 38,
                    "created"               => auth()->user()->id,
                    "created_date"          => date('Y-m-d H:i:s'),
                ];

                if ($filenameFoto !== null) {
                    $ulang["files"] = $kategori . '/' . $filenameFoto;
                }

                $updated = DB::table('dt_pengaduan')
                    ->where('id', $get_update->id)
                    ->update($ulang);

                if ($updated === false) {
                    throw new \Exception('Gagal memperbarui data pengaduan.');
                }

                $pengaduan = $get_update->id;

                $logs = [
                    "id_dtform"      => $id,
                    "id_dtpengaduan" => $pengaduan,
                    "public_id"      => Str::uuid()->toString(),
                    "is_trash"       => 38,
                    "created"        => auth()->user()->id,
                    "created_date"   => date('Y-m-d H:i:s'),
                ];

                $pengaduan_logs = DB::table('dt_pengaduan_logs')->insert($logs);

                if (!$pengaduan_logs) {
                    throw new \Exception('Gagal menyimpan log pengaduan.');
                }

                return $pengaduan;

            } else {

                $pengaduan = DB::table('dt_pengaduan')->insertGetId($data);

                if (!$pengaduan) {
                    throw new \Exception('Gagal menyimpan data pengaduan.');
                }

                $logs = [
                    "id_dtform"      => $id,
                    "id_dtpengaduan" => $pengaduan,
                    "public_id"      => Str::uuid()->toString(),
                    "is_trash"       => 31,
                    "created"        => auth()->user()->id,
                    "created_date"   => date('Y-m-d H:i:s'),
                ];

                $pengaduan_logs = DB::table('dt_pengaduan_logs')->insert($logs);

                if (!$pengaduan_logs) {
                    throw new \Exception('Gagal menyimpan log pengaduan.');
                }

                return $pengaduan;
            }
        });

            return response()->json([
                'message' => 200,
                'id'      => $pengaduan
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'message' => 201,
                'error'   => $e->getMessage()
            ]);
        }
    }

    public function json(Request $request)
    {
        if (!$request->ajax()) return;
        $start            = $request->get("start", 0);
        $length           = $request->get("length", 10);
        $search           = $request->get("search")["value"] ?? "";
        $user             = auth()->user();
        $roles            = $user->id_roles;
        $permissions_icon = Permissions::this_permissions("e26e561c-3030-4655-b978-f78ae33861c9");
        $query            = DB::table("view_peserta");

        if ($roles == 10) {
            $query->where("nik", $user->username);
        }

        if (in_array($roles, [1, 12])) {
            $query->whereNotNull('is_verifikasi_admin')
                ->where('is_verifikasi_admin', '<>', '');
        }

        $recordsTotal = $query->count();

        if ($search) {
            $columns = [
                "judul_acara",
                "instansi",
                "nama"
            ];

            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $col) {
                    $q->orWhereRaw(
                        "$col COLLATE utf8mb4_unicode_ci LIKE ?",
                        ["%{$search}%"]
                    );
                }
            });
        }

        $recordsFiltered = $query->count();
        $data = $query
            ->select(
                "id",
                "id_pengaduan",
                "public_id",
                "public_id_pengaduan",
                "judul_acara",
                "is_verifikasi_user",
                "is_verifikasi_admin",
                "verifikasi_pengaduan",
                "instansi",
                "utusan_pengaduan",
                "tempat_tanggal_lahir",
                "tempat_tanggal_lahir_pengaduan",
                "nama",
                "nama_pengaduan",
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

                if ($roles == 10) {
                    switch ((int) $row->is_verifikasi_user) {
                        // Perbaikan terkirim
                        case 31:
                            $actionFuncs = array_diff($actionFuncs, [
                                "get_edit"
                            ]);
                            break;

                        case 32:
                            $actionFuncs = array_diff($actionFuncs, [
                                "get_edit"
                            ]);
                            break;

                        case 35:
                            $actionFuncs = array_diff($actionFuncs, [
                                "get_edit"
                            ]);
                            break;

                        // Data nonaktif
                        case 36:
                            $actionFuncs = array_diff($actionFuncs, [
                                "get_edit",
                                "get_download"
                            ]);
                            break;

                        // Perbaikan ditolak
                        case 34:
                            $actionFuncs = array_diff($actionFuncs, [
                                "get_edit"
                            ]);
                            break;

                        case 38:
                            $actionFuncs = array_diff($actionFuncs, [
                                "get_edit"
                            ]);
                            break;
                    }
                }

                if (in_array($roles, [1, 12])) {
                    switch ((int) $row->is_verifikasi_admin) {
                        // Permintaan perbaharui data sertifikat
                        case 37:
                            $actionFuncs = [
                                "get_agree"
                            ];

                            break;

                        // Pengajuan ulang perbaharui data sertifikat
                        case 38:
                            $actionFuncs = [
                                "get_agree"
                            ];

                            break;

                        // Perbaikan dikembalikan
                        case 33:
                            $actionFuncs = [
                                "get_detail",
                                // "get_edit"
                            ];

                            break;

                        // Perbaikan ditolak
                        case 34:
                            $actionFuncs = [
                                "get_detail"
                            ];

                            break;

                        // Perbaikan disetujui
                        case 35:
                            $actionFuncs = [
                                "get_detail"
                            ];

                            break;
                    }
                }

                $action = $row->is_trash != 18
                    ? collect($actionFuncs)->reduce(
                        function ($carry, $func) use (
                            $encode,
                            $roles,
                            $permissions_icon
                        ) {
                            return $carry . $func(
                                $encode,
                                $roles,
                                $permissions_icon->uri,
                                $permissions_icon->public_id
                            );
                        },
                    ''
                )
                : get_detail(
                    $encode,
                    $roles,
                    $permissions_icon->uri,
                    $permissions_icon->public_id
                )
                .get_edit(
                    $encode,
                    $roles,
                    $permissions_icon->uri,
                    $permissions_icon->public_id
                );

                $bulanInggris = [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ];

                $bulanIndonesia = [
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                ];

                $tempatTanggalLahir = str_replace(
                    $bulanInggris,
                    $bulanIndonesia,
                    $row->tempat_tanggal_lahir
                );

                $tempatTanggalLahir_pengaduan = str_replace(
                    $bulanInggris,
                    $bulanIndonesia,
                    $row->tempat_tanggal_lahir_pengaduan
                );

                $statusVerifikasi = in_array($roles, [1, 12]) ? (int) $row->is_verifikasi_admin : (int) $row->is_verifikasi_user;
                $this_status = match ($statusVerifikasi) {
                    null => '<span class="badge text-bg-primary">Sedang berjalan di sistem</span>',
                    0    => '<span class="badge text-bg-primary">Sedang berjalan di sistem</span>',
                    30   => '<span class="badge text-bg-primary">Sedang berjalan di sistem</span>',
                    31   => '<span class="badge text-bg-info">Perbaikan terkirim</span>',
                    32   => '<span class="badge text-bg-dark">Perbaikan ditinjau</span>',
                    33   => '<span class="badge text-bg-warning">Perbaikan dikembalikan</span>',
                    34   => '<span class="badge text-bg-danger">Perbaikan ditolak</span>',
                    35   => '<span class="badge text-bg-success">Perbaikan disetujui</span>',
                    36   => '<span class="badge text-bg-danger">Data nonaktif, hubungi admin</span>',
                    37   => '<span class="badge text-bg-info">Permintaan perbaharui data sertifikat</span>',
                    38   => '<span class="badge text-bg-warning">Pengajuan ulang perbaharui data sertifikat</span>',
                    default => '<span class="badge text-bg-secondary">-</span>',
                };

                return [
                    "DT_RowIndex"          => $start,
                    "instansi"             => $roles == 10 ? $row->instansi : $row->utusan_pengaduan,
                    "nama"                 => $roles == 10 ? $row->nama : $row->nama_pengaduan,
                    "tempat_tanggal_lahir" => $roles == 10 ? $tempatTanggalLahir : $tempatTanggalLahir_pengaduan,
                    "status"               => $this_status,
                    "aksi"                 => $action,
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