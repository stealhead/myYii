<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 03/08/2018
 * Time: 4:53 PM
 */
namespace app\swolle\lib;

class LocalRedis
{
    private static $redis;
    private function __construct()
    {
        $host = '127.0.01';
        $port = 6379;
        $password = '';
        $redis = new \Redis();
        $redis->connect($host, $port);
        $redis->auth($password);
        self::$redis = $redis;
        return self::$redis;
    }

    /**
     * @return LocalRedis|\Redis
     */
    public static function getRedis() {
        if (self::$redis instanceof \Redis) {
            return self::$redis;
        }
        return new self();
    }

    public function subscribe($channel) {
        $redis = self::getRedis();
        $redis->subscribe($channel, array($this, 'callback'));
    }

    public function publish($channel, $message) {
        self::$redis->publish($channel, $message);
    }

    public function callback($redis, $channel, $message) {

    }
}