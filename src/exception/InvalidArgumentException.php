<?php

namespace Lambert\Allinpay\exception;


class InvalidArgumentException extends \Exception
{
    private array $errors;

    public function __construct(
        array $errors,
              $message = '',
              $code = 0,
              $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * 获取参数错误详情
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
