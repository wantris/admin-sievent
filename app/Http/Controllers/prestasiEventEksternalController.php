<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PrestasiEventEksternalExport;
use GuzzleHttp\Client;

class prestasiEventEksternalController extends Controller
{
    public function index()
    {
        $title = "Prestasi Event Eksternal";
        $headerTitle = "Export Prestasi Event Eksternal";

        return view('prestasi.eventeksternal.index', compact('title', 'headerTitle'));
    }

    public function exportAllExcel()
    {
        $data = $this->getAllDatas();
        if ($data->status == 1) {
            $prestasis = $data->data;
            // dd($prestasis);
            return Excel::download(new PrestasiEventEksternalExport($prestasis), 'Prestasi Event Eksternal.xlsx');
            // dd($data->data);
        } else {
            return redirect()->back()->with('failed', 'Upps terjadi error');
        }
    }

    public function getAllDatas()
    {

        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "prestasi/eventeksternal";
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            if ($response->getStatusCode() == 200) {
                $datas = json_decode($response->getBody());
                $prestasi = $datas->data;
                $status = (object)[
                    'status' => '1',
                    'data' => $prestasi
                ];

                return $status;
            } else {
                $status = (object)[
                    'status' => '0',
                    'data' => null
                ];
                return $status;
            }
        } catch (\Throwable $err) {
            $status = (object)[
                'status' => '0',
                'data' => null
            ];
            return $status;
        }
    }
}
