<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sertifikat {{ $peserta->angkatan == 99 ? 'Narasumber' : 'Peserta' }}</title>
    <style>
        body {
            font-family: 'times';
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 297mm;   /* A4 landscape */
            height: 210mm;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .page-break {
            page-break-after: always;
        }

        .judul {
            margin-top: 200px;   /* Jarak dari atas */
            margin-bottom: 0;
        }

        /* ===== Halaman belakang ===== */
        .content-back {
            position: absolute;
            top: 60mm;
            left: 40mm;
            right: 40mm;
            text-align: left;
        }

        h3 {
            font-size: 14pt;
            margin-bottom: 10px;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        table, th, td {
            border: 0.5pt solid #000;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        td {
            padding: 4px;
        }
    </style>
</head>
<body>

    {{-- ================= HALAMAN DEPAN ================= --}}
    <div class="page" style="background-image: url('{{ public_path('storage/' . $peserta->files_1) }}');">
        {{-- <table style="margin: 0 40px; width: 100%; border-collapse: collapse; border: none; margin-left:53%;">
            <tr>
                <td width="24%" style="border: none; font-size:18px; margin-top:4%;">Nomor: {{ $peserta->no_sertifikat }}</td>
            </tr>
        </table> --}}
        <p style="margin-left:58%;"><br><b>Nomor:</b> {{ $peserta->no_sertifikat }}</p>

        <br><br><br><br><br>
        <h2 style="text-align: center;">SERTIFIKAT</h2>
        <p style="text-align: center; font-size: 18px;">Direktur {{ ucwords($peserta->direktorat. ', ' . $peserta->eselon_1) }} menyatakan bahwa: </p>
        <table style="margin: 0 40px; width: 100%; border-collapse: collapse; border: none; margin-left:20%;">
            <tr>
                <td width="24%" style="border: none; font-size:18px;">Nama Lengkap</td>
                <td width="2%" style="border: none;">:</td>
                <td style="border: none; font-size:18px; margin-left:-90px;">{{ ucwords($peserta->nama) }}</td>
            </tr>
            <tr>
                <td width="24%" style="border: none; font-size:18px;">NIK</td>
                <td style="border: none;">:</td>
                <td style="border: none; font-size:18px;">{{ $peserta->nik }}</td>
            </tr>
            <tr>
                <td width="24%" style="border: none; font-size:18px;">Tempat, Tanggal Lahir</td>
                <td style="border: none;">:</td>
                <td style="border:none; font-size:18px;">
                    {{ ucwords($peserta->lahir) . ', ' . indo_date($peserta->tgl) }}
                </td>
            </tr>
            <tr>
                <td width="24%" style="border: none; font-size:18px;">Jabatan</td>
                <td style="border: none;">:</td>
                <td style="border: none; font-size:18px;">{{ ucwords($peserta->jabatan) }}</td>
            </tr>
            <tr>
                <td width="24%" style="border: none; font-size:18px;">Utusan/Satuan Kerja</td>
                <td style="border: none;">:</td>
                <td style="border: none; font-size:18px;">{{ {{ $peserta->instansi }} }}</td>
            </tr>
        </table>

        @php
        use Carbon\Carbon;

        $dari = Carbon::parse($peserta->dari)->locale('id');
        $sampai = Carbon::parse($peserta->sampai)->locale('id');

        $tanggalRange = ($dari->format('Y-m') == $sampai->format('Y-m'))
            ? $dari->translatedFormat('d') . ' sampai ' . $sampai->translatedFormat('d F Y')
            : $dari->translatedFormat('d F Y') . ' sampai ' . $sampai->translatedFormat('d F Y');

        $tanggalrincian = ($dari->format('Y-m') == $sampai->format('Y-m'))
            ? $dari->translatedFormat('d') . '-' . $sampai->translatedFormat('d F Y')
            : $dari->translatedFormat('d F Y') . ' - ' . $sampai->translatedFormat('d F Y');
        @endphp

        <p style="text-align: justify; margin-left:8%; width:83%; font-size: 18px; margin-bottom:-8px;">
            {!! $peserta->angkatan != 99 ? '<b>TELAH MENGIKUTI</b>' : '' !!} {{ ucwords($peserta->judul_acara) }} 
            yang diselenggarakan di {{ ucwords($peserta->lokasi) }} {!! $peserta->angkatan != 99 ? 'selama '.$total.' Jam' : '' !!} pada tanggal {{ $tanggalRange }}.
        </p>
        
        <!-- Bagian tanda tangan dan QR -->
        <table style="width: 100%; border-collapse: collapse; border: none; margin-left:60%;">
            <tr>
                <!-- Kolom foto -->
                <td style="width: 25%; border: none; text-align: center; vertical-align: top;">
                    <img
                        src="{{ getFotoPeserta($peserta->photo) }}"
                        style="width: 35mm; height: auto; object-fit: cover; border-radius: 4px;"
                        class="photo"
                    />
                </td>

                <!-- Kolom kosong -->
                <td style="border: none;" colspan="3"></td>

                <!-- Kolom teks & QR -->
                <td style="width: 75%; border: none; vertical-align: top;">
                    <p style="font-size: 18px; margin-bottom:4px;">
                        {{ ucwords($peserta->lokasi) }}, {{ indo_date($peserta->tgl_ttd) }} <br>
                        Direktur {!! implode(' dan<br>', explode(' dan ', $peserta->direktorat)) !!}
                    </p>
                    <div style="margin: 10px 0;">
                        <img src="{{ public_path('storage/qr_code.png') }}" style="width: 80px; height: 80px; margin:10px;">
                    </div>
                    <p style="margin: 0; font-weight: bold; font-size: 14pt;">
                        {{ ucwords($peserta->direktur) }}
                    </p>
                </td>
            </tr>
        </table>

        <!-- Bagian nomor sertifikat di bawah background -->
        

        {{-- <div style="
            position: relative;
            width: 1123px;    /* ukuran A4 landscape */
            height: 794px;    /* ukuran A4 landscape */
            background: url('{{ public_path('template/sertifikat-bg.png') }}') no-repeat center;
            background-size: cover;
            margin-top: 20px; /* beri jarak aman dari tabel di atas */
        ">

            <!-- Konten sertifikat lainnya di sini -->
            
            <!-- Nomor sertifikat di pojok kiri bawah -->
            <div style="
                position: absolute;
                bottom: 25px;   /* jarak dari bawah */
                left: 60px;     /* jarak dari kiri */
                font-size: 13pt;
                font-weight: bold;
                color: #000;
                letter-spacing: 0.5px;
            ">
                Nomor: {{ $peserta->no_sertifikat }}
            </div>
        </div> --}}

    </div>

    {{-- ================= HALAMAN BELAKANG ================= --}}
    @if($peserta->angkatan != 99)
        <div class="page" style="background-image: url('{{ public_path('storage/' . $peserta->files_2) }}');">
            <div class="content-back">
                <br><br><br>
                <h3>
                    {{ strtoupper($peserta->judul_acara) }}<br>
                    ANGKATAN {{ $peserta->angkatan }}<br>
                    {{ strtoupper($peserta->tempat) }} {{ $tanggalrincian }}
                </h3>

                <table style="width: 100%; border-collapse: collapse; margin-left:12%; margin-right:12%;">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th>MATERI</th>
                            <th width="10%">JPL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rincian as $key => $m)
                            <tr>
                                <td style="text-align: center; width: 5%;">{{ $key + 1 }}</td>
                                <td>{{ $m->judul }}</td>
                                <td style="text-align: center;">{{ $m->total }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="2" style="text-align: center;"><strong>TOTAL</strong></td>
                            <td style="text-align: center;"><strong>{{ $total }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</body>
</html>
