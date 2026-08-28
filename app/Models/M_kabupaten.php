<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_kabupaten extends Model
{
    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_data($id)
    {
        return DB::table('view_kabupaten')->where([['id', '=', $id]])->first();
    }

    public static function get_kabupaten($kabupaten, $satker)
    {
        if (empty($satker)) {
            return null;
        }

        return DB::table('mst_kabupaten')
            ->where('satker', $satker)
            ->orderBy('id')
            ->count();
    }

}