<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;
use Lamberd\Allinpay\exception\ErrorException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 1.0.6【企业会员影印件上传】
 *
 * 1、不限制上传次数(可重复上传)
 * 2、ocrComparisonResultBackUrl异步通知地址以最新请求上送的为准,后请求地址将覆盖前一次请求的地址,用户需保证每次请求的异步地址相同以确保一致性
 * 3、对于未准确留存影印件的企业会员（小B）将控制交易并关闭提现功能。
 * 4、异步通知见5.0.5【影印件异步通知】接口
 * 5、影印件上传base64图片需将前缀剔除,前缀如:data:image/jpg;base64,
 */
class UploadOcr extends BaseObject
{

    public const PIC_TYPE_YYZZ = 1;
    public const PIC_TYPE_ZZJGDMZ = 2;
    public const PIC_TYPE_SWDJZ = 3;
    public const PIC_TYPE_YHKHZM = 4;
    public const PIC_TYPE_JGXYDM = 5;
    public const PIC_TYPE_ICP = 6;
    public const PIC_TYPE_HYXKZ = 7;
    public const PIC_TYPE_SFZZM = 8;
    public const PIC_TYPE_SFZFM = 9;

    const PIC_TYPE_ARRAY = [
        self::PIC_TYPE_YYZZ,
        self::PIC_TYPE_ZZJGDMZ,
        self::PIC_TYPE_SWDJZ,
        self::PIC_TYPE_YHKHZM,
        self::PIC_TYPE_JGXYDM,
        self::PIC_TYPE_ICP,
        self::PIC_TYPE_HYXKZ,
        self::PIC_TYPE_SFZZM,
        self::PIC_TYPE_SFZFM,
    ];

    const PIC_TYPE_MAP = [
        self::PIC_TYPE_YYZZ => '营业执照',// 必传
        self::PIC_TYPE_ZZJGDMZ => '组织机构代码证',// 三证时必传
        self::PIC_TYPE_SWDJZ => '税务登记证',// 三证时必传
        self::PIC_TYPE_YHKHZM => '银行开户证明',// 非必传，上传《银行开户许可 证》或《基本存款账户信息》等可证明平台银行 账号和户名的文件
        self::PIC_TYPE_JGXYDM => '机构信用代码',// 非必传
        self::PIC_TYPE_ICP => 'ICP 备案许可',// 非必传
        self::PIC_TYPE_HYXKZ => '行业许可证',// 非必传
        self::PIC_TYPE_SFZZM => '身份证正面',// 必传
        self::PIC_TYPE_SFZFM => '身份证反面',// 必传
    ];

    public function getUrl(): string
    {
        return '/yst/foreign/openMember/uploadOcr';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @link Register 调用成功返回yunid
     * @var string
     * @Assert\NotBlank()
     */
    public string $yunid = '';

    /**
     * 上传材料类型编号
     * @var int
     * @Assert\NotBlank()
     * @Assert\Choice(choices=UploadOcr::PIC_TYPE_ARRAY)
     */
    protected int $picType;

    /**
     * 影印件图片的base64码 图片大小不超过500K
     * 影印件上传base64图片需将前缀剔除,前缀如:data:image/jpg;base64,
     * @var string
     * @Assert\NotBlank()
     */
    protected string $picture = '';

    /**
     * ocr（影印件）异步通知地址（不填不通知）
     * @var string
     */
    public string $ocrComparisonResultBackUrl = '';

    /**
     * 将远程图片转码成base64
     * @param int $picType
     * @param string $picUrl
     * @param int $sizeLimit 默认500K限制
     * @return void
     * @throws ErrorException
     */
    public function setPictureInfo(int $picType, string $picUrl, int $sizeLimit = 500): void
    {
        $this->setPicType($picType);
        try {
            $this->picture = $this->getPicBase($picUrl, $sizeLimit);
        } catch (ErrorException $e) {
            throw new ErrorException(self::PIC_TYPE_MAP[$picType] . $e->getMessage());
        }
    }

    /**
     * @param int $picType
     * @throws ErrorException
     */
    protected function setPicType(int $picType): void
    {
        if (array_key_exists($picType, self::PIC_TYPE_MAP)) {
            $this->picType = $picType;
        } else {
            throw new ErrorException('无效的上传材料类型');
        }
    }
}