<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PesertaImport;
use App\Services\PesertaService;
use Maatwebsite\Excel\Facades\Excel;

class PesertaController extends Controller
{
    public function import(Request $request, PesertaService $service)
    {
        $request->validate([
            'doks_excel' => 'required|file|mimes:xlsx,xls|max:5120',
        ]);

        try {

            Excel::import(
                new PesertaImport($service),
                $request->file('doks_excel')
            );

            return response()->json([
                'message' => 200
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'message' => 500,
                'error'   => $e->getMessage()
            ], 500);

        }
    }
}