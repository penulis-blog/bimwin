<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_systems;

class C_systems extends Controller
{
    public function index()
    {
        return view('backend.systems.index');
    }
}
