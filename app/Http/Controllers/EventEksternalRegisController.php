<?php

namespace App\Http\Controllers;

use App\Ormawa;
use Illuminate\Http\Request;
use App\EventEksternal;
use App\EventEksternalRegistration;
use GuzzleHttp\Client;

class EventEksternalRegisController extends Controller
{
    public function index()
    {
        $title = "Pendaftaran Event";
        $headerTitle = "Data Pendaftaran Event Eksternal";

        $registrations = $this->getAlData();

        $events = EventEksternal::get()->pluck('nama_event');


        return view('pendaftaran.eventeksternal.index', compact('title', 'headerTitle', 'registrations',  'events'));
    }

    public function getByEvent($id_eventeksternal)
    {
        $event = EventEksternal::select('nama_event')->first();
        if ($event) {
            $title = "Pendaftaran Event";
            $headerTitle = "Data Pendaftaran Event " . $event->nama_event;

            $registrations = $this->getDataByEvent($id_eventeksternal);


            return view('pendaftaran.eventeksternal.getbyevent', compact('title', 'headerTitle', 'registrations', 'event'));
        }
    }

    public function getAlData()
    {
        $registrations = collect();
        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventeksternal";

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

    public function getDataByEvent($id_eventeksternal)
    {
        $registrations = collect();
        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventeksternal";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'idevent' => $id_eventeksternal
                ]
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

        $regis = EventEksternalRegistration::find($id_regis);
        $regis->status = $status;
        $regis->save();

        return response()->json([
            "status" => 1,
            "message" => "Status berhasil di update",
        ]);
    }
}
