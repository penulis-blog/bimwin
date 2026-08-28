<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\M_kegiatan;
use App\Helpers\Permissions;
use App\Exports\DaftarHadirExport;
use App\Exports\DaftarPerlengkapanExport;
use App\Exports\DaftarRekeningExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DNS2D;
use Illuminate\Support\Facades\DB;

class C_kegiatan extends Controller
{
    public function index()
    {
        // return 'hallo';
        // return view("backend.layouts.kegiatan");
    }

    public function json(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $start = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $model = new M_kegiatan();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "f8f1df6c-b6e7-49b9-a9e1-5bebdb5dc496",
        );  // index halaman bimwin

        // dd($permissions_icon);die();

        // --- Build query langsung ---
        $query = DB::table("view_kegiatan")->where([['id_subdit', '=', '45'], ['id_kategori', '>', '456']]);

        // --- Filter berdasarkan role ---
        if (!in_array($roles, [1, 12])) {
            // Tampilkan hanya data terkait direktorat/subdit user
            $query->where("id_direktorat", $exec->id_direktorat)
                ->where("id_subdit", $exec->id_subdit);
        }

        // --- Filter search ---
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where("judul_acara", "like", "%{$search}%")
                ->orWhere("tempat", "like", "%{$search}%")
                ->orWhere("lokasi", "like", "%{$search}%");
            });
        }

        // --- recordsTotal & recordsFiltered ---
        $recordsTotal = DB::table("view_kegiatan")->where([['id_subdit', '=', '45'], ['id_kategori', '>', '456']]);
        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        // dd($query->toSql(), $query->getBindings());
        $data = $query
            ->select(
                "id",
                "public_id",
                "judul_acara",
                "lokasi",
                "tempat",
                "dari",
                "sampai",
                "angkatan",
                "peserta",
                "is_trash",
                "id_direktorat",
                "id_subdit"
            )
            ->skip($start)
            ->take($length)
            ->get();

        // --- Bangun result DataTables ---
        $result = [];
        $index = $start + 1;

        foreach ($data as $row) {
            $encode = $row->public_id;
            $angkatan = $row->angkatan;

            $actionFuncs = [
                "get_detail","get_edit","get_delete","get_password",
                "get_agree","get_back","get_config","get_modules","get_download"
            ];

            $action = $row->is_trash == 12
                ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                    $id = $func === "get_back" 
                        ? $row->angkatan.'+'.$row->public_id  
                        : $row->public_id;
                    return $carry . $func($id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                }, '');

            $result[] = [
                "DT_RowIndex" => $index++,
                "public_id" => $row->public_id,
                "judul_acara" => $row->judul_acara,
                "lokasi" => $row->lokasi,
                "tempat" => $row->tempat,
                "dari" => $row->dari,
                "sampai" => $row->sampai,
                "angkatan" => $row->angkatan,
                "peserta" => $row->peserta,
                "is_trash" => $row->is_trash,
                "aksi" => $action,
            ];
        }

        return response()->json([
            "draw" => intval($request->get("draw")),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $result,
        ]);
    }
}