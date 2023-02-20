<?php

namespace Lamberd\Allinpay\Member;

use Lamberd\Allinpay\BaseObject;

/**
 * 1.1.6【会员信息查询接口】
 *
 * 该接口支持查询个人会员、企业会员。
 */
class MemInfoQuery extends BaseObject
{

    public function getUrl(): string
    {
        return '/yst/foreign/openMember/memInfoQuery';
    }

    /**
     * 云商通外部系统编号(唯一的)
     * @var string
     */
    public string $yunid = '';

    /**
     *
     * 用户系统id(yunid与useId必须传其中一个,两个都传的话以yunid为条件进行查询)
     * @var string
     */
    public string $useId = '';

    /**
     * 若以useId查询改参数必传
     * @var string
     */
    public string $sysId = '';

}