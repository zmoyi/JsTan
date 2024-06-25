<?php

namespace JsTan;

use InvalidArgumentException;

class JsTanInIt
{
    /**
     * @var array
     * 配置
     */
    private $config = array();

    /**
     * @var array
     * 公共请求参数
     */
    private $publicRequestParams = array();

    /**
     * @param array $config
     * 构造函数
     */
    public function __construct($config = array())
    {
        $this->setConfig($config);
    }

    /**
     * @param array $config
     * 设置配置
     */
    private function setConfig($config)
    {
        // 新增时间戳配置
        $requiredKeys = array(
            'authUrl',
            'baseUrl',
            'apiUrl',
            'accessToken',
            'appKey',
            'appSecret',
            'version',
            'timestamp',
            'charset'
        );
        foreach ($requiredKeys as $key) {
            if (!isset($config[$key])) {
                throw new InvalidArgumentException("Configuration error: missing required configuration item:  '$key'。");
            }
        }
        $this->config = $config;
        $this->setPublicRequestParams();
    }

    /**
     * @return void
     * 设置公共请求参数
     */
    private function setPublicRequestParams()
    {
        $config = $this->config;
        $requiredKeys = array('appKey', 'accessToken', 'charset', 'version', 'timestamp');
        foreach ($requiredKeys as $key) {
            if (!isset($config[$key])) {
                throw new InvalidArgumentException("Configuration error: missing required configuration item: '$key'。");
            }
        }
        // 将timestamp提出
        $this->publicRequestParams = array(
            'app_key' => $config['appKey'],
            'access_token' => $config['accessToken'],
            'timestamp' => $config['timestamp'],
            'charset' => $config['charset'],
            'version' => $config['version']
        );
    }

    /**
     * @return array
     * 获取配置
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * @return array
     */
    protected function getPublicRequestParams()
    {
        return $this->publicRequestParams;
    }
}
