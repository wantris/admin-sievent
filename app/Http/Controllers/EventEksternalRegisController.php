<?php

namespace App\Http\Controllers;

use App\Ormawa;
use Illuminate\Http\Request;
use App\EventEksternal;
use App\EventEksternalRegistration;
use App\Exports\ListPesertaEksternalExport;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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
        $event = EventEksternal::with('tahapanRef')->select('nama_event', 'id_event_eksternal', 'role')->find($id_eventeksternal);
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

    public function exportExcel($id_eventeksternal)
    {
        $event = EventEksternal::with('tahapanRef')->find($id_eventeksternal);
        if ($event) {
            return Excel::download(new ListPesertaEksternalExport($id_eventeksternal), 'Peserta ' . $event->nama_event . '.xlsx');
        }

        return redirect()->back()->with('failed', 'Event tidak ada');
    }

    public function exportPdf($id_eventeksternal)
    {
        $event = EventEksternal::find($id_eventeksternal);
        $pendaftaran = $this->getPendaftarById($id_eventeksternal);

        $pdf = PDF::loadview('exports.pdf.list_peserta_eksternal_pdf', ['event' => $event, 'pendaftaran' => $pendaftaran])->setPaper('a4', 'landscape');

        return $pdf->download('data_peserta.pdf');
    }


    public function getPendaftarById($id_eventeksternal)
    {
        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventeksternal/export";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'eventid' => $id_eventeksternal,
                ]
            ]);

            $body = json_decode($responseP->getBody());

            return $body->data;
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $responseBodyAsString = json_decode($response->getBody());
            return redirect()->back()->with('failed', $responseBodyAsString->message);
        }
    }

    public function downloadSertificate()
    {
        $sertificateid = request()->sertificateid;
        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventeksternal/sertificate";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'sertificateid' => $sertificateid,
                ]
            ]);

            $body = json_decode($responseP->getBody());
            $sertif = $body->data;

            return redirect($sertif->file_url);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $responseBodyAsString = json_decode($response->getBody());
            dd($responseBodyAsString);
            // return redirect()->back()->with('failed', $responseBodyAsString->message);
        }
    }
}
