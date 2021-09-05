<?php

namespace App\Http\Controllers;

use App\Exports\PrestasiEventInternalExport;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;

class prestasiEventInternalController extends Controller
{
    public function index()
    {
        $title = "Prestasi Event Internal";
        $headerTitle = "Export Prestasi Event Internal";

        return view('prestasi.eventinternal.index', compact('title', 'headerTitle'));
    }

    public function exportAllExcel()
    {
        $data = $this->getAllDatas();
        if ($data->status == 1) {
            $prestasis = $data->data;
            return Excel::download(new PrestasiEventInternalExport($prestasis), 'Prestasi Event Internal.xlsx');
            // dd($data->data);
        } else {
            return redirect()->back()->with('failed', 'Upps terjadi error');
        }
    }

    public function getAllDatas()
    {

        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "prestasi/eventinternal";
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
