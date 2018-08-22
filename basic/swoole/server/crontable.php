<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 31/07/2018
 * Time: 9:14 PM
 */
use Swoole\Coroutine as co;
$chan = new co\Channel(1);
var_dump(time());
co::create(function () use ($chan) {
    for($i = 0; $i < 1; $i++) {
        co::sleep(1.0);
        $chan->push(['rand' => rand(1000, 9999), 'index' => $i]);
        echo "$i\n";
        var_dump(time());
    }
});
co::create(function () use ($chan) {
    while(1) {
        $data = $chan->pop();
        var_dump($data);
        var_dump(time());
    }
});