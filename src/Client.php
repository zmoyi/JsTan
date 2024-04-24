<?php
namespace JsTan;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use JsTan\Http\Http;


class Client extends JsTanInIt
{
    private static ?Client $instance = null;

    /**
     * @param string $url
     * @param array $data
     * @return Exception|GuzzleException|string
     */
    private function post(string $url,array $data): Exception|string|GuzzleException
    {
        $config = $this->getConfig();
        $http = Http::getInstance($config)->getClient();
        try {
            $response = $http->post(
                $url,[
                    'form_params' => $data
                ]
            );
            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            return $e;
        }
    }

    /**
     * @param string $url
     * @param array $data
     * @return Exception|string|GuzzleException
     * 请求接口
     */
    public function request(string $url,array $data): Exception|string|GuzzleException
    {
        $config = $this->getConfig();
        $publicRequestParams = $this->getPublicRequestParams();
        $params = Util::getInstance($publicRequestParams)->getParams($config['appSecret'], $data);
        return $this->post($url, $params);
    }

    /**
     * @return string
     * 获取授权链接
     */
    public function createAuthUrl(): string
    {
        $config = $this->getConfig();
        $data = [
            'app_key' =>$config['appKey'],
            'timestamp' => time(),
            'charset' => $config['charset']
        ];
        $sign = Util::getSign($config['appSecret'],$data);
        return $config['authUrl'] .
            '?app_key=' . $data['app_key'] .
            '&timestamp=' . $data['timestamp'] .
            '&charset=' . $data['charset'] .
            '&sign=' . $sign;
    }

    /**
     * @param $code
     * @return Exception|string|GuzzleException
     * 获取access_token（getInitToken）[商家自研系统授权流程](https://openweb.jushuitan.com/doc?docId=23)
     */
    public function getInitToken($code): Exception|string|GuzzleException
    {
        $data = [
            'app_key' => $this->getConfig()['appKey'],
            'timestamp' => time(),
            'grant_type' => 'authorization_code',
            'charset' => $this->getConfig()['charset'],
            'code' => $code,
        ];
        $data['sign'] = Util::getSign($this->getConfig()['appSecret'],$data);
        return $this->post($this->getConfig()['apiUrl']. 'openWeb/auth/getInitToken', $data);
    }

    /**
     * @param $code
     * @return Exception|string|GuzzleException
     * 获取access_token（accessToken）[第三方授权流程](https://openweb.jushuitan.com/doc?docId=25)
     */
    public function getAccessToken($code): Exception|string|GuzzleException
    {
        $data = [
            'app_key' => $this->getConfig()['appKey'],
            'timestamp' => time(),
            'grant_type' => 'authorization_code',
            'charset' => $this->getConfig()['charset'],
            'code' => $code,
        ];
        $data['sign'] = Util::getSign($this->getConfig()['appSecret'],$data);
        return $this->post($this->getConfig()['apiUrl']. 'openWeb/auth/accessToken', $data);
    }

    /**
     * @param $refreshToken
     * @return Exception|string|GuzzleException
     * 刷新access_token
     */
    public function refreshToken($refreshToken): Exception|string|GuzzleException
    {
        $data = [
            'app_key' => $this->getConfig()['appKey'],
            'timestamp' => time(),
            'grant_type' => 'refresh_token',
            'charset' => $this->getConfig()['charset'],
            'refresh_token' => $refreshToken,
            'scope' => 'all',
        ];

        $data['sign'] = Util::getSign($this->getConfig()['appSecret'],$data);
        return $this->post($this->getConfig()['apiUrl']. 'openWeb/auth/refreshToken', $data);
    }



    /**
     * @param array $config
     * @return Client
     * 获取实例
     */
    public static function getInstance(array $config = []): Client
    {
        if(self::$instance == null ||self::$instance->getConfig() !== $config ){
            self::$instance = new self($config);
        }
        return self::$instance;
    }
    
}