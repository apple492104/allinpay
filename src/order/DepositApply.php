<?php

namespace Lamberd\Allinpay\order;

use Lamberd\Allinpay\BaseObject;

/**
 * 4.0.3【充值接口】
 *
 * 1、充值不支持信用卡
 * 2、订单同步通知见5.0.8【订单同步通知参数】接口
 * 3、订单异步通知见5.0.9【订单结果异步通知】接口
 */
class DepositApply extends BaseObject
{
    public function getUrl(): string
    {
        return '/yst/foreign/openPay/depositApply';
    }

    /**
     * 订单号
     * @var string
     */
    public string $bizOrderNo = '';

    /**
     * 消费金额(分为单位)
     * @var int
     */
    public int $amount = 0;

    /**
     * 1:微信支付(公众号) 2:支付宝支付(主扫)3:支付宝/微信/银联/手机QQ被扫
     * 5快捷支付 7微信正扫 8微信正扫-集团 9:微信小程序支付 10:微信小程序支付(集团)
     * 11银联主扫 12银联集团主扫 13支付宝支付(正扫-集团) 14微信支付(公众号-集团)
     * 15网关支付 16网关支付(集团) 17收银宝H5收银台 18收银宝H5收银台-集团 19收银宝POS当面付及订单模式支付
     * 23 收银宝手机银行APP支付 24支付宝JS 支付(生活号) 25支付宝JS 支付(生活号)-集团 26微信原生小程序支付
     * @var int
     */
    public int $payType = 0;

    /**
     * yunid(如果为平台方不传,反之必传,如若yunid与sysId同时上传，则视为充值会员余额)
     * @var string
     */
    public string $yunid = '';

    /**
     * 云商通分配的系统编号(充值到平台余额必传)
     * @var string
     */
    public string $sysId = '';

    /**
     * payType为3时必填(付款码数字)
     * @var string
     */
    public string $authcode = '';

    /**
     * payType为1，9，10，14，24，25，26时必填
     * @var string
     */
    public string $openid = '';

    /**
     * 异步结果通知地址
     * @var string
     */
    public string $backUrl = '';

    /**
     * 手续费(不传默认为0)
     * @var int
     */
    public int $fee = 0;

    /**
     * payType:8微信正扫-集团 、10微信小程序支付(集团) 、12银联集团主扫 13支付宝主扫集团模式
     * 14微信支付(公众号-集团) 16 18 25必传---收银宝子商户号 19：必传----单商户模式：收银宝单商户号;集团模式：收银宝子商户号
     * @var string
     */
    public string $vspCusid = '';

    /**
     * 微信小程序支付 appid 参数 (当payType为9或1或10或14且商户有多个小程序或公众号时接 口指定上送（非必填）)
     * @var string
     */
    public string $subAppid = '';

    /**
     * payType5 必传(payType5的用户必须使用快捷绑卡(绑卡方式7)的银行卡号,其他绑卡方式不支持) 【需转base64转码】
     * @var string
     */
    protected string $bankCardNo = '';

    /**
     * 交易验证方式[不传默认为短信验证方式](payType5可传(其他方式传与不传都不影响))
     * -----1:短信验证方式(需调用确认绑卡接口) 0:无验证方式
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
     * @var string
     */
    public string $gateid = '';

    /**
     * (payType为15、16时填写(必填))gateid 不为空时，
     * 该域只能上送 “B2C”或者“B2B”; gateid 为 空 时 ，
     * 该 域 可 以 上 送 “B2C”,“B2B”,“B2C,B2B”;
     * @var string
     */
    public string $paytype = 'B2C,B2B';

    /**
     * (选填)商品名称(base64转码)，如填写将会透传至渠道，并在用户付款账单提现，如微信账单的“商品”字段，支付宝账单的“商品说明”
     * @var string
     */
    protected string $goodsName = '';

    /**
     * 1、14非必传(微信开通点金计划需要传才能跳转到商户的页面)
     * (payType为15、16、17、18、23【17、18目前仅支持微信、支付宝、qq跳回指定页面的功能】
     * 时填写(必填))前台通知地址-支付后，跳转的前台页面 例如:www.baidu.com?1=1
     * @var string
     */
    public string $frontUrl = '';

    /**
     * 订单过期时间(yyyy-MM-dd HH:mm:ss 控制订单可支付时间，订单最长时效为24小时，即过期时间不能大于订单创建时间 24 小时；
     * 1） 需确认支付情况-确认支付时 间不能大于订单过期时间；
     * 2） 无需确认支付情况-透传至渠 道方，最大不超过 60 分钟， 控制订单支付时间范围，
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
     * @param string $bankCardNo
     */
    public function setBankCardNo(string $bankCardNo): void
    {
        $this->bankCardNo = $this->base($bankCardNo);
    }

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