<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class Permissions
{
    public static function id_data()
    {
        $id = auth()->user()->id;
        $data = DB::table("view_users")
            ->select(
                "public_id",
                "id_roles",
                "id_provinsi",
                "id_kabupaten",
                "id_kecamatan",
                "id_direktorat",
                "id_subdit",
            )
            ->where([["id", "=", $id]])
            ->get();

        return $data[0];
    }

    public static function this_permissions($path = null)
    {
        $roles = auth()->user()->id_roles;

        // Jika path tidak diberikan, ambil dari current URL
        if (!$path) {
            $url = url()->current();
            $path = ltrim(str_replace(["/json", name_domain()], "", $url), "/");
        }

        // Cari menu berdasarkan public_id
        $menu = DB::table("sys_menu")
            ->select("id", "id_parent", "uri")
            ->where("public_id", $path)
            ->first();

        // Jika menu tidak ditemukan, kembalikan default permission
        if (!$menu) {
            return (object) [
                "view" => 0,
                "add" => 0,
                "edit" => 0,
                "delete" => 0,
                "report" => 0,
                "password" => 0,
                "agree" => 0,
                "back" => 0,
                "config" => 0,
                "module" => 0,
                "download" => 0,
                "is_trash" => 0,
            ];
        }

        // Ambil permissions berdasarkan role dan menu id
        $data = DB::table("view_permissions")
            ->select(
                "uri",
                "public_id",
                "view",
                "add",
                "edit",
                "delete",
                "report",
                "password",
                "agree",
                "back",
                "config",
                "module",
                "download",
                "is_trash",
            )
            ->where("is_trash", 1)
            ->where("id_roles", $roles)
            ->where("id", $menu->id)
            ->first();

        // Jika tidak ada permission, kembalikan default 0
        return $data ??
            (object) [
                "view" => 0,
                "add" => 0,
                "edit" => 0,
                "delete" => 0,
                "report" => 0,
                "password" => 0,
                "agree" => 0,
                "back" => 0,
                "config" => 0,
                "module" => 0,
                "download" => 0,
                "is_trash" => 0,
            ];
    }

    public static function get()
    {
        $roles = auth()->user()->id_roles;
        $path = url()->current();
        $cut_path = ltrim(
            str_replace("/json", "", str_replace(name_domain(), "", $path)),
            "/",
        );
        $how_id = DB::table("sys_menu")
            ->select("id_parent")
            ->where([["public_id", "=", $cut_path]])
            ->get();

        $cacheKey = "permission_{$roles}_" . md5($cut_path);

        $show = Cache::remember(
            $cacheKey,
            now()->addMinutes(1),
            function () use ($roles, $cut_path, $how_id) {
                return DB::table("view_permissions")
                    ->select("*")
                    ->where([
                        ["is_trash", "=", 1],
                        ["id_roles", "=", $roles],
                        ["id", "=", $how_id[0]->id_parent],
                    ])
                    ->first();
            },
        );

        return [
            "roles" => $roles,
            "path" => $path,
            "cut_path" => $cut_path,
            "show" => $show,
        ];
    }

    public static function clear($roles, $cut_path)
    {
        $cacheKey = "permission_{$roles}_" . md5($cut_path);
        Cache::forget($cacheKey);
    }

    public static function clearFromUri($roles, $uri)
    {
        $cut_path = str_replace(
            "/json",
            "",
            str_replace(name_domain(), "", $uri),
        );
        $cacheKey = "permission_{$roles}_" . md5($cut_path);
        Cache::forget($cacheKey);
    }

    public static function menu_frontend()
    {
        $data = DB::table("sys_menu")
            ->select(
                "public_id",
                "uri",
                "no_urut",
                "nama",
                "icon"
            )
            ->where([
                ["id_parent", "=", "0"],
                ["kategori", "=", "1"],
                ["is_trash", "=", "1"]
            ])
            ->orderBy("no_urut", "asc")
            ->get();

        return $data;
    }

    //-----------------------------------------------------------------------
    public static function this_permissions_peserta($path = null)
    {
        $roles = auth()->user()->id_roles;

        // Jika path tidak diberikan, ambil dari current URL
        if (!$path) {
            $url = url()->current();
            $path = ltrim(str_replace(["/json", name_domain()], "", $url), "/");
        }

        // Cari menu berdasarkan public_id
        $menu = DB::table("sys_menu")
            ->select("id", "id_parent", "uri")
            ->where("public_id", $path)
            ->first();

        // Jika menu tidak ditemukan, kembalikan default permission
        if (!$menu) {
            return (object) [
                "view" => 0,
                "add" => 0,
                "edit" => 0,
                "delete" => 0,
                "report" => 0,
                "password" => 0,
                "agree" => 0,
                "back" => 0,
                "config" => 0,
                "module" => 0,
                "download" => 0,
                "is_trash" => 0,
            ];
        }

        // Ambil permissions berdasarkan role dan menu id
        $data = DB::table("view_permissions")
            ->select(
                "uri",
                "public_id",
                "view",
                "add",
                "edit",
                "delete",
                "report",
                "password",
                "agree",
                "back",
                "config",
                "module",
                "download",
                "is_trash",
            )
            ->where("is_trash", 1)
            ->where("id_roles", $roles)
            ->where("id", $menu->id)
            ->first();

        // Jika tidak ada permission, kembalikan default 0
        return $data ??
            (object) [
                "view" => 0,
                "add" => 0,
                "edit" => 0,
                "delete" => 0,
                "report" => 0,
                "password" => 0,
                "agree" => 0,
                "back" => 0,
                "config" => 0,
                "module" => 0,
                "download" => 0,
                "is_trash" => 0,
            ];
    }

    public static function get_permissions($publicId)
    {
        $user = Auth::user();
        if (!$user) {
            return self::default_permissions();
        }

        $cacheKey = self::cacheKey($user->id, $publicId);

        return Cache::remember($cacheKey, 1800, function () use ($user, $publicId) {
            return self::fetch_permissions($user->id_roles, $publicId);
        });
    }

    /**
     * Query DB untuk ambil permission
     */
    protected static function fetch_permissions($roleId, $publicId)
    {
        $menu = DB::table("sys_menu")
            ->select("id", "id_parent", "uri", "public_id")
            ->where("public_id", $publicId)
            ->first();

        if (!$menu) {
            return self::default_permissions();
        }

        $data = DB::table("view_permissions")
            ->select(
                "uri",
                "public_id",
                "view",
                "add",
                "edit",
                "delete",
                "report",
                "password",
                "agree",
                "back",
                "config",
                "module",
                "download",
                "is_trash"
            )
            ->where("is_trash", 1)
            ->where("id_roles", $roleId)
            ->where("id", $menu->id)
            ->first();

        return $data ?? self::default_permissions();
    }

    /**
     * Default permissions (semua 0)
     */
    protected static function default_permissions()
    {
        return (object) [
            "view" => 0,
            "add" => 0,
            "edit" => 0,
            "delete" => 0,
            "report" => 0,
            "password" => 0,
            "agree" => 0,
            "back" => 0,
            "config" => 0,
            "module" => 0,
            "download" => 0,
            "is_trash" => 0,
        ];
    }

    /**
     * Buat key cache unik per user + public_id
     */
    protected static function cacheKey($userId, $publicId)
    {
        return "permissions_{$userId}_{$publicId}_peserta";
    }

    /**
     * Hapus cache permission user tertentu
     */
    public static function forget_cache($publicId)
    {
        $user = Auth::user();
        if ($user) {
            $cacheKey = self::cacheKey($user->id, $publicId);
            Cache::forget($cacheKey);
        }
    }
}