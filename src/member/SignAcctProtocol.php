<?php

namespace Lambert\Allinpay\Member;

use Lambert\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.0.7【账户提现协议签约】
 *
 * 注一：
 * （1） 以前台 H5 页面形式进行请求，为平台端的个人会员及企业会员通过页面方式签订三方协议（会员账户、
 * 平台、通联），协议链接有效期 10 分钟。
 * （2） 签约返回字段"acctProtocolNo-账户提现协议编号"，商户端需保存。
 * （3） 签约成功提供后台异步通知；签约失败，页面提示失败原因，不提供异步通知。
 * （4） 个人会员账户提现协议签约前须完成绑定银行卡成功。
 * （5） 企业会员账户提现协议签约前须完成设置企业信息，且企业信息审核成功。
 * （6） 未签约会员账户将控制提现功能，个人会员和企业会员提现前需要签订此协议。
 * 会员类型 签约方式
 * 个人会员 向最近绑定的银行卡预留手机号发送短信验证码，并校验通过，则签约
 * 企业会员
 * 对公户提现：向企业会员绑定的手机号发送短信验证码，并校验通过，则签约
 * 法人卡提现：向法人绑定银行卡预留手机号发送短信验证码，校验通过，则签约
 *如个人会员-“户名”；企业会员-“企业名称”“法人姓名”变更后，需重新签约。
 *
 * 二:
 * 同步通知见5.0.6【账户提现协议签约重定向】接口
 * 异步通知见5.0.7【账户提现协议签约异步通知】接口
 */
class SignAcctProtocol extends BaseObject
{

    public function getUrl(): string
    {
        return 'yst/foreign/openMember/signAcctProtocol';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';

    /**
     * 签订之后，跳转返回的页面地址(如http//:1dsf?1=?,重定向会加&进行参数拼接)
     * @var string
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public string $jumpUrl = '';

    /**
     * 异步通知地址
     * @var string
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public string $backUrl = '';

    /**
     * 企业会员签约必传 1:法人私户提现签约 2:公户提现签约
     * 0:表示个人会员
     * @var int
     * @Assert\Choice({0, 1, 2})
     */
    public int $signAccType = 0;

    /**
     * 1-H5页面 2-小程序页面兼容存量模式，不上送默认跳转 H5 页面
     * @var int
     * @Assert\NotBlank()
     * @Assert\Choice({1, 2})
     */
    public int $jumpPageType = 1;
}