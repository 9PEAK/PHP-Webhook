<?php

include 'lib.inc.php';

$shell = new Core($_GET['id']);

$res = $shell->check();
if ($res===true) {
    print_r($shell->exec('string'));
} else {
    echo '[ERROR] '.$res;
}
