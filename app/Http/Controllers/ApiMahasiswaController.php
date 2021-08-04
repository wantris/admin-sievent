<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiMahasiswaController extends Controller
{
    public function getAllMahasiswa()
    {
        $mahasiswa = collect();
        try {
            // call API
            // Fixed Value. don't change anything
            $cipher = "AES-256-CBC";

            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "mahasiswa/search";
            $response = $client->request('GET', $url, [
                'verify'  => false,
                'headers' => ['Authorization-Polindra' => env('API_KEY')],
                'query' => ['prefix' => env('PREFIX_KEY')]
            ]);
            $data = json_decode($response->getBody())->data;

            $decrypt = openssl_decrypt($data, $cipher, env('API_KEY'), 0, env('PREFIX_KEY'));

            if ($decrypt) $mahasiswa = json_decode($decrypt, false);

            return $mahasiswa->data;
        } catch (\Throwable $err) {
            return $mahasiswa;
        }
    }

    public function getMahasiswaByNim($nim)
    {
        $mahasiswa = null;
        try {
            // call API
            // Fixed Value. don't change anything
            $cipher = "AES-256-CBC";

            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "mahasiswa/search";
            $response = $client->request('GET', $url, [
                'headers' => ['Authorization-Polindra' => env('API_KEY')],
                'query' => [
                    'prefix' => env('PREFIX_KEY'),
                    'nim' => $nim
                ]
            ]);

            dd($response->getBody());

            $data = json_decode($response->getBody())->data;

            $decrypt = openssl_decrypt($data, $cipher, env('API_KEY'), 0, env('PREFIX_KEY'));

            if ($decrypt) $mahasiswa = json_decode($decrypt, false);

            return $mahasiswa->data[0];
        } catch (\Throwable $err) {
            return $mahasiswa;
        }
    }

    public function getMahasiswaSomeField($nim)
    {
        $mahasiswa = null;
        try {
            $cipher = "AES-256-CBC";

            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "mahasiswa/search";
            $response = $client->request('GET', $url, [
                'verify'  => false,
                'headers' => ['Authorization-Polindra' => env('API_KEY')],
                'query' => [
                    'prefix' => env('PREFIX_KEY'),
                    'nim' => $nim
                ]
            ]);
            $data = json_decode($response->getBody())->data;

            $decrypt = openssl_decrypt($data, $cipher, env('API_KEY'), 0, env('PREFIX_KEY'));

            if ($decrypt) {
                $mahasiswa = json_decode($decrypt, false)->data[0];

                $mahasiswa = (object) [
                    "mahasiswa_nama" => $mahasiswa->mahasiswa_nama,
                    "mahasiswa_nim" => $mahasiswa->mahasiswa_nim,
                    "kelas_kode" => $mahasiswa->kelas_kode,
                    "tahun_index" => $mahasiswa->tahun_index,
                    "program_studi_kode" => $mahasiswa->program_studi_kode
                ];
            }

            return $mahasiswa;
        } catch (\Throwable $err) {
            return $mahasiswa;
        }
    }
}
