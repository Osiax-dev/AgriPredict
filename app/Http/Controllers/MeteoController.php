<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MeteoController extends Controller
{
    public function getMeteo(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $lat = floatval($request->lat);
        $lng = floatval($request->lng);

        try {
            $response = Http::timeout(30)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude'              => $lat,
                'longitude'             => $lng,
                'daily'                 => 'precipitation_sum,temperature_2m_mean,relative_humidity_2m_mean',
                'timezone'              => 'auto',
                'forecast_days'         => 7,
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'erreur'  => 'Erreur Open-Meteo : ' . $response->status(),
                    'raw'     => $response->body(),
                ]);
            }

            $data  = $response->json();
            $daily = $data['daily'];

            // Calculer les moyennes sur 7 jours
            $pluviometrie = round(array_sum($daily['precipitation_sum']) , 2);
            $temperature  = round(array_sum($daily['temperature_2m_mean']) / count($daily['temperature_2m_mean']), 2);
            $humidite     = round(array_sum($daily['relative_humidity_2m_mean']) / count($daily['relative_humidity_2m_mean']), 2);

            return response()->json([
                'success'      => true,
                'lat'          => $lat,
                'lng'          => $lng,
                'pluviometrie' => $pluviometrie, // mm sur 7 jours
                'temperature'  => $temperature,  // °C moyenne
                'humidite'     => $humidite,     // % moyenne
                'details'      => $daily,        // données jour par jour
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'erreur'  => $e->getMessage(),
            ], 500);
        }
    }
}