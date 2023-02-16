<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.1.1【公户绑定】
 *
 * 校验会员已绑定对公户数量，最多可绑定 10 个绑定状态“已绑定”的企业对公户；
 * 支持提现到已绑定的指定的对公户
 */
class BindCompanyAccount extends BaseObject
{
    public function getUrl(): string
    {
        return '/yst/foreign/openMember/bindCompanyAccount';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';

    /**
     * 公户账号(base64转码)
     * @var string
     */
    protected string $accountNo = '';

    /**
     * 开户银行名称(base64转码)
     * @var string
     */
    protected string $parentBankName = '';

    /**
     * 开户行支行名称(base64转码)
     * @var string
     */
    protected string $bankName = '';

    /**
     * 支付行号，12 位数字
     * @var string
     */
    public string $unionBank = '';

    /**
     * @param string $accountNo
     */
    public function setAccountNo(string $accountNo): void
    {
        $this->accountNo = $this->base($accountNo);
    }

    /**
     * @param string $parentBankName
     */
    public function setParentBankName(string $parentBankName): void
    {
        $this->parentBankName = $this->base($parentBankName);
    }

    /**
     * @param string $bankName
     */
    public function setBankName(string $bankName): void
    {
        $this->bankName = $this->base($bankName);
    }

}