<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class C_login extends Controller
{
    public function index()
    {
        return view('login/index');
    }

    public function authenticate(Request $request)
    {
        $receiver = $request->validate([
            'username' => ['required', 'min:5', 'max:19'],
            'password' => ['required', 'min:5', 'max:15']
        ]);

        $username   = $receiver['username'];
        $check      = M_login::get_account($username);
        $is_check   = count($check);
        
        if ($is_check == 0) {
            return back()->with('UserNotFound', 'Maaf, akun kamu tidak terdaftar.');
        } else if($check[0]->is_verifikasi == 0){
            return back()->with('UserUnVerifikasi', 'Maaf, periksa email kamu untuk verifikasi akun.');
        } else if($check[0]->is_trash == 0){
            return back()->with('UserNonActive', 'Maaf, akun kamu di nonaktifkan.');
        } else {
            $db     = $receiver['password'];
            $verify = Hash::check($db, $check[0]->password);

            if ($check[0]->username == $receiver['username'] && $verify == true) {
                if (Auth::attempt(['username' => $receiver['username'], 'password' => $receiver['password'], 'is_trash' => 1])) {
                    $request->session()->regenerate();

                    // return redirect()->intended('dashboard');
                    return redirect()->intended('68b467d9-34c8-4163-8740-e256750ac1eb');
                }
            } else {
                return back()->with('AccountFalse', 'Maaf, username atau password salah.');
            }
        }
    }

    public function exitapps()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
