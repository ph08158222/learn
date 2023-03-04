<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WebSocketStop extends Command
{
    protected $signature = 'websocket:stop';
    protected $description = 'Stop the WebSocket server';

    public function handle()
    {
        $pidFile = storage_path('app/websocket.pid');

        if (!file_exists($pidFile)) {
            $this->error('WebSocket server is not running.');
            exit;
        }

        $pid = file_get_contents($pidFile);
        posix_kill($pid, SIGTERM);
        unlink($pidFile);

        $this->info('WebSocket server stopped.');
    }
}
