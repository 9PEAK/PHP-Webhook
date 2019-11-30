<?php

const FILE = 'config.php';

class Core
{

    protected static $conf;
    protected static $shell;

    /**
     * G本地仓库(GET传参)
     * @param string $id
     */
    function __construct($id, $shell='/bin/bash')
    {
        self::$conf = include (FILE);
        self::$conf = @self::$conf[$id] ?: false;
        self::$shell = $shell;
    }


    /**
     * 创建Shell文件
     */
    private function shell ()
    {
        $file = self::$conf['dir'].'webhook.sh';
        if (!file_exists($file)) {
            $cmd = self::$conf['cmd'];
            array_unshift($cmd, '#!'.self::$shell);
            $cmd = join("\n", $cmd);
            file_put_contents($file, $cmd);
            chmod($file, 0110);
        }
    }




    private static $error;

    /**
     * 设置|获取报错
     * @param null $error
     * @return null
     */
    public static function error($error=null)
    {
        if (isset($error)) {
            self::$error = $error;
        } else {
            return self::$error;
        }
    }


    private static function conf ($key=null)
    {
        return $key ? @self::$conf[$key] : @self::$conf;
    }

    protected static function conf_key ()
    {
        return self::conf('key');
    }

    protected static function conf_dir ()
    {
        return self::conf('dir');
    }

    protected static function conf_msg ()
    {
        return self::conf('msg');
    }

    protected static function conf_typ ()
    {
        return self::conf('typ');
    }

    protected static function conf_cmd ()
    {
        return self::conf('cmd');
    }



    /**
     * 检测是否正常或部署可执行
     * @return string|true
     */
    public function test ()
    {
        if (!self::$conf) {
            return self::error('项目配置有误。');
        }

        if (!@self::conf_dir()) {
            return self::error('项目文件夹未设置。');
        }

        $func = self::conf_typ();

        print_r($func);
        if (!method_exists(Git::class, $func)) {
            return self::error('暂不支持“'.$func.'”。');
        }

        $res = self::{$func}(self::conf_key());
        return $res===true ?: self::error($res);
    }


    use Git;


    /**
     * 执行Shell Command
     * @param string $to
     * @return array|string
     */
    public function exec ($to='string')
    {

        if (self::error()) return;
echo 'GIT MSG: '.self::git_msg();
echo 'CONF MSG: '.self::conf_msg();
        if (self::conf_msg() && self::git_msg()!==self::conf_msg()) {
            return self::git_msg().' '.self::conf_msg();
        }

        $res = [];

        array_unshift(self::$conf['cmd'], 'cd '.self::$conf['dir']);

        foreach (self::$conf['cmd'] as $i=>&$cmd) {
            $cmd = str_replace('{$dir}', self::$conf['dir'], $cmd);
            passthru ($cmd, $i);
            $res[] = '# '.$cmd.' = '.$i;
        }

        switch ($to) {
            case 'string':
                $res = join("\n". $res);
                break;
            case 'json':
                $res = json_encode($res);
                break;
        }

        return $res;

    }

}


trait Git
{


    protected static function github ($key)
    {
        $body = file_get_contents('php://input');
        $head = getallheaders();
        $sign = "sha1=".hash_hmac('sha1', $body, $key);
        return $head['X-Hub-Signature']==$sign ?: '非法签名。';
    }


    protected static function gitee ($key)
    {
        $head = getallheaders();
        return $head['X-Gitee-Token']==$key ?: '非法Token。';
    }



    protected static function git_msg ($type=null)
    {
        $post = $body = file_get_contents('php://input');
        return @$post['head_commit']['message'];

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
