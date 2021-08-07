<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BlogController extends Controller
{
    public function index()
    {
        $title = "Blog";
        $headerTitle = "Data Blog";
        $blogs = $this->getAllData();


        return view('blog.index', compact('title', 'headerTitle', 'blogs'));
    }

    public function add()
    {
        $title = "Tambah Blog";
        $headerTitle = "Tambah Data Blog";

        return view('blog.add', compact('title', 'headerTitle'));
    }

    public function getAllData()
    {
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "blog";
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $blogs = json_decode($response->getBody());

            return $blogs->data;
        } catch (\Throwable $err) {
            $blogs = collect();

            return $blogs;
        }
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'konten' => 'required',
            'image' => 'required | mimes:jpeg,jpg,png |max:2048',
        ]);

        $client = new Client();
        $url = env('BACKEND_URL') . "blog/save";
        $option = ['multipart' => [
            [
                'name'     => 'title',
                'contents' => $request->title
            ],
            [
                'name'     => 'konten',
                'contents' => $request->konten
            ],

        ]];

        if ($request->has('is_active')) {
            $is_active =   [
                'name'     => 'status',
                'contents' => 1
            ];

            array_push($option['multipart'], $is_active);
        } else {
            $is_active =  [
                'name'     => 'status',
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
                return redirect()->back()->with('success', 'Data blog berhasil ditambah');
            } else {
                return redirect()->back()->with('failed', 'Data blog gagal ditambah');
            }
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->back()->with('failed', 'Data blog gagal ditambah');
        }
    }

    public function edit($slug)
    {
        $title = "Update Blog";
        $headerTitle = "Update Data Blog";

        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "blog/search";
            $response = $client->request('GET', $url, [
                'verify'  => false,
                'query' => [
                    'slug' => $slug
                ]
            ]);

            $data = json_decode($response->getBody());

            if ($data->status == 404) {
                return redirect()->back()->with('failed', 'Data blog tidak ada');
            }

            $blog = $data->data;
            return view('blog.edit', compact('title', 'headerTitle', 'blog'));
        } catch (\Throwable $err) {
            redirect()->back()->with('failed', 'Terjadi error');
        }
    }

    public function update(Request $request, $id_blog)
    {
        $validated = $request->validate([
            'title' => 'required',
            'konten' => 'required',
            'image' => 'mimes:jpeg,jpg,png |max:2048',
        ]);

        $client = new Client();
        $url = env('BACKEND_URL') . "blog/update/" . $id_blog;
        $option = ['multipart' => [
            [
                'name'     => 'title',
                'contents' => $request->title
            ],
            [
                'name'     => 'konten',
                'contents' => $request->konten
            ],
            [
                'name'     => 'old_image',
                'contents' => $request->old_image
            ],

        ]];

        if ($request->has('is_active')) {
            $is_active =   [
                'name'     => 'status',
                'contents' => 1
            ];

            array_push($option['multipart'], $is_active);
        } else {
            $is_active =  [
                'name'     => 'status',
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
                return redirect()->route('blog.index')->with('success', 'Data blog berhasil diupdate');
            } else {
                return redirect()->route('blog.index')->with('failed', 'Data blog gagal diupdate');
            }
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('blog.index')->with('failed', 'Data blog gagal diupdate');
        }
    }

    public function delete($id_blog)
    {
        try {
            $client = new Client();
            $url = env('BACKEND_URL') . "blog/delete/" . $id_blog;
            $response = $client->request('GET', $url, [
                'verify'  => false,
            ]);

            $body = $response->getBody();
            $responseBody = json_decode($body);

            if ((bool)$responseBody->success) {
                return response()->json([
                    "status" => 1,
                    "message" => "Blog berhasil dihapus",
                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "message" => $responseBody->message,
                ]);
            }
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('blog.index')->with('failed', "Terjadi error");
        }
    }
}
