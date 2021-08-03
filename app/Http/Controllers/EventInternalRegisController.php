<?php

namespace App\Http\Controllers;

use App\EventInternal;
use App\Ormawa;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\EventInternalRegistration;

class EventInternalRegisController extends Controller
{
    public function index()
    {
        $title = "Pendaftaran Event";
        $headerTitle = "Data Pendaftaran Event Internal";

        $registrations = $this->getAlData();
        // dd($registrations);
        $ormawas = Ormawa::get()->pluck('nama_ormawa');
        $events = EventInternal::get()->pluck('nama_event');


        return view('pendaftaran.eventinternal.index', compact('title', 'headerTitle', 'registrations', 'ormawas', 'events'));
    }

    public function getAlData()
    {
        $registrations = collect();
        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventinternal";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
            ]);

            $registrations = json_decode($responseP->getBody());

            $new_data = $registrations->data;

            return $new_data;
        } catch (\Throwable $err) {
            return $registrations;
        }
    }

    public function updateStatus(Request $request, $id_regis)
    {
        $status = $request->status;

        $regis = EventInternalRegistration::find($id_regis);
        $regis->status = $status;
        $regis->save();

        return response()->json([
            "status" => 1,
            "message" => "Status berhasil di update",
        ]);

        // try {
        //     $regis = EventInternalRegistration::find($id_regis);
        //     $regis->status = $status;
        //     $regis->save();

        //     return response()->json([
        //         "status" => 1,
        //         "message" => "Status berhasil di update",
        //     ]);
        // } catch (\Throwable $err) {
        //     return response()->json([
        //         "status" => 0,
        //         "message" => "Status gagal di update",
        //     ]);
        // }
    }
}
