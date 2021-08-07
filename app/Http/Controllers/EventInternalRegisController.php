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

    public function getByEvent($id_eventinternal)
    {
        $event = EventInternal::select('nama_event')->first();
        if ($event) {
            $title = "Pendaftaran Event";
            $headerTitle = "Data Pendaftaran Event " . $event->nama_event;

            $registrations = $this->getDataByEvent($id_eventinternal);

            return view('pendaftaran.eventinternal.byevent', compact('title', 'headerTitle', 'registrations', 'event'));
        }

        return redirect()->back()->with('failed', 'Event internal tidak ada');
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

    public function getDataByEvent($id_eventinternal)
    {
        $registrations = collect();
        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventinternal";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'idevent' => $id_eventinternal
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

        $regis = EventInternalRegistration::find($id_regis);
        $regis->status = $status;
        $regis->save();

        return response()->json([
            "status" => 1,
            "message" => "Status berhasil di update",
        ]);
    }

    public function delete($id_regis)
    {
        try {
            EventInternalRegistration::destroy($id_regis);

            return response()->json([
                "status" => 1,
                "message" => "Pendaftaran berhasil dihapus",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 0,
                "message" => "Pendaftaran berhasil dihapus",
            ]);
        }
    }
}
