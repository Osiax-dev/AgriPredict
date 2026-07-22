<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeeController extends Controller
{
    public function getNdvi(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $lat = floatval($request->lat);
        $lng = floatval($request->lng);

        try {
            $scriptPath = storage_path('app/get_ndvi.py');
            $python     = 'py -3.11';
            $command    = "{$python} " . escapeshellarg($scriptPath) . " {$lat} {$lng} 2>&1";
            $output     = shell_exec($command);
            $data       = json_decode($output, true);

            if (!$data || !isset($data['success']) || !$data['success']) {
                return response()->json([
                    'success' => false,
                    'ndvi'    => null,
                    'erreur'  => $data['erreur'] ?? 'Erreur script Python',
                    'raw'     => $output,
                ]);
            }

            return response()->json([
                'success' => true,
                'ndvi'    => $data['ndvi'],
                'lat'     => $lat,
                'lng'     => $lng,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'ndvi'    => null,
                'erreur'  => $e->getMessage(),
            ], 500);
        }
    }
}