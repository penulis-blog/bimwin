<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Cache;
use App\Models\M_kecamatan;
use App\Helpers\Permissions;
use Illuminate\Support\Facades\DB;

class C_kecamatan extends Controller
{
    public function index()
    {
        return view("backend.layouts.masters.kecamatan");
    }

    public function kabupaten()
    {
        $data = DB::table('mst_kabupaten')->get();

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function post(Request $request)
    {
        $id_kabupaten  = $request->input('id_kabu');
        $max = DB::table('mst_kecamatan')
            ->where('id_kabupaten', $id_kabupaten) 
            ->selectRaw('MAX(CAST(id_kecamatan AS UNSIGNED)) as max_id')
            ->value('max_id');
        $total = $max + 1;

        $data = [
            'id_kabupaten' => $id_kabupaten,
            'id_kecamatan' => $total,
            'nama' => $request->input('nm_kec'),
            'is_actived' => 1,
            'latitude' => $request->input('lat'),
            'longitude' => $request->input('long')
        ];

        $id_ = DB::table("mst_kecamatan")->insertGetId($data);

        $nilai = DB::table('mst_kecamatan')
            ->where('id_kabupaten', $id_kabupaten)
            ->whereNotNull('kode_kua')
            ->selectRaw('MAX(CAST(kode_kua AS UNSIGNED)) as max_id')
            ->value('max_id');

        if (empty($nilai)) {
            $exec = $total . '1';
        } else {
            $hasil = substr((string)$nilai, 0, 6);

            if ((string)$total !== $hasil) {
                $exec = $total . '1';
            } else {
                $exec = (string)((int)$nilai + 1);
            }
        }

        $kode_kua = [
            'kode_kua' => $exec
        ];

        DB::table('mst_kecamatan')->where('id', $id_)->update($kode_kua);

        return response()->json(['message' => 200]);
    }

    public function edit($id)
    {
        $model = new M_kecamatan();
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
        $model = new M_kecamatan();
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
        $id           = $request->input('e_publicid');
        $id_kabupaten = $request->input('e_id_kabu');
        $id_kecamatan = $request->input('e_id_kec');
        $kua          = $request->input('e_id_kua');

        $model  = new M_kecamatan();
        $data   = $model->get_data($id);
        $hitung = $model->get_kecamatan($id_kabupaten, $id_kecamatan, $kua);

        if($data->id_kabupaten == $id_kabupaten && $data->id_kecamatan == $id_kecamatan && $data->kode_kua == $kua){
            $exec = [
                'nama' => $request->input('e_nm_kec'),
                'is_actived' => $request->input('eis_trash'),
                'latitude' => $request->input('e_lat'),
                'longitude' => $request->input('e_long')
            ];

            DB::table('mst_kecamatan')->where('id', $id)->update($exec);

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
            DB::table('mst_kecamatan')->where('id', $id)->update($data);

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
        $model = new M_kecamatan();
        $exec  = $model->get_group($roles, $user->id);

        $publicId = "3ba6c5f0-5300-44e4-951b-44f0a83dc898";
        $permissions_icon = Permissions::get_permissions($publicId);

        // --- Query utama ---
        $query = DB::table("view_kecamatan");

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
            return DB::table("view_kecamatan")->count();
        });

        // --- Filter search ---
        if ($search) {
            $searchColumns = ["kode_kua", "kecamatan"];
            $query->where(function($q) use ($searchColumns, $search) {
                foreach ($searchColumns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        $recordsFiltered = $query->count();

        $data = $query
            ->select("id", "id_kecamatan", "id_kabupaten", "kode_kua", "kecamatan", "latitude", "longitude", "status", "is_actived")
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
                    "id_kabupaten"  => $row->id_kabupaten,
                    "id_kecamatan"  => $row->id_kecamatan,
                    "kode_kua"      => $row->kode_kua,
                    "kecamatan"     => $row->kecamatan,
                    "latitude"      => $row->latitude,
                    "longitude"     => $row->longitude,
                    "status"        => $row->status,
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