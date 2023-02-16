<?php

namespace Lamberd\Allinpay\util;

class SignUtil
{
    /**
     * 接口参数签名
     * 这边不考虑转码
     * @link http://doc.dev.allinpaygx.com/#/s/56586734/fFWTTcxv/ZTaayB6X
     * @param array $array
     * @return string
     */
    public static function encrypt(array $array): string
    {
        ksort($array);

        $str = '';
        foreach ($array as $key => $value) {
            if ($value) {
                $str .= "{$key}={$value}&";
            }
        }

        return md5(rtrim($str, '&'));
    }
}