<?php
use Swoole\Coroutine;
use Swoole\Coroutine\Client;
go(function() {
    $client = new Client(SWOOLE_SOCK_TCP);
    if (!$client->connect('127.0.0.1', 9501, 0.5))
    {
        exit("connect failed. Error: \n");
    }
    $client->send("hello world\n");
    echo "b\n";
    echo $client->recv() . "\n";
    $client->close();
});