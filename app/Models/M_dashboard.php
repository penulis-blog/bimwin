<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_dashboard extends Model
{
    public static function get_user($id)
    {
        $data = DB::table('view_users')->select('id', 'public_id', 'pemilik', 'photo', 'nama', 'bergabung')->where([['id', '=', $id]])->get();
        return $data;
    }

    public static function get_induk($roles)
    {
        $data = DB::table('view_sidebar')->select('id', 'public_id', 'id_parent', 'id_parent_child', 'no_urut', 'nama', 'icon', 'icon_parent', 'uri')->where([['is_trash', '!=', '2'], ['is_systems', '!=', '1'], ['id_parent', '=', '0'], ['view', '!=', '0'], ['id_roles', '=', $roles]])->orderBy('no_urut', 'ASC')->get();
        return $data;
    }

    public static function get_roles()
    {
        $data = DB::table('sys_roles')->select('id', 'public_id', 'nama', 'keterangan', 'is_trash')->where([['is_trash', '!=', '0']])->orderBy('id', 'ASC')->get();
        return $data;
    }

    public static function grafik_golongan()
    {
        return DB::table('grafik_golongan')
            ->select('golongan', 'keterangan', 'total')
            ->orderBy('total', 'DESC')
            ->limit(5)                
            ->get();
    }

    public static function grafik_multifasilitator()
    {
        return DB::table('view_peserta_ganda')
            ->select('nip', 'nama', 'jabatan', 'jumlah_kegiatan_berbeda', 'files')
            ->get();
    }

    public static function grafik_provinsi()
    {
        $data = DB::table('grafik_provinsi')->select('id_provinsi', 'nama', 'total')->get();
        return $data;
    }

    public static function grafik_asn()
    {
        $data = DB::table('grafik_pegawai')->select('is_pegawai', 'pegawai', 'total')->get();
        return $data;
    }

    public static function grafik_jumlah()
    {
        $data = DB::table('view_total')->select('kategori', 'judul', 'total')->get();
        return $data;
    }

    public static function get_parent($roles)
    {
        return DB::table('view_sidebar')
            ->select('id', 'public_id', 'id_parent', 'id_parent_child', 'no_urut', 'nama', 'icon', 'uri', 'icon_parent')
            ->where([
                ['is_trash', '!=', '2'],
                ['kategori', '!=', '1'],
                ['is_systems', '!=', '1'],
                ['id_parent', '!=', '0'],
                ['view', '!=', '0'],
                ['id_roles', '=', $roles],
                ['id_parent_child', '=', null]  // ⬅️ hanya parent langsung
            ])
            ->orderBy('no_urut', 'ASC')
            ->get();
    }


    public static function get_parent_child($roles)
    {
        return DB::table('view_sidebar')
            ->select('id', 'public_id', 'id_parent', 'id_parent_child', 'no_urut', 'nama', 'icon', 'uri', 'icon_parent')
            ->where([
                ['is_trash', '!=', '2'],
                ['kategori', '!=', '1'],
                ['is_systems', '!=', '1'],
                ['id_parent', '!=', '0'],
                ['view', '!=', '0'],
                ['id_roles', '=', $roles],
                ['id_parent_child', '!=', null]
            ])
            ->orderBy('no_urut', 'ASC')
            ->get();
    }
}