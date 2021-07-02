<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembinaStoreRequest;
use App\Ormawa;
use Illuminate\Http\Request;
use App\Pembina;
use GuzzleHttp\Client;
use Throwable;

class PembinaController extends Controller
{
    public function index()
    {
        $title = "Pembina";
        $headerTitle = "Data Pembina";

        $pembinas = Pembina::all();
        foreach ($pembinas as $pembina) {

            // call API
            $client = new Client();
            $url = "http://localhost:7000/dosen/" . $pembina->nidn;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $dosen = json_decode($response->getBody());

            if ($dosen) {
                $pembina->nama_dosen = $dosen->nama_dosen;
            }
        }
        return view('pembina.index', compact('title', 'headerTitle', 'pembinas'));
    }

    public function add()
    {
        $title = "Pembina";
        $headerTitle = "Tambah Data Pembina";

        // call API
        $client = new Client();
        $url = "http://localhost:7000/dosen";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $ormawas = Ormawa::all();
        $dosens = json_decode($response->getBody());
        return view('pembina.add', compact('title', 'headerTitle', 'dosens', 'ormawas'));
    }

    public function save(PembinaStoreRequest $req)
    {
        $validated = $req->validated();

        $pembina = Pembina::where('nidn', $req->nidn)->where('status', 1)->where('ormawa_id', '!=', $req->ormawa)->first();
        if ($pembina) {
            return redirect()->route('pembina.index')->with('failed', 'Data pembina aktif di ormawa lain');
        }

        if ($req->status == 1) {
            $pembinaSpec = Pembina::where('ormawa_id', $req->ormawa)->get();
            foreach ($pembinaSpec as $item) {
                Pembina::where('id_pembina', $item->id_pembina)->where('periode', '<', $req->tahun)->update([
                    'status' => 0
                ]);
            }
        }

        try {
            $pembina = new Pembina();
            $pembina->nidn = $req->nidn;
            $pembina->ormawa_id = $req->ormawa;
            $pembina->periode = $req->tahun;
            $pembina->status = $req->status;
            $pembina->save();
            return redirect()->route('pembina.index')->with('success', 'Data pembina berhasil ditambah');
        } catch (Throwable $e) {
            return redirect()->back()->with('failed', 'Data pembina gagal ditambah');
        }
    }

    public function edit($id_pembina)
    {
        $title = "Pembina";
        $headerTitle = "Edit data Pembina";

        $pembina = Pembina::with('ormawaRef')->where('id_pembina', $id_pembina)->first();
        $ormawas = Ormawa::all();

        if ($pembina) {
            $urlFirst = "http://localhost:7000/dosen/" . $pembina->nidn;
            $urlGet = "http://localhost:7000/dosen";

            $client = new Client(); //GuzzleHttp\Client

            $responseFirst = $client->request('GET', $urlFirst, [
                'verify'  => false,
            ]);

            $responseGet = $client->request('GET', $urlGet, [
                'verify'  => false,
            ]);

            $dosen = json_decode($responseFirst->getBody());
            $dosens = json_decode($responseGet->getBody());

            return view('pembina.edit', compact('title', 'headerTitle', 'pembina', 'id_pembina', 'dosen', 'dosens', 'ormawas'));
        }

        return redirect()->route('pembina.index')->with('success', 'Data pembina tidak ada');
    }

    public function update(PembinaStoreRequest $req, $id_pembina)
    {
        $pembina = Pembina::where('id_pembina', $id_pembina)->first();
        if (!$pembina) {
            return redirect()->route('pembina.index')->with('success', 'Data pembina tidak ada');
        }

        $check = Pembina::where('nidn', $req->nidn)->where('status', 1)->where('ormawa_id', '!=', $req->ormawa)->first();
        if ($check) {
            return redirect()->route('pembina.index')->with('failed', 'Data pembina aktif di ormawa lain');
        }

        try {

            if ($req->status == 1) {
                $pembinaSpec = Pembina::where('ormawa_id', $pembina->ormawa_id)->get();
                foreach ($pembinaSpec as $item) {
                    Pembina::where('id_pembina', $item->id_pembina)->update([
                        'status' => 0
                    ]);
                }
            }

            $pembina->nidn = $req->nidn;
            $pembina->ormawa_id = $req->ormawa;
            $pembina->periode = $req->tahun;
            $pembina->status = $req->status;
            $pembina->save();
            return redirect()->route('pembina.index')->with('success', 'Data pembina berhasil diupdate');
        } catch (Throwable $e) {
            return redirect()->back()->with('failed', 'Data pembina gagal diupdate');
        }
    }

    public function delete(Request $request, $id_pembina)
    {
        Pembina::destroy($id_pembina);
        return response()->json([
            "status" => 1,
            "message" => "pembina berhasil dihapus",
        ]);
    }
}
