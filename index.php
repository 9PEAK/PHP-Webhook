<?php

include 'lib.inc.php';

$shell = new Core($_GET['id']);

$res = $shell->check();
if ($res===true) {
    $shell->exec();
    echo '['.date('Y-m-d H:i:s').'] Success!';
} else {
    echo $res;
}
