<?php

namespace App\Http\Controllers;

use App\EventInternal;
use App\Http\Requests\EventIinternalStoreRequest;
use App\Http\Requests\pengajuanUpdateRequest;
use App\KategoriEvent;
use App\Ormawa;
use App\TipePeserta;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Throwable;

class EventInternalController extends Controller
{
    public function index()
    {
        $title = "Event Internal";
        $headerTitle = "Data Event Internal";

        $client = new Client();
        $url = env('BACKEND_URL') . "eventinternal";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        $events = json_decode($response->getBody());

        return view('eventinternal.index', compact('title', 'headerTitle', 'events'));
    }

    public function add()
    {
        $title = "Event Internal";
        $headerTitle = "Tambah Data Event Internal";

        // all resources
        $ormawas = Ormawa::all();
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();


        return view('eventinternal.add', compact(
            'title',
            'headerTitle',
            'ormawas',
            'kategoris',
            'tipes'
        ));
    }

    public function save(EventIinternalStoreRequest $req)
    {
        $validated = $req->validated();

        $client = new Client();
        $url = env('BACKEND_URL') . "eventinternal/add";


        $option = ['multipart' => [
            [
                'name'     => 'nama_event',
                'contents' => $req->nama
            ],
            [
                'name'     => 'ormawa_id',
                'contents' => $req->ormawa
            ],
            [
                'name'     => 'kategori',
                'contents' => $req->kategori
            ],
            [
                'name'     => 'tipe_peserta',
                'contents' => $req->tipe_peserta
            ],
            [
                'name'     => 'maks',
                'contents' => $req->maks
            ],
            [
                'name'     => 'role',
                'contents' => $req->role
            ],
            [
                'name'     => 'tgl_buka',
                'contents' => $req->tgl_buka
            ],
            [
                'name'     => 'tgl_tutup',
                'contents' => $req->tgl_tutup
            ],
            [
                'name'     => 'deskripsi',
                'contents' => $req->deskripsi
            ],
            [
                'name'     => 'ketentuan',
                'contents' => $req->ketentuan
            ],
        ]];

        if ($req->file('poster')) {
            $file               = request('poster');
            $file_poster_path          = $file->getPathname();
            $file_poster_mime          = $file->getMimeType('image');
            $file_uploaded_poster_name = $file->getClientOriginalName();
            $posterArr =  [
                'name'      => 'poster',
                'filename' => $file_uploaded_poster_name,
                'Mime-Type' => $file_poster_mime,
                'contents' => fopen($file_poster_path, 'r'),
            ];

            array_push($option['multipart'], $posterArr);
        }

        if ($req->file('banner')) {
            $file               = request('banner');
            $file_banner_path          = $file->getPathname();
            $file_banner_mime          = $file->getMimeType('image');
            $file_uploaded_banner_name = $file->getClientOriginalName();
            $bannerArr =  [
                'name'      => 'banner',
                'filename' => $file_uploaded_banner_name,
                'Mime-Type' => $file_banner_mime,
                'contents' => fopen($file_banner_path, 'r'),
            ];

            array_push($option['multipart'], $bannerArr);
        }

        $response = $client->request('POST', $url, $option);

        $body = $response->getBody();
        $responseBody = json_decode($body);

        if ((bool)$responseBody->success) {
            return redirect()->route('eventinternal.index')->with('success', 'Data event internal berhasil diupdate');
        } else {
            dd($responseBody);
            return redirect()->route('eventinternal.index')->with('failed', 'Data event internal gagal diupdate');
        }
    }

