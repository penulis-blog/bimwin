<?php

if (!function_exists('indo_periode')) {
    function indo_periode($dari, $sampai) {
        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        $tglDari = new DateTime($dari);
        $tglSampai = new DateTime($sampai);

        // kalau bulan & tahun sama
        if ($tglDari->format('mY') === $tglSampai->format('mY')) {
            $periode = $tglDari->format('d') . ' s.d ' . $tglSampai->format('d F Y');
        } else {
            $periode = $tglDari->format('d F Y') . ' s.d ' . $tglSampai->format('d F Y');
        }

        return strtr($periode, $bulan);
    }
}

if (!function_exists('indo_date')) {
    function indo_date($date) {
        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
        $tgl = \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('d F Y');
        return strtr($tgl, $bulan);
    }
}

if (!function_exists('ambil_kata_terakhir')) {
    function ambil_kata_terakhir($string) {
        $parts = explode(' ', $string);
        return end($parts);
    }
}

if (!function_exists('getFotoPeserta')) {
    function getFotoPeserta($path) {
        if (!empty($path) && file_exists(public_path('storage/'.$path))) {
            return public_path('storage/'.$path);
        }
        return public_path('assets/backend/img/5856.jpg');
    }
}
