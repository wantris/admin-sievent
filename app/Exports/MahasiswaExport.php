<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Http\Controllers\MahasiswaController;

class MahasiswaExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {

        $mhs_controller = new MahasiswaController;
        $mahasiswas = $mhs_controller->getAllData();
        dd($mahasiswas);


        return view('exports.wadir3', [
            'wadir3s' => $mahasiswas
        ]);
    }
}
