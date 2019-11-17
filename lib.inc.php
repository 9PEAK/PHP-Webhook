<?php

class Core
{

    const CONFIG_FILE = 'config.json';

    protected static $conf;

    function __construct()
    {
        self::$conf = json_decode(file_get_contents(self::CONFIG_FILE));
    }



    protected static $post;

    public function post ()
    {

    }



    public function exec ()
    {

    }


}
