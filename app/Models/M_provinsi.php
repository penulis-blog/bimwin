<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_provinsi extends Model
{
    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_data($id)
    {
        return DB::table('mst_provinsi')->where([['id', '=', $id]])->first();
    }

    public static function get_provinsi($provinsi, $satker)
    {
        return DB::table('mst_provinsi')
            ->where(function ($q) use ($provinsi, $satker) {
                if (!empty($provinsi)) {
                    $q->where('id_provinsi', $provinsi);
                }

                if (!empty($satker)) {
                    $q->orWhere('satker', $satker);
                }
            });
    }

}