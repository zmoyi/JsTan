<?php

namespace JsTan;

use InvalidArgumentException;

class JsTanInit
{
    /**
     * @var array
     * 配置
     */
    private array $config;

    /**
     * @var array
     * 公共请求参数
     */
    private array $publicRequestParams;

    /**
     * @param array $config
     * 构造函数
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    /**
     * @param array $config
     * 设置配置
     */
    private function setConfig(array $config): void
    {
        $requiredKeys = [
            'authUrl',
            'baseUrl',
            'apiUrl',
            'accessToken',
            'appKey',
            'appSecret',
            'version',
            'charset'
        ];
        foreach ($requiredKeys as $key) {
            if (!isset($config[$key])) {
                throw new InvalidArgumentException("Configuration error: missing required configuration item:  '$key'。");
            }
        }
        $this->config = $config;
        $this->setPublicRequestParams();
    }

    /**
     * @return array
     * 获取配置
     */
    protected function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @return void
     * 设置公共请求参数
     */
    private function setPublicRequestParams(): void
    {
        $config = $this->config;
        $requiredKeys = ['appKey', 'accessToken', 'charset', 'version'];
        foreach ($requiredKeys as $key) {
            if (!isset($config[$key])) {
                throw new InvalidArgumentException("Configuration error: missing required configuration item: '$key'。");
            }
        }
        $this->publicRequestParams = [
            'app_key' => $config['appKey'],
            'access_token' => $config['accessToken'],
            'timestamp' => time(),
            'charset' => $config['charset'],
            'version' => $config['version']
        ];
    }

    /**
     * @return array
     */
    protected function getPublicRequestParams(): array
    {
        return $this->publicRequestParams;
    }


}