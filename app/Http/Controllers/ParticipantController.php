<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantStoreRequest;
use App\Participant;
use App\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Throwable, GuzzleHttp\Client;

class ParticipantController extends Controller
{
    public function index()
    {
        $title = "Participant";
        $headerTitle = "Data Participant";

        $client = new Client();
        $url = env('BACKEND_URL') . "participant";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $participants = json_decode($response->getBody());


        return view('participant.index', compact('title', 'headerTitle', 'participants'));
    }

    public function add()
    {
        $title = "Participant";
        $headerTitle = "Tambah Data Participant";

        return view('participant.add', compact('title', 'headerTitle'));
    }

    public function save(ParticipantStoreRequest $req)
    {
        $checkUsername = Pengguna::where('username', $req->username)->first();
        if ($checkUsername) {
            return redirect()->back()->with('failed', 'Username Pengguna sudah ada');
        }

        try {
            $participant = new Participant();
            $participant->nama_participant = $req->nama;
            $participant->save();

            $pengguna = new Pengguna();
            $pengguna->username = $req->username;
            $pengguna->password = Hash::make($req->password);
            $pengguna->is_mahasiswa = 0;
            $pengguna->is_wadir3 = 0;
            $pengguna->is_pembina = 0;
            $pengguna->is_participant = 1;
            $pengguna->participant_id = $participant->id_participant;
            $pengguna->save();


            return redirect()->route('participant.index')->with('success', 'Data Participant berhasil ditambah');
        } catch (Throwable $e) {
            return redirect()->back()->with('failed', 'Data Participant gagal ditambah');
        }
    }

    public function edit($id_participant)
    {
        $title = "Participant";
        $headerTitle = "Update Data Participant";

        $client = new Client();
        $url = env('BACKEND_URL') . "participant/edit/" . $id_participant;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $ps = json_decode($response->getBody());


        if (!$ps) {
            return redirect()->route('participant.index')->with('failed', 'Data Participanttidak ada');
        }

        return view('participant.edit', compact('title', 'headerTitle', 'ps'));
    }

    public function update(Request $req, $id_participant)
    {
        $client = new Client();
        $url = env('BACKEND_URL') . "participant/update/" . $id_participant;


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
                return redirect()->route('participant.edit', $id_participant)->with('success', 'Data participant berhasil diupdate');
            } else {
                return redirect()->route('participant.edit', $id_participant)->with('failed', 'Data participant gagal diupdate');
            }
        } catch (\Throwable) {
            return redirect()->route('participant.edit', $id_participant)->with('failed', 'Data participant gagal diupdate');
        }
    }

    public function delete(Request $request, $id_praticipant)
    {
        Participant::destroy($id_praticipant);

        return response()->json([
            "status" => 1,
            "message" => "Participant berhasil dihapus",
        ]);
    }
}
