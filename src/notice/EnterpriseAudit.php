<?php

namespace Lamberd\Allinpay\notice;

/**
 * 5.0.0【企业会员审核异步结果通知】
 *
 * 企业审核请以此为准(只通知一次，可通过会员信息查询接口查询会员信息)
 */
class EnterpriseAudit extends BaseNotice
{
    /**
     * 0000审核成功 其他的为审核失败
     * @var string
     */
    public string $code = '';

    /**
     * 接入方提供的系统唯一用户标识
     * @var string
     */
    public string $useId = '';

    /**
     * 用户云商通外部系统唯一标识
     * @var string
     */
    public string $yunid = '';

    /**
     * yyyy-MM-dd HH:mm:ss(企业审核通过必存在)
     * @var string
     */
    public string $checkTime = '';

    /**
     * 审核失败才存在(失败原因)
     * @var string
     */
    public string $msg = '';

    /**
     * 企业名称
     * @var string
     */
    public string $companyName = '';

    /**
     * 统一信用证
     * @var string
     */
    public string $uniCredit = '';

    /**
     * 法人身份证
     * @var string
     */
    public string $legalIds = '';

    /**
     * 法人名称
     * @var string
     */
    public string $legalName = '';

    /**
     * 法人号码
     * @var string
     */
    public string $legalPhone = '';

    /**
     * 法人对公户
     * @var string
     */
    public string $accountNo = '';

    /**
     * 开户银行名称
     * @var string
     */
    public string $parentBankName = '';

    /**
     * 支行名称
     * @var string
     */
    public string $bankName = '';

    /**
     * 支付行号
     * @var string
     */
    public string $unionBank = '';

    /**
     * 判断审核是否成功
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->code == '0000';
    }
}