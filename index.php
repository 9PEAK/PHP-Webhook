<?php

include 'common/config.php';
include 'common/req.php';
include 'git/core.php';


try {
    # 初始化获取配置
    $config = @include('repo.conf.php');
    if (!$config = @$config[$_GET['id']]) {
        throw new Exception('Webhook未配置。');
    }
    $config = Config::set($config);

    # 根据GIT消息判断是否执行部署
    if (!@$config->msg || trim(req_body('head_commit.message'))!=$config->msg) {
        return print('无需部署。');
    }

    # 创建处理器
//    if (!$git = Core::factory($config->typ)) {
//        throw new Exception('暂不支持该GIT仓库。');
//    }

    # 创建处理器、校验KEY、执行脚本
    $git = Core::factory($config->typ);
    if (!$git->auth($config->key, req_header(), (array)req_body())) {
        throw new Exception('KEY校验失败。');
    }

    $res = $git->exec($config->cmd, @$config->dir);

    echo '[SUCCESS] 执行完毕：<br>';
//    print_r($res);

} catch (Exception $e) {

//    echo '[ERROR CODE] '.$e->getCode(), '<br>';
    echo '[ERROR] '.$e->getMessage();
}
