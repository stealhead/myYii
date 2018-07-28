<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 2018/2/12
 * Time: 上午10:49
 */

namespace tests\controller\mockDatas;


class DoSomething
{
    public function getSomething() {
        $std = new \stdClass();
        $std->name = 'wang';
        return 'a';
    }
}