<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KabuApi;

use App\Enums\Exchange;
use App\Enums\Side;

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
            [ 'Symbol' => 8308, 'Exchange' => 1 ], // りそな
        ]);
    }

    public function unregistAll(): bool
    {
        return (new KabuApi())->unregister();
    }

    public function order(): bool
    {
        return (new KabuApi())->orderInfoBuilder(Exchange::TOSHO, Side::BUY, 8308, 100, 397.2)->sendOrder();
    }

    public function websocket()
    {
        $client = new WebSocket\Client("ws://echo.websocket.org/");
        while (true) {
            try {
                $message = $client->receive();
                echo "AAA";
            } catch (\WebSocket\ConnectionException $e) {
                var_dump($e)
            }
        }
        $client->close();
    }
}