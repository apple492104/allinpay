<?php

namespace Lamberd\Allinpay\notice;

/**
 * 5.0.5【影印件异步通知】
 *
 * 通知地址取【影印件采集】接口请求参数中上送的“ocrComparisonResultBackUrl”地址，如果上送则通知，
 * 不上送则不通知；
 * 通知机制说明：营业执照和法人身份证（正反面同时存在时再触发）分两次进行 OCR 识别，因此客户会收到
 * 多次结果通知，客户取每次收到通知的 ocrRegnumComparisonResult OCR 识别与企业工商认证信息是否一致
 * 和 ocrIdcardComparisonResult OCR 识别与企业法人实名信息是否一致字段更新状态，识别成功和失败都会发
 * 通知；
 */
class OcrAudit extends BaseNotice
{
    public string $yunid = '';

    /**
     * OCR识别与企业工商认证信息是否一致
     * 【OCR 识别与企业工商认证信息是否一致
     * 0-否 1-是 该字段与“OCR 识别与企业法人实名信 息是否一致”字段有一方发生变更即返值 若营业执照未进行识别该字段不返】
     * @var string
     */
    public string $ocrRegnumComparisonResult = '';


    /**
     * OCR识别与企业法人实名信息是否一致
     * 【OCR 识别与企业法人实名信息是否一致
     * 0-否 1-是 该字段与“OCR 识别与企业工商认证信 息是否一致”字段有一方发生变更即返值 若法人身份证未进行识别该字段不返】
     * @var string
     */
    public string $ocrIdcardComparisonResult = '';


    public string $sysId = '';

}