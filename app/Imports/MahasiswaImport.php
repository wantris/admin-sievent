<?php

namespace App\Imports;

use App\Pengguna;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MahasiswaImport implements ToCollection
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key > 0) {
                $pengguna = Pengguna::where('nim', $row[1])->first();
                if (!$pengguna) {
                    $pengguna = new Pengguna();
                    $pengguna->username = $row[1];
                    $pengguna->password = Hash::make('@Polindra123');
                    $pengguna->is_mahasiswa = 1;
                    $pengguna->is_wadir3 = 0;
                    $pengguna->is_pembina = 0;
                    $pengguna->is_participant = 0;
                    $pengguna->is_dosen = 0;
                    $pengguna->nim = $row[1];
                    $pengguna->save();
                }
            }
        }
    }
}
