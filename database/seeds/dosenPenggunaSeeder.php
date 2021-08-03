<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Http\Controllers\ApiDosenController;
use App\Pengguna;
use Illuminate\Support\Facades\Hash;

class dosenPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $api_dosen = new ApiDosenController;

        $dosens = $api_dosen->getAllDosen();

        if (count($dosens) > 0) {
            foreach ($dosens as $dosen) {
                $check = Pengguna::where('nidn', $dosen->dosen_nidn)->first();
                if (!$check) {
                    $ps = new Pengguna();
                    $ps->username = $dosen->dosen_nidn;
                    $ps->password = Hash::make('@Polindra123');
                    $ps->is_mahasiswa = 0;
                    $ps->is_wadir3 = 0;
                    $ps->is_pembina = 0;
                    $ps->is_participant = 0;
                    $ps->is_dosen = 1;
                    $ps->nidn = $dosen->dosen_nidn;
                    $ps->save();
                }
            }
        }
    }
}
