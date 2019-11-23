<?php

include 'lib.inc.php';

$shell = new Core($_GET['id']);

$res = $shell->check();

echo $res===true ? $shell->exec() : '[ERROR] '.$res;
