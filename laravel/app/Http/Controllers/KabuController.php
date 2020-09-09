<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KabuApi;

class KabuController extends Controller
{
    public function board($symbol = 101)
    {
        return view('board', [ 'info' => (new KabuApi())->board($symbol)]);
    }

    public function registSymbols(): bool
    {
        return (new KabuApi())->register([
            [ 'Symbol' => 101, 'Exchange' => 1 ], // 日経
            [ 'Symbol' => 9984, 'Exchange' => 1 ], // Sfotbank
            [ 'Symbol' => 4324, 'Exchange' => 1 ], // 電通
            [ 'Symbol' => 3633, 'Exchange' => 1 ], // GMOペパボ
            [ 'Symbol' => 3769, 'Exchange' => 1 ], // GMOペイメントゲートウェイ
        ]);
    }

    public function unregistAll(): bool
    {
        return (new KabuApi())->unregister();
    }
}
