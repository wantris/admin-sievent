<?php

namespace App\Http\Controllers;

use App\EventInternal;
use App\Ormawa;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\EventInternalRegistration;
use App\Exports\ListPesertaExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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
        $event = EventInternal::select('nama_event', 'id_event_internal')->first();
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

    public function exportExcel($id_eventinternal)
    {
        $event = EventInternal::find($id_eventinternal);
        if ($event) {
            return Excel::download(new ListPesertaExport($id_eventinternal), 'Peserta ' . $event->nama_event . '.xlsx');
        }

        return redirect()->back()->with('failed', 'Event tidak ada');
    }


    public function exportPdf($id_eventinternal)
    {
        $event = EventInternal::find($id_eventinternal);
        $pendaftaran = $this->getPendaftarById($id_eventinternal);

        $pdf = PDF::loadview('exports.pdf.list_peserta_internal_pdf', ['event' => $event, 'pendaftaran' => $pendaftaran])->setPaper('a4', 'landscape');

        return $pdf->download('data_peserta.pdf');
    }

    public function getPendaftarById($id_eventinternal)
    {

        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventinternal/export";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'eventid' => $id_eventinternal,
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
}
