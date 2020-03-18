<?php
/**
 * Created by PhpStorm.
 * User: gang
 * Date: 23/08/2018
 * Time: 12:40 PM
 */

fwrite(STDOUT, "ENTER your name\n");

$name = fgets(STDIN);

fwrite(STDOUT, "Hello, $name!");