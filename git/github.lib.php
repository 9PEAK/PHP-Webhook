<?php

final class Github extends Core
{

    public function auth (string $key, array $header, array $body=[]) :bool
    {
        $key = 'sha1='.hash_hmac('sha1', json_encode($body), $key);
        return $header['X-Hub-Signature']==$key;
    }

}
