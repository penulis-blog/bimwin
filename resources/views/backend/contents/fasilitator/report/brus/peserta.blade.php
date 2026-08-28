<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Biodata {{ $peserta->angkatan == 99 ? 'Narasumber' : 'Peserta' }}</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14px;
            }
            .header {
                text-align: center;
            }
            .header img {
                width: 70px;
            }
            .title {
                font-size: 16px;
                margin: 0px 0;
            }
            .subtitle {
                font-weight: bold;
                font-size: 16px;
                margin-bottom: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
                margin: 40px;
            }
            table td {
                padding: 6px 2px; /* tambah jarak antar isi */
                vertical-align: top;
                line-height: 1.6; /* tambah tinggi baris */
            }
            table td.label {
                width: 30%;
                font-weight: bold;
            }
            table td.sep {
                width: 3%;
                text-align: center;
            }
            .signature {
                text-align: right;
                font-size: 14px !important;
                margin-top: 40px;
            }
            .signature .name {
                margin-top: 60px;
                font-weight: bold;
            }
            .photo {
                width: 100px;
                border: 1px solid #000;
                margin-top: 10px;
            }
            .footer {
                width: 100%;
                margin-top: 20px;
            }
            .footer td {
                vertical-align: top;
            }
            .angkatan {
                position: absolute;
                top: 20px; /* jarak dari atas */
                right: 40px; /* jarak dari kanan */
                font-size: 14px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="angkatan">
            {{ $peserta->angkatan == 99 ? '' : 'ANGKATAN-'.$peserta->angkatan }}
        </div>
        {{-- HEADER --}}
        <div class="header">
            <img
                src="{{ public_path('assets/backend/img/bi-kemag.png') }}"
                width="100"
            /><br />
            <div class="title">
                DIREKTORAT JENDERAL BIMBINGAN MASYARAKAT ISLAM
            </div>
            <div class="title">DIREKTORAT BINA KUA DAN KELUARGA SAKINAH</div>
            <div class="subtitle">
                {{ strtoupper($peserta->judul_acara) }}
            </div>
            <div style="font-size: 14px; margin-top: -14px !important">
                {{ ucwords($peserta->tempat.', '. $peserta->lokasi.', ') }} {{ indo_periode($peserta->dari, $peserta->sampai) }}
            </div>
            <hr />
            <div
                style="
                    font-weight: bold;
                    font-size: 14px;
                    margin-top: -14px !important;
                "
            >
                {{ $peserta->angkatan == 99 ? 'BIODATA NARASUMBER' : 'BIODATA PESERTA' }}
            </div>
            <br />
        </div>

        {{-- TABEL BIODATA --}}
        <table
            border="0"
            style="margin: 0 40px; margin-top: -10px !important; width: 100%"
        >
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="sep">:</td>
                <td>{{ ucwords($peserta->nama) }}</td>
                <!-- Foto digabung ke kanan mulai baris pertama -->
                <td rowspan="8" style="text-align: center; width: 120px">
                    <img
                        src="{{ getFotoPeserta($peserta->files) }}"
                        style="width: 35mm; height: auto; object-fit: cover; border-radius: 4px;"
                        class="photo"
                    />
                </td>
            </tr>
            <tr>
                <td class="label">Tempat, Tanggal Lahir</td>
                <td class="sep">:</td>
                <td>{{ ucwords($peserta->tempat_tanggal_lahir) }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="sep">:</td>
                <td>{{ ucwords($peserta->jkl) }}</td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="sep">:</td>
                <td>{{ $peserta->nik }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="sep">:</td>
                <td>{{ $peserta->nip }}</td>
            </tr>
            <tr>
                <td class="label">Status Kepegawaian</td>
                <td class="sep">:</td>
                <td>{{ $peserta->pegawai }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="sep">:</td>
                <td>{{ ucwords($peserta->jabatan) }}</td>
            </tr>
            <tr>
                <td class="label">Golongan/Ruang</td>
                <td class="sep">:</td>
                <td>{{ $peserta->golongan }}</td>
            </tr>

            <!-- Mulai baris ke-9 ke bawah: kembali full width -->
            <tr>
                <td class="label">Instansi</td>
                <td class="sep">:</td>
                <td colspan="2">{{ ucwords($peserta->instansi) }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Kantor</td>
                <td class="sep">:</td>
                <td colspan="2">{{ ucwords($peserta->alamat_kantor) }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Rumah</td>
                <td class="sep">:</td>
                <td colspan="2">{{ ucwords($peserta->alamat_rumah) }}</td>
            </tr>
            <tr>
                <td class="label">Nomor HP</td>
                <td class="sep">:</td>
                <td colspan="2">{{ $peserta->no_hp }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Email</td>
                <td class="sep">:</td>
                <td colspan="2">{{ $peserta->email }}</td>
            </tr>
            <tr>
                <td class="label">NPWP</td>
                <td class="sep">:</td>
                <td colspan="2">{{ $peserta->npwp }}</td>
            </tr>
            <tr>
                <td class="label">No. Rekening</td>
                <td class="sep">:</td>
                <td colspan="2">{{ $peserta->no_rek }}</td>
            </tr>
            <tr>
                <td class="label">Nama Bank</td>
                <td class="sep">:</td>
                <td colspan="2">{{ $peserta->nm_bank }}</td>
            </tr>
        </table>

        <table class="footer"> <tr> <td width="50%" class="signature"> {{ ucwords($peserta->lokasi) }}, {{ indo_date($peserta->dari) }} <br /> {{ $peserta->angkatan == 99 ? 'Narasumber' : 'Peserta' }},<br><br><br><br> <div class="name">{{ ucwords($peserta->nama) }}</div> </td> </tr> </table>
    </body>
</html>
