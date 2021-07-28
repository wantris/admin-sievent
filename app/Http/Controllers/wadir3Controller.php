<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wadir3StoreRequest;
use App\Wadir3;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class wadir3Controller extends Controller
{


    public function index()
    {
        $title = "Wakil Direktur 3";
        $headerTitle = "Data Wakil Direktur 3";

        $wadir3s = Wadir3::all();
        foreach ($wadir3s as $wadir3) {

            // call API
            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "dosen/" . $wadir3->nidn;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $dosen = json_decode($response->getBody());

            if ($dosen) {
                $wadir3->nama_dosen = $dosen->nama_dosen;
            }
        }
        return view('wadir3.index', compact('title', 'headerTitle', 'wadir3s'));
    }

    public function add()
    {
        $title = "Wakil Direktur 3";
        $headerTitle = "Tambah data Wakil Direktur 3";

        $url = env('SECOND_BACKEND_URL') . "dosen/";

        $client = new Client(); //GuzzleHttp\Client

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $dosens = json_decode($response->getBody());

        return view('wadir3.add', compact('title', 'headerTitle', 'dosens'));
    }

    public function save(Wadir3StoreRequest $req)
    {
        $validated = $req->validated();

        if ($req->status == 1) {
            $wadir3s = Wadir3::all();
            foreach ($wadir3s as $wadir3) {
                Wadir3::where('id_wadir3', $wadir3->id_wadir3)->update([
                    'status' => 0
                ]);
            }
        }

        $wadir3 = new Wadir3();
        $wadir3->nidn = $req->nidn;
        $wadir3->status = $req->status;
        $wadir3->save();

        return redirect()->route('wadir3.index')->with('success', 'Data Wadir Direktur 3 berhasil disimpan');
    }

    public function edit($id)
    {
        $title = "Wakil Direktur 3";
        $headerTitle = "Edit data Wakil Direktur 3";

        $wadir3 = Wadir3::where('id_wadir3', $id)->first();
        if ($wadir3) {
            $url = env('SECOND_BACKEND_URL') . "dosen/" . $wadir3->nidn;

            $client = new Client(); //GuzzleHttp\Client

            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $dosen = json_decode($response->getBody());
        }
        return view('wadir3.edit', compact('title', 'headerTitle', 'wadir3', 'id', 'dosen'));
    }

    public function update(Wadir3StoreRequest $req, $id)
    {
        if ($req->status == 1) {
            $wadir3s = Wadir3::all();
            foreach ($wadir3s as $wadir3) {
                Wadir3::where('id_wadir3', $wadir3->id_wadir3)->update([
                    'status' => 0
                ]);
            }
        }

        $wadir3 = Wadir3::find($id);
        $wadir3->nidn = $req->nidn;
        $wadir3->status = $req->status;
        $wadir3->save();

        return redirect()->route('wadir3.index')->with('success', 'Data Wadir Direktur 3 berhasil di update');
    }
}
