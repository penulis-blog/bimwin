<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_informasi extends Model
{
    protected $table = 'dt_berita';

    public static function get_duplikat($judul = null, $pranala = null, $kategori)
    {
        // Jika kedua parameter kosong, langsung return koleksi kosong
        if (is_null($judul) && is_null($pranala)) {
            return collect();
        }

        return DB::table('dt_berita')
            ->where('kategori', $kategori)
            ->when($judul, function($q) use ($judul) {
                $q->whereRaw('LOWER(judul) = ?', [strtolower($judul)]);
            })
            ->when($pranala, function($q) use ($pranala) {
                $q->whereRaw('LOWER(pranala) = ?', [strtolower($pranala)]);
            })
            ->get();
    }

    public static function get_data($id)
    {
        return DB::table('dt_berita')->where('public_id', $id)->first();
    }

    public static function get_detail($id)
    {
        return DB::table('view_berita')->where('public_id', $id)->first();
    }

    public static function get_sebelumnya($judul = null, $kategori = null)
    {
        $query = self::query();

        if (!empty($judul)) {
            $query->where('judul', $judul);
        }

        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        return $query->get();
    }
}