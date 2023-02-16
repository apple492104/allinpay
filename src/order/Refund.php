<?php

namespace Lambert\Allinpay\order;

use Lambert\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 4.0.7【退款接口】
 *
 * 1、支持退款的订单：消费接口（1）标准版、消费接口（2）、充值、及平台转账接口的订单。
 * 2、发起退款时，请确保退款账户或中间账户（原订单收款账户）中有足够的可用余额；支持全额退款、部分金额退款，但退款金额不得超过原订单金额。
 * 3、通过消费接口（1）标准版的订单有分账的的情况下退款，需要原订单收款方承担分账资金。
 * 4、退款时 amount 是本次退款总金额，fee是平台需支付的手续费退款金额
 * A-平台不退手续费，退款 amount 需小于等于原支付单的 amount 减去 fee 的值；fee不填
 * B-平台退手续费，退款 amount 需小于等于原支付单的 amount，退款时 fee 需小于等于原支付单的 fee
 * 5、订单异步通知见5.0.9【订单结果异步通知】接口
 * 6、“refundAccount-退款资金账户”字段，当客户上送时，系统自动从通联通调拨退款资金到收银宝用于退款的功能，无论资金调拨是否成功均会向收银宝发起订单退款并新增响应“transferStatus-资金退款调拨状态”“transferAmount调拨金额”。说明：
 * （1）商户用这个功能，无需配置支付通道（使用原支付通道）。
 * （2）“通联通管理”资金管理模式的商户用此功能，“refundAccount-退款资金账户”字段支持上送“TLT”，系统自动从通联通调拨资金回收银宝（调拨资金=收银宝交易待退款金额），无论调拨成功、失败，均请求收银宝【交易退款】接口完成退款。
 * （3）上送“refundAccount-退款资金账户”字段，会影响通联通资金变动，为了避免提现时因通联通余额不足而导致提现失败，商户需要根据收银宝余额真实情况，上送此字段。
 * （4）接口响应字段增加“调拨状态”和“调拨金额”字段
 */
class Refund extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openPay/refund';
    }

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $sysId = '';

    /**
     * 商户订单号
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     */
    public string $bizOrderNo = '';

    /**
     * 原订单号（如果为消费接口(2)/分账接口的订单，都传消费接口(2)的订单号）
     * @var string
     * @Assert\NotBlank()
     */
    public string $oriBizOrderNo = '';

    /**
     * 退款金额(分为单位)【定时类型为消费(2)【代收】中金额等于订单总金额,refundList无效，视为全额退款【不管是否全额分账、部分分账、未分账】
     * @var int
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value=0)
     */
    public int $amount = 0;

    /**
     * 退款异步结果通知接口url
     * @var string
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public string $backUrl = '';

    /**
     * 手续费退款金额(不传默认为0，如为 0，则不退手续费。)
     * @var int
     * @Assert\NotBlank()
     */
    public int $fee = 0;

    /**
     * 退款资金账户
     * 【仅支持通联通存管模式上送：TLT 上送此字段，收银宝待结算资金不足的情况，则从通联通资金调拨回收银宝，实现退款。 未上送此字段或为空，则维持原功能】
     * @var string
     */
    public string $refundAccount;

    /**
     * 消费接口/分账接口(托管代收)订单中的收款人的退款金额等信息
     * [非消费接口2/分账接口付款类型,不处理该字段]
     * (消费接口二/分账接口全额退款无须需上送，仅退手续费无需上送如需上送不能留空数组，refundList内的amount填写0或空即可，
     * 部分退款且非仅退手续费的时候必须上送
     * 【意思为消费接口(2)收款成功，未使用分账接口或已使用分账接口分账出去（含部分分账-未全额分账出去）要部分退款必须上传】)
     * 此字段总金额=amount-fee,最多支持100个
     * @var array
     */
    public array $refundList;
}