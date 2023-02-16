<?php

namespace Lamberd\Allinpay\notice;

use Lamberd\Allinpay\exception\ErrorException;
use Lamberd\Allinpay\util\CommonUtil;
use Lamberd\Allinpay\util\SignUtil;

abstract class BaseNotice
{
    /**
     * yyyyMMddHHmmss
     * @var string
     */
    public string $timestamp = '';


    /**
     * 版本号
     * @var string
     */
    public string $v = '';

    /**
     * @var string
     */
    public string $sign = '';

    protected array $attributes = [];

    /**
     * 前面校验
     * @throws ErrorException
     */
    public static function signCheck(array $params, string $key): void
    {
        if (!isset($params['sign'])) {
            throw new ErrorException('缺少sign参数，无法确认数据正确性');
        }

        $sign = $params['sign'];
        $params['key'] = $key;
        $newSign = SignUtil::encrypt($params);
        if ($newSign != $sign) {
            throw new ErrorException('签名校验失败，无法确认数据正确性');
        }
    }

    /**
     * 加载异步通知数据
     * @param array $params 异步返回参数
     * @param string $key 秘钥
     * @return static
     * @throws ErrorException
     */
    public static function load(array $params, string $key): static
    {
        self::signCheck($params, $key);

        $object = new static();
        $attributes = CommonUtil::getAllAttr($object, \ReflectionProperty::IS_PUBLIC);
        $object->setAttributes($attributes);
        foreach ($params as $key => $value) {
            if (in_array($key, $attributes)) {
                $object->{$key} = $value;
            }
        }
        return $object;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}