<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style type="text/css">
    </style>
</head>
<body>
    <table style="border-collapse: collapse; width: 100%; vertical-align: middle;">
        {{-- === HEADER === --}}
        <tr>
            <td colspan="7" style="text-align: center; font-weight: bold; font-size: 26pt;">
                PERLENGKAPAN PESERTA
            </td>
        </tr>
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
            <td style="border: 1px solid black; font-weight:bold;">NAMA</td>
            <td style="border: 1px solid black; font-weight:bold;">UTUSAN</td>
            <td style="border: 1px solid black; font-weight:bold;">PERLENGKAPAN</td>
            <td colspan="3" style="border: 1px solid black; width: 20px; font-weight:bold;">TANDA TANGAN</td>
        </tr>

        @php $no = 1; @endphp
        @foreach($data as $item)
            <tr style="font-size: 15px;">
                <td style="text-align: center; border:1px solid black; vertical-align: middle;">{{ $no }}.</td>

                <!-- Kolom nama rata kiri -->
                <td style="border:1px solid black; text-align:center; vertical-align: middle;">
                    {{ strtoupper($item->nama ?? '-') }}
                </td>
                <td style="border:1px solid black; text-align:center; vertical-align: middle;">{{ strtoupper($item->kecamatan ?? '-') }}</td>
                <td style="border:1px solid black; text-align:center; vertical-align: middle;">............................</td>

                @if($no % 2 != 0)
                    {{-- Nomor ganjil → kiri --}}
                    <td style="border-bottom:1px solid black; height:30px; vertical-align: middle;">{{ $no }}............................</td>
                    <td colspan="2" style="border-bottom:1px solid black; border-right:1px solid black; height:30px;"></td>
                @else
                    {{-- Nomor genap → kanan --}}
                    <td style="border-bottom:1px solid black; height:30px;"></td>
                    <td colspan="2" style="border-bottom:1px solid black; vertical-align: middle; border-right:1px solid black; height:30px;">{{ $no }}............................</td>
                @endif
            </tr>
            @php $no++; @endphp
        @endforeach

        {{-- === PENUTUP === --}}
        <tr><td colspan="6"></td></tr>
        <tr><td colspan="6"></td></tr>
        <tr>
            <td colspan="5"></td>
            <td style="text-align: left; font-size: 12pt;">{{ ucwords($single->lokasi) }}, {{ $single->tanggal_ }}</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td style="text-align: left; font-size: 12pt;">Ketua Panitia,</td>
        </tr>
        <tr><td colspan="6" style="height: 69px;"></td></tr>
        <tr>
            <td colspan="5"></td>
            <td style="text-align: left; font-weight: bold; font-size: 12pt;">........................</td>
        </tr>
    </table>
</body>
</html>
