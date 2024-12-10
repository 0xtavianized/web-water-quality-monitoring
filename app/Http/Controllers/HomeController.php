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

            // Format untuk tampilan
            $phFormatted = isset($ph) ? number_format($ph, 2, ',', '') : null;
            $turbidityFormatted = isset($turbidity) ? number_format($turbidity, 2, ',', '') : null;
            $tdsFormatted = isset($tds) ? number_format($tds, 2, ',', '') : null;

            // Proses logika dengan tipe float asli
            $phStatus = $this->getPhStatus($ph);
            $turbidityStatus = $this->getTurbidityStatus($turbidity);
            $tdsStatus = $this->getTdsStatus($tds);

            return view('index', [
                'ph' => $phFormatted,
                'turbidity' => $turbidityFormatted,
                'tds' => $tdsFormatted,
                'phStatus' => $phStatus,
                'turbidityStatus' => $turbidityStatus,
                'tdsStatus' => $tdsStatus,
                'error' => isset($data['feeds']) ? null : 'Error fetching data',
            ]);
        } catch (\Exception $e) {
            return view('index', [
                'ph' => null,
                'turbidity' => null,
                'tds' => null,
                'phStatus' => null,
                'turbidityStatus' => null,
                'tdsStatus' => null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function history()
    {
        return view('history');
    }

    private function getPhStatus(?float $ph)
    {
        if ($ph === null) {
            return ['description' => 'Tidak Ada Data', 'color' => 'text-gray-500'];
        }
        if ($ph < 5.5) {
            return ['description' => 'Air Asam', 'color' => 'text-red-500'];
        } elseif ($ph >= 5.5 && $ph <= 9) {
            return ['description' => 'Normal', 'color' => 'text-green-500'];
        } else {
            return ['description' => 'Air Basa', 'color' => 'text-blue-500'];
        }
    }

    private function getTurbidityStatus(?float $turbidity)
    {
        if ($turbidity === null) {
            return ['description' => 'Tidak Ada Data', 'color' => 'text-gray-500'];
        }

        if ($turbidity < 20) {
            return ['description' => 'Normal', 'color' => 'text-green-500'];
        } elseif ($turbidity < 35) {
            return ['description' => 'Agak Keruh', 'color' => 'text-yellow-500'];
        } else {
            return ['description' => 'Keruh', 'color' => 'text-red-500'];
        }
    }

    private function getTdsStatus(?float $tds)
    {
        if ($tds === null) {
            return ['description' => 'Tidak Ada Data', 'color' => 'text-gray-500'];
        }
        if ($tds < 500) {
            return ['description' => 'Normal', 'color' => 'text-green-500'];
        } elseif ($tds <= 1000) {
            return ['description' => 'Agak Konduktif', 'color' => 'text-yellow-500'];
        } else {
            return ['description' => 'Sangat Konduktif', 'color' => 'text-red-500'];
        }
    }
}
