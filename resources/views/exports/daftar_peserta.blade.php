<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style type="text/css">
    </style>
</head>
<body>
    <table style="border-collapse: collapse; width: 100%; vertical-align: middle;">
        <tr>
            <td colspan="7" style="text-align: center; font-weight: bold; font-size: 24pt;">
                {{ strtoupper($single->judul_acara) }}
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center; font-size: 20pt;">
                {{ ucwords($single->tempat) }}, {{ indo_periode($single->in, $single->out) }}
            </td>
        </tr>
        <tr><td colspan="6"></td></tr>
        {{-- === HEADER TABEL === --}}
        <tr style="font-weight: bold; text-align: center; font-size: 15px;">
            <td style="border: 1px solid black; font-weight:bold;">NO</td>
            <td style="border: 1px solid black; font-weight:bold;">PROVINSI</td>
            <td style="border: 1px solid black; font-weight:bold;">KABUPATEN</td>
            <td style="border: 1px solid black; font-weight:bold;">KECAMATAN</td>
            <td style="border: 1px solid black; font-weight:bold;">KODE KUA</td>
            <td style="border: 1px solid black; font-weight:bold;">NIK KTP</td>
            <td style="border: 1px solid black; font-weight:bold;">NIP</td>
            <td style="border: 1px solid black; font-weight:bold;">NAMA</td>
            <td style="border: 1px solid black; font-weight:bold;">TEMPAT LAHIR</td>
            <td style="border: 1px solid black; font-weight:bold;">TANGGAL LAHIR</td>
            <td style="border: 1px solid black; font-weight:bold;">JENIS KELAMIN</td>
            <td style="border: 1px solid black; font-weight:bold;">JABATAN</td>
            <td style="border: 1px solid black; font-weight:bold;">GOLONGAN</td>
            <td style="border: 1px solid black; font-weight:bold;">INSTANSI</td>
            <td style="border: 1px solid black; font-weight:bold;">NO. HP</td>
            <td style="border: 1px solid black; font-weight:bold;">EMAIL</td>
            <td style="border: 1px solid black; font-weight:bold;">NPWP</td>
            <td style="border: 1px solid black; font-weight:bold;">BANK</td>
            <td style="border: 1px solid black; font-weight:bold;">NO.REKENING</td>
        </tr>

        @php $no = 1; @endphp
        @foreach($data as $item)
            <tr style="font-size: 15px;">
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ $no }}.</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->provinsi) }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->kabupaten) }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->kecamatan) }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ "'" . ($item->kode_kua ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ "'" . ($item->nik ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ "'" . ($item->nip ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->nama ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->lahir ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ $item->tgl ?? '-' }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->jkl) }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->jabatan ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ $item->golongan }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->instansi ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ "'" . ($item->no_hp ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ $item->email ?? '-' }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ "'" . ($item->npwp ?? '-') }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ strtoupper($item->nm_bank) }}</td>
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ "'" . $item->no_rek }}</td>
            </tr>
            @php $no++; @endphp
        @endforeach
    </table>
</body>
</html>
