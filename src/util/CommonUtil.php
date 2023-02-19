<?php

namespace Lamberd\Allinpay\util;


use Lamberd\Allinpay\exception\ErrorException;

class CommonUtil
{
    public const TEST_BASE_URL = 'https://interfacetest.allinpaygx.com';
    public const PROD_BASE_URL = 'https://interface.allinpaygx.com';

    /**
     * @param $url
     * @param $params
     * @return false|string
     * @throws ErrorException
     */
    public static function post($url, $params, $option = [])
    {
        return HttpClientUtil::post(self::getUrl($url), self::getParams($params), $option);
    }

    /**
     * 获取请求url
     * @param $url
     * @return string
     */
    private static function getUrl($url): string
    {
        $baseUrl = Config::getInstance()->isDev() ? self::TEST_BASE_URL : self::PROD_BASE_URL;
        $baseUrl = rtrim($baseUrl, '/');
        $method = ltrim($url, '/');
        return $baseUrl . '/' . $method . '?__traceId=' . md5(uniqid());
    }

    /**
     * @throws ErrorException
     */
    private static function getParams($params)
    {
        if (empty(Config::getInstance()->key)) {
            throw new ErrorException('请配置Config信息');
        }

        foreach ($params as $key => $value) {
            if (empty($value)) {
                unset($params[$key]);
            }
        }

        $params['key'] = Config::getInstance()->key;
        $params['sign'] = SignUtil::encrypt($params);
        unset($params['key']);
        return $params;
    }

    /**
     * 获取对象的相关属性
     * @param object $object
     * @param int $filter 选择对象属性的公开类型；\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED
     * @return array
     */
    public static function getAllAttr(object $object, int $filter): array
    {

        $classRef = new \ReflectionClass($object);
        $reflectionProperty = $classRef->getProperties($filter);
        $array = [];
        foreach ($reflectionProperty as $property) {
            $array[] = $property->name;
        }
        return $array;
    }
}