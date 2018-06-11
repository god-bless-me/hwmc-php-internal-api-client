<?php

namespace PdInternalApi;

/**
 * 签名
 * @param $params
 * @param $key
 * @return string
 */
function sign($params, $key)
{
    unset($params['sign']);
    ksort($params);
    $str = http_build_query($params, null, '&');
    return md5($str . $key);
}