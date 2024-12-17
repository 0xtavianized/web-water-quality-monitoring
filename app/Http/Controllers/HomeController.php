<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $apiUrl = "https://api.thingspeak.com/channels/2725512/feeds.json?results=1";

        try {
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);

            $ph = isset($data['feeds'][0]['field1']) ? (float) $data['feeds'][0]['field1'] : null;
            $turbidity = isset($data['feeds'][0]['field2']) ? (float) $data['feeds'][0]['field2'] : null;
            $tds = isset($data['feeds'][0]['field3']) ? (float) $data['feeds'][0]['field3'] : null;

            $phFormatted = isset($ph) ? number_format($ph, 2, ',', '') : null;
            $turbidityFormatted = isset($turbidity) ? number_format($turbidity, 2, ',', '') : null;
            $tdsFormatted = isset($tds) ? number_format($tds, 2, ',', '') : null;

            return view('index', [
                'ph' => $phFormatted,
                'turbidity' => $turbidityFormatted,
                'tds' => $tdsFormatted,
                'error' => isset($data['feeds']) ? null : 'Error fetching data',
            ]);
        } catch (\Exception $e) {
            return view('index', [
                'ph' => null,
                'turbidity' => null,
                'tds' => null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function history()
    {
        return view('history');
    }
}
