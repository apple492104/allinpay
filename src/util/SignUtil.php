<?php

namespace Lamberd\Allinpay\util;

class SignUtil
{
    /**
     * 接口参数签名
     * @param array $array
     * @return string
     */
    public static function encrypt(array $array): string
    {
        unset($array['sign']);
        ksort($array);

        $str = '';
        foreach ($array as $key => $value) {
            $str .= "{$key}={$value}&";
        }

        return md5(rtrim($str, '&'));
    }
}