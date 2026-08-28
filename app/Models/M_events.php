<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_events extends Model
{
    public static function get_sertifikat()
    {
        $data = DB::table('mst_template')->select('id', 'nama')->where('is_trash', '=', '11')->get();
        return $data;
    }
    
    public static function get_ttd($id_subdit)
    {
        return DB::table('mst_ttd')
            ->select('id', 'direktur', 'kegiatan')
            ->where('is_trash', 1)
            ->where('id_subdit', $id_subdit)
            ->get();
    }

    public static function list_kegiatan($id)
    {
        $data = DB::table('dt_kegiatan_kategori')->select('id_kategori', 'nama')->where([['id_subdit', '=', $id], ['is_trash', '=', '1']])->get();
        return $data;
    }

    public static function get_data($id)
    {
        return DB::table('dt_kegiatan')->where('public_id', $id)->first();
    }

    public static function get_view($id)
    {
        return DB::table('view_kegiatan')->where('public_id', $id)->first();
    }

    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_grouping($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->get();
    }

    public static function get_laporan($id)
    {
        return DB::table('view_peserta')->where([['id_kegiatan', '=', $id], ['is_trash', '!=', '18']])->get();
    }

    public static function get_kegiatan($id)
    {
        return DB::table('view_kegiatan')->where([['id', '=', $id]])->first();
    }
}