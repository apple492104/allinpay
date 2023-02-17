<?php

namespace Lamberd\Allinpay\notice;

/**
 * 5.0.7【账户提现协议签约异步通知】
 *
 */
class AcctProtocolAudit extends BaseNotice
{
    public string $yunid = '';

    /**
     * 0000:成功 其他失败
     * @var string
     */
    public string $code = '';

    /**
     * 协议号
     * @var string
     */
    public string $acctProtocolNo = '';

    /**
     * 1：私户签约 2:公户签约
     * @var string
     */
    public string $signAccType = '';

    public string $sysId = '';

    /**
     * 判断审核是否成功
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->code == '0000';
    }
}