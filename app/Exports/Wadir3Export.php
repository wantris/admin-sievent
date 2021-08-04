<?php

namespace App\Exports;

use App\Http\Controllers\ApiDosenController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Wadir3;

class Wadir3Export implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $wadir3s = Wadir3::all();
        $api_dosen = new ApiDosenController;

        if ($wadir3s->count() > 0) {
            foreach ($wadir3s as $wadir3) {
                $wadir3->dosenRef = null;
                $dosen = $api_dosen->getDosenOnlySomeField($wadir3->nidn);
                if ($dosen) {
                    $wadir3->dosenRef = $dosen;
                }
            }
        }

        return view('exports.wadir3', [
            'wadir3s' => $wadir3s
        ]);
    }
}
