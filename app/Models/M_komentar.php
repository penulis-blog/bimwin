<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_komentar extends Model
{
    public static function get_data($id)
    {
        return DB::table('view_komentar')->where('public_id', $id)->first();
    }

    public static function get_total($id)
    {
        return DB::table('view_komentar')
            ->where('id_berita', $id)
            ->count();
    }

    public static function get_anak($id)
    {
        return DB::table('dt_komentar')->where('id', $id)->first();
    }
}