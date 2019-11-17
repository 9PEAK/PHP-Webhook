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
            return -1;
        }
        if (get_current_user()!=self::$conf['usr']) {
            return -2;
        }
        return self::{self::$conf['typ']}(self::$conf['key']);
    }


    public function exec ()
    {
        $cmd = join(' && ', self::$conf['cmd']);
        passthru ($cmd, $cmd);
        return $cmd;
    }


    protected static function github ($key)
    {
        $body = file_get_contents('php://input');
        $head = getallheaders();
        $sign = "sha1=".hash_hmac('sha1', $body, $key);
        return $head['X-Hub-Signature']==$sign;
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
