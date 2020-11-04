<?php

final class Gitee extends Core
{

    protected function auth (string $key) :bool
    {
        $head = getallheaders();
        return $head['X-Gitee-Token']==$key ?: '非法Token。';
    }


}
