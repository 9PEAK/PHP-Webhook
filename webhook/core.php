<?php

abstract class Core
{

    private static $conf, $shell;

    /**
     * G本地仓库(GET传参)
     * @param string $id
     */
    function __construct(Config $config, $shell='/bin/bash')
    {
        self::$conf = $config;
        self::$shell = $shell;
    }


    abstract protected function auth (string $key):bool;



    /**
     * 创建Shell文件
     */
//    private function shell ()
//    {
//        $file = self::$conf['dir'].'webhook.sh';
//        if (!file_exists($file)) {
//            $cmd = self::$conf['cmd'];
//            array_unshift($cmd, '#!'.self::$shell);
//            $cmd = join("\n", $cmd);
//            file_put_contents($file, $cmd);
//            chmod($file, 0110);
//        }
//    }



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



    /**
     * 检测是否正常或部署可执行
     * @return string|true
     */
    final public function handle ()
    {

        if (!@self::conf_dir()) {
            return self::error('项目文件夹未设置。');
        }

        $func = self::conf_typ();

        if (!method_exists(Git::class, $func)) {
            return self::error('暂不支持“'.$func.'”。');
        }

        $res = self::{$func}(self::conf_key());
        return $res===true ?: self::error($res);
    }



    /**
     * 执行Shell Command
     * @param string $to
     * @return array|string
     */
    public function exec ($to='string')
    {

        if (self::error()) return;

        if (self::conf_msg() && self::git_msg()!==self::conf_msg()) {
            return 'Commit Message不匹配，部署终止。';
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



    protected static function git_msg ($type=null)
    {
        $post = json_decode(file_get_contents('php://input'));
        return @$post->head_commit->message;
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
