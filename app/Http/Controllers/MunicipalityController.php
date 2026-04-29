<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class MunicipalityController extends Controller
{
    public function index(Request $request)
    {
        $token = env('PLEMSI_API_TOKEN', '');
        $url = env('PLEMSI_MUNICIPALITY_URL', '');

        $data = Cache::remember('municipalities', 60 * 24, function() use ($token, $url) {
            $client = new Client();
            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
                'verify' => false
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result['data'] ?? [];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}