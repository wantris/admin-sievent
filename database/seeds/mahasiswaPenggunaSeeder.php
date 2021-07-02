<?php

use App\Pengguna;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class mahasiswaPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new Client();
        $url = env('SECOND_BACKEND_URL') . "mahasiswa";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $mahasiswas = json_decode($response->getBody());

        foreach ($mahasiswas as $mhs) {
            $check = Pengguna::where('nim', $mhs->nim)->first();
            echo $mhs->nim;
            if (!$check) {
                $ps = new Pengguna();
                $ps->username = $mhs->nim;
                $ps->password = Hash::make('@Polindra123');
                $ps->is_mahasiswa = 1;
                $ps->is_wadir3 = 0;
                $ps->is_pembina = 0;
                $ps->is_participant = 0;
                $ps->nim = $mhs->nim;
                $ps->save();
            }
        }
    }
}
