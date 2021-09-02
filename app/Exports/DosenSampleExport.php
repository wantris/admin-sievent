<?php

namespace App\Exports;

use App\Http\Controllers\ApiDosenController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class DosenSampleExport implements FromView
{
    public function view(): View
    {
        $api_dosen = new ApiDosenController;
        $dosens = $api_dosen->getAllDosen();

        return view('exports.dosen_sample', [
            'dosens' => $dosens
        ]);
    }
}
