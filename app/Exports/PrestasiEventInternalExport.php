<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PrestasiEventInternalExport implements FromView, ShouldAutoSize
{
    protected $prestasis;

    function __construct($prestasis)
    {
        $this->prestasis = $prestasis;
    }

    public function view(): View
    {

        $prestasis = $this->prestasis;

        return view('exports.excel.prestasi.eventinternal.index', [
            'prestasis' => $prestasis,
        ]);
    }
}
