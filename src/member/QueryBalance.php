<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;

/**
 * 2.0.0【会员余额查询-云商通】
 */
class QueryBalance extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openAmountCategory/queryBalance';
    }

    /**
     * 云商通会员唯一标识
     * @var string
     */
    public string $yunid = '';
}