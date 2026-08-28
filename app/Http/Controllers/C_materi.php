<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_materi;

class C_materi extends Controller
{
    public function index()
    {
        $model = new M_materi();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.informasi.materi", $data);
    }

    public function tambah(Request $request)
    {
        $data = [
            'public_id'      => Str::uuid()->toString(),
            'kategori'       => $request->input('mt_ktgr'),
            'judul'          => $request->input('mt_jdl'),
            'keterangan'     => $request->input('mt_ktrgn'),
            'pranala'        => $request->input('mt_url'),
            'is_trash'       => 11,
            "created"        => auth()->user()->id,
            "created_date"   => date("Y-m-d H:i:s")
        ];

        if($data){
             DB::table('dt_materi')->insert($data);

            return response()->json([
                "message"        => 200
            ]);
        }else{
            return response()->json([
                "message"        => 201
            ]);
        }
    }

    public function edit($id)
    {
        $data = M_materi::get_data($id);

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
        $id = $request->input('e_mt_publicid');

        $data = [
            'kategori'     => $request->input('e_mt_ktgr'),
            'judul'        => $request->input('e_mt_jdl'),
            'keterangan'   => $request->input('e_mt_ktrgn'),
            'pranala'      => $request->input('e_mt_url'),
            'is_trash'     => $request->input('e_mt_stat'),
            'updated'      => auth()->user()->id,
            'updated_date' => date("Y-m-d H:i:s")
        ];

        $updated = DB::table('dt_materi')
                    ->where('public_id', $id)
                    ->update($data);

        if ($updated) {
            return response()->json([
                "message" => 200
            ]);
        } else {
            return response()->json([
                "message" => 201
            ]);
        }
    }

    public function detail($id)
    {
        $data = M_materi::get_materi($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 200,
            ], 200)
            : response()->json([
                'message' => 404,
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
            DB::table('dt_materi')->where('public_id', $id)->update($data);

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
        $permissions_icon = Permissions::this_permissions("");
        $query = DB::table("view_materi");

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
                    "ktgr",
                    "judul",
                    "keterangan",
                    "pranala",
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
                        "ktgr"          => $row->ktgr,
                        "judul"         => Str::words($row->judul, 7, '...'),
                        "keterangan"    => Str::words($row->keterangan, 7, '...'),
                        "pranala"       => Str::words($row->pranala, 7, '...'),
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