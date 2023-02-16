<?php

namespace Lamberd\Allinpay;

use Lamberd\Allinpay\exception\ErrorException;
use Lamberd\Allinpay\exception\InvalidArgumentException;
use Lamberd\Allinpay\util\CommonUtil;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

abstract class BaseObject
{
    abstract public function getUrl(): string;

    /**
     * yyyyMMddHHmmss
     * @var string
     * @Assert\NotBlank()
     * @Assert\DateTime(format="YmdHis")
     */
    protected string $timestamp = '';


    /**
     * 版本号
     * @var string
     * @Assert\NotBlank()
     */
    protected string $v = '2.0';

    /**
     * 设置时间戳
     */
    public function setTimestamp(): void
    {
        $this->timestamp = date('YmdHis');
    }

    /**
     * 编码函数
     * @param string $value
     * @return string
     */
    protected function base(string $value): string
    {
        return base64_encode(trim($value));
    }

    /**
     * 参数校验
     * @return array
     */
    protected function valid(): array
    {
        $errors = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator()
            ->validate($this);
        $array = [];
        foreach ($errors as $error) {
            $array[$error->getPropertyPath()] = $error->getMessage();
        }
        return $array;
    }

    /**
     * 获取当前类的所有public、private、protected属性
     * @return array
     * @throws InvalidArgumentException
     */
    public function getRequestParams(): array
    {
        $errors = $this->valid();
        if ($errors) {
            throw new InvalidArgumentException($errors);
        }

        $classRef = new \ReflectionClass($this);
        $reflectionProperty = $classRef->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PROTECTED);
        $array = [];
        foreach ($reflectionProperty as $property) {
            $array[$property->name] = $this->{$property->name};
        }
        return $array;
    }

    /**
     * 获取远程图片base
     * @param string $url 远程图片地址
     * @param int $sizeLimit 限制大小，单位为K；sizeLimit=200时，表示获取的图片大小要低于200K；0表示不限制;
     * @return string
     * @throws ErrorException
     */
    public function getPicBase(string $url, int $sizeLimit = 0): string
    {
        $headerInfo = get_headers($url, true);
        $size = ceil($headerInfo['Content-Length'] / 1000);
        if ($size == 0) {
            throw new ErrorException("图片大小为0，确认远程图片存在");
        }
        if ($sizeLimit != 0 && ($size > $sizeLimit)) {
            throw new ErrorException("图片{$size}K，超出{$sizeLimit}K限制");
        }

        return base64_encode(file_get_contents($url));
    }

    /**
     * 发送请求
     * @return Response
     */
    public function send(): Response
    {
        $res = new Response();
        try {
            $this->setTimestamp();
            $params = $this->getRequestParams();
            $url = $this->getUrl();
            $result = CommonUtil::post($url, $params);
            $res->row = $result;
            $allinResponse = AllinResponse::load($result);
            $res->status = $allinResponse->isSuccess();
            $res->allinResponse = $allinResponse;
            if (!$res->status) {
                $res->msg = $allinResponse->msg;
            }
        } catch (InvalidArgumentException $e) {
            $res->setErrors($e->getErrors());
        } catch (ErrorException $e) {
            $res->msg = $e->getMessage();
        }

        var_dump($res);
        return $res;
    }
}