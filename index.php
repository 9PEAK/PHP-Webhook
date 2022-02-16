<?php

include 'inc.php';
include 'git/core.php';
include 'vendor/autoload.php';

$log = new Katzgrau\KLogger\Logger(__DIR__.'/logs');

try {
    # 初始化获取配置
    $config = @include('config.php');
    if (!$config = @$config[$_GET['id']]) {
        throw new Exception('Webhook未配置。');
    }

    # 创建处理器
    if (!$git = Core::factory($config['typ'])) {
        throw new Exception('暂不支持该GIT仓库：'.$config['typ'].'。');
    }

//    $header = req_header();
//    $log->info('head' );
//    $log->info(@$header['X-Hub-Signature'] );
////    $body = req_body();
//    $body = file_get_contents('php://input');
//    if (strpos($body, 'payload=') === 0) {
//        $log->info('body 转化');
//        $body = substr($body, 8);
//    }
//    $log->info('body');
//    $log->info(json_encode($body) );
//    $sign = 'sha1='.hash_hmac('sha1', is_string($body) ? $body : json_encode($body), '702F05186DC10B740604D923E5BAE669');
////    $sign = 'sha1='.sha1('702F05186DC10B740604D923E5BAE669'. json_encode($body));
//    $log->info('签名： '. $sign);


    # 校验KEY
    if (!$git->auth($config['key'], req_header(), req_body())) {
        throw new Exception('KEY校验失败。');
    }

    # 执行脚本
    $res = $git->exec($config['cmd']);

    echo "\n [SUCCESS] 执行完毕：";

    $log->info('成功。');

} catch (Exception $e) {

    echo '[ERROR] '.$e->getMessage();
    $log->info($e->getMessage());
}
