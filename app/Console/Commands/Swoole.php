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

		$server->on('open', function (\swoole_websocket_server $server, $frame) {
			//每一次客户端连接 最大连接数将增加
			$message = "【欢迎 用户{$frame->fd}】：进入了聊天室";
			echo $message."\n";
			foreach ($server->connections as $key => $value) {
				if($frame->fd != $value){
					$server->push($value, $message);
				}
			}
		});

		$server->on('message', function (\swoole_websocket_server $server, $frame) {
			$fd   = $frame->fd;
			$data = $frame->data;
			$message = "[用户{$fd}]:{$data}";
			//向所有人广播
			foreach ($server->connections as $key => $value) {
				if($frame->fd != $value){
					$server->push($value, $message);
				}
			}
		});

		$server->on('close', function (\swoole_websocket_server $server, $fd) {
			//关闭连接 连接减少
			$message = "【用户{$fd}】：退出了聊天室";
			echo "client {$fd} closed\n";
			foreach ($server->connections as $key => $value) {
				if($fd != $value){
					$server->push($value, $message);
				}
			}
		});

		$server->start();
	}
}
