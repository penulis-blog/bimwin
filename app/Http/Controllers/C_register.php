<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_register;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class C_register extends Controller
{
    public function index()
    {
        return view('register/index');
    }

    public function proses(Request $request)
    {
        $email          = $request->input('mails');
        $list_emails    = [];
        $mailing        = M_register::get_mailings();

        // list email yang tersedia di table sys_parameters
        foreach ($mailing as $mails) {
            $a = $mails->value;
            $b = str_replace(' ', '', explode(',', $a));

            foreach ($b as $key => $value) {
                $list_emails[$key] = $value;
            }
        }

        $username   = $request->input('nama');
        $karakter   = strlen($username);
        
        $token      = base64_encode(random_bytes(33));

        // ambil password terbaru di table sys_parameters
        $password       = M_register::get_default_password();

        // ambil default group atau role masyarakat
        $group          = M_register::get_default_group();

        // cek kondisi email dan username di table sys_users
        $cek_vuser      = M_register::get_vuser($username, $email);
        $total_vuser    = count($cek_vuser);
        
        if ($karakter > 5 || $karakter == 5) {
            if ($list_emails[0] == $email || preg_match("/$list_emails[0]/i", $email)) {
                if ($total_vuser > 0) {
                    return redirect('/register')->withInput()->with('available', 'Maaf, username atau email sudah tersedia.');
                } else {
                    $data_umum = [
                        'public_id' => Str::uuid()->toString(),
                        'id_roles' => $group[0]->id,
                        'username' => $username,
                        'password' => Hash::make($password[0]->value),
                        'mails' => $email,
                        'is_verifikasi' => 0,
                        'is_trash' => 0,
                        'remember_token' => $token,
                        'created' => 0,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    $id_umum_last = DB::table('sys_users')->insertGetId($data_umum);

                    $data_umum_profile = [
                        'public_id' => Str::uuid()->toString(),
                        'id_user' => $id_umum_last,
                        'created' => $id_umum_last,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    DB::table('sys_users_profile')->insert($data_umum_profile);

                    $dataid = array(
                        'created' => $id_umum_last,
                    );

                    DB::table('sys_users')->where('id', $id_umum_last)->update($dataid);

                    $dataemailumum = [
                        'name' => "Aktivasi Akun",
                        'pesan' => "Untuk bisa menggunakan akun yang telah di daftarkan, klik link dibawah ini untuk aktifkan
                        akun kamu.",
                        'username' => $username,
                        'password' => $password[0]->value,
                        'links' => url('aktivasi/verify?email=' . $email . '&token=' . urlencode($token))
                    ];

                    Mail::to($email)->send(new SendEmail($dataemailumum));

                    return redirect('/signin')->with('success', 'Berhasil, pendaftaran sukses dan cek email untuk aktivasi akun.');
                }
            } else if ($list_emails[1] == $email || preg_match("/$list_emails[1]/i", $email)) {
                if ($total_vuser > 0) {
                    return redirect('/register')->withInput()->with('available', 'Maaf, username atau email sudah tersedia.');
                } else {
                    $data_umum = [
                        'public_id' => Str::uuid()->toString(),
                        'id_roles' => $group[0]->id,
                        'username' => $username,
                        'password' => Hash::make($password[0]->value),
                        'mails' => $email,
                        'is_verifikasi' => 0,
                        'is_trash' => 0,
                        'remember_token' => $token,
                        'created' => 0,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    $id_umum_last = DB::table('sys_users')->insertGetId($data_umum);

                    $data_umum_profile = [
                        'public_id' => Str::uuid()->toString(),
                        'id_user' => $id_umum_last,
                        'created' => $id_umum_last,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    DB::table('sys_users_profile')->insert($data_umum_profile);

                    $dataid = array(
                        'created' => $id_umum_last,
                    );

                    DB::table('sys_users')->where('id', $id_umum_last)->update($dataid);

                    $dataemailumum = [
                        'name' => "Aktivasi Akun",
                        'pesan' => "Untuk bisa menggunakan akun yang telah di daftarkan, klik link dibawah ini untuk aktifkan
                        akun kamu.",
                        'username' => $username,
                        'password' => $password[0]->value,
                        'links' => url('aktivasi/verify?email=' . $email . '&token=' . urlencode($token))
                    ];

                    Mail::to($email)->send(new SendEmail($dataemailumum));

                    return redirect('/signin')->with('success', 'Berhasil, pendaftaran sukses dan cek email untuk aktivasi akun.');
                }
            } else if ($list_emails[2] == $email || preg_match("/$list_emails[2]/i", $email)) {
                if ($total_vuser > 0) {
                    return redirect('/register')->withInput()->with('available', 'Maaf, username atau email sudah tersedia.');
                } else {
                    $data_umum = [
                        'public_id' => Str::uuid()->toString(),
                        'id_roles' => $group[0]->id,
                        'username' => $username,
                        'password' => Hash::make($password[0]->value),
                        'mails' => $email,
                        'is_verifikasi' => 0,
                        'is_trash' => 0,
                        'remember_token' => $token,
                        'created' => 0,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    $id_umum_last = DB::table('sys_users')->insertGetId($data_umum);

                    $data_umum_profile = [
                        'public_id' => Str::uuid()->toString(),
                        'id_user' => $id_umum_last,
                        'created' => $id_umum_last,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    DB::table('sys_users_profile')->insert($data_umum_profile);

                    $dataid = array(
                        'created' => $id_umum_last,
                    );

                    DB::table('sys_users')->where('id', $id_umum_last)->update($dataid);

                    $dataemailumum = [
                        'name' => "Aktivasi Akun",
                        'pesan' => "Untuk bisa menggunakan akun yang telah di daftarkan, klik link dibawah ini untuk aktifkan
                        akun kamu.",
                        'username' => $username,
                        'password' => $password[0]->value,
                        'links' => url('aktivasi/verify?email=' . $email . '&token=' . urlencode($token))
                    ];

                    Mail::to($email)->send(new SendEmail($dataemailumum));

                    return redirect('/signin')->with('success', 'Berhasil, pendaftaran sukses dan cek email untuk aktivasi akun.');
                }
            } else if ($list_emails[3] == $email || preg_match("/$list_emails[3]/i", $email)) {
                if ($total_vuser > 0) {
                    return redirect('/register')->withInput()->withInput()->with('available', 'Maaf, username atau email sudah tersedia.');
                } else {
                    $data_umum = [
                        'public_id' => Str::uuid()->toString(),
                        'id_roles' => $group[0]->id,
                        'username' => $username,
                        'password' => Hash::make($password[0]->value),
                        'mails' => $email,
                        'is_verifikasi' => 0,
                        'is_trash' => 0,
                        'remember_token' => $token,
                        'created' => 0,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    $id_umum_last = DB::table('sys_users')->insertGetId($data_umum);

                    $data_umum_profile = [
                        'public_id' => Str::uuid()->toString(),
                        'id_user' => $id_umum_last,
                        'created' => $id_umum_last,
                        'created_date' => date('Y-m-d H:i:s')
                    ];

                    DB::table('sys_users_profile')->insert($data_umum_profile);

                    $dataid = array(
                        'created' => $id_umum_last,
                    );

                    DB::table('sys_users')->where('id', $id_umum_last)->update($dataid);

                    $dataemailumum = [
                        'name' => "Aktivasi Akun",
                        'pesan' => "Untuk bisa menggunakan akun yang telah di daftarkan, klik link dibawah ini untuk aktifkan
                        akun kamu.",
                        'username' => $username,
                        'password' => $password[0]->value,
                        'links' => url('aktivasi/verify?email=' . $email . '&token=' . urlencode($token))
                    ];

                    Mail::to($email)->send(new SendEmail($dataemailumum));

                    return redirect('/signin')->with('success', 'Berhasil, pendaftaran sukses dan cek email untuk aktivasi akun.');
                }
            } else {
                return redirect('/register')->withInput()->with('unlistmails', 'Maaf, email yang disetujui adalah (@gmail.com / @yahoo.com / @yahoo.co.id / @ymail.com).');
            }
        }else{
            return redirect('/register')->withInput()->with('karakterunvalid', 'Maaf, username tidak boleh kurang dari 5 karakter.');
        }
    }
}
