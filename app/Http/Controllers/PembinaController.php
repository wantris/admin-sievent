<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembinaStoreRequest;
use App\Ormawa;
use Illuminate\Http\Request;
use App\Pembina;
use App\Pengguna;
use GuzzleHttp\Client;
use Throwable;

class PembinaController extends Controller
{
    public function index()
    {
        $title = "Pembina";
        $headerTitle = "Data Pembina";
        $api_dosen = new ApiDosenController;

        $pembinas = Pembina::all();
        $ormawas = Ormawa::all()->pluck('nama_ormawa');

        foreach ($pembinas as $pembina) {
            $pembina->dosenRef = null;

            // call API
            $api_dosen = new ApiDosenController;
            $dosen = $api_dosen->getDosenOnlySomeField($pembina->nidn);

            if ($dosen) {
                $pembina->dosenRef = $dosen;
            }
        }

        return view('pembina.index', compact('title', 'headerTitle', 'pembinas', 'ormawas'));
    }

    public function add()
    {
        $title = "Pembina";
        $headerTitle = "Tambah Data Pembina";

        $ormawas = Ormawa::all();

        // call API
        $api_dosen = new ApiDosenController;
        $dosens = $api_dosen->getAllDosen();

        $dosens = $dosens;

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
                Pembina::where('id_pembina', $item->id_pembina)->update([
                    'status' => 0
                ]);

                Pengguna::where('nidn', $item->nidn)->update([
                    'is_pembina' => 0
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

            $pengguna = Pengguna::where('nidn', $req->nidn)->first();
            $pengguna->is_pembina = 1;
            $pengguna->save();

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

            // call API
            $api_dosen = new ApiDosenController;
            $dosens = $api_dosen->getAllDosen();
            $dosen = $api_dosen->getDosenByNidn($pembina->nidn);
            $dosens = $dosens;

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
        $pembina = Pembina::find($id_pembina);
        if ($pembina) {
            $pengguna = Pengguna::where('nidn', $pembina->nidn)->first();
            if ($pengguna) {
                $pengguna->is_pembina = 0;
                $pengguna->save();
            }
        }

        Pembina::destroy($id_pembina);
        return response()->json([
            "status" => 1,
            "message" => "pembina berhasil dihapus",
        ]);
    }
}
