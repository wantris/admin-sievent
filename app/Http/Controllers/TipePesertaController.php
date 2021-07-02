<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesertaTypeStoreRequest;
use Illuminate\Http\Request;
use App\TipePeserta;

class TipePesertaController extends Controller
{
    public function index()
    {
        $title = "Tipe Peserta";
        $headerTitle = "Data Tipe Peserta";

        $tps = TipePeserta::all();
        return view('tipepeserta.index', compact('title', 'headerTitle', 'tps'));
    }

    public function add()
    {
        $title = "Tipe Peserta";
        $headerTitle = "Tambah Data Tipe Peserta";

        return view('tipepeserta.add', compact('title', 'headerTitle'));
    }

    public function save(PesertaTypeStoreRequest $req)
    {
        $validated = $req->validated();

        $tp = new TipePeserta();
        $tp->nama_tipe = $req->nama;
        $tp->save();

        if (!$tp) {
            return redirect()->back()->with('failed', 'Tipe peserta gagal disimpan');
        }

        return redirect()->route('tipepeserta.index')->with('success', 'Tipe peserta berhasil disimpan');
    }

    public function edit($id_tipepeserta)
    {

        $title = "Tipe Peserta";
        $headerTitle = "Edit Tipe Peserta";

        $tp = TipePeserta::find($id_tipepeserta);
        if (!$tp) {
            return redirect()->route('tipepeserta.index')->with('failed', 'Tipe peserta gagal disimpan');
        }

        return view('tipepeserta.edit', compact('title', 'headerTitle', 'tp'));
    }

    public function update(PesertaTypeStoreRequest $req, $id_tipepeserta)
    {
        $validated = $req->validated();

        $tp = TipePeserta::find($id_tipepeserta);
        $tp->nama_tipe = $req->nama;
        $tp->save();

        if (!$tp) {
            return redirect()->back()->with('failed', 'Tipe peserta gagal diupdate');
        }

        return redirect()->route('tipepeserta.index')->with('success', 'Tipe peserta berhasil diupdate');
    }

    public function delete(Request $request, $id_tipepeserta)
    {
        TipePeserta::destroy($id_tipepeserta);
        return response()->json([
            "status" => 1,
            "message" => "Tipe peserta berhasil dihapus",
        ]);
    }
}
