<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ClientException;


class tahapanEventInternalController extends Controller
{
    public function saveRegistrationStep()
    {
        $id_eventinternal = request()->eventid;
        $regisid = request()->regisid;

        try {
            $client = new Client();
            $urlP = env('BACKEND_URL') . "tahapan/eventinternal/pendaftaran";

            $responseP = $client->request('GET', $urlP, [
                'verify'  => false,
                'query' => [
                    'eventid' => $id_eventinternal,
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
