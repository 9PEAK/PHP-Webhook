<?php

final class Github extends Core
{

    public function auth (string $key, array $header, $body='') :bool
    {
        $key = 'sha1='.hash_hmac('sha1', $body, $key);
        return @$header['X-Hub-Signature']==$key;
    }

}
