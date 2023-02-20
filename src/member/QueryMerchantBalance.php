<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;

/**
 * 2.0.2【平台余额查询】
 */
class QueryMerchantBalance extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openAmountCategory/queryMerchantBalance';
    }

    /**
     * @var string
     */
    public string $sysId='';

    /**
     * 平台标准账户集编号(入网后分配)
     * @var string
     */
    public string $accountSetNo='';
}