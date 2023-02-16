<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.1.3【绑定银行卡查询】
 *
 * 该接口用于查询用户已绑定的某张银行卡，或已绑定的全部银行卡，响应报文支持返回多条记录。
 */
class QueryBankCard extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openMember/queryBankCard';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';

    /**
     * 卡号(base64转码)
     * @var string
     * @Assert\NotBlank()
     */
    protected string $cardNo = '';

    /**
     * @param string $cardNo
     */
    public function setCardNo(string $cardNo): void
    {
        $this->cardNo = $cardNo;
    }
}