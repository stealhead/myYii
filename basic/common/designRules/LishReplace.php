<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 18/09/2018
 * Time: 9:26 PM
 */
// 里氏替换
// 原则，父类可以完成的工作，子类都可以完成
class Father
{
    public function eat() {
        echo "i can eat";
    }
}

class Son extends Father {

}

class Behavior {
    public function eat(Father $father) {
        $father->eat();
    }
}

$b = new Behavior();
$father = new Father();
$b->eat($father);

$son = new Son();
$b->eat($son);