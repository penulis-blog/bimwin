<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Exports\DaftarHadirExport;
use App\Exports\DaftarPerlengkapanExport;
use App\Exports\DaftarRekeningExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DNS2D;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_edukator;

class C_edukator extends Controller
{
    public function index()
    {
        $model = new M_edukator();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.kegiatan.index", $data);
    }

    public function sertifikat()
    {
        $model  = new M_edukator();
        $data   = $model->get_sertifikat();

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function formulir($id)
    {
        $idOnly     = strtok($id, '+');
        $url        = route('pendaftaranpeserta.show', ['id' => $id]);
        $barcode    = DNS2D::getBarcodePNG($url, 'QRCODE', 10, 10);
        $image      = base64_decode($barcode);
        $asli       = base64_decode($idOnly);
        $filename   = "barcode_bimwin_angkatan_{$asli}.png";
        $statis     = "barcode_bimwin_narasumber.png";

        if($asli == 99){
            return Response::make($image, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => "attachment; filename={$statis}"
            ]);
        }else{
            return Response::make($image, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => "attachment; filename={$filename}"
            ]);
        }
    }

    public function post(Request $request)
    {
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;

        if ($roles != 1 && $roles != 12) {
            $model  = new M_edukator();
            $exec   = $model->get_group($roles, $users);
            
            $data = [
                'public_id' => Str::uuid()->toString(),
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

    public function edit($id)
    {
        $data = M_edukator::get_data($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 'success',
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
    }

    public function detail($id)
    {
        $data = M_edukator::get_view($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 'success',
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
    }

    public function get_kegiatan($id)
    {
        $exec = new M_edukator();
        $data = $exec->list_kegiatan($id);

        $result = [
            'data' => $data
        ];

        return response()->json($result);
    }

    public function laporan(Request $request)
    {
        $id     = $request->input('l_acara');
        $jenis  = $request->input('l_kategori');
        $data   = M_edukator::get_laporan($id);
        $single = M_edukator::get_kegiatan($id);

        // pastikan locale bahasa Indonesia
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8');

        // tanggal hari ini
        $today = Carbon::today();

        // ubah string ke Carbon date
        $in  = Carbon::parse($single->in);
        $out = Carbon::parse($single->out);
        $dari = Carbon::parse($single->dari);
        $sampai = Carbon::parse($single->sampai);

        if (empty($data) || count($data) == 0) {
            return response()->json([
                'message' => 201
            ]);
        }else{
            if($jenis == 170){
                if ($today->between($in, $out)) {
                    $single->tanggal_kegiatan = $today->translatedFormat('l, d F Y');
                } else {
                    $single->tanggal_kegiatan = '(Tanggal Menyesuaikan Acara)';
                }

                if ($today->between($dari, $sampai)) {
                    $single->tanggal_ = $today->translatedFormat('d F Y');
                } else {
                    $single->tanggal_ = '(Tanggal Menyesuaikan Acara)';
                }

                $tanggal = Carbon::parse($single->dari)->translatedFormat('l, d F Y');

                return Excel::download(new DaftarHadirExport($data, $single, $tanggal), 'daftar_absen.xlsx');
            }else if($jenis == 171){
                if ($today->between($in, $out)) {
                    $single->tanggal_kegiatan = $today->translatedFormat('l, d F Y');
                } else {
                    $single->tanggal_kegiatan = '(Tanggal Menyesuaikan Acara)';
                }

                if ($today->between($dari, $sampai)) {
                    $single->tanggal_ = $today->translatedFormat('d F Y');
                } else {
                    $single->tanggal_ = '(Tanggal Menyesuaikan Acara)';
                }

                $tanggal = Carbon::parse($single->dari)->translatedFormat('l, d F Y');

                return Excel::download(new DaftarPerlengkapanExport($data, $single, $tanggal), 'daftar_perlengkapan.xlsx');
            }else if($jenis == 172){
                if ($today->between($in, $out)) {
                    $single->tanggal_kegiatan = $today->translatedFormat('l, d F Y');
                } else {
                    $single->tanggal_kegiatan = '(Tanggal Menyesuaikan Acara)';
                }

                if ($today->between($dari, $sampai)) {
                    $single->tanggal_ = $today->translatedFormat('d F Y');
                } else {
                    $single->tanggal_ = '(Tanggal Menyesuaikan Acara)';
                }

                $tanggal = Carbon::parse($single->dari)->translatedFormat('l, d F Y');

                return Excel::download(new DaftarRekeningExport($data, $single, $tanggal), 'daftar_rekening.xlsx');
            }
        }
    }

    public function update(Request $request)
    {
        $roles  = auth()->user()->id_roles;
        $users  = auth()->user()->id;
        $id     = $request->input('e_publicid');

        if ($roles != 1 && $roles != 12) {
            $data   = [
                'kategori' => $request->input('e_kategori'),
                'id_template' => $request->input('e_tempt'),
                'judul_acara' => $request->input('e_acara'),
                'tempat' => $request->input('e_tempat'),
                'lokasi' => $request->input('e_lokasi'),
                'in' => $request->input('e_dari'),
                'out' => $request->input('e_sampai'),
                'angkatan' => $request->input('e_jumlah'),
                'is_trash' => $request->input('e_status'),
                "updated" => auth()->user()->id,
                "updated_date" => date("Y-m-d H:i:s"),
            ];

            if(!empty($data)){
                DB::table('dt_kegiatan')->where('public_id', $id)->update($data);

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
        }else{
            $data   = [
                'id_direktorat' => $request->input('ed_direktorat'),
                'id_subdit' => $request->input('ed_subdit'),
                'kategori' => $request->input('e_kategori'),
                'id_template' => $request->input('e_tempt'),
                'judul_acara' => $request->input('e_acara'),
                'tempat' => $request->input('e_tempat'),
                'lokasi' => $request->input('e_lokasi'),
                'in' => $request->input('e_dari'),
                'out' => $request->input('e_sampai'),
                'angkatan' => $request->input('e_jumlah'),
                'is_trash' => $request->input('e_status'),
                "updated" => auth()->user()->id,
                "updated_date" => date("Y-m-d H:i:s"),
            ];

            if(!empty($data)){
                DB::table('dt_kegiatan')->where('public_id', $id)->update($data);

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

    public function permissions($id)
    {
        $id   = (string) $id;
        $exec = new M_edukator();
        $data = $exec->get_permissions($id);
        
        if (count($data) > 0) {
            return response()->json([
                "message" => 200,
                "data" => $data,
            ]);
        } else {
            return response()->json([
                "message" => 200,
                "data" => $data,
            ]);
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
        $model = new M_edukator();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "f8f1df6c-b6e7-49b9-a9e1-5bebdb5dc496",
        );

        // dd($permissions_icon);die();

        // --- Build query langsung ---
        $query = DB::table("view_kegiatan")->where("kategori", "=", "457");

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
        $recordsTotal = DB::table("view_kegiatan")->where("kategori", "=", "457")->count();
        $recordsFiltered = $query->count();

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

            // $btnForm = '<a href="javascript:;" onclick="Page.Form(\'' . $row->public_id . '\')" 
            //     data-bs-toggle="tooltip" data-bs-placement="top" title="Form Input">
            //     <span class="badge bg-success"><i class="fa-solid fa-file"></i></span>
            // </a>';

            $action = $row->is_trash == 12
            ? get_detail($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
                . get_edit($row->public_id, $roles, $permissions_icon->uri, $permissions_icon->public_id)
            : collect($actionFuncs)->reduce(function($carry, $func) use ($row, $roles, $permissions_icon) {
                $id = $func === "get_back" 
                    ? $row->angkatan.'+'.$row->public_id  
                    : $row->public_id;
                return $carry . $func($id, $roles, $permissions_icon->uri, $permissions_icon->public_id);
            }, ''); // 👈 ditambahkan di sini

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