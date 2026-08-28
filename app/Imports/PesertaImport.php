<?php

namespace App\Imports;

use App\Services\PesertaService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class PesertaImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    protected $service;

    public function __construct(PesertaService $service)
    {
        $this->service = $service;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = $row->toArray();
            // Lewati jika seluruh kolom kosong
            if (collect($data)->filter()->isEmpty()) {
                continue;
            }

            $data['tgl'] = $this->formatTanggal($data['tgl'] ?? null);
            $this->service->import($data);
        }
    }

    private function formatTanggal($tanggal)
    {
        if (empty($tanggal)) {
            return null;
        }

        if (is_numeric($tanggal)) {
            return Carbon::instance(
                Date::excelToDateTimeObject($tanggal)
            )->format('Y-m-d');
        }

        return Carbon::parse($tanggal)->format('Y-m-d');
    }
}