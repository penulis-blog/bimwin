<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_roles;

class C_roles extends Controller
{
    public function index()
    {
        return view("backend.layouts.pengaturan.roles");
    }

    public function post(Request $request)
    {
        $data = [
            "public_id" => Str::uuid()->toString(),
            "nama" => $request->input("nama_roles"),
            "keterangan" => $request->input("keterangan_roles"),
            "is_trash" => 1,
            "created" => auth()->user()->id,
            "created_date" => date("Y-m-d H:i:s"),
        ];

        $id_ = DB::table("sys_roles")->insertGetId($data);

        // insert ke menu permissions
        $checking_menu = DB::table("sys_menu")
            ->where([["kategori", "=", 2], ["is_systems", "=", 0]])
            ->get();
        $menu_permissions = [];
        $index = 0;

        foreach ($checking_menu as $c) {
            array_push($menu_permissions, [
                "public_id" => Str::uuid()->toString(),
                "id_roles" => $id_,
                "id_menu" => $c->id,
                "created" => auth()->user()->id,
                "created_date" => date("Y-m-d H:i:s"),
            ]);
            $index++;
        }

        DB::table("sys_menu_permissions")->insert($menu_permissions);

        $result = [
            "message" => 200,
        ];

        return response()->json($result);
    }

    public function edit($id)
    {
        $roles = new M_roles();
        $data = $roles->get_data($id);

        if (count($data) == 1) {
            $result = [
                "data" => $data,
                "message" => 200,
            ];

            return response()->json($result);
        } else {
            $result = [
                "message" => 404,
            ];

            return response()->json($result);
        }
    }

    public function detail($id)
    {
        $roles = new M_roles();
        $data = $roles->get_data($id);

        if (count($data) == 1) {
            $result = [
                "data" => $data,
                "message" => 200,
            ];

            return response()->json($result);
        } else {
            $result = [
                "message" => 404,
            ];

            return response()->json($result);
        }
    }

    public function permissions($id)
    {
        $roles = new M_roles();
        $data = $roles->get_permissions($id);

        if (count($data) > 0) {
            $result = [
                "message" => 200,
                "data" => $data,
            ];

            return response()->json($result);
        } else {
            $result = [
                "message" => 404,
            ];

            return response()->json($result);
        }
    }

    public function permissions_update(Request $request)
    {
        $ids = $request->input("id");
        $level = $request->input("id_roles");
        $views = $request->input("is_view");
        $adds = $request->input("is_add");
        $editeds = $request->input("is_edit");
        $deleteds = $request->input("is_delete");
        $accepts = $request->input("is_report");
        $passwords = $request->input("is_password");
        $agrees = $request->input("is_agree");
        $backs = $request->input("is_back");
        $configs = $request->input("is_config");
        $modules = $request->input("is_module");
        $download = $request->input("is_download");
        $updated = auth()->user()->id;
        $updated_date = date("Y-m-d H:i:s");

        foreach ($ids as $key => $val) {
            DB::table("sys_menu_permissions")
                ->where("id", $ids[$key])
                ->update([
                    "id_roles" => $level[$key],
                    "view" => $views[$key],
                    "add" => $adds[$key],
                    "edit" => $editeds[$key],
                    "delete" => $deleteds[$key],
                    "report" => $accepts[$key],
                    "password" => $passwords[$key],
                    "agree" => $agrees[$key],
                    "back" => $backs[$key],
                    "config" => $configs[$key],
                    "module" => $modules[$key],
                    "download" => $download[$key],
                    "updated" => $updated,
                    "updated_date" => $updated_date,
                ]);
        }

        $result = [
            "message" => true,
        ];

        return response()->json($result);
    }

    public function update(Request $request)
    {
        $id = $request->input("publicid_roles");
        $data = [
            "nama" => $request->input("edit_nama_roles"),
            "keterangan" => $request->input("edit_keterangan_roles"),
            "is_trash" => $request->input("edit_status_roles"),
            "updated" => auth()->user()->id,
            "updated_date" => date("Y-m-d H:i:s"),
        ];

        DB::table("sys_roles")
            ->where("public_id", $id)
            ->update($data);

        $result = [
            "message" => 200,
        ];

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $id = $request->input("val");
        $data = [
            "is_trash" => 0,
            "deleted" => auth()->user()->id,
            "deleted_date" => date("Y-m-d H:i:s"),
        ];

        if (!empty($id) && !empty($data)) {
            DB::table("sys_roles")
                ->where("public_id", $id)
                ->update($data);

            $result = [
                "message" => 200,
            ];

            return response()->json($result);
        } else {
            $result = [
                "message" => 201,
            ];

            return response()->json($result);
        }
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
        $this_ = Permissions::id_data();

        $permissions_icon = Permissions::this_permissions(
            "36162a2c-fca8-49da-ad12-14948e5f50dc",
        );

        // --- Build query langsung tanpa baseQuery ---
        $query = DB::table("view_roles");

        // --- recordsTotal (total sebelum filter) ---
        $recordsTotal = $query->count();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where("nama", "like", "%{$search}%"); // <-- tambahkan titik koma
            });
        }

        // --- recordsFiltered ---
        $recordsFiltered = $query->count();

        // --- Ambil data dengan pagination ---
        $data = $query
            ->select(
                "id",
                "public_id",
                "nama",
                "status",
                "keterangan",
                "is_trash",
            )
            ->skip($start)
            ->take($length)
            ->get();

        // --- Bangun result DataTables ---
        $result = [];
        $index = $start + 1;

        foreach ($data as $row) {
            $encode = $row->public_id;
            $action =
                $permissions_icon->is_trash == 1
                    ? get_detail(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_edit(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_delete(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_password(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_agree(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_back(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_config(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_modules(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_download(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        )
                    : get_detail(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        ) .
                        get_edit(
                            $encode,
                            $roles,
                            $permissions_icon->uri,
                            $permissions_icon->public_id,
                        );

            $result[] = [
                "DT_RowIndex" => $index++,
                "public_id" => $row->public_id,
                "nama" => $row->nama,
                "status" => $row->status,
                "keterangan" => $row->keterangan,
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