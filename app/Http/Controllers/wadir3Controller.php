<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wadir3StoreRequest;
use App\Wadir3;
use GuzzleHttp\Client;
use App\Http\Controllers\ApiDosenController;
use App\Pengguna;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Wadir3Export;

class wadir3Controller extends Controller
{
    public function index()
    {
        $title = "Wakil Direktur 3";
        $headerTitle = "Data Wakil Direktur 3";

        $wadir3s = Wadir3::all();
        foreach ($wadir3s as $wadir3) {

            // call API
            $api_dosen = new ApiDosenController;
            $dosen = $api_dosen->getDosenByNidn($wadir3->nidn);

            if ($dosen) {
                $wadir3->dosenRef = $dosen;
            }
        }
        return view('wadir3.index', compact('title', 'headerTitle', 'wadir3s'));
    }

    public function add()
    {
        $title = "Wakil Direktur 3";
        $headerTitle = "Tambah data Wakil Direktur 3";

        // call API
        $api_dosen = new ApiDosenController;
        $dosens = $api_dosen->getAllDosen();

        $dosens = $dosens;

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

                Pengguna::where('nidn', $wadir3->nidn)->update([
                    'is_wadir3' => 0
                ]);
            }
        }

        try {
            $wadir3 = new Wadir3();
            $wadir3->nidn = $req->nidn;
            $wadir3->status = $req->status;
            $wadir3->save();

            if ($wadir3) {
                $pengguna = Pengguna::where('nidn', $req->nidn)->first();
                $pengguna->is_wadir3 = 1;
                $pengguna->save();

                return redirect()->route('wadir3.index')->with('success', 'Data Wadir Direktur 3 berhasil disimpan');
            }
        } catch (\Throwable $err) {
            return redirect()->route('wadir3.index')->with('failed', 'Data Wadir Direktur 3 gagal disimpan');
        }
    }

    public function edit($id)
    {
        $title = "Wakil Direktur 3";
        $headerTitle = "Edit data Wakil Direktur 3";

        $wadir3 = Wadir3::where('id_wadir3', $id)->first();
        if ($wadir3) {
            // call API
            $api_dosen = new ApiDosenController;
            $dosens = $api_dosen->getAllDosen();
            $dosen = $api_dosen->getDosenByNidn($wadir3->nidn);
            $dosens = $dosens;
        }
        return view('wadir3.edit', compact('title', 'headerTitle', 'wadir3', 'id', 'dosen', 'dosens'));
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

    public function delete(Request $request, $id_wadir3)
    {
        try {
            Wadir3::where('id_wadir3', $id_wadir3)->delete();

            return response()->json([
                "status" => 1,
                "message" => $id_wadir3,
            ]);
        } catch (\Throwable $err) {
            Wadir3::where('id_wadir3', $id_wadir3)->delete();

            return response()->json([
                "status" => 0,
                "message" => $$err,
            ]);
        }
    }

    public function export()
    {
        return Excel::download(new Wadir3Export, 'wadir_3.xlsx');
    }
}
