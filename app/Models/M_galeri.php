<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_galeri extends Model
{
    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_data($id)
    {
        return DB::table('dt_galeri')->where('public_id', $id)->first();
    }

    public static function get_galeri($id)
    {
        return DB::table('view_galeri')->where('public_id', $id)->first();
    }
}