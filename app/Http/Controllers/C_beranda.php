<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use App\Helpers\Permissions;
use App\Models\M_beranda;

class C_beranda extends Controller
{
    public function index()
    {
        $data = [
            'induk' => Permissions::menu_frontend(),
            'informasi_terkini' => M_beranda::get_terkini_index(),
            'slider' => M_beranda::get_slider(),
            'galeri' => M_beranda::get_galeri(),
            'materi' => M_beranda::get_materi()
        ];

        return view('welcome', $data);
    }

    public function unduh()
    {
        $data = [
            'induk' => Permissions::menu_frontend()
        ];

        return view('frontend.contents.sertifikat', $data);
    }

    public function sertifikat(Request $request)
    {
        $id = $request->input('id_sertifikat');

        $data = DB::table("view_sertifikat")
        ->select("public_id", "nama", "judul_acara", "tempat", "lokasi", "dari", "sampai")
        ->where(function($q) use ($id) {
            $q->whereIn('kode_sertifikat', [$id])
              ->orWhereIn('no_sertifikat', [$id])
              ->orWhereIn('nip', [$id])
              ->orWhereIn('nik', [$id]);
        })
        ->where('is_trash', '11')
        ->get();

        if ($data->count() > 0) {
            $result = [
                'message' => 200,
                'data' => $data
            ];

            return response()->json($result);
        } else {
            $result = [
                'message' => 201
            ];

            return response()->json($result);
        }
    }

