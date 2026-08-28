<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Permissions;
use App\Models\M_users;

class C_users extends Controller
{
    public function index()
    {
        return view('backend.layouts.pengaturan.users');
    }

    public function group()
    {
        $data = get_roles();

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function direktorat()
    {
        $roles  = new M_users();
        $data = $roles->get_direktorat();

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function subdit($id)
    {
        $roles  = new M_users();
        $data = $roles->get_subdit($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function provinsi()
    {
        $roles  = new M_users();
        $data = $roles->get_provinsi();

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function kabupaten($id)
    {
        $roles  = new M_users();
        $data = $roles->get_kabupaten($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function kecamatan($id)
    {
        $roles  = new M_users();
        $data = $roles->get_kecamatan($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function post(Request $request)
    {
        $nama       = $request->input('username');
        $mail       = $request->input('emails');
        $username_  = M_users::get_username($nama);
        $hitung     = count($username_);
        $password   = M_users::get_password();
        $emails     = M_users::get_emails();
        
        if($hitung > 0){
            $result = [
                'message' => 201
            ];

            return response()->json($result);
        }else{
            $cek_email = $emails[0]->value;
            $allowed_domains = array_map('trim', explode(',', $cek_email));
            $input_domain = substr(strrchr($mail, "@"), 1); 

            if (!in_array($input_domain, $allowed_domains)) {
                $result = [
                    'message' => 202
                ];

                return response()->json($result);
            }

            $data       = [
                'public_id' => Str::uuid()->toString(),
                'id_roles' => $request->input('users_roles'),
                'username' => $nama,
                'password' => Hash::make($password[0]->value),
                'remember_token' => null,
                'is_verifikasi' => 1,
                'mails' => $mail,
                'is_trash' => 1,
                'created' => auth()->user()->id,
                'created_date' => date('Y-m-d H:i:s')
            ];

            $id_ = DB::table('sys_users')->insertGetId($data);
            
            // insert ke menu sys_users_profile
            $profile = [
                'public_id' => Str::uuid()->toString(),
                'id_user' => $id_,
                'photo' => 'uploads/default.png',
                'created' => auth()->user()->id,
                'created_date' => date('Y-m-d H:i:s')
            ];

            DB::table('sys_users_profile')->insert($profile);

            $result = [
                'message' => 200
            ];

            return response()->json($result);
        }
    }

    public function edit($id)
    {
        $roles  = new M_users();
        $data   = $roles->get_data($id);

        if(count($data) == 1){
            $result = [
                'data' => $data,
                'message' => 200
            ];

            return response()->json($result);
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function detail($id)
    {
        $roles  = new M_users();
        $data   = $roles->get_data($id);

        if(count($data) == 1){
            $result = [
                'data' => $data,
                'message' => 200
            ];

            return response()->json($result);
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function update(Request $request)
    {
        $akun       = $request->input('publicid_users');
        $profile    = $request->input('publicid_profile');
        $photo      = $request->hasFile('edit_files');
        $photo_old  = $request->input('files_old');
        
        if($photo == false){ // jika tidak ada update photo
            $user = [
                'id_roles' => $request->input('edit_group'),
                'username' => $request->input('edit_username'),
                'mails' => $request->input('edit_email'),
                'is_trash' => $request->input('edit_status_users'),
                'updated' => auth()->user()->id,
                'updated_date' => date('Y-m-d H:i:s')
            ];

            DB::table('sys_users')->where('public_id', $akun)->update($user);

            $userprofile = [
                'id_provinsi' => $request->input('edit_provinsi'),
                'id_kabupaten' => $request->input('edit_kabupaten'),
                'id_kecamatan' => $request->input('edit_kecamatan'),
                'id_direktorat' => $request->input('edit_direktorat'),
                'id_subdit' => $request->input('edit_subdit'),
                'nama' => $request->input('edit_nama'),
                'tgl' => $request->input('edit_tgl'),
                'tlp' => $request->input('edit_tlp'),
                'alamat' => $request->input('edit_alamat'),
                'updated' => auth()->user()->id,
                'updated_date' => date('Y-m-d H:i:s')
            ];

            DB::table('sys_users_profile')->where('public_id', $profile)->update($userprofile);

            $result = [
                'message' => 200
            ];

            return response()->json($result);
        }else{
            $ukuran = $request->file('edit_files')->getSize();
            $type   = $request->file('edit_files')->getClientOriginalExtension();
            $mime   = $request->file('edit_files')->getMimeType();
            
            if ($ukuran > 3000000) { // 3 MB, satuan byte
                $result = [
                    'message' => 202
                ];

                return response()->json($result);
            } else {
                if (!in_array($type, ['jpg','jpeg','png']) || !in_array($mime, ['image/jpeg','image/png'])) {
                    $result = [
                        'message' => 203
                    ];

                    return response()->json($result);
                } else {
                    $user = [
                        'id_roles' => $request->input('edit_group'),
                        'username' => $request->input('edit_username'),
                        'mails' => $request->input('edit_email'),
                        'is_trash' => $request->input('edit_status_users'),
                        'updated' => auth()->user()->id,
                        'updated_date' => date('Y-m-d H:i:s')
                    ];

                    DB::table('sys_users')->where('public_id', $akun)->update($user);

                    $userprofile = [
                        'id_provinsi' => $request->input('edit_provinsi'),
                        'id_kabupaten' => $request->input('edit_kabupaten'),
                        'id_kecamatan' => $request->input('edit_kecamatan'),
                        'id_direktorat' => $request->input('edit_direktorat'),
                        'id_subdit' => $request->input('edit_subdit'),
                        'nama' => $request->input('edit_nama'),
                        'tgl' => $request->input('edit_tgl'),
                        'tlp' => $request->input('edit_tlp'),
                        'alamat' => $request->input('edit_alamat'),
                        'photo' => $request->file('edit_files')->store('uploads', 'public'),
                        'updated' => auth()->user()->id,
                        'updated_date' => date('Y-m-d H:i:s')
                    ];

                    Storage::delete($photo_old);
                    DB::table('sys_users_profile')->where('public_id', $profile)->update($userprofile);

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }
            }
        }
    }

    public function default_password($id)
    {
        $roles   = new M_users();
        $default = $roles->get_default_password();

        $data   = [
            'password' => Hash::make($default[0]->value),
            'updated' => auth()->user()->id,
            'updated_date' => date('Y-m-d H:i:s')
        ];

        if (!empty($data)) {
            DB::table('sys_users')->where('public_id', $id)->update($data);

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

    public function post_password(Request $request)
    {
        $roles  = new M_users();
        $id     = $request->input('custom_iduser');
        $old    = htmlspecialchars($request->input('custom_password_old'));
        $new    = htmlspecialchars($request->input('custom_password_baru'));
        $cek    = $roles->get_data($id);
        $hasil  = Hash::check($old, $cek[0]->password);

        $data   = [
            'password' => Hash::make($new),
            'updated' => auth()->user()->id,
            'updated_date' => date('Y-m-d H:i:s')
        ];

        if ($hasil == false) {
            $result = [
                'message' => 202
            ];

            return response()->json($result);
        } else {
            if (!empty($data)) {
                DB::table('sys_users')->where('public_id', $id)->update($data);

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
            DB::table('sys_users')->where('public_id', $id)->update($data);

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
        $permissions_icon = Permissions::this_permissions("c44b34ee-37d0-4aec-9e91-b8235cb2ebc9");

        $query = DB::table("view_users");

        $recordsTotal = $query->count();

        if ($search) {
            $columns = ["username", "nama"];
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
                    "verifikasi",
                    "username",
                    "password",
                    "mails",
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
                        "nama"        => $row->nama,
                        "status"      => $row->status,
                        "username"    => $row->username,
                        "mails"       => $row->mails,
                        "verifikasi"  => $row->verifikasi,
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