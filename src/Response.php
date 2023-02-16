<?php

namespace Lambert\Allinpay;

class Response
{
    public bool $status = false;
    public string $msg = '';

    /**
     * 通联支付原始返回
     * @var string
     */
    public string $row = '';

    /**
     * 通联支付返回的对象信息
     * status=true必定存在，否可能为null
     * @var AllinResponse
     */
    public AllinResponse $allinResponse;

    /**
     * 将错误数组格式化成字符
     * @param array $errors
     * @return void
     */
    public function setErrors(array $errors)
    {
        foreach ($errors as $key => $value) {
            $this->msg .= "{$key} {$value}\n\r";
        }
    }
}