<?php

class Config
{


    private function __construct(){}

    private static $singleton;


    /**
     * 设置参数并返回单例对象
     * @param array $param 参数集合
     */
    static function set (array $param) :self
    {
        self::$singleton || self::$singleton=new self;
        foreach ($param as $key=>$val) {
            self::$singleton->{$key} = $val;
        }
        return self::$singleton;
    }


    public $key, $dir, $typ, $cmd;


}
