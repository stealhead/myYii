<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 2018/2/9
 * Time: 下午5:27
 */

namespace tests;


use tests\controller\DoSomething;
use PHPUnit\Framework\TestCase;

class Calculate extends TestCase
{
    public function testA() {
        $a = 'a
        b  
        c';
        $b = preg_replace('/\s+/', ',', $a);
        var_dump($b);
    }

    public function testB() {
//        $stub = $this->createMock(DoSomething::class);
        $stub = $this->getMockBuilder(DoSomething::class)
            ->getMock();
        $stub->method('getSomething')
            ->willReturn('a');
        $this->assertEquals('a', $stub->getSomething);
    }



    public function additionProvider() {
        return [
            [1,2,3]
        ];
    }
}