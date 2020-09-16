<?php

namespace App\Services;
use Amp\Delayed;
use Amp\Websocket\Client\Connection;
use Amp\Websocket\Client\Handshake;
use Amp\Websocket\Message;
use Amp\Loop;

use function Amp\Websocket\Client\connect;

class websocketClinet
{

    // https://github.com/amphp/websocket-client
    public function run()
    {

        Loop::run(function () {
            
            $handshake = (new Handshake(config('kabusapi.websocketUrl')));
        
            /** @var Connection $connection */
            $connection = yield connect($handshake);
            //yield $connection->send('Hello!');
        
            //$i = 0;
        
            /** @var Message $message */
            while ($message = yield $connection->receive()) {
                $payload = yield $message->buffer();
                echo $payload;
                echo "\n---------------------\n";
                /*
                printf("Received: %s\n", $payload);

                if (\strpos($payload, 'Goodbye!') !== false) {
                    yield $connection->close();
                    break;
                }

                yield new Delayed(100);
        
                if ($i < 3) {
                 
                yield $connection->send('Ping: 1');
                } else {
                    yield $connection->send('Goodbye!');
                }
                */
            }
        });
    }
}
