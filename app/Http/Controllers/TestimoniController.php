<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestimoniController extends Controller
{
    public function index()
    {
        $title = "Testimoni";
        $headerTitle = "Data Testimoni";

        $testimonis = $this->getAllData();

        return view('testimoni.index', compact('title', 'headerTitle', 'testimonis'));
    }

    public function getAllData()
    {
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "testimoni";
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $testimonis = json_decode($response->getBody());

            return $testimonis->data;
        } catch (\Throwable $err) {
            $testimonis = collect();

            return $testimonis;
        }
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'description' => 'required',
        ]);

        $client = new Client();
        $url = env('BACKEND_URL') . "testimoni/save";
        $option = ['multipart' => [
            [
                'name'     => 'name',
                'contents' => $request->name
            ],
            [
                'name'     => 'role',
                'contents' => $request->role
            ],
            [
                'name'     => 'description',
                'contents' => $request->description
            ],

        ]];

        if ($request->file('photo')) {
            $file               = request('photo');
            $file_photo_path          = $file->getPathname();
            $file_photo_mime          = $file->getMimeType('photo');
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
                return redirect()->route('testimoni.index')->with('success', 'Data testimoni berhasil ditambah');
            } else {
                return redirect()->route('testimoni.index')->with('failed', 'Data testimoni gagal ditambah');
            }
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('testimoni.index')->with('failed', 'Data testimoni gagal ditambah');
        }
    }

    public function update(Request $request, $id_testimoni)
    {
        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'description' => 'required',
        ]);

        $client = new Client();
        $url = env('BACKEND_URL') . "testimoni/update/" . $id_testimoni;
        $option = ['multipart' => [
            [
                'name'     => 'name',
                'contents' => $request->name
            ],
            [
                'name'     => 'role',
                'contents' => $request->role
            ],
            [
                'name'     => 'description',
                'contents' => $request->description
            ],
            [
                'name'     => 'oldPhoto',
                'contents' => $request->old_photo
            ],

        ]];

        if ($request->file('photo')) {
            $file               = request('photo');
            $file_photo_path          = $file->getPathname();
            $file_photo_mime          = $file->getMimeType('photo');
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
                return redirect()->route('testimoni.index')->with('success', 'Data testimoni berhasil ditambah');
            } else {
                return redirect()->route('testimoni.index')->with('failed', 'Data testimoni gagal ditambah');
            }
        } catch (\Throwable $err) {
            return redirect()->route('testimoni.index')->with('failed', 'Data testimoni gagal ditambah');
        }
    }

    public function delete($id_testimoni)
    {

        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "testimoni/delete/" . $id_testimoni;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $body = $response->getBody();
            $responseBody = json_decode($body);

            if ((bool)$responseBody->success) {
                return response()->json([
                    "status" => 1,
                    "message" => "testimoni berhasil dihapus",
                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "message" => $responseBody->message,
                ]);
            }
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('testimoni.index')->with('failed', "Terjadi error");
        }
    }
}
