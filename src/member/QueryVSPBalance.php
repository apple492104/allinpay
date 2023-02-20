<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;

/**
 * 2.0.1【会员余额查询-收银宝】
 */
class QueryVSPBalance extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openAmountCategory/queryVSPBalance';
    }

    /**
     * 系统编号
     * @var string
     */
    public string $sysId = '';
}