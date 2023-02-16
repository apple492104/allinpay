<?php

namespace Lambert\Allinpay\Member;

use Lambert\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.1.0【确认绑卡】
 *
 * 使用绑卡方式7：快捷绑卡时，需要调用此接口
 */
class BindBankCard extends BaseObject
{

    public function getUrl(): string
    {
        return 'yst/foreign/openMember/bindBankCard';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';

    /**
     * 绑卡方式7必传
     * @var string
     */
    public string $tranceNum = '';

    /**
     * 卡号(base64转码)
     * @var string
     * @Assert\NotBlank()
     */
    protected string $cardNo = '';

    /**
     * 银行卡预留手机号
     * @var string
     * @Assert\NotBlank()
     */
    public string $phone = '';

    /**
     * 短信验证码
     * @var string
     * @Assert\NotBlank()
     */
    public string $verificationCode = '';

    /**
     * 设置银行卡
     * @param string $cardNo
     */
    public function setCardNo(string $cardNo): void
    {
        $this->cardNo = $this->base($cardNo);
    }


}