    public function edit($id_eventinternal)
    {
        $title = "Event Internal";
        $headerTitle = "Update Data Event Internal";

        // all resources
        $ormawas = Ormawa::all();
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();

        // get api
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "eventinternal/detail/" . $id_eventinternal;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $event = json_decode($response->getBody());

            return view('eventinternal.edit', compact(
                'title',
                'headerTitle',
                'event',
                'ormawas',
                'kategoris',
                'tipes'
            ));
        } catch (Throwable $err) {
            return redirect()->route('eventinternal.index')->with('failed', 'Data event internal tidak ada');
        }
    }

    public function update(Request $req, $id_eventinternal)
    {
        $client = new Client();
        $url = env('BACKEND_URL') . "eventinternal/update/" . $id_eventinternal;


        $option = ['multipart' => [
            [
                'name'     => 'nama_event',
                'contents' => $req->nama
            ],
            [
                'name'     => 'ormawa_id',
                'contents' => $req->ormawa
            ],
            [
                'name'     => 'kategori',
                'contents' => $req->kategori
            ],
            [
                'name'     => 'tipe_peserta',
                'contents' => $req->tipe_peserta
            ],
            [
                'name'     => 'maks',
                'contents' => $req->maks
            ],
            [
                'name'     => 'role',
                'contents' => $req->role
            ],
            [
                'name'     => 'tgl_buka',
                'contents' => $req->tgl_buka
            ],
            [
                'name'     => 'tgl_tutup',
                'contents' => $req->tgl_tutup
            ],
            [
                'name'     => 'deskripsi',
                'contents' => $req->deskripsi
            ],
            [
                'name'     => 'ketentuan',
                'contents' => $req->ketentuan
            ],
            [
                'name'     => 'oldPoster',
                'contents' => $req->oldPoster
            ],
            [
                'name'     => 'oldBanner',
                'contents' => $req->oldBanner
            ],
        ]];

        if ($req->file('poster')) {
            $file               = request('poster');
            $file_poster_path          = $file->getPathname();
            $file_poster_mime          = $file->getMimeType('image');
            $file_uploaded_poster_name = $file->getClientOriginalName();
            $posterArr =  [
                'name'      => 'poster',
                'filename' => $file_uploaded_poster_name,
                'Mime-Type' => $file_poster_mime,
                'contents' => fopen($file_poster_path, 'r'),
            ];

            array_push($option['multipart'], $posterArr);
        }

        if ($req->file('banner')) {
            $file               = request('banner');
            $file_banner_path          = $file->getPathname();
            $file_banner_mime          = $file->getMimeType('image');
            $file_uploaded_banner_name = $file->getClientOriginalName();
            $bannerArr =  [
                'name'      => 'banner',
                'filename' => $file_uploaded_banner_name,
                'Mime-Type' => $file_banner_mime,
                'contents' => fopen($file_banner_path, 'r'),
            ];

            array_push($option['multipart'], $bannerArr);
        }

        try {
            $response = $client->request('POST', $url, $option);

            $body = $response->getBody();
            $responseBody = json_decode($body);

            return redirect()->route('eventinternal.edit', $id_eventinternal)->with('success', 'Data event internal berhasil diupdate');
        } catch (Throwable $err) {
            return redirect()->route('eventinternal.edit', $id_eventinternal)->with('failed', 'Data event internal gagal diupdate');
        }
    }

    public function seePengajuan($id_eventinternal)
    {
        $title = "Event Internal | Pengajuan";
        $headerTitle = "Pengajuan Event Internal";

        // get api
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "eventinternal/pengajuan/" . $id_eventinternal;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $pengajuan = json_decode($response->getBody());
            $statusCode = $response->getStatusCode();
            return view('eventinternal.pengajuan', compact(
                'title',
                'headerTitle',
                'pengajuan',
            ));
        } catch (Throwable $err) {
            return redirect()->route('eventinternal.index')->with('failed', 'Pengajuan event internal tidak ada');
        }
    }

    public function updatePengajuan(pengajuanUpdateRequest $req, $id_eventinternal_detail)
    {
        $validated = $req->validated();

        $client = new Client();

        $url = env('BACKEND_URL') . "eventinternal/pengajuan/" . $id_eventinternal_detail;


        $option = ['multipart' => [
            [
                'name'     => 'event_internal_id',
                'contents' => $req->event_internal_id
            ],
            [
                'name'     => 'validate_pembina',
                'contents' => $req->validate_pembina
            ],
            [
                'name'     => 'validate_wadir3',
                'contents' => $req->validate_wadir3
            ],
        ]];

        try {
            $response = $client->request('POST', $url, $option);

            $body = $response->getBody();
            $responseBody = json_decode($body);

            return redirect()->route('eventinternal.pengajuan', $req->event_internal_id)->with('success', 'Berhasil');
        } catch (Throwable $err) {
            return redirect()->back()->with('failed', 'Gagal');
        }
    }

    public function delete(Request $request, $id_eventinternal)
    {
        EventInternal::destroy($id_eventinternal);
        return response()->json([
            "status" => 1,
            "message" => "Event internal berhasil dihapus",
        ]);
    }
}
