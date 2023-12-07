# 聚水潭 sdk（2.0）

[![Latest Stable Version](http://poser.pugx.org/zmoyi/jstan/v)](https://packagist.org/packages/zmoyi/jstan)	 [![Total Downloads](http://poser.pugx.org/zmoyi/jstan/downloads)](https://packagist.org/packages/zmoyi/jstan) 	[![License](http://poser.pugx.org/zmoyi/jstan/license)](https://packagist.org/packages/zmoyi/jstan)	[![Monthly Downloads](http://poser.pugx.org/zmoyi/jstan/d/monthly)](https://packagist.org/packages/zmoyi/jstan) 	[![Daily Downloads](http://poser.pugx.org/zmoyi/jstan/d/daily)](https://packagist.org/packages/zmoyi/jstan)	[![Version](http://poser.pugx.org/zmoyi/jstan/version)](https://packagist.org/packages/zmoyi/jstan)	[![PHP Version Require](http://poser.pugx.org/zmoyi/jstan/require/php)](https://packagist.org/packages/zmoyi/jstan)


## 介绍

时隔一年，没有怎么维护旧版本，并且有很多问题，代码如屎山，这次进行了重构，2.0 版本（虽然代码还是屎山）

聚水潭php-sdk

遇到问题先去查阅官方文档 [聚水潭文档](https://openweb.jushuitan.com/dev-doc)

## 要求

- php >= 8.1（其他 php 版本理论支持，但是未经过测试，请自行修改 php 版本号）

## 安装

```
composer require zmoyi/jstan
```

### laravel 使用移步至 [laravel-jsTan](https://github.com/zmoyi/laravel-jstan)

## 配置

> 如果下面的示例比较晦涩，请查看测试用例

`config`全局配置

```php
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
```

### api调用

```php
use JsTan\Client;
use JsTan\Route;

/****/

$client = Client::getInstance($this->config);
$route = Route::getInstance();


//路由可使用 Route::QUERY_SHOPS || $route->getRoute('QUERY_SHOPS') || 'open/logisticscompany/query'
// 常量传入，getRoute 传入，字符串传入，看自己喜好

/**
* 查询门店列表（请求示例）
*/
$response = $client->request($route->getRoute('QUERY_SHOPS'), [
  'page_index' => 1,
  'page_size' => 10
]);


/**
* 获取access_token （请求示例）
*/
$response = $client->getAccessToken('001');


/**
* 刷新access_token （请求示例）
*/
$response = $client->refreshToken('001');


print_r($response);
```

## License

JsTan is made available under the MIT License (MIT). Please see [License File]() for more information.

## 交流

点击链接加入群聊[【聚水潭phpsdk使用交流Q】](http://qm.qq.com/cgi-bin/qm/qr?_wv=1027&k=kz7Ytn8pSTbFeYzF3pVgrof2_PbsTNzk&authKey=XhdLyWKahlJlDOMVin3toWxkpwF6R6OEN5Ijw2epahb7kQ9a5LuIpXOdjAIBxijI&noverify=0&group_code=689699469)