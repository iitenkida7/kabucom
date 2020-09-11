use Illuminate\Support\Facades\Redis;

        // TODO Tokenが死んでいるときの再取得処理が 考慮されていない
        $this->token = Redis::get('token');
        if($this->token == null){
            Redis::set('token', $this->token);
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
