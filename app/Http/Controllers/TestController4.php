<?php

namespace App\Http\Controllers;

use App\Models\Preanalytics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TestController4 extends Controller
{




public function index(){
    $ip = request()->header('X-Forwarded-For') ?? request()->ip();
    
$location = $this->getLocationFromIp($ip);

        if ($location) {
            echo "IP: {$location['ip']}, City: {$location['city']}, Country: {$location['country']}";
        } else {
            echo "Could not determine location.";
        }
}
function getLocationFromIp($ip)
{
    $apiKey = 'YOUR_IPAPI_KEY'; // Replace with your ipapi key
    $url = "http://api.ipapi.com/{$ip}?access_key={$apiKey}";

    // Make API call
    $response = Http::get($url);

    if ($response->ok()) {
        $data = $response->json();

        if (!empty($data)) {
            return [
                'ip' => $data['ip'] ?? 'Unknown',
                'city' => $data['city'] ?? 'Unknown',
                'region' => $data['region_name'] ?? 'Unknown',
                'country' => $data['country_name'] ?? 'Unknown',
                'latitude' => $data['latitude'] ?? 'Unknown',
                'longitude' => $data['longitude'] ?? 'Unknown',
            ];
        }
    }

    return null;
}



}
