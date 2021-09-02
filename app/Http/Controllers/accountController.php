<?php

namespace App\Http\Controllers;

use App\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class accountController extends Controller
{
    public function index()
    {
        $title = "profil";
        $headerTitle = "profil Akun";
        $api_dosen_controller = new ApiDosenController;

        if (Session::get('is_wadir3')) {
            $pengguna = Pengguna::find(Session::get('id_pengguna'));
            $pengguna->dosenRef = null;
            $dosen = $api_dosen_controller->getDosenOnlySomeField($pengguna->nidn);
            if ($dosen) {
                $pengguna->dosenRef = $dosen;
            }
            return view('account.index', compact('title', 'headerTitle', 'pengguna'));
        }
    }

    public function postProfile(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'phone' => 'required',
            'alamat' => 'required',
        ]);

        // if ($request->file('photo')) {
        //     $resorceBerkas = $request->file('photo');
        //     $nameBerkas   = "berkas_" . rand(00000, 99999) . "." . $resorceBerkas->getClientOriginalExtension();
        //     $resorceBerkas->move(\base_path() . "/public/assets/file/dokumen_event/", $nameBerkas);
        // }

        try {
            $pengguna = Pengguna::find(Session::get('id_pengguna'));
            $pengguna->email = $request->email;
            $pengguna->phone = $request->phone;
            $pengguna->alamat = $request->alamat;
            $pengguna->save();

            return redirect()->back()->with('success', 'Update profil berhasil');
        } catch (\Throwable $err) {
            return $err;
        }
    }
}
