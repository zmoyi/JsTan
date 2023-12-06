<?php

use JsTan\Client;
use JsTan\Route;
use PHPUnit\Framework\TestCase;

class MyClientTest extends TestCase
{
    private array $config = [
        // 授权地址
        'authUrl' => 'https://openweb.jushuitan.com/auth',
        // 接口地址
        'baseUrl' => 'https://dev-api.jushuitan.com/',
        // 授权接口地址
        'apiUrl' => 'https://openapi.jushuitan.com/',
        // 授权token
        'accessToken' => 'b7e3b1e24e174593af8ca5c397e53dad',
        // 应用key
        'appKey' => 'b0b7d1db226d4216a3d58df9ffa2dde5',
        // 应用secret
        'appSecret' => '99c4cef262f34ca882975a7064de0b87',
        // 版本号
        'version' => '2',
        // 字符集
        'charset' => 'utf-8',
        // 是否验证证书
        'verify' => false,
        // 超时时间
        'timeout' => 0
    ];
    public function testCreateAuthUrl()
    {
        $client = Client::getInstance($this->config);
        $url = $client->createAuthUrl();
        echo $url;
        $this->assertNotEmpty($url);
    }

    public function testGetAccessToken()
    {
        $client = Client::getInstance($this->config);
        /**
         * 获取access_token （请求示例）
         */
        $response = $client->getAccessToken('001');
        print_r($response);
        $this->assertNotEmpty($response);
    }

    public function testRefreshAccessToken()
    {
        $client = Client::getInstance($this->config);
        /**
         * 刷新access_token （请求示例）
         */
        $response = $client->refreshToken('001');
        print_r($response);
        $this->assertNotEmpty($response);
    }

    public function testRequest()
    {
        $client = Client::getInstance($this->config);
        $route = Route::getInstance();
        /**
         * 查询门店列表（请求示例）
         */
        $response = $client->request($route->getRoute('QUERY_SHOPS'), [
            'page_index' => 1,
            'page_size' => 10
        ]);
        print_r($response);
        $this->assertNotEmpty($response);
    }

}