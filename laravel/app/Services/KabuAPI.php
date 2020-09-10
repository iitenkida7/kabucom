use Illuminate\Support\Facades\Redis;

        // TODO Tokenが死んでいるときの再取得処理が 考慮されていない
        $this->token = Redis::get('token');
        if($this->token == null){
            Redis::set('token', $this->token);
        }       
