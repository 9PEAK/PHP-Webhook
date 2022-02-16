<?php

include 'inc.php';
include 'git/core.php';
include 'vendor/autoload.php';

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

    # 校验KEY
    if (!$git->auth($config['key'], req_header(), req_body())) {
        throw new Exception('KEY校验失败。');
    }

    # 执行脚本
    $res = $git->exec($config['cmd']);

    $msg = '[SUCCESS] 执行完毕： ';


} catch (Exception $e) {

    $msg = '[ERROR] '.$e->getMessage();
}

echo "\n ",$msg;

if (!$_GET['log']) exit;
$log = new Katzgrau\KLogger\Logger(__DIR__.'/logs');
$log->info('请求 HEADER ', req_header());
$log->info('请求 BODY ');
$log->info(req_body());
@$e ? $log->alert($msg) : $log->info($msg);
