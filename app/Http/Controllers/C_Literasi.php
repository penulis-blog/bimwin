<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_literasi;
use Intervention\Image\ImageManager;
use PDF;

class C_Literasi extends Controller
{
    public function index()
    {
        return view("backend.layouts.fasilitator.jadwalliterasi");
    }

    public function post(Request $request)
    {
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;

        if ($roles != 1 && $roles != 12) {
            $model  = new M_events();
            $exec   = $model->get_group($roles, $users);
            
            $data = [
                'public_id' => Str::uuid()->toString(),
                'id_tte' => $request->input('_ttedirektur'),
                'kategori' => $request->input('_kategori'),
                'id_direktorat' => $exec->id_direktorat ?? null,
                'id_subdit' => $exec->id_subdit ?? null,
                'id_template' => $request->input('tempt') ?: null,
                'judul_acara' => $request->input('acara') ?: null,
                'tempat' => $request->input('tempat') ?: null,
                'lokasi' => $request->input('lokasi') ?: null,
                'in' => $request->input('dari') ?: null,
                'out' => $request->input('sampai') ?: null,
                'judul_form' => 'biodata peserta',
                'angkatan' => $request->input('jumlah'),
                'is_trash' => 11,
                'created' => auth()->user()->id,
                'created_date' => date('Y-m-d H:i:s')
            ];

            if(!empty($data)){
                DB::table('dt_kegiatan')->insert($data);

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
        } else {
            $data = [
                'public_id' => Str::uuid()->toString(),
                'id_tte' => $request->input('_ttedirektur'),
                'kategori' => $request->input('_kategori'),
                'id_direktorat' => $request->input('_direktorat'),
                'id_subdit' => $request->input('_subdit'),
                'id_template' => $request->input('tempt') ?: null,
                'judul_acara' => $request->input('acara') ?: null,
                'tempat' => $request->input('tempat') ?: null,
                'lokasi' => $request->input('lokasi') ?: null,
                'in' => $request->input('dari') ?: null,
                'out' => $request->input('sampai') ?: null,
                'judul_form' => 'biodata peserta',
                'angkatan' => $request->input('jumlah'),
                'is_trash' => 11,
                'created' => auth()->user()->id,
                'created_date' => date('Y-m-d H:i:s')
            ];

            if(!empty($data)){
                DB::table('dt_kegiatan')->insert($data);

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
        $model = new M_literasi();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "",
        );  // index halaman literasi keuangan

        // --- Build query langsung ---
        $query = DB::table("view_kegiatan")->where("kategori", "=", "459");

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
        $recordsTotal = DB::table("view_kegiatan")->where("kategori", "=", "459")->count();
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
                "judul_acara" => Str::words($row->judul_acara, 7, '...'),
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

    public function delete(Request $request)
    {
        $id     = $request->input('val');
        $data   = [
            'is_trash' => 12,
            'deleted' => auth()->user()->id,
            'deleted_date' => date('Y-m-d H:i:s')
        ];

        if (!empty($id) && !empty($data)) {
            DB::table('dt_kegiatan')->where('public_id', $id)->update($data);

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