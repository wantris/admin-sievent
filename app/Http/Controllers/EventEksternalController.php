<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Requests\EventEksternalStoreRequest;
use App\{CakupanOrmawa, EventEksternal, EventInternal, KategoriEvent, TipePeserta};
use App\Http\Requests\pengajuanEksternalUpdateRequest;

class EventEksternalController extends Controller
{
    public function index()
    {
        $title = "Event Eksternal";
        $headerTitle = "Data Event Eksternal";


        $events = $this->getAllEvents();

        $kategoris = KategoriEvent::all();

        $ormawa_controller = new ormawaController;
        $ormawas = $ormawa_controller->getAllOrmawa();


        return view('eventeksternal.index', compact('title', 'headerTitle', 'events', 'kategoris', 'ormawas'));
    }

    public function add()
    {
        $title = "Event Eksternal";
        $headerTitle = "Tambah Data Event Eksternal";

        // all resources
        $cakupans = CakupanOrmawa::all();
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();


        return view('eventeksternal.add', compact(
            'title',
            'headerTitle',
            'cakupans',
            'kategoris',
            'tipes'
        ));
    }

    public function save(EventEksternalStoreRequest $req)
    {
        $validated = $req->validated();

        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "eventeksternal/add";


            $option = ['multipart' => [
                [
                    'name'     => 'nama_event',
                    'contents' => $req->nama
                ],
                [
                    'name'     => 'cakupan_ormawa_id',
                    'contents' => $req->cakupan_ormawa_id
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
                return redirect()->route('eventeksternal.index')->with('success', 'Data event eksternal berhasil ditambah');
            } else {
                return redirect()->route('eventeksternal.index')->with('failed', 'Data event eksternal gagal ditambah');
            }
        } catch (\Throwable $err) {
            return redirect()->route('eventeksternal.index')->with('failed', 'Data event eksternal gagal ditambah');
        }
    }

    public function edit($id_eventeksternal)
    {
        $title = "Event Eksternal";
        $headerTitle = "Update Data Event Eksternal";

        // all resources
        $cakupans = CakupanOrmawa::all();
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();

        // get api
        $event = $this->getEventEksternalById($id_eventeksternal);
        if (!$event) {
            return redirect()->back()->with('failed', 'Data event eksternal tidak ada');
        }


        return view('eventeksternal.edit', compact(
            'title',
            'headerTitle',
            'event',
            'cakupans',
            'kategoris',
            'tipes'
        ));
    }

    public function update(Request $req, $id_eventeksternal)
    {
        $client = new Client();
        $url = env('BACKEND_URL') . "eventeksternal/update/" . $id_eventeksternal;


        $option = ['multipart' => [
            [
                'name'     => 'nama_event',
                'contents' => $req->nama
            ],
            [
                'name'     => 'cakupan_ormawa_id',
                'contents' => $req->cakupan_ormawa_id
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

            return redirect()->route('eventeksternal.edit', $id_eventeksternal)->with('success', 'Data event eksternal berhasil diupdate');
        } catch (\Throwable $err) {
            return redirect()->route('eventeksternal.edit', $id_eventeksternal)->with('failed', 'Data event eksternal gagal diupdate');
        }
    }

    public function delete(Request $request, $id_eventeksternal)
    {
        EventEksternal::destroy($id_eventeksternal);

        return response()->json([
            "status" => 1,
            "message" => "Event eksternal berhasil dihapus",
        ]);
    }

    public function seePengajuan($id_eventeksternal)
    {
        $title = "Event Eksternal | Pengajuan";
        $headerTitle = "Pengajuan Event Eksternal";

        // get api

        $pengajuan = $this->getPengajuanEventEksternal($id_eventeksternal);
        $event = $this->getEventEksternalById($id_eventeksternal);

        if (!$pengajuan) {
            return redirect()->route('eventeksternal.index')->with('failed', 'Pengajuan event eksternal tidak ada');
        }

        return view('eventeksternal.pengajuan', compact(
            'title',
            'headerTitle',
            'pengajuan',
            'event'
        ));
    }

    public function updatePengajuan(pengajuanEksternalUpdateRequest $req, $id_eventeksternal_detail)
    {
        $validated = $req->validated();

        $client = new Client();

        $url = env('BACKEND_URL') . "eventeksternal/pengajuan/" . $id_eventeksternal_detail;


        $option = ['multipart' => [
            [
                'name'     => 'event_eksternal_id',
                'contents' => $req->event_eksternal_id
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

            return redirect()->route('eventeksternal.pengajuan', $req->event_eksternal_id)->with('success', 'Berhasil');
        } catch (\Throwable $err) {
            return redirect()->back()->with('failed', 'Gagal');
        }
    }

    public function getAllEvents()
    {
        $events = collect();
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "eventeksternal";
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $events = json_decode($response->getBody())->data;

            return $events;
        } catch (\Throwable $err) {
            return $events;
        }
    }

    public function getEventEksternalById($id_eventeksternal)
    {
        $event = null;

        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "eventeksternal/detail/" . $id_eventeksternal;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $event = json_decode($response->getBody())->data;

            return $event;
        } catch (\Throwable $err) {
            return $event;
        }
    }

    public function getPengajuanEventEksternal($id_eventeksternal)
    {
        $pengajuan = null;
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "eventeksternal/pengajuan/" . $id_eventeksternal;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $pengajuan = json_decode($response->getBody())->data;

            return $pengajuan;
        } catch (\Throwable $err) {
            return $pengajuan;
        }
    }
}
