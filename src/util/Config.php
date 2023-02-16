<?php

namespace Lambert\Allinpay\util;

class Config
{
    public string $env = '';

    public string $key = '';

    public string $proxy = '';

    private function __construct(){}

    private function __clone(){}

    /**
     * 单件实例
     * @var Config|null
     */
    private static ?Config $instance = null;

    /**
     * 返回此单件实例。
     * @return Config
     */
    public static function getInstance(): Config
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * 重置此单件实例
     */
    public static function reset(): void
    {
        self::$instance = null;
    }
}