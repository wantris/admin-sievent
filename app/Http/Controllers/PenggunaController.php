<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenggunaStoreRequest;
use App\Pembina;
use Illuminate\Http\Request;
use App\Pengguna;
use App\Wadir3;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Throwable;

class PenggunaController extends Controller
{
    public function index()
    {
        $title = "Pengguna";
        $headerTitle = "Data Pengguna";

        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "pengguna";
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $penggunas = json_decode($response->getBody());

            return view('pengguna.index', compact('title', 'headerTitle', 'penggunas'));
        } catch (Throwable $err) {
            $penggunas = Pengguna::all();
            return view('pengguna.index', compact('title', 'headerTitle', 'penggunas'));
        }
    }

    public function add()
    {
        $title = "Pengguna";
        $headerTitle = "Tambah Data Pengguna";

        try {
            $client = new Client();
            $urlMhs = env('SECOND_BACKEND_URL') . "mahasiswa";
            $responseMhs = $client->request('GET', $urlMhs, [
                'verify'  => false,
            ]);

            // Pembina
            $pembinas = Pembina::all();
            foreach ($pembinas as $pembina) {

                // call API
                $client = new Client();
                $url = env('SECOND_BACKEND_URL') . "dosen/" . $pembina->nidn;
                $response = $client->request('GET', $url, [
                    'verify'  => false,
                ]);
                $dosen = json_decode($response->getBody());

                if ($dosen) {
                    $pembina->nama_dosen = $dosen->nama_dosen;
                }
            }

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

            $mahasiswas = json_decode($responseMhs->getBody());
            return view('pengguna.add', compact('title', 'headerTitle', 'pembinas', 'wadir3s', 'mahasiswas'));
        } catch (Throwable $err) {
            return redirect()->route('pengguna.index');
        }
    }

    public function save(PenggunaStoreRequest $req)
    {
        $validated = $req->validated();

        $pembina = null;
        $wadir3 = null;
        $mahasiswa = null;
        $is_pembina = 0;
        $is_wadir3 = 0;
        $is_mahasiswa = 0;

        if ($req->pembina != "undefined" && $req->pembina != null) {
            $pembina = $req->pembina;
            $is_pembina = 1;
        }

        if ($req->wadir3 != "undefined" && $req->wadir3 != null) {
            $wadir3 = $req->wadir3;
            $is_wadir3 = 1;
        }

        if ($req->mhs != "undefined" && $req->mhs != null) {
            $mahasiswa = $req->mhs;
            $is_mahasiswa = 1;
        }

        try {
            $pengguna = new Pengguna();
            $pengguna->username = $req->username;
            $pengguna->password = Hash::make($req->password);
            $pengguna->is_mahasiswa = $is_mahasiswa;
            $pengguna->is_wadir3 = $is_wadir3;
            $pengguna->is_pembina = $is_pembina;
            $pengguna->is_participant = 0;
            $pengguna->nim = $mahasiswa;
            $pengguna->wadir3_id = $wadir3;
            $pengguna->pembina_id = $pembina;
            $pengguna->save();

            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
        } catch (Throwable $err) {
            dd($err);
            return redirect()->route('pengguna.add')->with('failed', 'Pengguna berhasil ditambahkan');
        }
    }

    public function edit($id_pengguna)
    {
        $title = "Pengguna";
        $headerTitle = "Update Data Pengguna";

        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "pengguna/detail/" . $id_pengguna;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $pengguna = json_decode($response->getBody());
            return view('pengguna.edit', compact('title', 'headerTitle', 'pengguna'));
        } catch (Throwable $err) {
            return $err;
        }
    }

    public function update(Request $req, $id_pengguna)
    {
        $client = new Client();
        $url = env('BACKEND_URL') . "pengguna/update/" . $id_pengguna;


        $option = ['multipart' => [
            [
                'name'     => 'phone',
                'contents' => $req->phone
            ],
            [
                'name'     => 'username',
                'contents' => $req->username
            ],
            [
                'name'     => 'oldPassword',
                'contents' => $req->oldPassword
            ],
            [
                'name'     => 'newPassword',
                'contents' => $req->newPassword
            ],
            [
                'name'     => 'email',
                'contents' => $req->email
            ],
            [
                'name'     => 'alamat',
                'contents' => $req->alamat
            ],
            [
                'name'     => 'oldPhoto',
                'contents' => $req->oldPhoto
            ],
        ]];

        if ($req->file('photo')) {
            $file               = request('photo');
            $file_photo_path          = $file->getPathname();
            $file_photo_mime          = $file->getMimeType('image');
            $file_uploaded_photo_name = $file->getClientOriginalName();
            $photoArr =  [
                'name'      => 'photo',
                'filename' => $file_uploaded_photo_name,
                'Mime-Type' => $file_photo_mime,
                'contents' => fopen($file_photo_path, 'r'),
            ];

            array_push($option['multipart'], $photoArr);
        }

        try {
            $response = $client->request('POST', $url, $option);

            $body = $response->getBody();
            $responseBody = json_decode($body);

            if ((bool)$responseBody->success) {
                return redirect()->route('pengguna.edit', $id_pengguna)->with('success', 'Data pengguna berhasil diupdate');
            } else {
                return redirect()->route('pengguna.edit', $id_pengguna)->with('failed', 'Data pengguna gagal diupdate');
            }
        } catch (\Throwable $err) {
            return redirect()->route('pengguna.edit', $id_pengguna)->with('failed', 'Data pengguna gagal diupdate');
        }
    }

    public function delete(Request $request, $id_pengguna)
    {
        Pengguna::destroy($id_pengguna);

        return response()->json([
            "status" => 1,
            "message" => "Pengguna berhasil dihapus",
        ]);
    }

    public function relasi($id_pengguna)
    {
        $title = "Pengguna";
        $headerTitle = "Update Relasi Data Pengguna";

        try {

            $pengguna = Pengguna::with('wadir3Ref', 'pembinaRef', 'participantRef')->where('id_pengguna', $id_pengguna)->first();
            if (!$pengguna) {
                return redirect()->route('pengguna.index')->with('failed', 'Pengguna gagal ditambahkan');
            }

            // Check relation with API
            $pengguna->nama_mahasiswa = null;
            if ($pengguna->pembina_id) {
                $urlFirst = env('SECOND_BACKEND_URL') . "dosen/" . $pengguna->pembinaRef->nidn;
                $client = new Client();
                $responsePengguna = $client->request('GET', $urlFirst, [
                    'verify'  => false,
                ]);
                $jsonPengguna = json_decode($responsePengguna->getBody());
                $pengguna->pembinaRef->nama_dosen = $jsonPengguna->nama_dosen;
            }

            if ($pengguna->wadir3_id) {
                $urlFirst = env('SECOND_BACKEND_URL') . "dosen/" . $pengguna->wadir3Ref->nidn;
                $client = new Client();
                $responsePengguna = $client->request('GET', $urlFirst, [
                    'verify'  => false,
                ]);
                $jsonPengguna = json_decode($responsePengguna->getBody());
                $pengguna->wadir3Ref->nama_dosen = $jsonPengguna->nama_dosen;
            }

            if ($pengguna->nim) {
                $urlFirst = env('SECOND_BACKEND_URL') . "mahasiswa/detail/" . $pengguna->nim;
                $client = new Client();
                $responsePengguna = $client->request('GET', $urlFirst, [
                    'verify'  => false,
                ]);
                $jsonPengguna = json_decode($responsePengguna->getBody());

                $pengguna->nama_mahasiswa = $jsonPengguna->nama;
            }

            // CALL API 
            $client = new Client();
            $urlMhs = env('SECOND_BACKEND_URL') . "mahasiswa/";
            $responseMhs = $client->request('GET', $urlMhs, [
                'verify'  => false,
            ]);
            $mahasiswas = json_decode($responseMhs->getBody());

            // Pembina
            $pembinas = Pembina::all();
            foreach ($pembinas as $pembina) {

                // call API
                $client = new Client();
                $url = env('SECOND_BACKEND_URL') . "dosen/" . $pembina->nidn;
                $response = $client->request('GET', $url, [
                    'verify'  => false,
                ]);
                $dosen = json_decode($response->getBody());

                if ($dosen) {
                    $pembina->nama_dosen = $dosen->nama_dosen;
                }
            }

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


            return view('pengguna.relasi', compact('title', 'headerTitle', 'pembinas', 'wadir3s', 'mahasiswas', 'pengguna'));
        } catch (Throwable $err) {
            return $err;
            // return redirect()->route('pengguna.index');
        }
    }

    public function updateRelasi(Request $req, $id_pengguna)
    {

        $pembina = null;
        $wadir3 = null;
        $mahasiswa = null;
        $is_pembina = 0;
        $is_wadir3 = 0;
        $is_mahasiswa = 0;

        if ($req->pembina != "undefined" && $req->pembina != null) {
            $pembina = $req->pembina;
            $is_pembina = 1;
        }

        if ($req->wadir3 != "undefined" && $req->wadir3 != null) {
            $wadir3 = $req->wadir3;
            $is_wadir3 = 1;
        }

        if ($req->mhs != "undefined" && $req->mhs != null) {
            $mahasiswa = $req->mhs;
            $is_mahasiswa = 1;
        }

        try {
            $pengguna = Pengguna::find($id_pengguna);
            $pengguna->is_mahasiswa = $is_mahasiswa;
            $pengguna->is_wadir3 = $is_wadir3;
            $pengguna->is_pembina = $is_pembina;
            $pengguna->is_participant = 0;
            $pengguna->nim = $mahasiswa;
            $pengguna->wadir3_id = $wadir3;
            $pengguna->pembina_id = $pembina;
            $pengguna->save();

            return redirect()->route('pengguna.index')->with('success', 'Edit Relasi Pengguna Berhasil');
        } catch (Throwable $err) {
            return $err;
            return redirect()->route('pengguna.add')->with('failed', 'Edit Relasi Pengguna Gagal');
        }
    }
}
