<?php

namespace App\Http\Controllers;

use App\CakupanOrmawa;
use App\Http\Requests\CakupanStoreRequest;
use App\Ormawa;
use Illuminate\Http\Request;

class CakupanOrmawaController extends Controller
{
    public function index()
    {
        $title = "Cakupan Ormawa";
        $headerTitle = "Data Cakupan Ormawa";

        $cakupans = CakupanOrmawa::with('ormawaRef')->get();

        return view('cakupanOrmawa.index', compact('title', 'headerTitle', 'cakupans'));
    }

    public function add()
    {
        $title = "Cakupan Ormawa";
        $headerTitle = "Tambah Data Cakupan Ormawa";

        $ormawas = Ormawa::all();

        return view('cakupanOrmawa.add', compact('title', 'headerTitle', 'ormawas'));
    }

    public function save(CakupanStoreRequest $req)
    {
        $validated = $req->validated();

        $cakupan = new CakupanOrmawa();
        $cakupan->ormawa_id = $req->ormawa;
        $cakupan->role = $req->role;
        $cakupan->save();

        if ($cakupan) {
            return redirect()->route('cakupanOrmawa.index')->with('success', 'Cakupan ormawa berhasil disimpan');
        } else {
            return redirect()->route('cakupanOrmawa.index')->with('failed', 'Cakupan ormawa gagal disimpan');
        }
    }

    public function edit($id_cakupanOrmawa)
    {
        $title = "Cakupan Ormawa";
        $headerTitle = "Update Data Cakupan Ormawa";

        $cakupan = CakupanOrmawa::find($id_cakupanOrmawa);

        $ormawas = Ormawa::all();

        return view('cakupanOrmawa.edit', compact('title', 'headerTitle', 'ormawas', 'cakupan'));
    }

    public function update(CakupanStoreRequest $req, $id_cakupanOrmawa)
    {
        $validated = $req->validated();

        $cakupan = CakupanOrmawa::find($id_cakupanOrmawa);
        $cakupan->ormawa_id = $req->ormawa;
        $cakupan->role = $req->role;
        $cakupan->save();

        if ($cakupan) {
            return redirect()->route('cakupanOrmawa.index')->with('success', 'Cakupan ormawa berhasil diupdate');
        } else {
            return redirect()->route('cakupanOrmawa.index')->with('failed', 'Cakupan ormawa gagal diupdate');
        }
    }

    public function delete(Request $request, $id_cakupanOrmawa)
    {
        CakupanOrmawa::destroy($id_cakupanOrmawa);
        return response()->json([
            "status" => 1,
            "message" => "Cakupan Ormawa berhasil dihapus",
        ]);
    }
}
