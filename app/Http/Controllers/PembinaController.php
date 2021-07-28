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
            $pembina->dosenRef = null;

            // call API
            $dosen = $this->getDosenSingle($pembina);

            if ($dosen) {
                $pembina->dosenRef = $dosen;
            }
        }

        return view('pembina.index', compact('title', 'headerTitle', 'pembinas'));
    }

    public function add()
    {
        $title = "Pembina";
        $headerTitle = "Tambah Data Pembina";

        $ormawas = Ormawa::all();
        $dosens = $this->getAllDosen();


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
            $pembina->tahun_jabatan = $req->tahun;
            $pembina->status = $req->status;
            $pembina->save();
            return redirect()->route('pembina.index')->with('success', 'Data pembina berhasil ditambah');
        } catch (Throwable $e) {
            dd($e);
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

            $dosen = $this->getDosenSingle($pembina);
            $dosens = $this->getAllDosen();

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

            Pembina::where('id_pembina', $pembina->id_pembina)->update([
                'nidn' => $req->nidn,
                'ormawa_id' => $req->ormawa,
                'tahun_jabatan' => $req->tahun,
                'status' => $req->status
            ]);


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

    public function getAllDosen()
    {
        try {
            // call API
            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "dosen";
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $dosens = json_decode($response->getBody());

            return $dosens;
        } catch (\Throwable $err) {
        }
    }

    public function getDosenSingle($pembina)
    {
        try {
            // call API
            $client = new Client();
            $url = env('SECOND_BACKEND_URL') . "dosen/" . $pembina->nidn;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $dosen = json_decode($response->getBody());

            return $dosen;
        } catch (\Throwable $err) {
        }
    }
}
