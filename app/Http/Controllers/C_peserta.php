<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\M_peserta;
use App\Helpers\Permissions;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use PDF;

class C_peserta extends Controller
{
    public function index()
    {
        return view("backend.layouts.kegiatan.peer");
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
        $model = new M_peserta();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "6a46d0d8-4c4a-4a8d-a877-c429c46e17c7";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Hapus cache setelah update DB ---
        Permissions::forget_cache($publicId);

        $query = DB::table("view_peserta")->where([['is_trash', '!=', 18]])->whereNotBetween('kategori', [451, 456]); // peer educator

        // --- Filter role ---
        if (!in_array($roles, [1, 12])) {
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