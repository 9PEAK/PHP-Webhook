<?php

exit;
//echo file_get_contents('php://input');exit;

function klog ()
{
    return __FUNCTION__;

    $json = json_decode(file_get_contents('php://input'), true);

    $file = 'log.txt';
    $fp = fopen($file,'a');//打开文件资源通道 不存在则自动创建
    $json = json_encode($json)."\n";
    fwrite($fp, $json);//写入文件
    fclose($fp);//关闭资源通道
    return $json;
}

//
//try {
//    echo @klog();
//} catch (\Exception $e) {
//    echo $e->getMessage();
//}
//
//passthru('cd ../');
//passthru('ls');

//echo shell_exec('cd /data/wwwroot/crm.yun.9peak.net; sudo -u www git pull');exit;
$dir = '/data/wwwroot/huba.yun.9peak.net'; // 生产环境web目录
$cmd = 'cd '.$dir;
$cmd.= ' && git pull ';
$cmd.= ' && composer install ';
passthru($cmd);



