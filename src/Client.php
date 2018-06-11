<?php

namespace PdInternalApi;

class Client
{

    protected $currentApp;
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param $app
     * @return $this
     */
    public function app($app)
    {
        if (isset($this->config[$app]))
            $this->currentApp = $app;
        return $this;
    }

    /**
     * 调用api，如果状态码不为200则抛出异常
     * @param $uri
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public function call($uri, $params)
    {
        $config = array_merge(['timeout' => 3],
            $this->config[$this->currentApp]);
        $secret = $config['secret'];
        unset($config['secret']);
        $client = new \GuzzleHttp\Client($config);
        $params['appid'] = $config['appid'];
        $params['timestamp'] = time();
        $params['sign'] = sign($params, $secret);
        $resp = $client->post($uri, ['form_params' => $params]);
        if ($resp->getStatusCode() == 200) {
            return \GuzzleHttp\json_decode($resp->getBody(), true);
        }
        return false;
    }

}