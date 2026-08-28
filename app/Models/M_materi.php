<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_materi extends Model
{
    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_data($id)
    {
        return DB::table('dt_materi')->where('public_id', $id)->first();
    }

    public static function get_materi($id)
    {
        return DB::table('view_materi')->where('public_id', $id)->first();
    }
}