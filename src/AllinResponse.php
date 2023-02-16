<?php

namespace Lamberd\Allinpay;

use Lamberd\Allinpay\exception\ErrorException;
use Lamberd\Allinpay\util\CommonUtil;

/**
 * @example {
 * "yunid":"124139a265ab4490a1879a5e3eeaf4e8",
 * "randomstr":"5644a1cf08e8435385b7d2f1200a328d",
 * "code":"0000",
 * "sysId":"1581648210684",
 * "v":"2.0",
 * "sign":"0b7dfe735c8f0716d89f5059e2d7ed8d"
 * }
 */
class AllinResponse
{
    /**
     * 云商通会员编号
     * @var string
     */
    public string $yunid = '';

    /**
     * 0000代表成功 其他失败【4000调用服务失败】
     * @var string
     */
    public string $code = '';

    /**
     * 失败原因,失败的情况下存在
     * @var string
     */
    public string $msg = '';

    /**
     * code非4000状态必返回
     * @var string
     */
    public string $randomstr = '';

    /**
     * code非4000状态必返回
     * @var string
     */
    public string $sysId = '';

    /**
     * code非4000状态必返回
     * @var string
     */
    public string $v = '';

    /**
     * code非4000状态必返回
     * @var string
     */
    public string $sign = '';


    /**
     * 载入返回数据,生成Response对象
     * @param $data
     * @return AllinResponse
     * @throws ErrorException
     */
    public static function load($data): AllinResponse
    {
        if (is_string($data)) {
            $array = json_decode($data, true);
            if (!is_array($array)) {
                throw new ErrorException("无效的数据结构");
            }
        } else {
            $array = $data;
        }

        $response = new self();
        $keys = CommonUtil::getAllAttr($response, \ReflectionProperty::IS_PUBLIC);
        foreach ($array as $key => $value) {
            if (in_array($key, $keys)) {
                $response->{$key} = $value;
            }
        }
        return $response;
    }

    /**
     * 判断请求是否成功
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->code == '0000';
    }
}