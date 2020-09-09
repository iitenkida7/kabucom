<?php

namespace App\Services;

class KabuApi
{
    var $client;
    var $token = null;

    function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->token = $this->getToken();
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
        return json_decode($res->getBody(),true);
    }
 


    public function register(array $symbols): bool
    {
        $res = $this->client->request('PUT', config('kabusapi.url') . '/register', [
            'headers' => ['X-API-KEY' => $this->token],
            'json' => [
                'Symbols' => $symbols,
            ],
        ]);
        if ($res->getStatusCode() === 200){
            return true;
        }
        return false;
    }

    public function unregister(): bool
    {
        $res = $this->client->request('PUT', config('kabusapi.url') . '/unregister/all', [
            'headers' => ['X-API-KEY' => $this->token]]);
        if ($res->getStatusCode() === 200){
            return true;
        }
        return false;
    }
}