<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_template extends Model
{
    public static function get_jadwal()
    {
        $data = DB::table('mst_ttd')->select('id', 'direktur', 'kegiatan')->get();
        return $data;
    }

    public static function get_listmateri($id)
    {
        $data = DB::table('mst_template_materi')->select('id', 'id_template', 'public_id', 'judul', 'total')
        ->where([['id_template', '=', $id], ['is_trash', '!=', '12']])
        ->get();
        return $data;
    }

    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_view($id)
    {
        return DB::table('view_template')->where([['public_id', '=', $id]])->first();
    }

    public static function get_data($id)
    {
        return DB::table('mst_template')->where([['public_id', '=', $id]])->first();
    }
}