<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class KabuController extends Controller
{

    var $token = null;
    var $softbank = 9984;

    function __construct()
    {
        $this->token = Redis::get('kabusapi.token');
        if(! $this->token){
            $this->getToken();
        }
    }

    private function getToken() :string
    {
       $client = new \GuzzleHttp\Client();
       $res = $client->request('POST', config('kabusapi.url') . '/token', [
            'json' => ['APIPassword' => config('kabusapi.password')]
        ]);
       $response = (json_decode($res->getBody(), true));
       Redis::set('kabusapi.token', $response['Token']);
       return Redis::get('kabusapi.token');
    }

    public function index()
    {
        dd($this->board($this->softbank));
    }

    // 購買余力（残高)
    public function stockAccountWallet():int
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', config('kabusapi.url') . '/wallet/cash', [
            'headers' => [
                'X-API-KEY' => $this->token,
            ],
        ]);
        return json_decode($res->getBody(), true)['StockAccountWallet'];
    }

    public function board(string $symbol, int $exchange = 1):array
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', config('kabusapi.url') . '/board/' . $symbol . '@' . $exchange, [
            'headers' => [
                'X-API-KEY' => $this->token,
            ]],
        );
        return json_decode($res->getBody(),true);
    }
 
    public function register(int $symbol): bool
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('PUT', config('kabusapi.url') . '/register', [
            'headers' => [
                'X-API-KEY' => $this->token,
            ],
            
            'json' => [
                'Symbols' => [[
                    'Symbol' => $symbol,
                    'Exchange' => 1, // 東証
                ]],
            ],
        ]);
        if ($res->getStatusCode() === 200){
            return true;
        }
        return false;


    }
}