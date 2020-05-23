<?php

namespace Songyz\Common\Components\Traits;

use GuzzleHttp\Client;

trait HttpClientAsyncTrait
{
    protected $httpClient;

    /** @var 访问远程host */
    public $host;

    /** @var array curlOptions配置项 */
    private $curlOptions = [];

    /**
     * 设置发送短信需要的header头
     * @var array
     */
    protected $headers = [
        'content-type' => 'x-www-form-urlencoded',
        'X-Requested-With' => 'XMLHttpRequest',
    ];

    /**
     * 初始化Client配置
     * 可以在构造方法中初始化此属性
     * @var array
     */
    protected $newClientConfig = [];

    public function setHeader($name, $value = '')
    {
        if (is_array($name)) {
            is_array($this->headers) || $this->headers = [];
            $this->headers = array_merge($this->headers, $name);
        } else {
            $this->headers[$name] = $value;
        }

        return $this;
    }

    protected function setClientConfig($name, $value = '')
    {
        if (is_array($name)) {
            $this->newClientConfig = array_merge($this->newClientConfig, $name);
        } elseif (!empty($value)) {
            $this->newClientConfig[$name] = $value;
        }

        return $this;
    }

    public function getHeader($name = '')
    {
        if ($name && isset($this->headers[$name])) {
            return $this->headers[$name];
        } else {
            return $this->headers;
        }
    }

    public function fetchPost(string $url, array $params = [])
    {
        return $this->fetch($url, "POST", $params);
    }

    public function fetchPut(string $url, array $params = [])
    {
        return $this->fetch($url, "PUT", $params);
    }

    public function fetchPatch(string $url, array $params = [])
    {
        return $this->fetch($url, "PATCH", $params);
    }

    public function fetchDelete(string $url, array $params = [])
    {
        return $this->fetch($url, "DELETE", $params);
    }

    public function fetchGet(string $url, array $params = [])
    {
        return $this->fetch($url, "GET", $params);
    }

    /**
     * 发送请求前处理数据
     * fetchBefore
     * @param $data
     * @return mixed
     *
     * @date 2020/5/22 23:58
     */
    protected function fetchBefore($data)
    {
        return $data;
    }

    /**
     * 发送请求后处理数据
     * fetchBefore
     * @param $data
     * @return mixed
     *
     * @date 2020/5/22 23:58
     */
    protected function fetchAfter($data)
    {
        return $data;
    }

    /**
     * 发送请求成功处理数据
     * fetchBefore
     * @param $data
     * @return mixed
     *
     * @date 2020/5/22 23:58
     */
    protected function fetchSuccess($data)
    {
        return $data;
    }

    private function fetch(string $url, string $method, array $params)
    {
        $defaultConfig = ['verify' => false];
        $defaultConfig = $this->newClientConfig + $defaultConfig;
        try {
            if (is_null($this->httpClient)) {
                $this->httpClient = new Client($defaultConfig);
            }
            $params = $this->fetchBefore($params);

            $httpSendData = [
                'headers' => $this->headers
            ];

            $headers = array_change_key_case($this->headers);

            if ($method === 'GET') {
                $httpSendData['query'] = $params;
            } elseif (isset($headers['content-type']) && stristr($headers['content-type'], 'application/json')) {
                $httpSendData['json'] = $params;
            } elseif (isset($headers['content-type']) && stristr($headers['content-type'], 'x-www-form-urlencoded')) {
                $httpSendData['form_params'] = $params;
            } else {
                $httpSendData['form_params'] = $params; //服务器端使用 file_get_contents('php://input'); 接收数据
            }
            $url = $this->urlParse($url);

            $response = $this->httpClient->requestAsync($method, $url, $httpSendData);

            return $this->fetchSuccess($this->fetchAfter($response));
        } catch (\Exception $exception) {
            throw  $exception;
        }
    }

    protected function urlParse($url)
    {
        if (!isset($this->host)) {
            $this->host = '';
        }
        if (parse_url($url, PHP_URL_HOST)) {
            return $url;
        }
        $url = rtrim($this->host, '/') . '/' . trim($url, '/');
        $urlData = parse_url($url);

        if (!isset($urlData['host'])) {
            throw new \Exception('远程访问地址错误 请排查:' . $url);
        }
        return $url;
    }

    //根据参数获取url
    protected function getUrl($url, $method, $params)
    {
        if (!isset($this->host)) {
            $this->host = '';
        }

        if (parse_url($url, PHP_URL_HOST)) {
            $urlData = parse_url($url);
            $result = $url;
        } else {
            $url = rtrim($this->host, '/') . '/' . trim($url, '/');
            $urlData = parse_url($url);
            if (!isset($urlData['host'])) {
                throw new \InvalidArgumentException('访问远程地址错误');
            }
            $result = $url;
        }

        if (strtoupper($method) == 'GET' && $params) {
            if (isset($urlData['query'])) {
                parse_str($urlData['query'], $query);
                $query = array_merge($query, $params);
                $queryStr = http_build_query($query);
                $url = $urlData['scheme'] . '//' . $urlData['host'] . $urlData['path'] . '?' . $queryStr;
            } else {
                $queryStr = http_build_query($params);
                $url = $url . '?' . $queryStr;
            }
            $result = $url;
        }
        return $result;
    }
}
