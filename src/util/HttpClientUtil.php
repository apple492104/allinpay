<?php

namespace Lambert\Allinpay\util;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Lambert\Allinpay\exception\ErrorException;
use Symfony\Component\HttpKernel\Log\Logger;

class HttpClientUtil
{
    /**
     * 发送post请求
     * @param string $url
     * @param array $params
     * @param array $option
     * @return false|string
     * @throws ErrorException
     */
    public static function post(string $url, array $params, array $option = [])
    {
        $option['form_params'] = $params;

        if (!isset($option['proxy'])) {
            if (empty(Config::getInstance()->proxy)) {
                throw new ErrorException('请配置Config信息');
            }
            $option['proxy'] = Config::getInstance()->proxy;
        }

        try {
            $client = new Client($option);
            $response = $client->request('POST', $url, $option);

            if ($response->getStatusCode() == 200) {
                return $response->getBody()->getContents();
            } else {
                return false;
            }
        } catch (GuzzleException $e) {
            if (Config::getInstance()->env == 'dev') {
                $logger = new Logger();
                $logger->error($e->getMessage());
            }
            return false;
        }
    }
}