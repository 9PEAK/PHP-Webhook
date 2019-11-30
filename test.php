<?php

echo 'Composer!!!';
exit;

$res = null;
passthru('/data/wwwroot/huba.yun.9peak.net/test.sh', $res);

echo $res;

