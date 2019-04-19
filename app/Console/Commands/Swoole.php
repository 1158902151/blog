<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class Swoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '启动swoole';

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
		$server = new \swoole_websocket_server("0.0.0.0", 9501);
		$server->on('message', function (\swoole_websocket_server $server, $frame) {
			foreach($server->connections as $key => $fd) {
				$user_message = $frame->data;
				$uuid    = mt_rand(1,99999);
				$message = json_encode(array('count'=>count($server->connections),'uuid'=>$uuid,'data'=>$user_message,'time'=>date('Y-m-d H:i:s',time())));
				$server->push($fd, $message);
			}

		});

		$server->on('close', function ($ser, $fd) {
			echo "client {$fd} closed\n";
		});

		$server->start();
	}
}
