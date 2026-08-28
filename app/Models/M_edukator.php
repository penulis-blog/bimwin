<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_edukator extends Model
{
    public static function get_sertifikat()
    {
        $data = DB::table('mst_template')->select('id', 'nama')->where('is_trash', '=', '11')->get();
        return $data;
    }

    public static function get_group($roles, $users)
    {
        return DB::table('view_users')->where([['id_roles', '=', $roles], ['id', '=', $users]])->first();
    }

    public static function get_data($id)
    {
        return DB::table('dt_kegiatan')->where('public_id', $id)->first();
    }

    public static function get_view($id)
    {
        return DB::table('view_kegiatan')->where('public_id', $id)->first();
    }

    public static function list_kegiatan($id)
    {
        $data = DB::table('dt_kegiatan_kategori')->select('id_kategori', 'nama')->where([['id_subdit', '=', $id], ['is_trash', '=', '1']])->get();
        return $data;
    }

    public static function get_permissions($id)
    {
        $id   = (string) $id;
        $data = DB::table('view_input')
            ->select(
                'public_id',
                'idpublic_dtinput', 
                'idmst_input', 
                'idkegiatan', 
                'idpermissions', 
                'judul_acara', 
                'i_label', 
                'i_type', 
                'i_name', 
                'i_id', 
                'i_event', 
                'placeholder', 
                'opsi_select', 
                'urutan',
                'is_view'
            )
            ->where([['public_id', '=', $id], ['is_trash', '=', '11']])
            ->orderBy('urutan')
            ->get();

        if ($data->isEmpty()) {
            $data = DB::table('view_input')
                ->select(
                    'public_id',
                    'idpublic_dtinput', 
                    'idmst_input', 
                    'idkegiatan', 
                    'idpermissions', 
                    'judul_acara', 
                    'i_label', 
                    'i_type', 
                    'i_name', 
                    'i_id', 
                    'i_event', 
                    'placeholder', 
                    'opsi_select', 
                    'urutan',
                    'is_view'
                )
                ->whereNull('public_id')
                ->where('is_trash', '=', 11)
                ->orderBy('urutan')
                ->get();
        }
        return $data;
    }
}