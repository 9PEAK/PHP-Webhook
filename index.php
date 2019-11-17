<?php

include 'lib.inc.php';

$shell = new Core($_GET['id']);
if ($shell->check()) {
    $shell->exec();
    echo 'Success';
}
