<?php

include 'lib.inc.php';

$shell = new Core($_GET['id']);

if ($shell->test()) {
    echo $shell->error();
    print_r($shell->exec('string'));
} else {
    echo '[ERROR] '.$shell->error();
}
