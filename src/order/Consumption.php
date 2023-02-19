<?php

namespace Lamberd\Allinpay\order;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 4.0.0【消费接口(1)-标准版】
 *
 * 1、支持分账，但分账出去的资金不支持原路退款，退款金额由收款会员全额承担。
 * 2、订单同步通知见5.0.8【订单同步通知参数】接口
 * 3、订单异步通知见5.0.9【订单结果异步通知】接口
 *
 */
class Consumption extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openPay/consumption';
    }

    /**
     * 商户订单号
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     */
    public string $bizOrderNo = '';

    /**
     * 消费金额(分为单位) 订单金额=分账列表总金额+手续费
     * @var int
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value=0)
     */
    public int $amount = 0;

    /**
     * 支付方式，目前只支持网关支付
     * 15网关支付 16网关支付(集团)
     */
    public int $payType = 15;

    /**
     * 需分账时必填(最多支持10个)
     * @var array
     */
    public array $arrJson = [];

    /**
     * 异步结果通知地址
     * @var string
     * @Assert\NotBlank()
     */
    public string $backUrl = '';

    /**
     * 收款者yunid(如果为平台方不传, 反之必传, 如若yunid与sysId同时上传，则视为付款给会员)
     * @var string
     */
    public string $yunid = '';

    /**
     * 云商通分配的系统编号(收款者为平台方必传)
     * @var string
     */
    public string $sysId = '';

    /**
     * 手续费(不传默认为0）
     * @var int
     */
    public int $fee = 0;

    /**
     * 交易验证方式[不传默认为短信验证方式](payType5可传(其他方式传与不传都不影响))
     * 1:短信验证方式(需调用确认绑卡接口)
     * 0:无验证方式
     * @var int
     */
    public int $validateType = 0;

    /**
     * 摘要（base64转码）
     * @var string
     */
    protected string $summary = '';

    /**
     * (payType为15、16时填写(选填))银行代码
     * (不填时，跳转至通联网关页面，提供银行列表供用户选择反之调到银行网关页面)
     * 【https://aipboss.allinpay.com/know/devhelp/main.php?pid=13附录】
     * 该字段不填，直接跳转到通联网关页面
     * @var string
     */
    protected string $gateid = '';

    /**
     * (payType为15、16时填写(必填))gateid 不为空时，该域只能上送 “B2C”或者“B2B”;
     * gateid 为 空 时 ， 该 域 可 以 上 送 “B2C”, “B2B”, “B2C, B2B”;
     */
    public string $paytype = 'B2C,B2B';

    /**
     * (payType为15、16时填写(选填))商品名称(base64转码)
     * @var string
     */
    protected string $goodsName = '';

    /**
     * payType为1、14非必传(微信开通点金计划需要传才能跳转到商户的页面，回调参数见2.0.4.1接口)
     * (payType为15、16、17、18、23【17、18目前仅支持微信、支付宝、qq跳回指定页面的功能】时填写(必填))前台通知地址-支付后，跳转的前台页面 例如:www.baidu.com?1 = 1
     * @var string
     */
    public string $frontUrl = '';

    /**
     * 订单过期时间(yyyy-MM-dd HH:mm:ss 控制订单可支付时间，订单最长时效为 24 小时，即过期时间不能大 于订单创建时间 24 小时；
     * 1） 需确认支付情况-确认支付时 间不能大于订单过期时间；
     * 2） 无需确认支付情况-透传至渠道方，最大不超过60分钟， 控制订单支付时间范围，
     * 下述支付方式有效:
     * 微信正扫： SCAN_WEIXIN、 SCAN_WEIXIN_ORG
     * 支付宝正扫： SCAN_ALIPAY、 SCAN_ALIPAY_ORG
     * 银联正扫： SCAN_UNIONPAY、 SCAN_UNIONPAY_ORG
     * 微信公众号： WECHAT_PUBLIC、 WECHAT_PUBLIC_ORG
     * 微信小程序： WECHATPAY_MINIPROGRAM、 WECHATPAY_MINIPROGRAM_ ORG
     * 微信原生 APP： WECHATPAY_APP_OPEN)
     * @var string
     */
    public string $orderExpireDatetime = '';

    /**
     * @param string $summary
     */
    public function setSummary(string $summary): void
    {
        $this->summary = $this->base($summary);
    }

    /**
     * @param string $goodsName
     */
    public function setGoodsName(string $goodsName): void
    {
        $this->goodsName = $this->base($goodsName);
    }
}