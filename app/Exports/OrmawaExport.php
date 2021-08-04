<?php

namespace App\Exports;

use App\Http\Controllers\ormawaController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrmawaExport implements FromView, ShouldAutoSize
{

    public function view(): View
    {
        $ormawa_controller = new ormawaController;
        $ormawas = $ormawa_controller->getAllOrmawa();

        return view('exports.ormawa', [
            'ormawas' => $ormawas
        ]);
    }
}
