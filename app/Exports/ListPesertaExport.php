<?php

namespace App\Exports;

use App\EventInternal;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ListPesertaExport implements FromView, ShouldAutoSize
{
    protected $id_eventinternal;

    function __construct($id_eventinternal)
    {
        $this->id_eventinternal = $id_eventinternal;
    }

    public function view(): View
    {

        $event = EventInternal::select('nama_event')->find($this->id_eventinternal);
        $data = $this->getData();

        return view('exports.list_peserta_internal', [
            'pendaftaran' => $data,
            'event' => $event
        ]);
    }

    public function getData()
    {

        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "registration/eventinternal/export";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'eventid' => $this->id_eventinternal,
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
