<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.0.0【注册接口】
 *
 * 1、企业会员审核通过后需调1.0.6【企业会员影印件上传】接口上送图片（对于未准确留存影印件的企业会员（小B）控制交易并关闭提现功能）。
 * 2、企业会员工商要素验证：企业名称，法人姓名，法人证件号、认证类型，统一信用代码，工商注册号，纳税人识别号，组织机构代码。
 * 3、同一人仅只能注册3次(注册成功的情况下)—特殊情况需提高次数需提申请。
 * 4、企业会员异步通知见5.0.0【企业会员审核异步结果通知】接口
 */
class Register extends BaseObject
{
    const CHANGES = [1, 2, 3];

    const COMPANY_CHANGES = [1, 2];

    const CHANGES_MAP = [
        1 => '企业会员--企业',
        2 => '企业会员--事业单位',
        3 => '个人会员',
    ];

    /**
     * 应用编号
     * @var string
     * @Assert\NotBlank()
     */
    public string $sysId = '';

    /**
     * 会员类型( 企业会员(1:企业 2事业单位） 3:个人会员)
     * @var string
     * @Assert\NotBlank()
     * @Assert\Choice(choices=Register::CHANGES)
     */
    public $change = 1;


    /**
     * 用户id(接入方的用户id)
     * @var string
     * @Assert\NotBlank()
     */
    public string $useId = '';

    /**
     * 姓名(base编码后传输) 必传
     * @var string
     * @Assert\NotBlank()
     */
    protected string $name = '';

    /**
     * 身份证号(base编码后传输) 必传
     * @var string
     * @Assert\NotBlank()
     */
    protected string $identityNo = '';


    /**
     * 企业名称，如有括号，用中文格式（）(base编码后传输) 企业会员必传
     * @var string
     * @Assert\Expression("!this.isCompany() or (this.isCompany() and value != '')")
     */
    protected string $companyName = '';


    /**
     * 统一信用证 企业会员必传
     * @var string
     * @Assert\Expression("!this.isCompany() or (this.isCompany() and value != '')")
     */
    public string $uniCredit = '';

    /**
     * 法人手机号 企业会员必传
     * @var string
     * @Assert\Expression("!this.isCompany() or (this.isCompany() and value != '')")
     */
    public string $legalPhone = '';

    /**
     * 对公户账号(base编码后传输) 企业会员必传
     * @var string
     * @Assert\Expression("!this.isCompany() or (this.isCompany() and value != '')")
     */
    protected string $accountNo = '';


    /**
     * 开户银行名称 ：测试环境仅支持工农中建交。(base编码后传输) 企业会员必传
     * @var string
     * @Assert\Expression("!this.isCompany() or (this.isCompany() and value != '')")
     */
    protected string $parentBankName = '';

    /**
     * 开户行支行名称(base编码后传输) 企业会员必传
     * @var string
     * @Assert\Expression("!this.isCompany() or (this.isCompany() and value != '')")
     */
    protected string $bankName = '';

    /**
     * 支付行号，12 位数字 企业会员必传
     * @var string
     * @Assert\Length(12)
     * @Assert\Expression("!this.isCompany() or (this.isCompany() and value != '')")
     */
    public string $unionBank = '';


    /**
     * 接入方用户注册结果异步通知地址 企业会员必传
     * @var string
     * @Assert\Expression("!this.isCompany() or (this.isCompany() and value != '')")
     */
    public string $backUrl = '';

    /**
     * 判断是否是企业用户
     * @return bool
     */
    public function isCompany(): bool
    {
        return in_array($this->change, Register::COMPANY_CHANGES);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $this->base($name);
    }

    /**
     * @param string $identityNo
     */
    public function setIdentityNo(string $identityNo): void
    {
        $this->identityNo = $this->base($identityNo);
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $this->base($companyName);
    }

    /**
     * @param string $accountNo
     */
    public function setAccountNo(string $accountNo): void
    {
        $this->accountNo = $this->base($accountNo);
    }

    /**
     * @param string $parentBankName
     */
    public function setParentBankName(string $parentBankName): void
    {
        $this->parentBankName = $this->base($parentBankName);
    }

    /**
     * @param string $bankName
     */
    public function setBankName(string $bankName): void
    {
        $this->bankName = $this->base($bankName);
    }

    /**
     * 获取请求地址
     * @return string
     */
    public function getUrl(): string
    {
        return '/yst/foreign/openMember/createMember';
    }
}