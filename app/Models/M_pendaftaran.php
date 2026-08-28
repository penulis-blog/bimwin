<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_pendaftaran extends Model
{
    public static function get_data($id)
    {
        return DB::table('dt_kegiatan')->select('id', 'judul_acara', 'tempat', 'lokasi', 'in', 'out', 'is_trash')->where('public_id', $id)->first();
    }

    public static function get_folder($id)
    {
        return DB::table('dt_kegiatan')->select('id', 'kategori')->where('id', $id)->first();
    }

    public static function get_provinsi()
    {
        $data = DB::table('mst_provinsi')->select('id_provinsi', 'nama')->where('is_actived', '=', '1')->get();
        return $data;
    }

    public static function get_kabupaten($id)
    {
        $data = DB::table('mst_kabupaten')->select('id_kabupaten', 'nama')->where([['id_provinsi', '=', $id], ['is_actived', '=', '1']])->get();
        return $data;
    }

    public static function get_kecamatan($id)
    {
        $data = DB::table('mst_kecamatan')->select('id_kecamatan', 'nama')->where([['id_kabupaten', '=', $id], ['is_actived', '=', '1']])->get();
        return $data;
    }

    public static function get_daftar($id_form = null, $nik = null, $angkatan = null)
    {
        return DB::table('dt_form')
            ->select('id', 'id_kegiatan', 'nama', 'nik', 'no_hp', 'angkatan', 'tgl')
            ->when($id_form, function ($query, $id_form) {
                return $query->where('id_kegiatan', $id_form);
            })
            ->when($nik, function ($query, $nik) {
                return $query->where('nik', $nik);
            })
            ->when(isset($angkatan) && $angkatan !== '', function ($query) use ($angkatan) {
                return $query->where('angkatan', (int) $angkatan);
            })
            ->first();
    }
}