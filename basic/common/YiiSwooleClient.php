<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 17/07/2018
 * Time: 2:44 PM
 */

namespace app\common;


use Swoole\Client;

class YiiSwooleClient
{
    public $host = '127.0.0.1';
    public $port = 9501;
    public $client;
    public function __construct()
    {
        $this->client = new Client(SWOOLE_TCP);
        $this->connect();
        return $this->client;
    }

    public function connect() {
        $this->client->connect($this->host, $this->port);
    }

    public function request() {
        $this->client->send('hello');
    }

    public function receive() {
        echo $this->client->recv();
    }
}