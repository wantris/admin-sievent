<?php

namespace App\Exports;

use App\EventEksternal;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ListPesertaEksternalExport implements FromView, ShouldAutoSize
{
    protected $id_eventeksternal;

    function __construct($id_eventeksternal)
    {
        $this->id_eventeksternal = $id_eventeksternal;
    }

    public function view(): View
    {

        $event = EventEksternal::with('tahapanRef')->select('nama_event', 'id_event_eksternal', 'role')->find($this->id_eventeksternal);
        $data = $this->getData();
        // dd($data);

        return view('exports.list_peserta_eksternal', [
            'pendaftaran' => $data,
            'event' => $event
        ]);
    }

    public function getData()
    {

        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventeksternal/export";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'eventid' => $this->id_eventeksternal,
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
