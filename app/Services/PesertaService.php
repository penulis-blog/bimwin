<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PesertaService
{
    /**
     * Simpan peserta hasil import excel
     */
    public function import(array $row)
    {
        return DB::transaction(function () use ($row) {
            $id = DB::table('dt_form')->insertGetId([
                'public_id'      => Str::uuid()->toString(),
                'id_kegiatan'    => $row['id_kegiatan']   ?? null,
                'id_provinsi'    => $row['id_provinsi']   ?? null,
                'id_kabupaten'   => $row['id_kabupaten']  ?? null,
                'id_kecamatan'   => $row['id_kecamatan']  ?? null,
                'nama'           => $row['nama']          ?? null,
                'lahir'          => $row['lahir']         ?? null,
                'tgl'            => $row['tgl']           ?? null,
                'jkl'            => $row['jkl']           ?? null,
                'nik'            => $row['nik']           ?? null,
                'nip'            => $row['nip']           ?? null,
                'jabatan'        => $row['jabatan']       ?? null,
                'golongan'       => $row['golongan']      ?? null,
                'instansi'       => $row['instansi']      ?? null,
                'alamat_kantor'  => $row['alamat_kantor'] ?? null,
                'alamat_rumah'   => $row['alamat_rumah']  ?? null,
                'no_hp'          => $row['no_hp']         ?? null,
                'email'          => $row['email']         ?? null,
                'npwp'           => $row['npwp']          ?? null,
                'no_rek'         => $row['no_rek']        ?? null,
                'nm_bank'        => $row['nm_bank']       ?? null,

                // default upload
                'files'          => 'default.png',
                'files_surtug'   => null,
                'is_pegawai'     => $row['is_pegawai']    ?? 0,
                'angkatan'       => $row['angkatan']      ?? null,
                'is_trash'       => 17,
                'created'        => auth()->user()->id,
                'created_date'   => date("Y-m-d H:i:s"),
                'updated'        => 0,
                'updated_date'   => null,
                'deleted'        => 0,
                'deleted_date'   => null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Nomor Sertifikat
            |--------------------------------------------------------------------------
            */

            $noSertifikat = sprintf(
                "BKS/SERTIF/%s/%s/%s/%s",
                $id,
                $row['id_kegiatan'] ?? 0,
                strtoupper(uniqid().Str::random(4)),
                date('Y')
            );

            DB::table('dt_sertifikat')->insert([
                'public_id'      => Str::uuid()->toString(),
                'id_form'        => $id,
                'no_sertifikat'  => $noSertifikat,
                'is_trash'       => 1,
                'created'        => auth()->user()->id,
                'created_date'   => date("Y-m-d H:i:s")
            ]);

            return $id;
        });
    }
}