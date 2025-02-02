<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trade;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TradeController extends Controller
{
    public function index()
    {
        return view('trade.index');
    }

    public function store(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric',
        'type' => 'required|string|in:buy_up,buy_down',
        'duration' => 'required|integer|in:180,150,90',
    ]);

    $duration = (int) $request->input('duration'); // Convert to integer
    $expiryTime = Carbon::now()->addSeconds($duration); // Now it will work properly

    // Save trade to database
    $trade = new Trade();
    $trade->amount = $request->input('amount');
    $trade->type = $request->input('type');
    $trade->duration = $duration;
    $trade->expiry_time = $expiryTime;
    $trade->save();

    return response()->json(['message' => 'Trade placed successfully!', 'expiry' => $expiryTime]);
}

    public function getChartData()
    {
        $btc_price = $this->getBtcPrice();
        return response()->json(['price' => $btc_price, 'time' => now()->toDateTimeString()]);
    }

    private function getBtcPrice()
    {
        $response = Http::get('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=inr');
        return $response->json()['bitcoin']['inr'];
    }
}
