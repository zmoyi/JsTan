<?php

namespace JsTan;

class Util
{
    /**
     * @var array
     * 公共参数
     */
    protected static array $params;

    protected static Util $instance;

    public function __construct(array $params = [])
    {
        $this->setParams($params);
    }

    /**
     * @param array $params
     * 设置参数
     */
    private function setParams(array $params): void
    {
        self::$params = $params;
    }

    /**
     * @return array
     * 获取参数
     */
    public static function getParams($appSecret, array $biz): array
    {
        $data = self::$params;
        $data['biz'] = !empty($biz) ? json_encode($biz) : '{}';
        $data['sign'] = self::getSign($appSecret, $data);
        return $data;
    }

    /**
     * @param $appSecret
     * @param $params
     * @return string|null
     * 生成签名
     */
    public static function getSign($appSecret, $params): ?string
    {
        if (empty($params)) {
            return null;
        }
        ksort($params);
        $resultStr = "";
        foreach ($params as $key => $value) {
            if ($key != "sign") {
                $resultStr .= $key . $value;
            }
        }
        $resultStr = $appSecret . $resultStr;
        return bin2hex(md5($resultStr, true));
    }

    /**
     * @param array $publicRequestParams
     * @return Util
     */
    public static function getInstance(array $publicRequestParams): Util
    {
        return new self($publicRequestParams);
    }

}