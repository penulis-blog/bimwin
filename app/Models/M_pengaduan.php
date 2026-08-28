<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_pengaduan extends Model
{
    public static function get_data($id)
    {
        return DB::table('view_peserta')->select('id', 'id_pengaduan', 'nama', 'nama_pengaduan', 'jabatan',
        'nik', 'nik_pengaduan', 'lahir', 'tgl', 'instansi', 'files', 'judul_acara', 'tempat', 'tempat_pengaduan', 
        'lokasi', 'lahir_pengaduan', 'dari', 'sampai', 'jabatan_pengaduan', 'utusan_pengaduan', 'files_pengaduan', 
        'is_verifikasi_user', 'is_verifikasi_admin', 'jenis_kategori', 'keterangan_pengaduan')
        ->where('public_id', $id)->first();
    }

    public static function get_by_id($id)
    {
        return DB::table('dt_pengaduan')->where('id_dtform', $id)->first();
    }

    public static function get_all_id($nik)
    {
        return DB::table('dt_form')->where('nik', $nik)->get();
    }
}