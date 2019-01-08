<?php

class Request extends GuzzleHttp\Client
{
    private $domain = '';
    private $environment = 'sandbox';
    private $version = '1.0';
    private $url = '';
    private $method = 'get';
    private $nonceStr = '';
    private $signature = '';
    private $timestamp;

    public function isMethod(string $method)
    {
        return $this->method == strtolower($method);
    }

    public function getUrl() 
    {
        return $this->url;
    }
}