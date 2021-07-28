<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
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
        $client = new Client();
        $url = env('SECOND_BACKEND_URL') . "dosen";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $dosens = json_decode($response->getBody());

        foreach ($dosens as $dosen) {
            $check = Pengguna::where('nidn', $dosen->nidn)->first();
            echo $dosen->nidn;
            if (!$check) {
                $ps = new Pengguna();
                $ps->username = $dosen->nidn;
                $ps->password = Hash::make('@Polindra123');
                $ps->is_mahasiswa = 0;
                $ps->is_wadir3 = 0;
                $ps->is_pembina = 0;
                $ps->is_participant = 0;
                $ps->is_dosen = 1;
                $ps->nidn = $dosen->nidn;
                $ps->save();
            }
        }
    }
}
