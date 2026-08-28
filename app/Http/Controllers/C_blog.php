<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\Permissions;
use App\Models\M_blog;

class C_blog extends Controller
{
    public function index()
    {
        $data = [
            'induk' => Permissions::menu_frontend(),
            'berita' => M_blog::get_berita()
        ];

        return view('frontend.contents.blog', $data);
    }

    public function searching(Request $request)
    {
        $id = trim($request->input('judul_blog'));
        $data = M_blog::get_data($id);
        if ($data->count() > 0) {
            $html = view('frontend.contents.blog_hasil_pencarian', [
                'berita' => $data
            ])->render();

            return response()->json([
                'message' => 200,
                'total'   => $data->count(),
                'keyword' => $id,
                'html'    => $html
            ]);
        }

        return response()->json([
            'message' => 201,
            'total'   => 0,
            'html'    => ''
        ]);
    }

    public function taging($id)
    {
        $data = [
            'induk'  => Permissions::menu_frontend(),
            'taging' => M_blog::get_taging($id),
            'title_tag' => $id
        ];

        return view('frontend.contents.tags', $data);
    }
}