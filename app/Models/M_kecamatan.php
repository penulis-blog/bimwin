<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_kecamatan extends Model
{
    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_data($id)
    {
        return DB::table('view_kecamatan')->where([['id', '=', $id]])->first();
    }

    public static function get_kecamatan($kabupaten, $kecamatan, $kua)
    {
        if (empty($kecamatan)) {
            return null;
        }

        return DB::table('mst_kecamatan')
            ->where('id_kecamatan', $kecamatan)
            ->orderBy('id')
            ->count();
    }

}