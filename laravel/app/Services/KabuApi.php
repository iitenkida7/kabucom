<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;


class KabuApi
{
    public $client;
    public $token = null;
    public $orderInfo = null;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();

        $this->token = $this->getToken();
        /*
        // TODO Tokenが死んでいるときの再取得処理が 考慮されていない
        Redis::set('token', null);
        $this->token = Redis::get('token');
        if($this->token == null){
            $this->token = $this->getToken();
            Redis::set('token', $this->token);
        }       
        */      
    }

    private function getToken() :string
    {
        $res = $this->client->request('POST', config('kabusapi.url') . '/token', [
            'json' => ['APIPassword' => config('kabusapi.password')]
        ]);
        return json_decode($res->getBody(), true)['Token'];
    }

    // 購買余力（残高)
    public function stockAccountWallet():int
    {
        $res = $this->client->request('GET', config('kabusapi.url') . '/wallet/cash', [
            'headers' => ['X-API-KEY' => $this->token,]]);
        return json_decode($res->getBody(), true)['StockAccountWallet'];
    }

    public function board(string $symbol, int $exchange = 1):array
    {
        $res = $this->client->request('GET', config('kabusapi.url') . '/board/' . $symbol . '@' . $exchange, [
            'headers' => ['X-API-KEY' => $this->token]]);
        return json_decode($res->getBody(), true);
    }
 
    public function register(array $symbols): bool
    {
        $res = $this->client->request('PUT', config('kabusapi.url') . '/register', [
            'headers' => ['X-API-KEY' => $this->token],
            'json' => [
                'Symbols' => $symbols,
            ],
        ]);
        if ($res->getStatusCode() === 200) {
            return true;
        }
        return false;
    }

    public function unregister(): bool
    {
        $res = $this->client->request('PUT', config('kabusapi.url') . '/unregister/all', [
            'headers' => ['X-API-KEY' => $this->token]]);
        if ($res->getStatusCode() === 200) {
            return true;
        }
        return false;
    }

    public function sendOrder(): bool
    {

        try {
        $res = $this->client->request('POST', config('kabusapi.url') . '/sendorder', [
            'headers' => ['X-API-KEY' => $this->token],
            'json' => $this->orderInfo],
            );
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
            
        if ($res->getStatusCode() === 200) {
            return true;
        }
        return false;
    }

    public function orderInfoBuilder(int $exchange, int $side, string $symbol, int $qty, float $price) : object
    {
        $this->orderInfo = [
            'Password' => config('kabusapi.orderPassword'),
            'Symbol'   => $symbol,
            'Exchange' => $exchange,
            'SecurityType' => 1, //株式（固定）
            'Side' => $side,
            'CashMargin' => 1, // 1:現物, 2:信用新規, 3:信用返済
            //'MarginTradeType' => '', // 現物省略化 1:制度信用, 2:一般信用, 3:一般信用（売短）
            'DelivType' => 2,  //  0:指定なし, 1:自動振替, 2:お預り金
            'FundType' => 'AA', //  ' ':現物売、信用返済の場合  ※よくわからん。
            'AccountType' => 4, // 4:特定
            'Qty' => $qty, // 数量
            // 'ClosePositionOrder' => ,
            // 'ClosePositions' => ,
            'Price' => $price,
            'ExpireDay' => 0, // 0:当日
            'FrontOrderType' => 20 // 20:指値
        ];
        //dd(Collect($this->orderInfo)->toJson());
        return $this;
    }


    public function websocket()
    {
        $client = new WebSocket\Client(config('kabusapi.websocketUrl'));
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

