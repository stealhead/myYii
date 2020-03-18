<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 17/07/2018
 * Time: 3:34 PM
 */
namespace app\swoole;

use app\swolle\lib\BaiduApi;
use Swoole\Server;

class AsyncService
{
    public $server;
    public $host = '127.0.0.1';
    public $port = 9502;
    public function __construct()
    {
        $this->server = new Server($this->port, $this->port);
        $this->server->on('connect', array($this, 'connect'));
        $this->server->on('start', array($this, 'start'));
        $this->server->on('WorkerStart', array($this, 'workerStart'));
        $this->server->on('receive', array($this, 'receive'));
        $this->server->on('task', array($this, 'task'));
        $this->server->on('finish', array($this, 'finish'));
        $this->server->on('close', array($this, 'close'));
    }

    public function connect(Server $server, int $fd, int $reactorId) {
        echo sprintf("fd:%d, reactorId:%d\n", $fd, $reactorId);
        echo "swoole has been connect \n";
    }

    public function start(Server $server) {
        echo "swoole start \n";
    }

    public function workerStart() {
        include_once "../lib/BaiduApi.php";
    }

    public function receive(Server $server, int $fd, int $reactor_id, string $data) {
        $a = $server->task($data, -1, function (Server $server, $task_id, $data) use ($fd) {
            $server->send($fd, $data);
        });
        var_dump($a);
    }

    public function close(Server $server, int $fd, int $reactorId) {
        $server->stop();
    }

    public function task(Server $server, int $task_id, int $src_worker_id, string $data) {
        $data = json_decode($data, true);
        var_dump($data);
        $lat = $data['lat'];
        $lng = $data['lng'];
        $result = BaiduApi::getLocation($lat, $lng);
        sl
        var_dump($result);
        return $result;
    }

    public function finish(Server $server, int $task_id, string $data) {
        echo "task finished \n";
    }
}

$yiiServer = new AsyncService();
$yiiServer->server->set([
    'worker_num' => 2,
    'task_worker_num' => 2,
    'reactor_num' => 1,
]);
$yiiServer->server->start();
