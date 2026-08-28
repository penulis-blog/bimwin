<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_menu extends Model
{
    public static function get_menu($id)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'id_parent', 'id_parent_child', 'no_urut',
        'kategori', 'nama', 'icon', 'icon_parent', 'method', 'uri', 'controller', 'action', 'name', 'middleware', 'is_systems', 'is_trash')
        ->where([['public_id', '=', $id]])
        ->get();
        return $data;
    }

    public static function get_menu_id($id)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'id_parent', 'id_parent_child', 'no_urut',
        'kategori', 'nama', 'icon', 'icon_parent', 'method', 'uri', 'controller', 'action', 'name', 'middleware', 'is_systems', 'is_trash')
        ->where([['id', '=', $id]])
        ->get();
        return $data;
    }

    public static function get_detail($id)
    {
        $data = DB::table('view_menu')->select('public_id', 'kategoris', 'nama', 'icon', 'icon_parent', 'methods', 'uri', 'controller', 'systems', 'status')
        ->where([['public_id', '=', $id]])
        ->get();
        return $data;
    }

    public static function get_induk_next($id)
    {
        $data = DB::table('sys_menu')->select('id', 'no_urut', 'nama')
        ->where([['kategori', '!=', '1'], ['is_systems', '!=', '1'], ['id_parent', '=', '0'], ['id', '>', $id]])
        ->orderBy('no_urut', 'ASC')->get();
        return $data;
    }

    public static function get_induk_next_frontend($id)
    {
        $data = DB::table('sys_menu')->select('id', 'no_urut', 'nama')
        ->where([['kategori', '!=', '2'], ['is_systems', '!=', '1'], ['id_parent', '=', '0'], ['id', '>', $id]])
        ->orderBy('no_urut', 'ASC')->get();
        return $data;
    }

    public static function get_induk_next_edit($id)
    {
        $current = DB::table('sys_menu')
            ->select('no_urut')
            ->where('id', $id)
            ->first();

        if (!$current) {
            return collect();
        }

        $data = DB::table('sys_menu')
            ->select('id', 'no_urut', 'nama')
            // ->where('kategori', '!=', 1)
            ->where('id_parent', 0)
            ->where('no_urut', '>', $current->no_urut)
            ->orderBy('no_urut', 'asc')
            ->get();

        return $data;
    }

    public static function get_induk_on($id)
    {
        $data = DB::table('sys_menu')->select('id', 'no_urut', 'nama')
        ->where([['kategori', '!=', '1'], ['is_systems', '!=', '1'], ['id_parent', '=', '0'], ['id', '=', $id]])
        ->orderBy('no_urut', 'ASC')->get();
        return $data;
    }

    public static function get_induk_on_frontend($id)
    {
        $data = DB::table('sys_menu')->select('id', 'no_urut', 'nama')
        ->where([['kategori', '!=', '2'], ['is_systems', '!=', '1'], ['id_parent', '=', '0'], ['id', '=', $id]])
        ->orderBy('no_urut', 'ASC')->get();
        return $data;
    }

    public static function get_parent($id)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'nama')
        ->where([['kategori', '!=', '1'], ['id_parent', '=', $id]])
        ->get();
        return $data;
    }

    public static function get_frontend($id)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'nama')
        ->where([['kategori', '=', $id], ['id_parent', '=', 0]])
        ->get();
        return $data;
    }

    public static function get_parent_on($id)
    {
        $data = DB::table('sys_menu')->select('id', 'id_parent', 'public_id', 'nama', 'no_urut')
        ->where([['kategori', '!=', '1'], ['id', '=', $id]])
        ->get();
        return $data;
    }

    public static function get_first_parent_on($id)
    {
        $data = DB::table('sys_menu')->select('id', 'id_parent', 'public_id', 'nama', 'no_urut')
        ->where([['kategori', '!=', '1'], ['is_systems', '!=', '1'], ['id_parent', '=', $id]])
        ->get();
        return $data;
    }

    public static function get_parent_next($id, $parent)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'nama', 'no_urut')
        ->where([['kategori', '!=', '1'], ['id', '>', $id], ['id_parent', '=', $parent]])
        ->get();
        return $data;
    }

    public static function get_parent_new_next($id, $parent)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'nama', 'no_urut')
        ->where([['kategori', '!=', '1'], ['id', '!=', $id], ['id_parent', '=', $parent]])
        ->get();
        return $data;
    }

    public static function get_child($id)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'nama')
        ->where([['kategori', '!=', '1'], ['id_parent_child', '=', $id]])
        ->get();
        return $data;
    }

    public static function get_child_on($id)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'nama', 'no_urut')
        ->where([['kategori', '!=', '1'], ['is_systems', '!=', '1'], ['id', '=', $id]])
        ->get();
        return $data;
    }

    public static function get_child_new_next($id, $parent)
    {
        $data = DB::table('sys_menu')->select('id', 'public_id', 'nama', 'no_urut')
        ->where([['kategori', '!=', '1'], ['id', '>', $id], ['id_parent_child', '=', $parent]])
        ->get();
        return $data;
    }

    public static function get_roles()
    {
        $data = DB::table('sys_roles')->select('id', 'nama')->get();
        return $data;
    }
}