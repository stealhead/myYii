<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 18/09/2018
 * Time: 11:58 AM
 */
// 依赖倒置
interface Person
{
    public function say();
}

class Student implements Person
{
    public function say() {
        echo "i am student\n";
    }
}

class Teacher implements Person
{
    public function say() {
        echo "i am teacher\n";
    }
}


class SayWord
{
    public function word(Person $person) {
        $person->say();
    }
}

$say = new SayWord();
$person = new Student();
$say->word($person);