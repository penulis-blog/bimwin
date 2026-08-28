<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_aktivasi extends Model
{
    protected $table = 'sys_users';

    public static function get_verify($email, $token)
    {
        $data = DB::table('sys_users')
            ->select('id', 'mails', 'remember_token', 'is_verifikasi', 'username')
            ->where([
                ['mails', '=', $email],
                ['remember_token', '=', $token],
            ])
            ->get();

        return $data;
    }
}
