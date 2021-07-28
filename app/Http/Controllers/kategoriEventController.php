<?php

namespace App\Http\Controllers;

use App\KategoriEvent;
use Illuminate\Http\Request;

class kategoriEventController extends Controller
{
    public function index()
    {
        $title = "Kategori Event";
        $headerTitle = "Data Kategori Event";

        $kategoris = KategoriEvent::all();
        return view('kategori.index', compact('title', 'headerTitle', 'kategoris'));
    }

    public function add()
    {
        $title = "Kategori Event";
        $headerTitle = "Tambah Kategori Event";

        return view('kategori.add', compact('title', 'headerTitle'));
    }

    public function save(Request $req)
    {
        $kategori = new KategoriEvent();
        $kategori->nama_kategori = $req->nama;
        $kategori->save();

        return redirect()->route('kategorievent.index')->with('success', 'Data admin berhasil disimpan');
    }

    public function edit($id_kategori)
    {
        $title = "Kategori Event";
        $headerTitle = "Edit Kategori Event";

        $kategori = KategoriEvent::find($id_kategori);

        return view('kategori.edit', compact('title', 'headerTitle', 'kategori', 'id_kategori'));
    }

    public function update(Request $req, $id_kategori)
    {
        $kategori = KategoriEvent::find($id_kategori);
        $kategori->nama_kategori = $req->nama;
        $kategori->save();

        return redirect()->route('kategorievent.index')->with('success', 'Data admin berhasil diupdate');
    }

    public function delete(Request $request, $id_kategori)
    {
        KategoriEvent::destroy($id_kategori);
        return response()->json([
            "status" => 1,
            "message" => "Kategori event berhasil dihapus",
        ]);
    }
}
