<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_register extends Model
{
    public static function get_mailings()
    {
        $data = DB::table('sys_parameters')->select('value')->where('group', 'register')->get();

        return $data;
    }

    public static function get_default_password()
    {
        $default = DB::table('sys_parameters')->select('value')->where([
            ['is_trash', '=', '1'],
            ['group', '=', 'security'],
        ])->get();

        return $default;
    }

    public static function get_default_group()
    {
        $data = DB::table('sys_roles')->where([
            ['is_trash', '=', '1'],
            ['id', '=', '1'],
        ])->get();

        return $data;
    }

    public static function get_vuser($username, $email)
    {
        $data = DB::table('sys_users')->select('username', 'mails')->where('username', $username)->orWhere('mails', '=', $email)->get();

        return $data;
    }
}
