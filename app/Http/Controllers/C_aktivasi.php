<?php

namespace App\Http\Controllers;

use App\Models\M_aktivasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class C_aktivasi extends Controller
{
    public function verify(Request $request)
    {
        $email = $request->get('email');
        $token = $request->get('token');

        $data = M_aktivasi::get_verify($email, $token);
        
        if (count($data) == 1) {
            if($data[0]->is_verifikasi == 1 && $data[0]->remember_token == null){
                return redirect('/signin')->with('reaktivasi', 'Maaf, kamu sudah melakukan verifikasi sebelumnya, silahkan login.');
            }else{
                $aktivasi = [
                    'is_trash' => 1,
                    'is_verifikasi' => 1,
                    'updated' => $data[0]->id,
                    'updated_date' => date('Y-m-d H:i:s'),
                    'remember_token' => null // telah aktivasi
                ];
    
                if ($aktivasi) {
                    DB::table('sys_users')->where('id', $data[0]->id)->update($aktivasi);
                    return redirect('/signin')->with('aktivasi', 'Berhasil, Akun kamu telah berhasil aktivasi, silahkan login.');
                }
            }
        } else {
            return redirect('/signin')->with('aktivasifailed', 'Maaf, Email atau token tidak terdaftar.');
        }
    }
}
