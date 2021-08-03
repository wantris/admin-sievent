<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiDosenController extends Controller
{
    public function getAllDosen()
    {
        $dosen = collect();
        try {
            // call API
            // Fixed Value. don't change anything
            $cipher = "AES-256-CBC";

            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "dosen/search";
            $response = $client->request('GET', $url, [
                'verify'  => false,
                'headers' => ['Authorization-Polindra' => env('API_KEY')],
                'query' => ['prefix' => env('PREFIX_KEY')]
            ]);
            $data = json_decode($response->getBody())->data;

            $decrypt = openssl_decrypt($data, $cipher, env('API_KEY'), 0, env('PREFIX_KEY'));

            if ($decrypt) $dosen = json_decode($decrypt, false);

            return $dosen->data;
        } catch (\Throwable $err) {
            return $dosen;
        }
    }

    public function getDosenByNidn($nidn)
    {
        $dosen = null;
        try {
            // call API
            // Fixed Value. don't change anything
            $cipher = "AES-256-CBC";

            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "dosen/search";
            $response = $client->request('GET', $url, [
                'verify'  => false,
                'headers' => ['Authorization-Polindra' => env('API_KEY')],
                'query' => [
                    'prefix' => env('PREFIX_KEY'),
                    'nidn' => $nidn
                ]
            ]);
            $data = json_decode($response->getBody())->data;

            $decrypt = openssl_decrypt($data, $cipher, env('API_KEY'), 0, env('PREFIX_KEY'));

            if ($decrypt) $dosen = json_decode($decrypt, false);

            return $dosen->data[0];
        } catch (\Throwable $err) {
            return $dosen;
        }
    }

    public function getDosenOnlySomeField($nidn)
    {
        $dosen = null;
        try {
            // call API
            // Fixed Value. don't change anything
            $cipher = "AES-256-CBC";

            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "dosen/search";
            $response = $client->request('GET', $url, [
                'verify'  => false,
                'headers' => ['Authorization-Polindra' => env('API_KEY')],
                'query' => [
                    'prefix' => env('PREFIX_KEY'),
                    'nidn' => $nidn
                ]
            ]);
            $data = json_decode($response->getBody())->data;

            $decrypt = openssl_decrypt($data, $cipher, env('API_KEY'), 0, env('PREFIX_KEY'));

            if ($decrypt) {
                $dosen = json_decode($decrypt, false)->data[0];
                $dosen = (object) [
                    "dosen_nidn" => $dosen->dosen_nidn,
                    "dosen_lengkap_nama" => $dosen->dosen_gelar_depan . " " . $dosen->dosen_nama . " " . $dosen->dosen_gelar_belakang,
                    "dosen_nama" => $dosen->dosen_nama,
                    "dosen_gelar_depan" => $dosen->dosen_gelar_depan,
                    "dosen_gelar_belakang" => $dosen->dosen_gelar_belakang,
                    "program_studi_nama" => $dosen->program_studi_nama
                ];
            };

            return $dosen;
        } catch (\Throwable $err) {
            return $dosen;
        }
    }
}
