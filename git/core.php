<?php
include 'gitee.lib.php';
include 'github.lib.php';

abstract class Core
{

    private static $conf;


    const TYPE = [
        'gitee' => Gitee::class,
        'github' => Github::class,
    ];

    static function factory ($type) :self
    {
        if ($cls=@self::TYPE[$type]) {
            return new $cls;
        }
        throw new Exception('暂不支持当前GIT仓库：'.$type.'。');
    }


    abstract public function auth (string $key, array $header, array $body=null):bool;


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



    /**
     * 执行脚本
     * @param array $cmd 命令行数组集合
     * @param string $dir 项目所在文件夹，所有指令执行前将先进入该文件夹，并替换$cmd指令中{$dir}的部分，默认空，表示不执行上述规则、直接执行$cmd指令。
     * @return array 指令执行结果
     */
    final public function exec (array $cmd, $dir='')
    {

        $res = [];

        array_unshift($cmd, 'cd '.self::$conf['dir']);
        foreach ($cmd as $i=>&$shell) {
            $shell = str_replace('{$dir}', $dir, $shell);
            passthru ($shell, $i);
            $res[] = '['.$i.'] '.$shell;
        }

        return $res;

    }

}