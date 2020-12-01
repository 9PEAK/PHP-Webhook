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
     * @return array 指令执行结果
     */
    final public function exec (array $cmd) :bool
    {
        $cmd = join (' && ', $cmd);
        $res = $status = null;
        exec($cmd, $res, $status);
        if ($status) {
            throw new \Exception(json_encode($res));
        }

        return true;

//        $res = [];
        array_unshift($cmd, 'cd '.$dir);
        foreach ($cmd as $i=>&$shell) {
            $shell = str_replace('{$dir}', $dir, $shell);
//            $res[$shell] = null;
            $res = $status = null;
            exec($shell, $res, $status);
//            print_r($res);
            $status && print('指令出错：'.$shell);
//            $res[] = '['.$i.'] '.$shell;
        }

        return $cmd;

    }

}
