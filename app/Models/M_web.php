<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_web extends Model
{
    public static function get_routes()
    {
        $data = DB::table('view_menu')->select('public_id', 'methods', 'uri', 'controller', 'action', 'name', 'middleware')->where([['is_trash', '!=', '0'], ['kategori', '!=', '1']])->get();
        return $data;
    }
}