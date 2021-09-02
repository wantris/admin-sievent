<?php

namespace App\Exports;

use App\Http\Controllers\ApiMahasiswaController;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MahasiswaSampleExport implements FromView
{
    public function view(): View
    {
        $api_mahasiswa = new ApiMahasiswaController;
        $mahasiswas = $api_mahasiswa->getAllMahasiswa();

        return view('exports.mahasiswa_sample', [
            'mahasiswas' => $mahasiswas
        ]);
    }
}
