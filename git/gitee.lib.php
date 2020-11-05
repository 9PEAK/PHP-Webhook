<?php

final class Gitee extends Core
{


    public function auth(string $key, array $header, array $body=null): bool
    {
        return @$header['X-Gitee-Token']==$key;
    }


}
