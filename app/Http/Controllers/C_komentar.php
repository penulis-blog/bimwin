<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_komentar;

class C_komentar extends Controller
{
    public function index()
    {
        return view("backend.layouts.informasi.komentar");
    }

    public function edit($id)
    {
        $data = M_komentar::get_data($id);

        if (!$data) {
            return response()->json([
                'message' => 404,
            ], 404);
        }

        $anak = M_komentar::get_anak($data->child);

        return response()->json([
            'data' => $data,
            'child' => $anak,
            'message' => 200,
        ], 200);
    }

    public function detail($id)
    {
        $data = M_komentar::get_data($id);
        $total = M_komentar::get_total($data->id_berita);

        if (!$data) {
            return response()->json([
                'message' => 404,
            ], 404);
        }

        $anak = M_komentar::get_anak($data->child);

        return response()->json([
            'data' => $data,
            'child' => $anak,
            'hitung' => $total,
            'message' => 200,
        ], 200);
    }

    public function update(Request $request)
    {
        $id   = $request->input('e_komentar');

        $data = [
            'pesan'         => $request->filled('k_isi') ? $request->input('k_isi') : null,
            'is_trash'      => $request->input('k_stat'),
            'updated'       => auth()->user()->id,
            'updated_date'  => date("Y-m-d H:i:s"),
        ];

        DB::table('dt_komentar')->where('public_id', $id)->update($data);

        return response()->json(['message' => 200]);
    }

    public function delete(Request $request)
    {
        $id     = $request->input('val');
        $data   = [
            'is_trash' => 3,
            'deleted' => auth()->user()->id,
            'deleted_date' => date('Y-m-d H:i:s')
        ];

        if (!empty($id) && !empty($data)) {
            DB::table('dt_komentar')->where('public_id', $id)->update($data);

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
        $permissions_icon = Permissions::this_permissions("938bfcb4-471c-4fe0-b5f7-0fde33825aa6");

        $query = DB::table("view_komentar");

        // Total awal
        $recordsTotal = $query->count();

        // Search filter
        if ($search) {
            $columns = ["judul_berita", "nama"];
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $col) {
                    $q->orWhereRaw("$col COLLATE utf8mb4_unicode_ci LIKE ?", ["%{$search}%"]);
                }
            });
        }

        // Total setelah filter
        $recordsFiltered = $query->count();

        // Tambahkan ORDER BY tgl DESC
        $query->orderByRaw("
            CASE 
                WHEN is_trash = 2 THEN 0
                ELSE 1
            END
        ")->orderBy('tgl_post', 'DESC');

        // Ambil data
        $data = $query->select(
                    "id",
                    "public_id",
                    "judul_berita",
                    "nama",
                    "total_like",
                    "total_unlike",
                    "tgl_post",
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

                    if ($row->is_trash == 1) {
                        $action = collect($actionFuncs)->reduce(function ($carry, $func) use ($encode, $roles, $permissions_icon) {
                            return $carry . $func($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                        }, '');
                    } elseif ($row->is_trash == 2) {
                        $action = get_detail($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                                . get_edit($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    } elseif ($row->is_trash == 3) {
                        $action = get_edit($encode, $roles, $permissions_icon->uri, $permissions_icon->public_id);
                    } else {
                        $action = '';
                    }

                    switch ($row->is_trash) {
                        case 1:
                            $badge = '<span class="badge text-bg-success"><i>Publish</i></span>';
                            break;
                        case 2:
                            $badge = '<span class="badge text-bg-warning"><i>Pending</i></span>';
                            break;
                        case 3:
                            $badge = '<span class="badge text-bg-danger"><i>Private/Delete</i></span>';
                            break;
                        default:
                            $badge = '-';
                            break;
                    }

                    return [
                        "DT_RowIndex"   => $start,
                        "public_id"     => $row->public_id,
                        "judul_berita"  => Str::words($row->judul_berita, 4, '...'),
                        "nama"          => $row->nama,
                        "total_like"    => $row->total_like,
                        "total_unlike"  => $row->total_unlike,
                        "tgl_post"      => indo_date($row->tgl_post),
                        "is_trash"      => $badge,
                        "aksi"          => $action,
                    ];
                });

        // Response JSON DataTables
        return response()->json([
            "draw"            => intval($request->get("draw")),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }
}