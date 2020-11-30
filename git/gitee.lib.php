<?php

final class Gitee extends Core
{


    public function auth(string $key, array $header, array $body=[]): bool
    {
        return @$header['X-Gitee-Token']==$key;
    }


}
