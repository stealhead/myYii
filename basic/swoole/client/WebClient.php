<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 22/07/2018
 * Time: 10:31 AM
 */

namespace app\swoole\client;

use Swoole\Client;

class WebClient
{
    public $client;
    public function __construct()
    {
        $this->client = new Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->client->on('connect', [$this, 'connect']);
        $this->client->on('receive', [$this, 'receive']);
        $this->client->on('error', [$this, 'error']);
        $this->client->on('close', [$this, 'close']);
    }

    /**
     * @param Client $cli
     */
    public function connect($cli) {
        echo "connect success \n";
        $data = json_encode(['lat' => '24.4741340', 'lng' => '118.1043850']);

        $cli->send($data);
    }

    public function receive($cli, $data) {
        echo $data . "\n";
    }

    public function error($cli) {
        echo "error \n";
    }

    public function close($cli) {
        echo "close \n";
    }
}

$client = (new WebClient())->client;
$client->connect('127.0.0.1', 9502);


