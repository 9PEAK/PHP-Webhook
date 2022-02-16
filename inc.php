<?php

/**
 * 获取HTTP请求头部
 * @return array
 */
function req_header () :array
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
 * @return string
 */
function req_body ()
{
    return file_get_contents('php://input');
}

/**
 * 获取Object或Array格式的HTTP请求内容
 * @param bool $toArray 默认false 返回Object 否则Array
 * @return mixed
 */
function req_body_mixed (bool $toArray=false)
{
    return json_decode(req_body(), $toArray);
}
