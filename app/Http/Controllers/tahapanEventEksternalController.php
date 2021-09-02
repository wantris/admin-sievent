<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class tahapanEventEksternalController extends Controller
{
    public function saveRegistrationStep()
    {
        $id_eventeksternal = request()->eventid;
        $regisid = request()->regisid;

        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "tahapan/eventeksternal/pendaftaran";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'eventid' => $id_eventeksternal,
                    'regisid' => $regisid
                ]
            ]);

            $body = json_decode($responseP->getBody());

            return redirect()->back()->with('success', $body->message);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $responseBodyAsString = json_decode($response->getBody());
            return redirect()->back()->with('failed', $responseBodyAsString->message);
        }
    }
}
