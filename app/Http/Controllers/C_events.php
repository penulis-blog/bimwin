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
use App\Exports\DaftarPesertaExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DNS2D;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Permissions;
use App\Models\M_events;

class C_events extends Controller
{
    //------------------------------- Di bawah ini BIMWIN -------------------------------
    public function index()
    {
        $model = new M_events();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.fasilitator.jadwal", $data);
    }

    public function sertifikat()
    {
        $model  = new M_events();
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

    public function edit($id)
    {
        $data = M_events::get_data($id);

        return $data
            ? response()->json([
                'data' => $data,
                'message' => 'success',
            ], 200)
            : response()->json([
                'message' => 'Data not found',
            ], 404);
    }

    public function ambil_ttd($id)
    {
        $id_fix = (int) substr($id, 0, 2); // ambil 2 digit depan
    
        $exec  = new M_events();
        $data  = $exec->get_ttd($id_fix);
    
        return response()->json([
            'data' => $data
        ]);
    }

    public function detail($id)
    {
        $data = M_events::get_view($id);

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
        $exec = new M_events();
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
        $data   = M_events::get_laporan($id);
        $single = M_events::get_kegiatan($id);

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
            }else if($jenis == 173){
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

                return Excel::download(new DaftarPesertaExport($data, $single, $tanggal), 'daftar_peserta.xlsx');
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
                'id_tte' => $request->input('e_ttedirektur'),
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
                'id_tte' => $request->input('e_ttedirektur'),
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
        $model = new M_events();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "73afc0ae87c00032ded5a9c54df13bf490ac87e8a7efe8cf123b696f7372ac34",
        );  // index halaman bimwin

        // --- Build query langsung ---
        $query = DB::table("view_kegiatan")->where("kategori", "=", "451");

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
        $recordsTotal = DB::table("view_kegiatan")->where("kategori", "=", "451")->count();
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
                "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                "lokasi" => $row->lokasi,
                "tempat" => Str::words($row->tempat, 4, '...'),
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

    //------------------------------- Di bawah ini LITERASI KEUANGAN -------------------------------
    public function index_literasi()
    {
        $model = new M_events();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.fasilitator.jadwalliterasi", $data);
    }

    public function json_literasi(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $start = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $model = new M_events();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "c2763c80-ed3d-4c61-8e11-2a6f9f8d43d8", // index halaman jadwal literasi keuangan
        );

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
                "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                "lokasi" => $row->lokasi,
                "tempat" => Str::words($row->tempat, 4, '...'),
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

    public function formulir_literasi($id)
    {
        $idOnly     = strtok($id, '+');
        $url        = route('pendaftaranpeserta.show', ['id' => $id]);
        $barcode    = DNS2D::getBarcodePNG($url, 'QRCODE', 10, 10);
        $image      = base64_decode($barcode);
        $asli       = base64_decode($idOnly);
        $filename   = "barcode_brus_angkatan_{$asli}.png";
        $statis     = "barcode_brus_narasumber.png";

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

    //------------------------------- Di bawah ini LAYANAN KONSULTASI dan PENDAMPINGAN KELUARGA -------------------------------
    public function index_keluarga()
    {
        $model = new M_events();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.fasilitator.jadwalkeluarga", $data);
    }

    public function json_keluarga(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $start = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $model = new M_events();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "675d0594-b8ed-4afb-a5e0-5efbb8905a64", // index halaman jadwal keluarga
        );

        // --- Build query langsung ---
        $query = DB::table("view_kegiatan")->where("kategori", "=", "454");

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
        $recordsTotal = DB::table("view_kegiatan")->where("kategori", "=", "454")->count();
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
                "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                "lokasi" => $row->lokasi,
                "tempat" => Str::words($row->tempat, 4, '...'),
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

    public function formulir_keluarga($id)
    {
        $idOnly     = strtok($id, '+');
        $url        = route('pendaftaranpeserta.show', ['id' => $id]);
        $barcode    = DNS2D::getBarcodePNG($url, 'QRCODE', 10, 10);
        $image      = base64_decode($barcode);
        $asli       = base64_decode($idOnly);
        $filename   = "barcode_brus_angkatan_{$asli}.png";
        $statis     = "barcode_brus_narasumber.png";

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

    //------------------------------- Di bawah ini BRUS -------------------------------
    public function index_brus()
    {
        $model = new M_events();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.fasilitator.jadwalbrus", $data);
    }

    public function json_brus(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $start = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $model = new M_events();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "d4410731-93ef-4762-8b45-dbbfed1995aa", // index halaman jadwal brus
        );

        // --- Build query langsung ---
        $query = DB::table("view_kegiatan")->where("kategori", "=", "452");

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
        $recordsTotal = DB::table("view_kegiatan")->where("kategori", "=", "452")->count();
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
                "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                "lokasi" => $row->lokasi,
                "tempat" => Str::words($row->tempat, 4, '...'),
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

    public function formulir_brus($id)
    {
        $idOnly     = strtok($id, '+');
        $url        = route('pendaftaranpeserta.show', ['id' => $id]);
        $barcode    = DNS2D::getBarcodePNG($url, 'QRCODE', 10, 10);
        $image      = base64_decode($barcode);
        $asli       = base64_decode($idOnly);
        $filename   = "barcode_brus_angkatan_{$asli}.png";
        $statis     = "barcode_brus_narasumber.png";

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

    //------------------------------- Di bawah ini JEJARING LOKAL -------------------------------
    public function index_jejaring()
    {
        $model = new M_events();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.fasilitator.jadwaljejaring", $data);
    }

    public function json_jejaring(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $start = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $model = new M_events();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "15be6a7c-1548-451d-9ab3-a8354b88b943", // index halaman jadwal jejaring
        );

        // --- Build query langsung ---
        $query = DB::table("view_kegiatan")->where("kategori", "=", "453");

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
        $recordsTotal = DB::table("view_kegiatan")->where("kategori", "=", "453")->count();
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
                "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                "lokasi" => $row->lokasi,
                "tempat" => Str::words($row->tempat, 4, '...'),
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

    public function formulir_jejaring($id)
    {
        $idOnly     = strtok($id, '+');
        $url        = route('pendaftaranpeserta.show', ['id' => $id]);
        $barcode    = DNS2D::getBarcodePNG($url, 'QRCODE', 10, 10);
        $image      = base64_decode($barcode);
        $asli       = base64_decode($idOnly);
        $filename   = "barcode_jejaring_lokal_angkatan_{$asli}.png";
        $statis     = "barcode_jejaring_lokal_narasumber.png";

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

    //------------------------------- Di bawah ini RELASI HARMONIS -------------------------------
    public function index_harmonis()
    {
        $model = new M_events();
        $roles = auth()->user()->id_roles;
        $users = auth()->user()->id;
        $exec  = $model->get_group($roles, $users);
        $data  = [
            'data' => $exec
        ];

        return view("backend.layouts.fasilitator.jadwalharmonis", $data);
    }

    public function json_harmonis(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }

        $start = $request->get("start", 0);
        $length = $request->get("length", 10);
        $search = $request->get("search")["value"] ?? "";

        $user = auth()->user();
        $roles = $user->id_roles;
        $model = new M_events();
        $exec  = $model->get_group($roles, $user->id);

        $permissions_icon = Permissions::this_permissions(
            "cc910ac8-5f52-469e-9fa6-5a21b0c6e34c", // index halaman jadwal harmonis
        );

        // --- Build query langsung ---
        $query = DB::table("view_kegiatan")->where("kategori", "=", "455");

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
        $recordsTotal = DB::table("view_kegiatan")->where("kategori", "=", "455")->count();
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
                "judul_acara" => Str::words($row->judul_acara, 3, '...'),
                "lokasi" => $row->lokasi,
                "tempat" => Str::words($row->tempat, 4, '...'),
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

    public function formulir_harmonis($id)
    {
        $idOnly     = strtok($id, '+');
        $url        = route('pendaftaranpeserta.show', ['id' => $id]);
        $barcode    = DNS2D::getBarcodePNG($url, 'QRCODE', 10, 10);
        $image      = base64_decode($barcode);
        $asli       = base64_decode($idOnly);
        $filename   = "barcode_jejaring_lokal_angkatan_{$asli}.png";
        $statis     = "barcode_jejaring_lokal_narasumber.png";

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

    public function jadwal()
    {
        //
    }

    public function peserta()
    {
        //
    }
}
