<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DaftarRekeningPerAngkatanSheet implements FromView, WithColumnWidths, WithStyles, WithTitle
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
        return view('exports.daftar_rekening', [
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
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getDefaultRowDimension()->setRowHeight(22);

        // Header tetap center
        $sheet->getStyle('A1:F7')->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');

        // 🔹 Set kolom Provinsi, Kabupaten/Kota, dan KUA/Utusan auto width
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

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
