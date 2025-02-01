<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CryptoController extends Controller
{
    // public function index()
    // {
    //     $client = new Client();
    //     $response = $client->get('https://api.coingecko.com/api/v3/coins/markets', [
    //         'query' => [
    //             'vs_currency' => 'usd',
    //             'order' => 'market_cap_desc',
    //             'per_page' => 50, // Fetch only 10 for testing
    //             'page' => 1,
    //             'sparkline' => 'true',
    //         ],
    //     ]);

    //     $cryptos = json_decode($response->getBody(), true);

    //     // Debug the API response
    //     // dd($cryptos); 
    // }
    public function index()
{
    $client = new Client();
    $response = $client->get('https://api.coingecko.com/api/v3/coins/markets', [
        'query' => [
            'vs_currency' => 'usd',
            'order' => 'market_cap_desc',
            'per_page' => 50, // Fetch only 50
            'page' => 1,
            'sparkline' => 'true',
        ],
    ]);

    $cryptos = json_decode($response->getBody(), true);

    // Pass the $cryptos data to the view
    return view('crypto.index', ['cryptos' => $cryptos]);
}

}
