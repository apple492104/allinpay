<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.1.2【解绑绑定银行卡】
 *
 * 如需解绑银行卡，直接调用该接口，无需调用其它接口进行确认。
 * 支持解绑个人会员绑定的银行卡和企业会员绑定的法人银行卡。
 */
class UnbindBankCard extends BaseObject
{
    public function getUrl(): string
    {
        return '/yst/foreign/openMember/unbindBankCard';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';

    /**
     * 解绑卡号(base64转码)
     * @var string
     * @Assert\NotBlank()
     */
    protected string $cardNo = '';

    /**
     * @param string $cardNo
     */
    public function setCardNo(string $cardNo): void
    {
        $this->cardNo = $this->base($cardNo);
    }
}