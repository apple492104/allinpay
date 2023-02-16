<?php

namespace Lambert\Allinpay\notice;

/**
 * 5.0.9【订单结果异步通知】
 */
class OrderNotice extends BaseNotice
{
    /**
     * “OK”标识支付成功； “error”表示支付失败； 提现在成功和失败时都会通知 商户；其他订单只在成功时会通 知商户。
     * @var string
     */
    public string $status = '';

    /**
     * 订单支付失败原因
     * @var string
     */
    public string $message = '';

    /**
     * 商户系统用户标识，商户系统中唯一编号。付款人
     * @var string
     */
    public string $buyerBizUserId = '';

    /**
     * 商户订单号
     * @var string
     */
    public string $bizOrderNo = '';


    public int $amount = 0;

    /**
     * 通商云订单支付完成时间 yyyy-MM-dd HH:mm:ss
     * @var string
     */
    public string $payDatetime = '';


    public string $sysId = '';

    /**
     * VSP501 微信支付
     * VSP502 微信支付撤销
     * VSP503 微信支付退款
     * VSP505 手机 QQ 支付
     * VSP506 手机 QQ 支付撤销
     * VSP507 手机 QQ 支付退款
     * VSP511 支付宝支付
     * VSP512 支付宝支付撤销
     * VSP513 支付宝支付退款
     * VSP551 银联扫码支付
     * VSP552 银联扫码撤销
     * VSP553 银联扫码退货
     *
     * @var string
     */
    public string $payInterfacetrxcode = '';

    /**
     * 云商通分公司订单号
     * @var string
     */
    public string $systemOrder = '';

    /**
     * 支付人帐号
     * @var string
     */
    public string $acct = '';

    /**
     * 刷卡消费交易必传 00-借记卡 01-存折 02-信用卡 03-准贷记卡 04-预付费卡 05-境外卡 99-其他
     * @var string
     */
    public string $accttype = '';

    /**
     * 终端号
     * @var string
     */
    public string $termno = '';

    /**
     * 渠道商户号
     * @var string
     */
    public string $cusid = '';

    /**
     * 渠道手续费
     * @var string
     */
    public string $channelFee = '';

    /**
     * 单品优惠透传的优惠信息【优惠存在必传】
     * @var string
     */
    public string $chnldata = '';

    /**
     * 支付渠道的交易流水号，微信订单详情“商户单号”，支付宝订 单详情“商家订单号 走收银宝渠道-对应收银宝接口指定 trxid
     * @var string
     */
    public string $payInterfaceOutTradeNo = '';

    /**
     * 终端授权码-------仅微信支付返回付款银行卡所属银行跟借贷标记，如CMB_CREDIT，在商户与银行联合做营销活动时，可根据所属银行跟借贷标记判断用户是否享受活动权益。
     * @var string
     */
    public string $termauthno = '';

    /**
     * 响应对方服务器，返回成功信息
     * @return string
     */
    public function success(): string
    {
        return 'success';
    }

    /**
     * 响应对方服务器，返回失败信息
     * @return string
     */
    public function fail(): string
    {
        return 'fail';
    }
}