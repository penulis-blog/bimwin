<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_blog extends Model
{
    public static function get_berita()
    {
        return DB::table('view_berita')
            ->select('judul', 'excerpt', 'pranala', 'files', 'meta_title', 'tgl', 'jam_menit', 'kategori_berita')
            ->where([
                ['is_trash', '=', '11']
            ])
            ->orderBy('tgl_post', 'DESC')
            ->paginate(9);
    }

    public static function get_data($id)
    {
        return DB::table('view_berita')
            ->where('is_trash', 11)
            ->where('judul', 'LIKE', '%' . $id . '%')
            ->orderBy('tgl_post', 'DESC')
            ->limit(20)
            ->get();
    }

    public static function get_taging($id)
    {
        $id = trim(str_replace('-', ' ', $id));
        return DB::table('view_berita')
            ->select('judul', 'excerpt', 'pranala', 'files', 'meta_title', 'tgl', 'jam_menit', 'kategori_berita')
            ->where('is_trash', 11)
            ->whereRaw(
                "FIND_IN_SET(?, REPLACE(meta_tags, ', ', ',')) > 0",
                [$id]
            )
            ->orderBy('tgl_post', 'DESC')
            ->paginate(9);
    }
}