<?php

//echo 'Composer!!!';
//exit;

$cmd = '/data/wwwroot/huba.yun.9peak.net/test.sh';

$res = [];
$code = 0;
exec($cmd, $res, $code);

print_r($res);
echo $code;
//echo exec('env');
//$res = null;
//passthru($cmd, $res);
//echo $res;


