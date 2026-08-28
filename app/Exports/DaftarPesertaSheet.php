<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DaftarPesertaSheet implements FromView, WithColumnWidths, WithStyles, WithTitle
{
    protected $data;
    protected $single;
    protected $tanggal;
    protected $angkatanLabel;

    public function __construct($data, $single, $tanggal, $angkatanLabel)
    {
        $this->data = $data;
        $this->single = $single;
        $this->tanggal = $tanggal;
        $this->angkatanLabel = $angkatanLabel;
    }

    public function view(): View
    {
        return view('exports.daftar_peserta', [
            'data' => $this->data,
            'single' => $this->single,
            'tanggal' => $this->tanggal,
            'angkatanLabel' => $this->angkatanLabel,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 20,
            'G' => 25,
            'H' => 25,
            'I' => 25,
            'J' => 25,
            'K' => 25,
            'L' => 25,
            'M' => 25,
            'N' => 25,
            'O' => 25,
            'P' => 25,
            'Q' => 25,
            'R' => 25,
            'S' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getDefaultRowDimension()->setRowHeight(22);

        // Header tetap center
        $sheet->getStyle('A1:S20')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        // 🔹 Set kolom Provinsi, Kabupaten/Kota, dan KUA/Utusan auto width
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            3 => ['font' => ['size' => 11]],
        ];
    }

    public function title(): string
    {
        return $this->angkatanLabel;
    }
}
