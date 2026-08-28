<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_login extends Model
{
    use HasFactory;
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public static function get_account($username)
    {
        $data = DB::table('sys_users')->select('id', 'username', 'password', 'is_verifikasi', 'is_trash')->where([['username', '=', $username]])->get();
        return $data;
    }
}
