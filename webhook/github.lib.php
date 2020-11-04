<?php

final class Github extends Core
{

    protected function auth (string $key) :bool
    {
        $body = file_get_contents('php://input');
        $head = getallheaders();
        $sign = "sha1=".hash_hmac('sha1', $body, $key);
        return $head['X-Hub-Signature']==$sign ?: '非法签名。';
    }

}
