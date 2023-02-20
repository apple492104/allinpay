<?php

namespace Lamberd\Allinpay\order;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 4.0.4【提现接口】
 *
 * 创建提现订单需要先绑定手机。
 * 企业会员提现交易，默认使用企业对公账户。如需提现到个人银行卡，可通过绑定银行卡相关接口绑定个人银行账户，企业会员最多只允许绑定一张法人个人银行卡。
 * 测试环境提现不会真实到账。
 * 订单同步通知见5.0.8【订单同步通知参数】接口
 * 订单异步通知见5.0.9【订单结果异步通知】接口
 */
class WithdrawApply extends BaseObject
{

    public function getUrl(): string
    {
        return 'yst/foreign/openPay/withdrawApply';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     */
    public string $yunid = '';

    /**
     * 云商通编号(yunid与sysId两者必填一个，两者都存在已yunid为准进行会员提现(传yunid为进行会员提现,sysId为平台提现))
     * @var string
     */
    public string $sysId = '';

    /**
     * 平台提现必传(平台对应账户集编号,入网时分配)
     * @var string
     */
    public string $accountSetNo = '';

    /**
     * 手续费(不传默认为0，单位：分，如 amount 为 100，fee 为 2，实际 到账金额为 98，平台手续费收入为 2)
     * @var int
     */
    public int $fee = 0;

    /**
     * 1(若为企业会员提现到个人卡必填1)
     * @var string
     */
    public string $bankCardPro = '';

    /**
     * 商户订单号
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     */
    public string $bizOrderNo = '';

    /**
     * 金额(分为单位)
     * @var int
     * @Assert\NotBlank()
     */
    public int $amount = 0;

    /**
     * 0：无验证 1短信验证(1:需调用4.0.5确认支付接口)
     * @var int
     */
    public int $validateType = 0;

    /**
     * 异步结果通知地址
     * @var string
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public string $backUrl = '';

    /**
     * 提现方式(D0、D0customized、D1和T1customized) D0：D+0 到账 D1：D+1 到账 T1customized：T+1 到账，仅工作日代付
     * @var string
     */
    public string $withdrawType = 'D0';

    /**
     * 卡号(base64转码)
     * @var string
     * @Assert\NotBlank()
     */
    protected string $bankCardNo = '';

    /**
     * 摘要(最长支持20个字符-base64转码)
     * @var string
     */
    protected string $summary = '';

    /**
     * 设置卡号
     * @param string $bankCardNo
     */
    public function setBankCardNo(string $bankCardNo): void
    {
        $this->bankCardNo = $this->base($bankCardNo);
    }

    /**
     * 设置摘要，最多20字符
     * @param string $summary
     */
    public function setSummary(string $summary): void
    {
        $this->summary = $this->base($summary);
    }
}