<?php

class Core
{

    const CONFIG_FILE = 'config.php';

    protected static $conf;

    /**
     * G本地仓库(GET传参)
     * @param string $id
     */
    function __construct($id)
    {
        self::$conf = include (self::CONFIG_FILE);
        self::$conf = @self::$conf[$id] ?: false;
    }


    public function check ()
    {
        if (!self::$conf) {
            return '配置有误。';
        }

//        if (get_current_user()!=self::$conf['usr']) {
//            return '';
//        }

        if (!method_exists(static::class, self::$conf['typ'])) {
            return '暂不支持“'.self::$conf['typ'].'”。';
        }

        return self::{self::$conf['typ']}(self::$conf['key']);
    }


    public function exec ()
    {
//        $cmd = join(' && ', self::$conf['cmd']);
        //        passthru ($cmd, $cmd);
//        return $cmd;
        foreach (self::$conf['cmd'] as $i=>&$cmd) {
            passthru ($cmd, $i);
            echo "\n".$cmd." : ".$i;
        }

    }


    protected static function github ($key)
    {
        $body = file_get_contents('php://input');
        $head = getallheaders();
        $sign = "sha1=".hash_hmac('sha1', $body, $key);
        return $head['X-Hub-Signature']==$sign ? true : '非法签名。';
    }


    protected static function gitee ($key)
    {
        $head = getallheaders();
        return $head['X-Gitee-Token']==$key ? true : '非法Token。';
    }

}



if (!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}
