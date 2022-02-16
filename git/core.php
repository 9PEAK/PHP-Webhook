<?php
include 'gitee.lib.php';
include 'github.lib.php';

abstract class Core
{

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


    abstract public function auth (string $key, array $header, array $body): bool;


    /**
     * 执行脚本
     * @param array $cmd 命令行数组集合
     * @return array 指令执行结果
     */
    final public function exec (array $cmd) :bool
    {
        $cmd = join (' && ', $cmd);
        strpos($cmd, '2>&1') || $cmd.=' 2>&1';
        $res = $status = null;
        echo $cmd," \n";
        exec($cmd, $res, $status);
        if ($status) {
            echo $status;
            print_r($res);
            throw new \Exception(json_encode($res));
        }
        return true;
    }

}
