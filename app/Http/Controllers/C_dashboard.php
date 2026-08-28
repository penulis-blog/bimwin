<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\M_dashboard;

class C_dashboard extends Controller
{
    public function index()
    {
        $model  = new M_dashboard();
        $data   = [
            'golongan'      => $model->grafik_golongan(),
            'fasilitator'   => $model->grafik_multifasilitator(),
            'jumlah'        => $model->grafik_jumlah()
        ];
        // dd($data['jumlah']);die();
        return view('backend.index', $data);
    }

    public function index_2()
    {
        $model  = new M_dashboard();
        $data   = [
            'golongan'      => $model->grafik_golongan(),
            'fasilitator'   => $model->grafik_multifasilitator(),
            'jumlah'        => $model->grafik_jumlah()
        ];
        // dd($data['jumlah']);die();
        return view('backend.index_2', $data);
    }

    public function grafik_wilayah()
    {
        $model  = new M_dashboard();
        $data   = $model->grafik_provinsi();

        $geojson = json_decode(file_get_contents(public_path('assets/id.json')), true);

        return response()->json([
            'data' => $data,
            'geojson' => $geojson
        ]);
    }

    public function grafik_pegawai()
    {
        $model  = new M_dashboard();
        $data   = $model->grafik_asn();

        return response()->json([
            'data' => $data
        ]);
    }

    public function multi_fasilitator()
    {
        return view("backend.layouts.fasilitator.multi");
    }

    public function json_fasilitator(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = (int) $request->get("start", 0);
        $length = (int) $request->get("length", 10);
        $search = trim($request->input("search.value", ""));

        $baseQuery = DB::table("view_peserta_ganda_list");

        $recordsTotal = Cache::remember(
            'peserta_ganda_total',
            600,
            fn () => $baseQuery->count()
        );

        if ($search !== '') {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', $search.'%')
                ->orWhere('nip', 'LIKE', '%'.$search.'%');
            });
        }

        $recordsFiltered = $search === ''
            ? $recordsTotal
            : Cache::remember(
                'peserta_ganda_filtered_' . md5($search),
                300,
                fn () => (clone $baseQuery)->count()
            );

        $data = $baseQuery
            ->select("id", "judul_acara", "angkatan", "tempat", "nama", "nip")
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($row, $i) use ($start) {
                return [
                    "DT_RowIndex" => $start + $i + 1,
                    "id"          => $row->id,
                    "nip"         => $row->nip,
                    "nama"        => $row->nama,
                    "judul_acara" => $row->judul_acara,
                    "angkatan"    => $row->angkatan,
                    "tempat"      => $row->tempat
                ];
            });

        return response()->json([
            "draw"            => (int) $request->get("draw"),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

    public function golongan_fasilitator()
    {
        return view("backend.layouts.fasilitator.golongan");
    }

    public function json_golongan(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = (int) $request->get("start", 0);
        $length = (int) $request->get("length", 10);
        $search = trim($request->input("search.value", ""));

        $baseQuery = DB::table("view_golongan");

        $recordsTotal = Cache::remember(
            'peserta_ganda_total',
            600,
            fn () => $baseQuery->count()
        );

        if ($search !== '') {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', $search.'%')
                ->orWhere('instansi', 'LIKE', '%'.$search.'%');
            });
        }

        $recordsFiltered = $search === ''
            ? $recordsTotal
            : Cache::remember(
                'peserta_ganda_filtered_' . md5($search),
                300,
                fn () => (clone $baseQuery)->count()
            );

        $data = $baseQuery
            ->select("nik", "jabatan", "golongan", "instansi", "nama", "no_hp", "email", "nip")
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($row, $i) use ($start) {
                return [
                    "DT_RowIndex" => $start + $i + 1,
                    "nip"         => $row->nip,
                    "nama"        => $row->nama,
                    "nik"         => $row->nik,
                    "jabatan"     => $row->jabatan,
                    "golongan"    => $row->golongan,
                    "instansi"    => $row->instansi,
                    "no_hp"       => $row->no_hp,
                    "email"       => $row->email
                ];
            });

        return response()->json([
            "draw"            => (int) $request->get("draw"),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

    public function pegawai_fasilitator()
    {
        return view("backend.layouts.fasilitator.pegawai");
    }

    public function json_pegawai(Request $request)
    {
        if (!$request->ajax()) return;

        $start  = (int) $request->get("start", 0);
        $length = (int) $request->get("length", 10);
        $search = trim($request->input("search.value", ""));

        $baseQuery = DB::table("view_pegawai");

        $recordsTotal = Cache::remember(
            'peserta_ganda_total',
            600,
            fn () => $baseQuery->count()
        );

        if ($search !== '') {
            $baseQuery->where(function ($q) use ($search) {
                $q->whereRaw(
                    "nama COLLATE utf8mb4_unicode_ci LIKE ?",
                    [$search.'%']
                )
                ->orWhereRaw(
                    "pegawai COLLATE utf8mb4_unicode_ci LIKE ?",
                    ['%'.$search.'%']
                );
            });
        }

        $recordsFiltered = $search === ''
            ? $recordsTotal
            : Cache::remember(
                'peserta_ganda_filtered_' . md5($search),
                300,
                fn () => (clone $baseQuery)->count()
            );

        $data = $baseQuery
            ->select("jabatan", "pegawai", "instansi", "nama", "no_hp", "email")
            ->offset($start)
            ->limit($length)
            ->get()
            ->map(function ($row, $i) use ($start) {
                return [
                    "DT_RowIndex" => $start + $i + 1,
                    "nama"        => $row->nama,
                    "jabatan"     => $row->jabatan,
                    "pegawai"     => $row->pegawai,
                    "instansi"    => $row->instansi,
                    "no_hp"       => $row->no_hp,
                    "email"       => $row->email
                ];
            });

        return response()->json([
            "draw"            => (int) $request->get("draw"),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        ]);
    }

    public function exitapps()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
