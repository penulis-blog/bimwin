<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_roles extends Model
{
    public static function get_data($id)
    {
        $data = DB::table('view_roles')->select('public_id', 'nama', 'keterangan', 'is_trash', 'status')->where([['public_id', '=', $id]])->get();
        return $data;
    }

    public static function get_permissions($id)
    {
        $data = DB::table('view_permissions')
            ->select(
                'id',
                'id_permissions', 
                'id_parent', 
                'id_parent_child', 
                'no_urut', 
                'id_roles', 
                'nama', 
                'view', 
                'add', 
                'edit', 
                'delete', 
                'report', 
                'password', 
                'agree',
                'back', 
                'config', 
                'module', 
                'download'
            )
            ->where([['id_group', '=', $id]])
            ->orderBy('id_parent')
            ->orderBy('id_parent_child')
            ->orderBy('no_urut')
            ->get()
            ->toArray();

        // ubah jadi tree dengan indentasi
        $result = self::buildTree($data);

        return $result;
    }

    protected static function buildTree($items, $parent = 0, $level = 0)
{
    $branch = [];
    foreach ($items as $item) {
        if ($item->id_parent == $parent) {
            
            // Root (level 0) = bold
            if ($level === 0) {
                $item->nama_indent = '<strong>' . $item->nama . '</strong>';
            } else {
                // selain root pakai strip sesuai level
                $item->nama_indent = str_repeat('- ', $level) . $item->nama;
            }

            // Rekursi untuk anak (level naik 1)
            $children = self::buildTree($items, $item->id, $level + 1);

            $branch[] = $item;
            $branch = array_merge($branch, $children);
        }
    }
    return $branch;
}






}