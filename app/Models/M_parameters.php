<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_parameters extends Model
{
    public static function get_data($id)
    {
        $data = DB::table('view_parameters')->select('id', 'public_id', 'name', 'group', 'value', 'keterangan', 'status', 'is_trash')
        ->where([['public_id', '=', $id]])
        ->get();
        return $data;
    }
}