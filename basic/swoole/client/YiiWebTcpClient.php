<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 22/07/2018
 * Time: 10:31 AM
 */

namespace app\swoole\client;

use Swoole\Client;

class YiiWebTcpClient
{
    public $client;
    public function __construct()
    {   
        $this->client = new Client(SWOOLE_SOCK_TCP);
    }

    /**
     * @param Client $cli
     */
    public function connect($cli) {
        echo "connect success \n";
    }

    public function receive($cli, $data) {
        echo $data . "\n";
    }

    public function error($cli) {
        echo "error \n";
    }

    public function send($data) {
        $this->client->send($data);
    }

    public function close($cli) {
        echo "close \n";
    }
}
