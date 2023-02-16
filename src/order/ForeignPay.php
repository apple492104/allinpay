<?php

namespace Lamberd\Allinpay\order;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 4.0.5【确认支付接口】
 *
 */
class ForeignPay extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openPay/foreignPay';
    }

    /**
     * 订单号(如余额支付的订单号/订单申请的商户订单号)
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     */
    public string $bizOrderNo = '';

    /**
     * 短信验证码（网关与h5不填，填也无效）
     * @var string
     */
    public string $code = '';
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $sysId = '';

}