    public function list_sertifikat($id)
    {
        $data    = M_beranda::get_sertifikat($id);

        if(!empty($data)){
            $rincian = M_beranda::get_sertifikat_rincian($data->id_template);
            $total   = $rincian->sum('total');

            $pdf = \PDF::loadView('backend.contents.fasilitator.report.bimwin.sertifikat', [
                'peserta' => $data,
                'rincian' => $rincian,
                'total' => $total
            ], [], [
                'format' => 'A4',
                'orientation' => 'L',
                'margin_left'   => 0,
                'margin_right'  => 0,
                'margin_top'    => 0,
                'margin_bottom' => 0,
            ]);

            return $pdf->stream('sertifikat-' . $data->nama . '.pdf');
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function detail($id)
    {
        $berita = M_beranda::get_berita($id);
        $data   = [
            'induk' => Permissions::menu_frontend(),
            'berita' => M_beranda::get_berita($id),
            'informasi_terkini' => M_beranda::get_terkini(),
            'komentar' => $this->ambil_komentar($berita->id)
        ];

        return view("frontend.contents.berita", $data);
    }

    public function ambil_komentar($id)
    {
        return DB::table('view_komentar')
            ->where('id_berita', $id)
            ->where('is_trash', 1)
            ->get();
    }

    public function share_link(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('val');
        $data   = DB::table('dt_berita')->where('public_id', $id)->first();

        if(!empty($data)){
            $berita = DB::table('dt_berita_logs')
                    ->where([
                        ['id_berita', '=', $data->id],
                        ['kategori', '=', 4],
                        ['ip_address', '=', request()->ip()],
                    ])->first();
            
            if(empty($berita)){
                $input  =  [
                    'public_id' => Str::uuid()->toString(),
                    'id_berita' => $data->id,
                    'kategori'  => 4,
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser(),
                    'browser_version' => $agent->version($agent->browser()),
                    'version' => $agent->version($agent->browser()),
                    'os' => $agent->platform(),
                    'os_version' => $agent->version($agent->platform()),
                    'device' => $agent->device(),
                    'is_mobile' => $agent->isMobile(),
                    'is_tablet' => $agent->isTablet(),
                    'is_desktop' => $agent->isDesktop(),
                    'is_bot' => $agent->isRobot(),
                    'is_bot_name' => $agent->robot(),
                    'pengguna_baru' => 1,
                    'jumlah' => 1,
                    'created_date' => date("Y-m-d H:i:s")
                ];

                DB::table('dt_berita_logs')->insert($input);

                $result = [
                    'message' => 200
                ];

                return response()->json($result);
            }else{
                $sameDevice =
                    ($agent->isMobile()  && $berita->is_mobile) ||
                    ($agent->isTablet()  && $berita->is_tablet) ||
                    ($agent->isDesktop() && $berita->is_desktop);

                if ($request->ip() === $berita->ip_address && $sameDevice) {
                    // dd($berita, 'lama dan kembali lagi');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 4,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_kembali' => 1,
                        'jumlah' => 1,
                        'updated_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 201
                    ];

                    return response()->json($result);
                } else {
                    // dd($berita, 'baru dan tidak sama');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 4,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_baru' => 1,
                        'jumlah' => 1,
                        'created_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }
            }
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function post_like(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('val');
        $data   = DB::table('dt_berita')->where('public_id', $id)->first();

        if(!empty($data)){
            $berita = DB::table('dt_berita_logs')
                    ->where([
                        ['id_berita', '=', $data->id],
                        ['kategori', '=', 5],
                        ['ip_address', '=', request()->ip()],
                    ])->first();
            
            if(empty($berita)){
                $input  =  [
                    'public_id' => Str::uuid()->toString(),
                    'id_berita' => $data->id,
                    'kategori'  => 5,
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser(),
                    'browser_version' => $agent->version($agent->browser()),
                    'version' => $agent->version($agent->browser()),
                    'os' => $agent->platform(),
                    'os_version' => $agent->version($agent->platform()),
                    'device' => $agent->device(),
                    'is_mobile' => $agent->isMobile(),
                    'is_tablet' => $agent->isTablet(),
                    'is_desktop' => $agent->isDesktop(),
                    'is_bot' => $agent->isRobot(),
                    'is_bot_name' => $agent->robot(),
                    'pengguna_baru' => 1,
                    'jumlah' => 1,
                    'created_date' => date("Y-m-d H:i:s")
                ];

                DB::table('dt_berita_logs')->insert($input);

                $result = [
                    'message' => 200
                ];

                return response()->json($result);
            }else{
                $sameDevice =
                    ($agent->isMobile()  && $berita->is_mobile) ||
                    ($agent->isTablet()  && $berita->is_tablet) ||
                    ($agent->isDesktop() && $berita->is_desktop);

                if ($request->ip() === $berita->ip_address && $sameDevice) {
                    // dd($berita, 'lama dan kembali lagi');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 5,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_kembali' => 1,
                        'jumlah' => 1,
                        'updated_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 201
                    ];

                    return response()->json($result);
                } else {
                    // dd($berita, 'baru dan tidak sama');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 5,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_baru' => 1,
                        'jumlah' => 1,
                        'created_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }
            }
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function post_unlike(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('val');
        $data   = DB::table('dt_berita')->where('public_id', $id)->first();

        if(!empty($data)){
            $berita = DB::table('dt_berita_logs')
                    ->where([
                        ['id_berita', '=', $data->id],
                        ['kategori', '=', 6],
                        ['ip_address', '=', request()->ip()],
                    ])->first();
            
            if(empty($berita)){
                $input  =  [
                    'public_id' => Str::uuid()->toString(),
                    'id_berita' => $data->id,
                    'kategori'  => 6,
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser(),
                    'browser_version' => $agent->version($agent->browser()),
                    'version' => $agent->version($agent->browser()),
                    'os' => $agent->platform(),
                    'os_version' => $agent->version($agent->platform()),
                    'device' => $agent->device(),
                    'is_mobile' => $agent->isMobile(),
                    'is_tablet' => $agent->isTablet(),
                    'is_desktop' => $agent->isDesktop(),
                    'is_bot' => $agent->isRobot(),
                    'is_bot_name' => $agent->robot(),
                    'pengguna_baru' => 1,
                    'jumlah' => 1,
                    'created_date' => date("Y-m-d H:i:s")
                ];

                DB::table('dt_berita_logs')->insert($input);

                $result = [
                    'message' => 200
                ];

                return response()->json($result);
            }else{
                $sameDevice =
                    ($agent->isMobile()  && $berita->is_mobile) ||
                    ($agent->isTablet()  && $berita->is_tablet) ||
                    ($agent->isDesktop() && $berita->is_desktop);

                if ($request->ip() === $berita->ip_address && $sameDevice) {
                    // dd($berita, 'lama dan kembali lagi');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 6,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_kembali' => 1,
                        'jumlah' => 1,
                        'updated_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 201
                    ];

                    return response()->json($result);
                } else {
                    // dd($berita, 'baru dan tidak sama');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 6,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_baru' => 1,
                        'jumlah' => 1,
                        'created_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }
            }
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function post_view(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('val');
        $data   = DB::table('dt_berita')->where('public_id', $id)->first();

        if(!empty($data)){
            $berita = DB::table('dt_berita_logs')
                    ->where([
                        ['id_berita', '=', $data->id],
                        ['kategori', '=', 1],
                        ['ip_address', '=', request()->ip()],
                    ])->first();
            
            if(empty($berita)){
                $input  =  [
                    'public_id' => Str::uuid()->toString(),
                    'id_berita' => $data->id,
                    'kategori'  => 1,
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser(),
                    'browser_version' => $agent->version($agent->browser()),
                    'version' => $agent->version($agent->browser()),
                    'os' => $agent->platform(),
                    'os_version' => $agent->version($agent->platform()),
                    'device' => $agent->device(),
                    'is_mobile' => $agent->isMobile(),
                    'is_tablet' => $agent->isTablet(),
                    'is_desktop' => $agent->isDesktop(),
                    'is_bot' => $agent->isRobot(),
                    'is_bot_name' => $agent->robot(),
                    'pengguna_baru' => 1,
                    'jumlah' => 1,
                    'created_date' => date("Y-m-d H:i:s")
                ];

                DB::table('dt_berita_logs')->insert($input);

                $result = [
                    'message' => 200
                ];

                return response()->json($result);
            }else{
                $sameDevice =
                    ($agent->isMobile()  && $berita->is_mobile) ||
                    ($agent->isTablet()  && $berita->is_tablet) ||
                    ($agent->isDesktop() && $berita->is_desktop);

                if ($request->ip() === $berita->ip_address && $sameDevice) {
                    // dd($berita, 'lama dan kembali lagi');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 1,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_kembali' => 1,
                        'jumlah' => 1,
                        'updated_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 201
                    ];

                    return response()->json($result);
                } else {
                    // dd($berita, 'baru dan tidak sama');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 1,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_baru' => 1,
                        'jumlah' => 1,
                        'created_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }
            }
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function post_twitter(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('val');
        $data   = DB::table('dt_berita')->where('public_id', $id)->first();

        if(!empty($data)){
            $berita = DB::table('dt_berita_logs')
                    ->where([
                        ['id_berita', '=', $data->id],
                        ['kategori', '=', 3],
                        ['ip_address', '=', request()->ip()],
                    ])->first();
            
            if(empty($berita)){
                $input  =  [
                    'public_id' => Str::uuid()->toString(),
                    'id_berita' => $data->id,
                    'kategori'  => 3,
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser(),
                    'browser_version' => $agent->version($agent->browser()),
                    'version' => $agent->version($agent->browser()),
                    'os' => $agent->platform(),
                    'os_version' => $agent->version($agent->platform()),
                    'device' => $agent->device(),
                    'is_mobile' => $agent->isMobile(),
                    'is_tablet' => $agent->isTablet(),
                    'is_desktop' => $agent->isDesktop(),
                    'is_bot' => $agent->isRobot(),
                    'is_bot_name' => $agent->robot(),
                    'pengguna_baru' => 1,
                    'jumlah' => 1,
                    'created_date' => date("Y-m-d H:i:s")
                ];

                DB::table('dt_berita_logs')->insert($input);

                $result = [
                    'message' => 200
                ];

                return response()->json($result);
            }else{
                $sameDevice =
                    ($agent->isMobile()  && $berita->is_mobile) ||
                    ($agent->isTablet()  && $berita->is_tablet) ||
                    ($agent->isDesktop() && $berita->is_desktop);

                if ($request->ip() === $berita->ip_address && $sameDevice) {
                    // dd($berita, 'lama dan kembali lagi');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 3,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_kembali' => 1,
                        'jumlah' => 1,
                        'updated_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 201
                    ];

                    return response()->json($result);
                } else {
                    // dd($berita, 'baru dan tidak sama');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 3,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_baru' => 1,
                        'jumlah' => 1,
                        'created_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }
            }
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function post_facebook(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('val');
        $data   = DB::table('dt_berita')->where('public_id', $id)->first();

        if(!empty($data)){
            $berita = DB::table('dt_berita_logs')
                    ->where([
                        ['id_berita', '=', $data->id],
                        ['kategori', '=', 2],
                        ['ip_address', '=', request()->ip()],
                    ])->first();
            
            if(empty($berita)){
                $input  =  [
                    'public_id' => Str::uuid()->toString(),
                    'id_berita' => $data->id,
                    'kategori'  => 2,
                    'ip_address' => $request->ip(),
                    'browser' => $agent->browser(),
                    'browser_version' => $agent->version($agent->browser()),
                    'version' => $agent->version($agent->browser()),
                    'os' => $agent->platform(),
                    'os_version' => $agent->version($agent->platform()),
                    'device' => $agent->device(),
                    'is_mobile' => $agent->isMobile(),
                    'is_tablet' => $agent->isTablet(),
                    'is_desktop' => $agent->isDesktop(),
                    'is_bot' => $agent->isRobot(),
                    'is_bot_name' => $agent->robot(),
                    'pengguna_baru' => 1,
                    'jumlah' => 1,
                    'created_date' => date("Y-m-d H:i:s")
                ];

                DB::table('dt_berita_logs')->insert($input);

                $result = [
                    'message' => 200
                ];

                return response()->json($result);
            }else{
                $sameDevice =
                    ($agent->isMobile()  && $berita->is_mobile) ||
                    ($agent->isTablet()  && $berita->is_tablet) ||
                    ($agent->isDesktop() && $berita->is_desktop);

                if ($request->ip() === $berita->ip_address && $sameDevice) {
                    // dd($berita, 'lama dan kembali lagi');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 2,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_kembali' => 1,
                        'jumlah' => 1,
                        'updated_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 201
                    ];

                    return response()->json($result);
                } else {
                    // dd($berita, 'baru dan tidak sama');
                    $input  =  [
                        'public_id' => Str::uuid()->toString(),
                        'id_berita' => $data->id,
                        'kategori'  => 2,
                        'ip_address' => $request->ip(),
                        'browser' => $agent->browser(),
                        'browser_version' => $agent->version($agent->browser()),
                        'version' => $agent->version($agent->browser()),
                        'os' => $agent->platform(),
                        'os_version' => $agent->version($agent->platform()),
                        'device' => $agent->device(),
                        'is_mobile' => $agent->isMobile(),
                        'is_tablet' => $agent->isTablet(),
                        'is_desktop' => $agent->isDesktop(),
                        'is_bot' => $agent->isRobot(),
                        'is_bot_name' => $agent->robot(),
                        'pengguna_baru' => 1,
                        'jumlah' => 1,
                        'created_date' => date("Y-m-d H:i:s")
                    ];

                    DB::table('dt_berita_logs')->insert($input);

                    $result = [
                        'message' => 200
                    ];

                    return response()->json($result);
                }
            }
        }else{
            $result = [
                'message' => 404
            ];

            return response()->json($result);
        }
    }

    public function post_komentar(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('id_berita');
        $child  = $request->input('id_child');
        $data   = DB::table('dt_berita')->where('public_id', $id)->first();
        
        if(empty($child)){
            $input = [
                'public_id' => Str::uuid()->toString(),
                'id_user' => null,
                'id_berita' => $data->id,
                'child' => null,
                'nama' => $request->input('name'),
                'pesan' => $request->input('comment'),
                'ip_address' => $request->ip(),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'version' => $agent->version($agent->browser()),
                'os' => $agent->platform(),
                'os_version' => $agent->version($agent->platform()),
                'device' => $agent->device(),
                'is_mobile' => $agent->isMobile(),
                'is_tablet' => $agent->isTablet(),
                'is_desktop' => $agent->isDesktop(),
                'is_bot' => $agent->isRobot(),
                'is_bot_name' => $agent->robot(),
                'is_trash' => 2,
                'created_date' => date("Y-m-d H:i:s")
            ];
        }else{
            $input = [
                'public_id' => Str::uuid()->toString(),
                'id_user' => null,
                'id_berita' => $data->id,
                'child' => $child,
                'nama' => $request->input('name'),
                'pesan' => $request->input('comment'),
                'ip_address' => $request->ip(),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'version' => $agent->version($agent->browser()),
                'os' => $agent->platform(),
                'os_version' => $agent->version($agent->platform()),
                'device' => $agent->device(),
                'is_mobile' => $agent->isMobile(),
                'is_tablet' => $agent->isTablet(),
                'is_desktop' => $agent->isDesktop(),
                'is_bot' => $agent->isRobot(),
                'is_bot_name' => $agent->robot(),
                'is_trash' => 2,
                'created_date' => date("Y-m-d H:i:s")
            ];
        }

        if($input){
            DB::table('dt_komentar')->insert($input);

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

    public function post_komentar_like(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('val');
        $data   = DB::table('dt_komentar')->where('public_id', $id)->first();
        
        if(!empty($data)){
            $insert = [
                'public_id' => Str::uuid()->toString(),
                'id_berita' => $data->id_berita,
                'id_komentar' => $data->id,
                'ip_address' => $request->ip(),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'version' => $agent->version($agent->browser()),
                'os' => $agent->platform(),
                'os_version' => $agent->version($agent->platform()),
                'device' => $agent->device(),
                'is_mobile' => $agent->isMobile(),
                'is_tablet' => $agent->isTablet(),
                'is_desktop' => $agent->isDesktop(),
                'is_bot' => $agent->isRobot(),
                'is_bot_name' => $agent->robot(),
                'kategori' => 9,
                'is_trash' => 1,
                'created_date' => date("Y-m-d H:i:s")
            ];

            DB::table('dt_komentar_logs')->insert($insert);

            $result = [
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

    public function post_komentar_unlike(Request $request)
    {
        $agent  = new Agent();
        $id     = $request->input('val');
        $data   = DB::table('dt_komentar')->where('public_id', $id)->first();
        
        if(!empty($data)){
            $insert = [
                'public_id' => Str::uuid()->toString(),
                'id_berita' => $data->id_berita,
                'id_komentar' => $data->id,
                'ip_address' => $request->ip(),
                'browser' => $agent->browser(),
                'browser_version' => $agent->version($agent->browser()),
                'version' => $agent->version($agent->browser()),
                'os' => $agent->platform(),
                'os_version' => $agent->version($agent->platform()),
                'device' => $agent->device(),
                'is_mobile' => $agent->isMobile(),
                'is_tablet' => $agent->isTablet(),
                'is_desktop' => $agent->isDesktop(),
                'is_bot' => $agent->isRobot(),
                'is_bot_name' => $agent->robot(),
                'kategori' => 10,
                'is_trash' => 1,
                'created_date' => date("Y-m-d H:i:s")
            ];

            DB::table('dt_komentar_logs')->insert($insert);

            $result = [
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

    public function post_balas_komentar(Request $request)
    {}
}