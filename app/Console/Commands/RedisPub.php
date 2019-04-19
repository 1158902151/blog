<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisPub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:pub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '发布';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$server = new swoole_websocket_server("0.0.0.0", 9501);

		$server->on('workerStart', function ($server, $workerId) {
			$client = new \swoole_redis;
			$client->on('message', function (\swoole_redis $client, $result) use ($server) {
				if ($result[0] == 'message') {
					foreach($server->connections as $fd) {
						$server->push($fd, $result[1]);
					}
				}
			});
			$client->connect('39.107.122.217', 6379, function (\swoole_redis $client, $result) {
				$client->subscribe('msg_0');
			});
		});

		$server->on('open', function ($server, $request) {

		});

		$server->on('message', function (\swoole_websocket_server $server, $frame) {
			$server->push($frame->fd, "hello");
		});

		$server->on('close', function ($serv, $fd) {

		});

		$server->start();
    }
}
