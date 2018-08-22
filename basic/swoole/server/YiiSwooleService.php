<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 17/07/2018
 * Time: 3:34 PM
 */
namespace app\swoole;

use Swoole\Server;

class YiiSwooleService
{
    public $server;
    public $host = '127.0.0.1';
    public $port = 9501;
    public function __construct()
    {
        $this->server = new Server($this->port, $this->port);
        $this->server->on('connect', array($this, 'connect'));
        $this->server->on('start', array($this, 'start'));
        $this->server->on('receive', array($this, 'receive'));
        $this->server->on('task', array($this, 'task'));
        $this->server->on('finish', array($this, 'finish'));
        $this->server->on('close', array($this, 'close'));
    }

    public function connect(Server $server, int $fd, int $reactorId) {
        echo "swoole has been connect \n";
    }

    public function start(Server $server) {
        echo "swoole start \n";
    }

    public function receive(Server $server, int $fd, int $reactor_id, string $data) {
        echo $data . "\n";
        $server->tick(100, function() use ($server, $fd, $data) {
            $workId = $server->task($data . ":{$fd}");
        });
        $fds = $server->connection_list();
        foreach ($fds as $d) {
//            if ($d == $fd) continue;
            $server->send($d, $data . time());
        }
    }

    public function close(Server $server, int $fd, int $reactorId) {
        $server->stop();
    }

    public function task(Server $server, int $task_id, int $src_worker_id, string $data) {
        return $data;
    }

    public function finish(Server $server, int $task_id, string $data) {
        $fdArr = explode(':', $data);
        if (count($fdArr) > 1) {
            $fd = $fdArr[1];
        }
        if (isset($fd)) {
            echo "i am finish $fd \n";
            $time = time();
            $server->send($fd, "task finish: {$time} \n");
        }
    }
}

$yiiServer = new YiiSwooleService();
$yiiServer->server->set([
    'worker_num' => 2,
    'task_worker_num' => 2,
]);
$yiiServer->server->start();
