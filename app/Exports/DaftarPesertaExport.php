<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DaftarPesertaExport implements WithMultipleSheets
{
    protected $data;
    protected $single;
    protected $tanggal;

    public function __construct($data, $single, $tanggal)
    {
        $this->data = $data;
        $this->single = $single;
        $this->tanggal = $tanggal;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Ambil semua angkatan unik dari data
        $angkatanList = collect($this->data)
        ->pluck('angkatan')
        ->unique()
        ->filter(function($val) {
            return $val !== null; // hanya buang yang null
        })
        ->values();

        if ($angkatanList->isEmpty()) {
            // Jika kosong, tampilkan 1 sheet default
            $sheets[] = new DaftarRekeningPerAngkatanSheet($this->data, $this->single, $this->tanggal, 'Semua Peserta');
        } else {
            foreach ($angkatanList as $angkatan) {
                $filtered = collect($this->data)->where('angkatan', $angkatan)->values();

                if ($angkatan == 0) {
                    $label = 'Peserta';
                } elseif ($angkatan == 99) {
                    $label = 'Narasumber';
                } else {
                    $label = 'Angkatan ' . $angkatan;
                }

                $sheets[] = new DaftarPesertaSheet($filtered, $this->single, $this->tanggal, $label);
            }
        }

        return $sheets;
    }
}
