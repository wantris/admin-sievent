<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\ApiMahasiswaController;
use App\EventInternalRegistration;
use App\TimEvent;
use App\EventInternal;
use App\EventEksternal;

class TeamController extends Controller
{
    public function index($type)
    {
        if ($type == "eventinternal") {
            $title = "Team Peserta Event";
            $headerTitle = "Data Team Peserta Event Internal";
            $events = EventInternal::select(['id_event_internal', 'nama_event'])->get();

            $tims = $this->getAllByEventInternal();

            return view('tim.event_internal',  compact('title', 'headerTitle', 'tims', 'events'));
        } elseif ($type == "eventeksternal") {
            $title = "Team Peserta Event";
            $headerTitle = "Data Team Peserta Event Eksternal";
            $events = EventEksternal::select(['id_event_eksternal', 'nama_event'])->get();

            $tims = $this->getAllByEventEksternal();
            return view('tim.event_eksternal',  compact('title', 'headerTitle', 'tims', 'events'));
        }
    }

    public function getAllByEventInternal()
    {
        $tims = collect();
        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "team/eventinternal";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
            ]);

            $tims = json_decode($responseP->getBody());

            $new_data = $tims->data;

            return $new_data;
        } catch (\Throwable $err) {
            return $tims;
        }
    }

    public function getAllByEventEksternal()
    {
        $tims = collect();
        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "team/eventeksternal";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
            ]);

            $tims = json_decode($responseP->getBody());

            $new_data = $tims->data;

            return $new_data;
        } catch (\Throwable $err) {
            return $tims;
        }
    }

    public function updateStatus(Request $request, $id_tim)
    {
        try {
            $tim = TimEvent::find($id_tim);
            $tim->status = $request->status;
            $tim->save();

            return response()->json([
                "status" => 1,
                "message" => "Status berhasil di update",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 0,
                "message" => "Status gagal di update",
            ]);
        }
    }
}
