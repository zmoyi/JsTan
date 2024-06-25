<?php

namespace JsTan;

use JsTan\Http\Http;

class Client extends JsTanInIt
{
    private static $instance;

    public function request($url, array $data)
    {
        $config = $this->getConfig();
        $publicRequestParams = $this->getPublicRequestParams();
        $params = Util::getInstance($publicRequestParams)->getParams($config['appSecret'], $data);
        return $this->post($url, $params);
    }

    /**
     * @param array $config
     * @return Client
     * 获取实例
     */
    public static function getInstance(array $config = [])
    {
        // 时间戳
        $currentTimestamp = time(); // 获取当前时间戳
        $instance = self::$instance;

        // 获取当前实例的配置
        $instanceConfig = $instance ? $instance->getConfig() : null;

        // 如果没有实例，或者实例配置不同，并时间戳差异超过30秒，则创建新实例
        if (!$instance || $instanceConfig !== $config && abs($currentTimestamp - $instanceConfig['timestamp']) > 30) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    private function post($url, $data)
    {
        $config = $this->getConfig();
        $http = Http::getInstance($config)->getClient();
        $response = $http->post($url, [], $data);
        return $response->body;
    }

    /**
     * 获取授权链接
     *
     * @return string
     */
    public function createAuthUrl()
    {
        $config = $this->getConfig();
        $data = [
            'app_key' => $config['appKey'],
            'timestamp' => time(),
            'charset' => $config['charset']
        ];
        $sign = Util::getSign($config['appSecret'], $data);
        return $config['authUrl'] .
            '?app_key=' . $data['app_key'] .
            '&timestamp=' . $data['timestamp'] .
            '&charset=' . $data['charset'] .
            '&sign=' . $sign;

    }

    /**
     * 获取access_token（getInitToken）
     * 商家自研系统授权流程: https://openweb.jushuitan.com/doc?docId=23
     *
     * @param  $code
     * @return string
     */
    public function getInitToken($code)
    {
        $config = $this->getConfig();
        $data = [
            'app_key' => $config['appKey'],
            'timestamp' => time(),
            'grant_type' => 'authorization_code',
            'charset' => $config['charset'],
            'code' => $code,
        ];
        $data['sign'] = Util::getSign($config['appSecret'], $data);
        return $this->post($config['apiUrl'] . 'openWeb/auth/getInitToken', $data);
    }

    /**
     * 获取access_token（accessToken）
     * 第三方授权流程: https://openweb.jushuitan.com/doc?docId=25
     *
     * @param  $code
     * @return string
     */
    public function getAccessToken($code)
    {
        $config = $this->getConfig();
        $data = [
            'app_key' => $config['appKey'],
            'timestamp' => time(),
            'grant_type' => 'authorization_code',
            'charset' => $config['charset'],
            'code' => $code,
        ];
        $data['sign'] = Util::getSign($config['appSecret'], $data);
        return $this->post($config['apiUrl'] . 'openWeb/auth/accessToken', $data);
    }

    /**
     * 刷新access_token
     *
     * @param $refreshToken
     * @return string
     */
    public function refreshToken($refreshToken)
    {
        $config = $this->getConfig();
        $data = [
            'app_key' => $config['appKey'],
            'timestamp' => time(),
            'grant_type' => 'refresh_token',
            'charset' => $config['charset'],
            'refresh_token' => $refreshToken,
            'scope' => 'all',
        ];
        $data['sign'] = Util::getSign($config['appSecret'], $data);
        return $this->post($config['apiUrl'] . 'openWeb/auth/refreshToken', $data);
    }
}