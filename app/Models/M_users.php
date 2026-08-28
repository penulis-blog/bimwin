<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_users extends Model
{
    public static function get_data($id)
    {
        $data = DB::table('view_users')->select('id', 'public_id', 'public_id_profile', 'id_roles', 'id_provinsi', 'id_kabupaten', 'id_kecamatan', 'id_direktorat', 'id_subdit', 'username', 'password', 
        'provinsi', 'kabupaten', 'kecamatan', 'direktorat', 'subdit', 'nama', 'status', 'keterangan', 'mails', 'verifikasi', 'pemilik', 
        'tgl', 'tanggal', 'usia', 'tlp', 'alamat', 'photo', 'status', 'is_trash')->where([['public_id', '=', $id]])->get();
        return $data;
    }

    public static function get_username($id)
    {
        $data = DB::table('sys_users')->select('username')->where('username', 'like', '%' . $id . '%')->get();
        return $data;
    }

    public static function get_password()
    {
        $data = DB::table('sys_parameters')->select('value')->where([['group', '=', 'security'], ['is_trash', '=', '1']])->get();
        return $data;
    }

    public static function get_emails()
    {
        $data = DB::table('sys_parameters')->select('value')->where([['group', '=', 'register'], ['is_trash', '=', '1']])->get();
        return $data;
    }

    public static function get_provinsi()
    {
        $data = DB::table('mst_provinsi')->select('id_provinsi', 'nama')->get();
        return $data;
    }

    public static function get_kabupaten($id)
    {
        $data = DB::table('mst_kabupaten')->select('id_kabupaten', 'nama')->where([['id_provinsi', '=', $id]])->get();
        return $data;
    }

    public static function get_kecamatan($id)
    {
        $data = DB::table('mst_kecamatan')->select('id_kecamatan', 'nama')->where([['id_kabupaten', '=', $id]])->get();
        return $data;
    }

    public static function get_direktorat()
    {
        $data = DB::table('mst_direktorat')->select('id_direktorat', 'nama')->get();
        return $data;
    }

    public static function get_subdit($id)
    {
        $data = DB::table('mst_subdit')->select('id_subdit', 'nama')->where([['id_direktorat', '=', $id]])->get();
        return $data;
    }

    public static function get_default_password()
    {
        $data = DB::table('sys_parameters')->select('value')->where([['group', '=', 'security'], ['name', '=', 'password'], ['is_trash', '=', '1']])->get();
        return $data;
    }
}