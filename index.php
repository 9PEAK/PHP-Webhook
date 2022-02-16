<?php

include 'common/req.php';
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
        throw new Exception('暂不支持该GIT仓库。');
    }

    $log->info(req_header());
    $log->info((array)req_body());

    # 校验KEY
    if (!$git->auth($config['key'], req_header(), (array)req_body())) {
        throw new Exception('KEY校验失败。');
    }

    # 执行脚本
    $res = $git->exec($config['cmd']);

    echo "[SUCCESS] 执行完毕：\n";

} catch (Exception $e) {

//    echo '[ERROR CODE] '.$e->getCode(), '<br>';
    echo '[ERROR] '.$e->getMessage();
}
