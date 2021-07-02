<?php

namespace App\Http\Controllers;

use App\Pengguna;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MahasiswaController extends Controller
{
    public function index()
    {
        $title = "Akun Mahasiswa";
        $headerTitle = "Data Akun Mahasiswa";

        $mahasiswas = Pengguna::where('is_mahasiswa', 1)->get();

        foreach ($mahasiswas as $mahasiswa) {

            // call API
            $client = new Client();
            $url = "http://localhost:7000/mahasiswa/detail/" . $mahasiswa->nim;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $mhs = json_decode($response->getBody());

            if ($mhs) {
                $mahasiswa->nama_mahasiswa = $mhs->nama;
            }
        }
        return view('akun_mahasiswa.index', compact('title', 'headerTitle', 'mahasiswas'));
    }

    public function runSeeder()
    {
        Artisan::call("db:seed", ['--class' => 'mahasiswaPenggunaSeeder']);

        return redirect()->route('mahasiswa.index')->with('success', 'Akun mahasiswa berhasil di perbarui');
    }

    public function edit($nim)
    {
        $title = "Akun Mahasiswa";
        $headerTitle = "Update Data Akun Mahasiswa";

        $client = new Client();
        $urlP = env('BACKEND_URL') . "mahasiswa/edit/" . $nim;
        $urlM = env('SECOND_BACKEND_URL') . "mahasiswa/detail/" . $nim;

        $responseP = $client->request('GET', $urlP, [
            'verify'  => false,
        ]);
        $responseM = $client->request('GET', $urlM, [
            'verify'  => false,
        ]);

        $pengguna = json_decode($responseP->getBody());
        $mhs = json_decode($responseM->getBody());


        if (!$pengguna) {
            return redirect()->route('mahasiswa.edit')->with('failed', 'Data mahasiswatidak ada');
        }

        return view('akun_mahasiswa.edit', compact('title', 'headerTitle', 'mhs', 'pengguna'));
    }

    public function update(Request $req, $nim)
    {
        $client = new Client();
        $url = env('BACKEND_URL') . "mahasiswa/update/" . $nim;

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

        $response = $client->request('POST', $url, $option);

        $body = $response->getBody();
        $responseBody = json_decode($body);

        if ((bool)$responseBody->success) {
            return redirect()->route('mahasiswa.edit', $nim)->with('success', 'Data mahasiswa berhasil diupdate');
        } else {
            return redirect()->route('mahasiswa.edit', $nim)->with('failed', 'Data mahasiswa gagal diupdate');
        }
    }

    public function delete(Request $request, $nim)
    {
        Pengguna::where('nim', $nim)->delete();

        return response()->json([
            "status" => 1,
            "message" => $nim,
        ]);
    }
}
