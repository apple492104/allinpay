<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.0.1【短信发送接口】
 *
 * 1、绑定手机前调用此接口（Type=9），系统将向待绑定手机号码发送动态短信验证码。
 * 2、测试环境下，短信验证码从管理后台中查看(测试环境参数查看管理后台登录信息)
 * 3、生产环境下，短信验证码会真实发送到用户待绑定手机，管理后台不允许查看。
 * 4、解绑手机前调用此接口（Type=6），系统将向待解绑手机号码发送动态短信验证码。
 *
 */
class SendVer extends BaseObject
{
    const TYPE_UNBIND = 6;

    const TYPE_BIND = 9;

    const TYPE_ARRAY = [self::TYPE_UNBIND, self::TYPE_BIND];

    public function getUrl(): string
    {
        return '/yst/foreign/openMember/sendVer';
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
     * 9绑定手机号,6解绑手机号(不填默认为绑定手机号)
     * @var int
     * @Assert\NotBlank()
     * @Assert\Choice(choices=SendVer::TYPE_ARRAY)
     */
    public int $type = SendVer::TYPE_BIND;

}