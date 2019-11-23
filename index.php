<?php

include 'lib.inc.php';

$shell = new Core($_GET['id']);

$res = $shell->check();
if ($res===true) {
    $shell->exec();
} else {
    echo '[ERROR] '.$res;
}
