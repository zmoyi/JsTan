<?php

namespace JsTan\Http;

use GuzzleHttp\Client;

class Http
{
    /**
     * 储存实例
     */
    private static ?Http $instance = null;

    /**
     * @var Client
     * Guzzle客户端
     */
    private Client $client;

    public function __construct($config = [])
    {
        $this->client = new Client([
            'base_uri' => $config['baseUrl']?? '',
            'verify' => $config['verify']?? false,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
            ],
            'connect_timeout' => $config['timeout']??3.14
        ] + ($config['httpClientConfig'] ?? []));
    }

    /**
     * @return Http
     * 获取实例
     */
    public static function getInstance($config = []): Http
    {
        if(self::$instance == null){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * @return Client
     * 获取Guzzle客户端
     */
    public function getClient(): Client
    {
        return $this->client;
    }


}
