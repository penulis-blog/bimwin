<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_bimwin extends Model
{
    public static function get_jadwal()
    {
        $data = DB::table('dt_kegiatan')->select('id', 'kategori', 'id_direktorat', 'id_subdit', 'judul_acara', 'tempat', 'lokasi', 'judul_form', 'angkatan', 'created', 'is_trash')->get();
        return $data;
    }

    public static function get_angkatan($id)
    {
        $data = DB::table('dt_kegiatan')->select('id', 'judul_acara', 'tempat', 'lokasi', 'judul_form', 'angkatan')->where('id', $id)->get();
        return $data;
    }

    public static function get_data($id)
    {
        return DB::table('dt_form')->where('public_id', $id)->first();
    }

    public static function get_view($id)
    {
        return DB::table('view_peserta')->where('public_id', $id)->first();
    }

    public static function get_report($id)
    {
        return DB::table('view_peserta')
        ->select('judul_form', 'judul_acara', 'tempat', 'lokasi', 'dari', 'sampai', 'nama', 'lahir', 'tgl', 'tempat_tanggal_lahir', 'jkl', 'nik', 'nip', 'pegawai', 'jabatan', 
        'golongan', 'instansi', 'alamat_kantor', 'alamat_rumah', 'no_hp', 'email', 'npwp', 'no_rek', 'nm_bank', 'files', 'angkatan')
        ->where('public_id', $id)->first();
    }

    public static function get_sertifikat($id)
    {
        return DB::table('view_sertifikat')->where('public_id', $id)->first();
    }

    public static function get_sertifikat_rincian($id)
    {
        return DB::table('mst_template_materi')->select('judul', 'total')->where([['id_template', '=', $id], ['is_trash', '!=', '12']])->get();
    }

    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_daftar($id_form = null, $nik = null, $nip = null, $angkatan = null)
    {
        return DB::table('dt_form')
            ->select('id', 'id_kegiatan', 'nama', 'nik', 'nip', 'no_hp', 'angkatan', 'tgl')
            ->when($id_form, function ($query, $id_form) {
                return $query->where('id_kegiatan', $id_form);
            })
            ->when($nik, function ($query, $nik) {
                return $query->where('nik', $nik);
            })
            ->when($nip, function ($query, $nip) {
                return $query->where('nip', $nip);
            })
            ->when(isset($angkatan) && $angkatan !== '', function ($query) use ($angkatan) {
                return $query->where('angkatan', (int) $angkatan);
            })
            ->first();
    }

    public static function get_folder($id)
    {
        return DB::table('dt_kegiatan')->select('id', 'kategori')->where('id', $id)->first();
    }
}