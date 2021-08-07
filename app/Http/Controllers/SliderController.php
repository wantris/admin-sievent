<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SliderController extends Controller
{
    public function index()
    {
        $title = "Slider";
        $headerTitle = "Data Slider";
        $sliders = $this->getAllData();


        return view('slider.index', compact('title', 'headerTitle', 'sliders'));
    }

    public function getAllData()
    {
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "slider";
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $sliders = json_decode($response->getBody());

            return $sliders->data;
        } catch (\Throwable $err) {
            $sliders = collect();

            return $sliders;
        }
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);

        $client = new Client();
        $url = env('BACKEND_URL') . "slider/save";
        $option = ['multipart' => [
            [
                'name'     => 'title',
                'contents' => $request->title
            ],
            [
                'name'     => 'deskripsi',
                'contents' => $request->description
            ],

        ]];

        if ($request->has('is_active')) {
            $is_active =   [
                'name'     => 'is_active',
                'contents' => 1
            ];

            array_push($option['multipart'], $is_active);
        } else {
            $is_active =  [
                'name'     => 'is_active',
                'contents' => 0
            ];

            array_push($option['multipart'], $is_active);
        };

        if ($request->file('image')) {
            $file               = request('image');
            $file_image_path          = $file->getPathname();
            $file_image_mime          = $file->getMimeType('image');
            $file_uploaded_image_name = $file->getClientOriginalName();
            $imageArr =  [
                'name'      => 'image',
                'filename' => $file_uploaded_image_name,
                'Mime-Type' => $file_image_mime,
                'contents' => fopen($file_image_path, 'r'),
            ];

            array_push($option['multipart'], $imageArr);
        }

        try {
            $response = $client->request('POST', $url, $option);

            $body = $response->getBody();
            $responseBody = json_decode($body);

            if ((bool)$responseBody->success) {
                return redirect()->route('slider.index')->with('success', 'Data slider berhasil ditambah');
            } else {
                return redirect()->route('slider.index')->with('failed', 'Data slider gagal ditambah');
            }
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('slider.index')->with('failed', 'Data slider gagal ditambah');
        }
    }

    public function update(Request $request, $id_slider)
    {
        $validated = $request->validate([
            'title' => 'required',
        ]);

        $client = new Client();
        $url = env('BACKEND_URL') . "slider/update/" . $id_slider;
        $option = ['multipart' => [
            [
                'name'     => 'title',
                'contents' => $request->title
            ],
            [
                'name'     => 'deskripsi',
                'contents' => $request->description
            ],
            [
                'name'     => 'oldImage',
                'contents' => $request->old_image
            ],

        ]];

        if ($request->has('is_active')) {
            $is_active =   [
                'name'     => 'is_active',
                'contents' => 1
            ];

            array_push($option['multipart'], $is_active);
        } else {
            $is_active =  [
                'name'     => 'is_active',
                'contents' => 0
            ];

            array_push($option['multipart'], $is_active);
        };

        if ($request->file('image')) {
            $file               = request('image');
            $file_image_path          = $file->getPathname();
            $file_image_mime          = $file->getMimeType('image');
            $file_uploaded_image_name = $file->getClientOriginalName();
            $imageArr =  [
                'name'      => 'image',
                'filename' => $file_uploaded_image_name,
                'Mime-Type' => $file_image_mime,
                'contents' => fopen($file_image_path, 'r'),
            ];

            array_push($option['multipart'], $imageArr);
        }

        try {
            $response = $client->request('POST', $url, $option);

            $body = $response->getBody();
            $responseBody = json_decode($body);

            if ((bool)$responseBody->success) {
                return redirect()->route('slider.index')->with('success', 'Data slider berhasil ditambah');
            } else {
                return redirect()->route('slider.index')->with('failed', 'Data slider gagal ditambah');
            }
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('slider.index')->with('failed', 'Data slider gagal ditambah');
        }
    }

    public function delete($id_slider)
    {
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "slider/delete/" . $id_slider;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $body = $response->getBody();
            $responseBody = json_decode($body);

            if ((bool)$responseBody->success) {
                return response()->json([
                    "status" => 1,
                    "message" => "Slider berhasil dihapus",
                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "message" => $responseBody->message,
                ]);
            }
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('slider.index')->with('failed', "Terjadi error");
        }
    }
}
