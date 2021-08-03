<?php

use App\Pengguna;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiMahasiswaController;

class mahasiswaPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $api_mahasiswa = new ApiMahasiswaController;
        $mahasiswas = $api_mahasiswa->getAllMahasiswa();

        foreach ($mahasiswas as $key =>  $mhs) {
            if ($key < 50) {
                $check = Pengguna::select(['nim'])->where('nim', $mhs->mahasiswa_nim)->first();
                if (!$check) {
                    $data = [
                        'username' => $mhs->mahasiswa_nim,
                        'username' => $mhs->mahasiswa_nim,
                        'password' => Hash::make('@Polindra123'),
                        'is_mahasiswa' => 1,
                        'is_wadir3' => 0,
                        'is_pembina' => 0,
                        'is_participant' => 0,
                        'is_dosen' => 0,
                        'nim' => $mhs->mahasiswa_nim,
                    ];

                    Pengguna::create($data);
                }
            } else {
                break;
            }
        }
    }
}
