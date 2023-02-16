<?php

namespace Lambert\Allinpay\Member;

use Lambert\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.0.2【绑定手机】
 *
 * 1、本接口自带验证短信验证码的逻辑，因此调用本接口实现绑定会员手机时，应先调用：发送短信 验证码接，且请求参数验证码类型为“9绑定手机号”；
 * 2、测试环境验证码是人工查询，不会真实下发到手机上；
 * 3、个人/企业会员绑定手机才能创建订单，如会员未绑定手机仅可作为消费、分账的收款方。
 */
class DwAddPhone extends BaseObject
{

    public function getUrl(): string
    {
        return 'yst/foreign/openMember/dwAddPhone';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $phone = '';

    /**
     * 短信验证码(6位)
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(6)
     */
    public string $verCode = '';
}