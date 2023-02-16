<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.0.9【申请绑卡】
 *
 * 个人用户必须先完成注册才能绑定银行卡，且接口(生产环境)请求参数（姓名和证件号码）必须与注册时的信息一致，验证与注册信息是同人银行卡，且银行卡真实有效。
 * 个人用户默认允许绑定多张银行卡，具体配置信息可与通商云业务人员确认。
 * 企业用户最多只允许绑定一张法人的个人银行卡，支持通过【解绑绑定银行卡】接口解绑。
 * 企业用户如需提现到个人银行账户，可调用此接口绑定银行卡。
 * 调用申请绑卡接口，此接口会自动发送短信验证码。
 * 绑卡方式7真实校验身份信息，需是注册会员本人(或法人)卡
 * 绑卡方式8有挡板，非真实校验，推荐使用卡号:6210980200722062
 */
class ApplyBindBankCard extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openMember/applyBindBankCard';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';
    /**
     * 卡号（base64转码）
     * @var string
     */
    protected string $cardNo = '';

    /**
     * @var string
     */
    public string $phone = '';

    /**
     * 绑卡方式1：3要素绑卡(不支持贷记卡)
     * 绑卡方式7：快捷绑卡(部分银行、支持支付及提现) ,绑卡方式7调用成功后还需要调用1.1.0【确认绑卡】接口
     * 绑卡方式8：万鉴通绑卡(所有银行、只支持用于提现) , 绑卡方式8则不需要
     * @var string
     * @Assert\NotBlank()
     * @Assert\Choice({1,7,8})
     */
    public int $cardCheck = 1;

    /**
     * 有效期格式为月年；如 0321，2位月2位年(信用卡必传(绑卡方式8可不传))
     * @var string
     */
    public string $validate = '';

    /**
     * cvv2信用卡必传(绑卡方式8可不传)
     * @var string
     */
    public $cvv2 = '';

    /**
     * @param string $cardNo
     */
    public function setCardNo(string $cardNo): void
    {
        $this->cardNo = $cardNo;
    }
}