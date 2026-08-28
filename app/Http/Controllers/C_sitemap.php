<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class C_sitemap extends Controller
{
    public function index()
    {
        $posts = Cache::remember('sitemap_dt_berita', 3600, function () {
            return DB::table('dt_berita')
                ->where('is_trash', 11)
                ->select('pranala', 'created_date')
                ->get();
        });

        return response()
            ->view('frontend.sitemap', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }
}
