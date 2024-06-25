<?php

namespace JsTan\Http;

use WpOrg\Requests\Session;

class Http
{
    private static $instance;

    private $client;

    /**
     * @param array $config
     */
    private function __construct($config = [])
    {
        $options = [
            'verify' => isset($config['verify']) ? $config['verify'] : false,
        ];
        $baseUrl = isset($config['baseUrl']) ? $config['baseUrl'] : '';
        $this->client = new Session($baseUrl);
        $this->client->options = $options;
        $this->client->headers['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';
    }

    // 获取实例
    public static function getInstance($config = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * @return Session
     */
    public function getClient()
    {
        return $this->client;
    }
}
