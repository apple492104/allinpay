<?php

namespace Lambert\Allinpay\order;

use Lambert\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 4.0.6【平台转账接口】
 *
 * 1、无异步通知,同步通知为准
 * 2、订单详情可根据3.0.0【订单查询接口】查询
 */
class Ptzz extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openPay/ptzz';
    }

    /**
     * 商户系统转账订单号
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     */
    public string $bizOrderNo = '';

    /**
     * 源账户集编号
     * @var string
     * @Assert\NotBlank()
     */
    public string $sourceAccountSetNo = '';

    /**
     * 收款会员的yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';

    /**
     * 金额(分为单位)
     * @var int
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value=0)
     */
    public int $amount = 0;
}