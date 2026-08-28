<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_beranda extends Model
{
    public static function get_sertifikat($id)
    {
        return DB::table('view_sertifikat')->where('public_id', $id)->first();
    
    }
    
    public static function get_berita($id)
    {
        return DB::table('view_berita')->where([['pranala', '=', $id], ['is_trash', '=', '11']])->first();
    }

    public static function get_sertifikat_rincian($id)
    {
        return DB::table('mst_template_materi')->select('judul', 'total')->where([['id_template', '=', $id], ['is_trash', '!=', '12']])->get();
    }

    public static function get_slider()
    {
        return DB::table('dt_galeri')->select('judul', 'deskripsi', 'files')->where([['kategori', '=', '1'], ['is_trash', '!=', '12']])->get();
    }

    public static function get_materi()
    {
        return DB::table('dt_materi')->select('judul', 'keterangan', 'pranala')->where([['kategori', '=', '1'], ['is_trash', '!=', '12']])->get();
    }

    public static function get_galeri()
    {
        return DB::table('dt_galeri')
            ->select('judul', 'deskripsi', 'files')
            ->where('is_trash', '11')
            ->where('kategori', '2')
            ->orderBy('created_date', 'DESC')
            ->limit(6)
            ->get();
    }

    public static function get_terkini_index()
    {
        return DB::table('view_berita')
            ->select('public_id', 'judul', 'excerpt', 'pranala', 'files', 'meta_title', 'kategori_berita')
            ->where('is_trash', '11')
            ->where('kategori', '1')
            ->orderBy('tgl_post', 'DESC')
            ->limit(8)
            ->get();
    }

    public static function get_terkini()
    {
        return DB::table('view_berita')
            ->select('public_id', 'judul', 'excerpt', 'pranala', 'files', 'meta_title', 'kategori_berita')
            ->where('is_trash', '11')
            ->where('kategori', '1')
            ->orderBy('tgl_post', 'DESC')
            ->limit(5)
            ->get();
    }
}