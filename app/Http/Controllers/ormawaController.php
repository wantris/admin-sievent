<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\ormawaStoreRequest;
use App\Ormawa;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;

class ormawaController extends Controller
{
    public function index()
    {
        $title = "Organisasi Mahasiswa";
        $headerTitle = "Data Organisasi Mahasiswa";

        $client = new Client();
        $url = env('BACKEND_URL') . "ormawa";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $ormawas = json_decode($response->getBody());

        return view('ormawa.index', compact('title', 'headerTitle', 'ormawas'));
    }

    public function add()
    {
        $title = "Organisasi Mahasiswa";
        $headerTitle = "Tambah Data Organisasi Mahasiswa";

        return view('ormawa.add', compact('title', 'headerTitle'));
    }

    public function save(ormawaStoreRequest $req)
    {
        $validated = $req->validated();

        $ormawa = new Ormawa();
        $ormawa->nama_ormawa = $req->nama;
        $ormawa->nama_akronim = $req->akronim;
        $ormawa->username = $req->username;
        $ormawa->password = Hash::make($req->password);
        $ormawa->save();

        if ($ormawa) {
            return redirect()->route('oramawa.index')->with('success', 'Data ormawa berhasil disimpan');
        } else {
            return redirect()->route('ormawa.index')->with('failed', 'Data ormawa gagal disimpan');
        }
    }

    public function edit($id_ormawa)
    {
        $title = "Organisasi Mahasiswa";
        $headerTitle = "Update Data Organisasi Mahasiswa";

        $ormawa = Ormawa::find($id_ormawa);

        if (!$ormawa) {
            return redirect()->route('ormawa.index')->with('failed', 'Data ormawa tidak ada');
        }

        return view('ormawa.edit', compact('title', 'headerTitle', 'ormawa', 'id_ormawa'));
    }

    public function update(Request $req, $id_ormawa)
    {
        $client = new Client();
        $url = env('BACKEND_URL') . "ormawa/update/" . $id_ormawa;
        $client = new Client();

        if ($req->file('photo') || $req->file('banner')) {
            if ($req->file('photo')) {
                $file               = request('photo');
                $file_photo_path          = $file->getPathname();
                $file_photo_mime          = $file->getMimeType('image');
                $file_uploaded_photo_name = $file->getClientOriginalName();
                $response = $client->request('POST', $url, [
                    'multipart' => [
                        [
                            'name'     => 'nama',
                            'contents' => $req->nama
                        ],
                        [
                            'name'     => 'akronim',
                            'contents' => $req->akronim
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
                            'name'     => 'deskripsi',
                            'contents' => $req->deskripsi
                        ],
                        [
                            'name'      => 'photo',
                            'filename' => $file_uploaded_photo_name,
                            'Mime-Type' => $file_photo_mime,
                            'contents' => fopen($file_photo_path, 'r'),
                        ],
                        [
                            'name'     => 'oldBanner',
                            'contents' => $req->oldBanner
                        ],
                        [
                            'name'     => 'website',
                            'contents' => $req->website
                        ],
                    ]
                ]);
            }

            if ($req->file('banner')) {
                $file               = request('banner');
                $file_banner_path          = $file->getPathname();
                $file_banner_mime          = $file->getMimeType('image');
                $file_uploaded_banner_name = $file->getClientOriginalName();
                $response = $client->request('POST', $url, [
                    'multipart' => [
                        [
                            'name'     => 'nama',
                            'contents' => $req->nama
                        ],
                        [
                            'name'     => 'akronim',
                            'contents' => $req->akronim
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
                            'name'     => 'deskripsi',
                            'contents' => $req->deskripsi
                        ],
                        [
                            'name'      => 'banner',
                            'filename' => $file_uploaded_banner_name,
                            'Mime-Type' => $file_banner_mime,
                            'contents' => fopen($file_banner_path, 'r'),
                        ],
                        [
                            'name'     => 'oldPhoto',
                            'contents' => $req->oldPhoto
                        ],
                        [
                            'name'     => 'website',
                            'contents' => $req->website
                        ],
                    ]
                ]);
            }
        } else {
            $response = $client->request('POST', $url, [
                'multipart' => [
                    [
                        'name'     => 'nama',
                        'contents' => $req->nama
                    ],
                    [
                        'name'     => 'akronim',
                        'contents' => $req->akronim
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
                        'name'     => 'deskripsi',
                        'contents' => $req->deskripsi
                    ],
                    [
                        'name'     => 'oldBanner',
                        'contents' => $req->oldBanner
                    ],
                    [
                        'name'     => 'oldPhoto',
                        'contents' => $req->oldPhoto
                    ],
                    [
                        'name'     => 'website',
                        'contents' => $req->website
                    ],
                ]
            ]);
        }

        $body = $response->getBody();
        $responseBody = json_decode($body);

        if ((bool)$responseBody->success) {
            return redirect()->route('ormawa.edit', $id_ormawa)->with('success', 'Data ormawa berhasil diupdate');
        } else {
            return redirect()->route('ormawa.edit', $id_ormawa)->with('failed', 'Data ormawa gagal diupdate');
        }
    }

    public function detail($id_ormawa)
    {
        $title = "Organisasi Mahasiswa";
        $headerTitle = "Detail Data Organisasi Mahasiswa";

        $ormawa = Ormawa::find($id_ormawa);
        if (!$ormawa) {
            return redirect()->route('ormawa.index')->with('failed', 'Data ormawa tidak ada');
        }

        return view('ormawa.detail', compact('title', 'headerTitle', 'ormawa', 'id_ormawa'));
    }
}
