<?php

namespace App\Console\Commands;

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use MyApp\MyChat;
use Illuminate\Console\Command;

class WebSocketServe extends Command
{
    protected $signature = 'websocket:serve';
    protected $description = 'Start the WebSocket server';

    public function handle()
    {
        $pidFile = storage_path('app/websocket.pid');

        if (file_exists($pidFile)) {
            $this->error('WebSocket server is already running.');
            exit;
        }

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new MyChat()
                )
            ),
            8080
        );

        $pid = getmypid();
        file_put_contents($pidFile, $pid);

        $this->info('WebSocket server started.');

        $server->run();
    }
}
