<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiDosenController;
use GuzzleHttp\Client;
use App\Pengguna;

class dosenController extends Controller
{
    protected $api_dosen;

    public function __construct()
    {
        $this->api_dosen = new ApiDosenController;
    }

    public function index()
    {
        $title = "Akun Dosen";
        $headerTitle = "Data Akun Dosen";
        $api_dosen = $this->api_dosen;

        $dosens = $this->getAllData();

        return view('akun_dosen.index', compact('title', 'headerTitle', 'dosens'));
    }

    public function edit($nidn)
    {
        $title = "Edit Akun Dosen";
        $headerTitle = "Edit Data Akun Dosen";

        $dosen = $this->getDataByNidn($nidn);

        if ($dosen) {
            return view('akun_dosen.edit', compact('title', 'headerTitle', 'dosen'));
        }
    }

    public function getAllData()
    {
        $dosens = collect();

        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "pengguna/dosen";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
            ]);

            $dosens = json_decode($responseP->getBody());

            $new_data = $dosens->data;

            return $new_data;
        } catch (\Throwable $err) {
            return $dosens;
        }
    }

    public function getDataByNidn($nidn)
    {
        $dosen = null;

        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "pengguna/dosen/detail/" . $nidn;

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
            ]);

            $dosen = json_decode($responseP->getBody());

            $new_data = $dosen->data;

            return $new_data;
        } catch (\Throwable $err) {
            return $dosen;
        }
    }
}
