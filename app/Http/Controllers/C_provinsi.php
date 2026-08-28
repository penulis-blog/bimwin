<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use App\Models\M_provinsi;
use App\Helpers\Permissions;
use Illuminate\Support\Facades\DB;

class C_provinsi extends Controller
{
    public function index()
    {
        return view("backend.layouts.masters.provinsi");
    }

    public function post(Request $request)
    {
        $id_provinsi = $request->input('id_prov');
        $id_satker   = $request->input('id_satker');
        $model       = new M_provinsi();

        $hitung = $model->get_provinsi($id_provinsi, $id_satker)->count();

        if ($hitung > 0) {
            return response()->json(['message' => 201]);
        }

        $data = [
            'id_provinsi' => $id_provinsi,
            'satker' => $id_satker,
            'nama' => $request->input('nm_prov'),
            'is_actived' => 1,
            'latitude' => $request->input('lat'),
            'longitude' => $request->input('long')
        ];

        DB::table('mst_provinsi')->insert($data);

        return response()->json(['message' => 200]);
    }

    public function edit($id)
    {
        $model = new M_provinsi();
        $data  = $model->get_data($id);

        if ($data) {
            return response()->json([
                'message' => 200,
                'data'    => $data
            ]);
        }

        return response()->json(['message' => 201]);
    }

    public function detail($id)
    {
        $model = new M_provinsi();
        $data  = $model->get_data($id);

        if ($data) {
            return response()->json([
                'message' => 200,
                'data'    => $data
            ]);
        }

        return response()->json(['message' => 201]);
    }

    public function update(Request $request)
    {
        $id          = $request->input('e_publicid');
        $id_provinsi = $request->input('e_id_prov');
        $id_satker   = $request->input('e_id_satker');

        $model  = new M_provinsi();
        $data   = $model->get_data($id);
        $hitung = $model->get_provinsi($id_provinsi, $id_satker)->count();

        if($data->id_provinsi == $id_provinsi && $data->satker == $id_satker){
            $exec = [
                'id_provinsi' => $id_provinsi,
                'satker' => $id_satker,
                'nama' => $request->input('e_nm_prov'),
                'is_actived' => $request->input('eis_trash'),
                'latitude' => $request->input('e_lat'),
                'longitude' => $request->input('e_long')
            ];

            DB::table('mst_provinsi')->where('id', $id)->update($exec);

            return response()->json(['message' => 200]);
        }else{
            if ($hitung > 0) {
                return response()->json(['message' => 201]);
            }
        }
    }

    public function deleted(Request $request)
    {
        $id     = $request->input('val');
        $data   = [
            'is_actived' => 0
        ];

        if (!empty($id) && !empty($data)) {
            DB::table('mst_provinsi')->where('id', $id)->update($data);

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
        $model = new M_provinsi();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "e6f72447-0c76-4e3a-96d0-70bc4f18be83";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Query utama ---
        $query = DB::table("view_provinsi");

        // --- Filter role ---
        if (!in_array($roles, [1, 12])) {
            if ($exec->id_direktorat) {
                $query->where("id_direktorat", $exec->id_direktorat);
            }
            if ($exec->id_subdit) {
                $query->where("id_subdit", $exec->id_subdit);
            }
        }

        // --- Cache total records tanpa filter role/search (5 menit) ---
        $cacheKeyTotal = "peserta_total";
        $recordsTotal = Cache::remember($cacheKeyTotal, 300, function () {
            return DB::table("view_provinsi")->count();
        });

        // --- Filter search ---
        if ($search) {
            $searchColumns = ["satker", "nama"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        $data = $query
            ->select("id", "id_provinsi", "satker", "nama", "latitude", "longitude", "status", "is_actived")
            ->skip($start)
            ->take($length)
            ->get()
            ->map(function($row) use ($permissions_icon, $roles, &$start) {
                $start++;

                $actionFuncs = [
                    "get_detail","get_edit","get_delete","get_password",
                    "get_agree","get_back","get_config","get_modules","get_download"
                ];

                $action = $row->is_actived == 0
                    ? get_detail($row->id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    . get_edit($row->id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                    : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                        return $carry . $func($row->id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    }, '');

                return [
                    "DT_RowIndex"   => $start,
                    "id"            => $row->id,
                    "id_provinsi"   => $row->id_provinsi,
                    "satker"        => $row->satker,
                    "nama"          => $row->nama,
                    "status"        => $row->status,
                    "latitude"      => $row->latitude,
                    "longitude"     => $row->longitude,
                    "is_actived"    => $row->is_actived,
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