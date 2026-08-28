<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_menu;

class C_menu extends Controller
{
    public function index()
    {
        return view('backend.layouts.pengaturan.menu');
    }

    public function ambil_induk_menu()
    {
        $data = get_induk();

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function induk_frontend($id)
    {
        $menu = new M_menu();
        $data = $menu->get_frontend($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function ambil_parent($id)
    {
        $menu = new M_menu();
        $data = $menu->get_parent($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function edit_menu($id)
    {
        $menu   = new M_menu();
        $data   = $menu->get_menu($id);
        $hitung = count(array($data[0]->id_parent_child));
        
        if(!empty($data[0]->id_parent_child)){
            $induk = $menu->get_menu_id($data[0]->id_parent_child);

            $result = [
                'data' => $data,
                'data2' => $data[0]->id,
                'data3' => $data[0]->id_parent,
                'id_' => $induk[0]->id_parent
            ];

            return response()->json($result);
        }else{
            $result = [
                'data' => $data,
                'data2' => $data[0]->id,
                'data3' => $data[0]->id_parent
            ];

            return response()->json($result);
        }
    }

    public function update(Request $request)
    {
        $menu    = new M_menu();
        $id      = $request->input('edit_public');
        $urutan  = $request->input('edit_id_urutan_menu');
        $icon_2  = $request->input('edit_icon_menu_child');
        
        if(!empty($urutan)){
            $no_on   = $menu->get_menu_id($urutan);
            $no_next = $menu->get_induk_next_edit($urutan);

            $number   = [
                'no_urut' => $no_on[0]->no_urut + 1,
                'nama' => $request->input('edit_nama_menu'),
                'icon' => $request->input('edit_icon_menu'),
                'method' => $request->input('edit_id_method'),
                'uri' => $request->input('edit_uri_pranala'),
                'controller' => $request->input('edit_controller'),
                'action' => $request->input('edit_action'),
                'middleware' => $request->input('edit_middleware'),
                'is_trash' => $request->input('edit_is_trash'),
                'updated' => auth()->user()->id,
                'updated_date' => date('Y-m-d H:i:s')
            ];

            DB::table('sys_menu')->where('public_id', $id)->update($number);

            foreach ($no_next as $key => $val) {
                DB::table('sys_menu')
                    ->where('id', $val->id)
                    ->update([
                        'no_urut'  => $val->no_urut + 1,
                ]);
            }

            $result = [
                'message' => 200
            ];

            return response()->json($result);
        }else if(!empty($icon_2)){
            $icon_parent   = [
                'nama' => $request->input('edit_nama_menu'),
                'icon' => $request->input('edit_icon_menu'),
                'icon_parent' => $request->input('edit_icon_menu_child'),
                'method' => $request->input('edit_id_method'),
                'uri' => $request->input('edit_uri_pranala'),
                'controller' => $request->input('edit_controller'),
                'action' => $request->input('edit_action'),
                'middleware' => $request->input('edit_middleware'),
                'is_trash' => $request->input('edit_is_trash'),
                'updated' => auth()->user()->id,
                'updated_date' => date('Y-m-d H:i:s')
            ];

            DB::table('sys_menu')->where('public_id', $id)->update($icon_parent);

            $result = [
                'message' => 200
            ];

            return response()->json($result);
        }else{
            $polos   = [
                'nama' => $request->input('edit_nama_menu'),
                'method' => $request->input('edit_id_method'),
                'uri' => $request->input('edit_uri_pranala'),
                'controller' => $request->input('edit_controller'),
                'action' => $request->input('edit_action'),
                'middleware' => $request->input('edit_middleware'),
                'is_trash' => $request->input('edit_is_trash'),
                'updated' => auth()->user()->id,
                'updated_date' => date('Y-m-d H:i:s')
            ];

            DB::table('sys_menu')->where('public_id', $id)->update($polos);

            $result = [
                'message' => 200
            ];

            return response()->json($result);
        }
    }

    public function detail($id)
    {
        $menu = new M_menu();
        $data = $menu->get_detail($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function ambil_child($id)
    {
        $menu = new M_menu();
        $data = $menu->get_child($id);
        $total = count($data);

        if($total == 0){
            $result = [
                'data' => $data
            ];

            return response()->json($result);
        }else{
            $result = [
                'data' => $data
            ];

            return response()->json($result);
        }
    }

    public function post(Request $request)
    {
        $menu      = new M_menu();
        $jenisMenu = $request->input('id_checkbox');
        $kategori  = $request->input('id_kategori');
        $systems   = $request->input('id_systems');
        $roles     = $menu->get_roles();

        if($jenisMenu == true){
            if($systems == 1){ // tanpa isi id_parent, id_parent_child, nomor urut, icon, dan icon_parent (buat menu proses script/query)
                $data = [
                    'public_id' => Str::uuid()->toString(),
                    'id_parent' => null,
                    'id_parent_child' => null,
                    'no_urut' => null,
                    'kategori' => $request->input('id_kategori'),
                    'nama' => $request->input('nama_menu'),
                    'icon' => null,
                    'icon_parent' => null,
                    'method' => $request->input('id_method'),
                    'uri' => $request->input('uri_pranala'),
                    'controller' => $request->input('controller'),
                    'action' => $request->input('action'),
                    'name' => $request->input('name_route', null),
                    'middleware' => $request->input('middleware', null),
                    'is_systems' => $systems,
                    'is_trash' => 1,
                    'created' => auth()->user()->id,
                    'created_date' => date('Y-m-d H:i:s')
                ];

                DB::table('sys_menu')->insert($data);

                $result = [
                    'message' => 200
                ];

                return response()->json($result);
            }else{
                if($systems == 0 && $kategori == 2){ // hanya menu dan kategori backend
                    $on_posisi_menu_backend = M_menu::get_induk_on($request->input('id_urutan_menu'));
                    $next_posisi_menu_backend = M_menu::get_induk_next($request->input('id_urutan_menu'));

                    $data = [
                        'public_id' => Str::uuid()->toString(),
                        'id_parent' => 0,
                        'id_parent_child' => null,
                        'no_urut' => $on_posisi_menu_backend[0]->no_urut + 1,
                        'kategori' => $kategori,
                        'nama' => $request->input('nama_menu'),
                        'icon' => $request->input('icon_menu'),
                        'icon_parent' => null,
                        'method' => $request->input('id_method'),
                        'uri' => $request->input('uri_pranala'),
                        'controller' => $request->input('controller'),
                        'action' => $request->input('action'),
                        'middleware' => $request->input('middleware'),
                        'is_systems' => $systems,
                        'is_trash' => 1,
                        'created' => auth()->user()->id,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    $id_ = DB::table('sys_menu')->insertGetId($data);

                    // insert ke menu permissions
                    $permissions    = array();
                    $index          = 0;

                    foreach ($roles as $c) {
                        array_push($permissions, array(
                            'public_id'     => Str::uuid()->toString(),
                            'id_roles'      => $c->id,
                            'id_menu'       => $id_,
                            'created'       => auth()->user()->id,
                            'created_date'  => date('Y-m-d H:i:s')
                        ));
                        $index++;
                    }

                    DB::table('sys_menu_permissions')->insert($permissions);

                    // update nomor urut, sesuai id setelahnya dari id yang di atas
                    foreach ($next_posisi_menu_backend as $key => $val) {
                        DB::table('sys_menu')
                            ->where('id', $val->id)
                            ->update([
                                'no_urut'  => $val->no_urut + 1,
                        ]);
                    }

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }else if($systems == 0 && $kategori == 1){ // hanya menu dan kategori frontend (tidak perlu menu permissions)
                    $urutan = $request->input('id_urutan_menu');
                    
                    if($urutan == null){
                        $data = [
                            'public_id' => Str::uuid()->toString(),
                            'id_parent' => 0,
                            'id_parent_child' => null,
                            'no_urut' => 1,
                            'kategori' => $kategori,
                            'nama' => $request->input('nama_menu'),
                            'icon' => $request->input('icon_menu'),
                            'icon_parent' => null,
                            'method' => $request->input('id_method'),
                            'uri' => $request->input('uri_pranala'),
                            'controller' => $request->input('controller'),
                            'action' => $request->input('action'),
                            'middleware' => $request->input('middleware'),
                            'is_systems' => $systems,
                            'is_trash' => 1,
                            'created' => auth()->user()->id,
                            'created_date' => date('Y-m-d H:i:s')
                        ];

                        DB::table('sys_menu')->insert($data);

                        $result = [
                            'message' => 200
                        ];

                        return response()->json($result);
                    }else{
                        $on_posisi_menu_backend = M_menu::get_induk_on_frontend($request->input('id_urutan_menu'));
                        $next_posisi_menu_backend = M_menu::get_induk_next_frontend($request->input('id_urutan_menu'));
                        $total = count($next_posisi_menu_backend);
                        
                        if($total > 0){
                            $data = [
                                'public_id' => Str::uuid()->toString(),
                                'id_parent' => 0,
                                'id_parent_child' => null,
                                'no_urut' => $on_posisi_menu_backend[0]->no_urut + 1,
                                'kategori' => $kategori,
                                'nama' => $request->input('nama_menu'),
                                'icon' => $request->input('icon_menu'),
                                'icon_parent' => null,
                                'method' => $request->input('id_method'),
                                'uri' => $request->input('uri_pranala'),
                                'controller' => $request->input('controller'),
                                'action' => $request->input('action'),
                                'middleware' => $request->input('middleware'),
                                'is_systems' => $systems,
                                'is_trash' => 1,
                                'created' => auth()->user()->id,
                                'created_date' => date('Y-m-d H:i:s')
                            ];

                            DB::table('sys_menu')->insert($data);

                            foreach ($next_posisi_menu_backend as $key => $val) {
                                DB::table('sys_menu')
                                    ->where('id', $val->id)
                                    ->update([
                                        'no_urut'  => $val->no_urut + 1,
                                ]);
                            }

                            $result = [
                                'message' => 200
                            ];

                            return response()->json($result);
                        }else{
                            $data = [
                                'public_id' => Str::uuid()->toString(),
                                'id_parent' => 0,
                                'id_parent_child' => null,
                                'no_urut' => $on_posisi_menu_backend[0]->no_urut + 1,
                                'kategori' => $kategori,
                                'nama' => $request->input('nama_menu'),
                                'icon' => $request->input('icon_menu'),
                                'icon_parent' => null,
                                'method' => $request->input('id_method'),
                                'uri' => $request->input('uri_pranala'),
                                'controller' => $request->input('controller'),
                                'action' => $request->input('action'),
                                'middleware' => $request->input('middleware'),
                                'is_systems' => $systems,
                                'is_trash' => 1,
                                'created' => auth()->user()->id,
                                'created_date' => date('Y-m-d H:i:s')
                            ];

                            DB::table('sys_menu')->insert($data);

                            $result = [
                                'message' => 200
                            ];

                            return response()->json($result);
                        }
                    }
                }
            }
        }else if($jenisMenu == null){
            if($kategori == 1){ // frontend
                dd('frontend');die();
            }else{
                $parent = $request->input('id_parent');
                $child  = $request->input('id_child');

                if($parent == null || $parent == '' || $parent == 'Pilih'){ // buat parent baru pertama kali dan cek juga nomor urut menu siapa tau sudah ada dan ingin nomor satu
                    $on_posisi_menu_backend = M_menu::get_first_parent_on($request->input('id_induk'));

                    $count = count($on_posisi_menu_backend);

                    $data = [
                        'public_id' => Str::uuid()->toString(),
                        'id_parent' => $request->input('id_induk'),
                        'no_urut' => 1,
                        'kategori' => $request->input('id_kategori'),
                        'nama' => $request->input('nama_menu'),
                        'icon' => $request->input('icon_menu'),
                        'method' => $request->input('id_method'),
                        'uri' => $request->input('uri_pranala'),
                        'controller' => $request->input('controller'),
                        'action' => $request->input('action'),
                        'middleware' => $request->input('middleware'),
                        'is_systems' => 0,
                        'is_trash' => 1,
                        'created' => auth()->user()->id,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    $id_ = DB::table('sys_menu')->insertGetId($data);

                    // insert ke menu permissions
                    $permissions    = array();
                    $index          = 0;

                    foreach ($roles as $c) {
                        array_push($permissions, array(
                            'public_id'     => Str::uuid()->toString(),
                            'id_roles'      => $c->id,
                            'id_menu'       => $id_,
                            'created'       => auth()->user()->id,
                            'created_date'  => date('Y-m-d H:i:s')
                        ));
                        $index++;
                    }

                    DB::table('sys_menu_permissions')->insert($permissions);

                    if($count > 0){ // nomor urut di jadikan pertama walaupun menu parent sudah ada sebelumnya
                        foreach ($on_posisi_menu_backend as $key => $val) {
                            DB::table('sys_menu')
                                ->where('id', $val->id)
                                ->update([
                                    'no_urut'  => $val->no_urut + 1,
                            ]);
                        }
                    }

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }else if($parent != null || $parent != '' || $parent != 'Pilih'){
                    if (!empty($parent) && $child == 'Pilih') { // buat parent
                        $on_posisi_menu_backend = M_menu::get_parent_on($request->input('id_parent'));
                        $next_posisi_menu_backend = M_menu::get_parent_new_next($request->input('id_parent'), $request->input('id_induk'));

                        $count = count($next_posisi_menu_backend);
                        
                        $data = [
                            'public_id' => Str::uuid()->toString(),
                            'id_parent' => $request->input('id_induk'),
                            'no_urut' => $on_posisi_menu_backend[0]->no_urut + 1,
                            'kategori' => $request->input('id_kategori'),
                            'nama' => $request->input('nama_menu'),
                            'icon' => $request->input('icon_menu'),
                            'method' => $request->input('id_method'),
                            'uri' => $request->input('uri_pranala'),
                            'controller' => $request->input('controller'),
                            'action' => $request->input('action'),
                            'middleware' => $request->input('middleware'),
                            'is_systems' => 0,
                            'is_trash' => 1,
                            'created' => auth()->user()->id,
                            'created_date' => date('Y-m-d H:i:s')
                        ];

                        $id_ = DB::table('sys_menu')->insertGetId($data);

                        // insert ke menu permissions
                        $permissions    = array();
                        $index          = 0;

                        foreach ($roles as $c) {
                            array_push($permissions, array(
                                'public_id'     => Str::uuid()->toString(),
                                'id_roles'      => $c->id,
                                'id_menu'       => $id_,
                                'created'       => auth()->user()->id,
                                'created_date'  => date('Y-m-d H:i:s')
                            ));
                            $index++;
                        }

                        DB::table('sys_menu_permissions')->insert($permissions);

                        if($count > 0){
                            foreach ($next_posisi_menu_backend as $key => $val) {
                                DB::table('sys_menu')
                                    ->where('id', $val->id)
                                    ->update([
                                        'no_urut'  => $val->no_urut + 1,
                                ]);
                            }
                        }else{
                            foreach ($next_posisi_menu_backend as $key => $val) {
                                DB::table('sys_menu')
                                    ->where('id', $val->id)
                                    ->update([
                                        'no_urut'  => $val->no_urut + 1,
                                ]);
                            }
                        }

                        $result = [
                            'message' => 200
                        ];

                        return response()->json($result);
                    } else if (!empty($parent) && $child == 'buat_menu_child') { // buat child pertama kali
                        $data = [
                            'public_id' => Str::uuid()->toString(),
                            'id_parent' => $request->input('id_parent'),
                            'id_parent_child' => $request->input('id_parent'),
                            'no_urut' => 1,
                            'kategori' => $request->input('id_kategori'),
                            'nama' => $request->input('nama_menu'),
                            'icon' => $request->input('icon_menu'),
                            'method' => $request->input('id_method'),
                            'uri' => $request->input('uri_pranala'),
                            'controller' => $request->input('controller'),
                            'action' => $request->input('action'),
                            'middleware' => $request->input('middleware'),
                            'is_systems' => 0,
                            'is_trash' => 1,
                            'created' => auth()->user()->id,
                            'created_date' => date('Y-m-d H:i:s')
                        ];

                        $id_ = DB::table('sys_menu')->insertGetId($data);

                        // insert ke menu permissions
                        $permissions    = array();
                        $index          = 0;

                        foreach ($roles as $c) {
                            array_push($permissions, array(
                                'public_id'     => Str::uuid()->toString(),
                                'id_roles'      => $c->id,
                                'id_menu'       => $id_,
                                'created'       => auth()->user()->id,
                                'created_date'  => date('Y-m-d H:i:s')
                            ));
                            $index++;
                        }

                        DB::table('sys_menu_permissions')->insert($permissions);

                        $icon_child = [
                            'icon_parent' => 'nav-arrow bi bi-chevron-right',
                            'uri' => 'javascript:;',
                            'updated' => auth()->user()->id,
                            'updated_date' => date('Y-m-d H:i:s')
                        ];

                        DB::table('sys_menu')->where('id', $request->input('id_parent'))->update($icon_child);

                        $result = [
                            'message' => 200
                        ];

                        return response()->json($result);
                    } else if (!empty($parent) && !empty($child)) { // buat child selanjutnya
                        $on_posisi_menu_backend = M_menu::get_child_on($request->input('id_child'));
                        $next_posisi_menu_backend = M_menu::get_child_new_next($request->input('id_child'), $request->input('id_parent'));
                        $count = count($next_posisi_menu_backend);

                        $data = [
                            'public_id' => Str::uuid()->toString(),
                            'id_parent' => $request->input('id_parent'),
                            'id_parent_child' => $request->input('id_parent'),
                            'no_urut' => $on_posisi_menu_backend[0]->no_urut + 1,
                            'kategori' => $request->input('id_kategori'),
                            'nama' => $request->input('nama_menu'),
                            'icon' => $request->input('icon_menu'),
                            'method' => $request->input('id_method'),
                            'uri' => $request->input('uri_pranala'),
                            'controller' => $request->input('controller'),
                            'action' => $request->input('action'),
                            'middleware' => $request->input('middleware'),
                            'is_systems' => 0,
                            'is_trash' => 1,
                            'created' => auth()->user()->id,
                            'created_date' => date('Y-m-d H:i:s')
                        ];

                        $id_ = DB::table('sys_menu')->insertGetId($data);

                        // insert ke menu permissions
                        $permissions    = array();
                        $index          = 0;

                        foreach ($roles as $c) {
                            array_push($permissions, array(
                                'public_id'     => Str::uuid()->toString(),
                                'id_roles'      => $c->id,
                                'id_menu'       => $id_,
                                'created'       => auth()->user()->id,
                                'created_date'  => date('Y-m-d H:i:s')
                            ));
                            $index++;
                        }

                        DB::table('sys_menu_permissions')->insert($permissions);

                        if($count > 0){
                            foreach ($next_posisi_menu_backend as $key => $val) {
                                DB::table('sys_menu')
                                    ->where('id', $val->id)
                                    ->update([
                                        'no_urut'  => $val->no_urut + 1,
                                ]);
                            }
                        }else{
                            foreach ($next_posisi_menu_backend as $key => $val) {
                                DB::table('sys_menu')
                                    ->where('id', $val->id)
                                    ->update([
                                        'no_urut'  => $val->no_urut + 1,
                                ]);
                            }
                        }

                        $result = [
                            'message' => 200
                        ];

                        return response()->json($result);
                    }
                }else{
                    dd('??');die();
                }
            }
        }else{
            dd('kolom false');die();
        }
    }

    public function delete(Request $request)
    {
        $id     = $request->input('val');
        $data   = [
            'is_trash' => 2,
            'deleted' => auth()->user()->id,
            'deleted_date' => date('Y-m-d H:i:s')
        ];

        if (!empty($id) && !empty($data)) {
            DB::table('sys_menu')->where('public_id', $id)->update($data);

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
        $permissions_icon = Permissions::this_permissions("d58edd63-9d79-47d9-9e6f-a35782dbcc04");

        $query = DB::table("view_menu");

        $recordsTotal = $query->count();

        if ($search) {
            $columns = ["methods", "nama", "kategoris"];
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
                    "nama",
                    "icon",
                    "kategoris",
                    "methods",
                    "systems",
                    "status",
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

                    $action = $permissions_icon->is_trash == 1 
                        ? collect($actionFuncs)->reduce(function($carry, $func) use ($encode, $roles, $permissions_icon) {
                            return $carry . $func($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                        }, '')
                        : get_detail($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                        . get_edit($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);

                    return [
                        "DT_RowIndex" => $start,
                        "public_id"   => $row->public_id,
                        "nama"        => $row->nama,
                        "status"      => $row->status,
                        "icon"        => $row->icon,
                        "kategoris"   => $row->kategoris,
                        "methods"     => $row->methods,
                        "systems"     => $row->systems,
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
