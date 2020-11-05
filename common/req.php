<?php

/**
 * 获取HTTP请求头部
 * @return array
 */
function req_header ()
{

    if (function_exists('getallheaders')) {
        return getallheaders();
    }
    $headers = [];
    foreach ($_SERVER as $key => $val) {
        if (substr($key, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))] = $val;
        }
    }
    return $headers;

}


/**
 * 获取HTTP请求主体
 * @param string $key 参数名，允许使用“.”作为层级连接符，例如person.name表示获取person参数下的name参数；默认空，已数组形式返回所有参数。
 * @return mixed Object或int或string
 */
function req_body ($key='')
{
    $post = json_decode(file_get_contents('php://input'));
    if ($key ) {
        $key = explode('.', $key);
        foreach ($key as &$k) {
            $post = @$post->$k;
        }
    }
    return $post;
}
