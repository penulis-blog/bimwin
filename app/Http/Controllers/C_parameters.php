<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_parameters;

class C_parameters extends Controller
{
    public function index()
    {
        return view('backend.layouts.pengaturan.parameters');
    }

    public function post(Request $request)
    {
        $data = [
            'public_id' => Str::uuid()->toString(),
            'name' => $request->input('nama_parameters'),
            'group' => $request->input('group_parameters'),
            'value' => $request->input('value_parameters'),
            'keterangan' => $request->input('ket_parameters'),
            'is_trash' => 1,
            'created' => auth()->user()->id,
            'created_date' => date('Y-m-d H:i:s')
        ];

        if(!empty($data)){
            DB::table('sys_parameters')->insert($data);

            $result = [
                'message' => 200
            ];

            return response()->json($result);
        }else{
            $result = [
                'message' => 201
            ];

            return response()->json($result);
        }
    }

    public function detail($id)
    {}

    public function edit($id)
    {
        $menu   = new M_parameters();
        $data   = $menu->get_data($id);
        $hitung = count($data);

        if($hitung > 0){
            $result = [
                'message' => 200,
                'data' => $data
            ];

            return response()->json($result);
        }else{
            $result = [
                'message' => 201
            ];

            return response()->json($result);
        }
    }

    public function update(Request $request)
    {
        $id     = $request->input('e_id');

        $data   = [
            'name' => $request->input('e_nama_parameters'),
            'group' => $request->input('e_group_parameters'),
            'value' => $request->input('e_value_parameters'),
            'keterangan' => $request->input('e_ket_parameters'),
            'is_trash' => $request->input('e_is_trash'),
            'updated' => auth()->user()->id,
            'updated_date' => date('Y-m-d H:i:s')
        ];

        if(!empty($id) && !empty($data)){
            DB::table('sys_parameters')->where('public_id', $id)->update($data);

            $result = [
                'message' => 200
            ];

            return response()->json($result);
        }else{
            $result = [
                'message' => 201
            ];

            return response()->json($result);
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
            DB::table('sys_parameters')->where('public_id', $id)->update($data);

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
        $permissions_icon = Permissions::this_permissions("a46773a5-d01e-444a-ab2a-d012a8ef1c08");

        $query = DB::table("view_parameters");

        $recordsTotal = $query->count();

        if ($search) {
            $columns = ["name", "`group`", "keterangan"];
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
                    "name",
                    "group",
                    "value",
                    "keterangan",
                    "status",
                    "is_trash"
                )
                ->skip($start)
                ->take($length)
                ->get()
                ->map(function($row) use ($permissions_icon, $roles, &$start) {
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

                    $action = $permissions_icon->is_trash == 1
                        ? collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                            return $carry . $func($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                        }, '')
                        : get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                        . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id);

                    return [
                        "DT_RowIndex" => $start,
                        "public_id"   => $row->public_id,
                        "name"        => $row->name,
                        "group"       => $row->group,
                        "value"       => $row->value,
                        "keterangan"  => Str::words($row->keterangan, 3, '...'),
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