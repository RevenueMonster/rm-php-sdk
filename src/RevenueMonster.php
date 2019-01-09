<?php

namespace RM\SDK;

use Httpful\Request;

class RevenueMonster 
{
    private static $oauthDomain = 'oauth.revenuemonster.my';
    private static $apiDomain = 'open.revenuemonster.my';

    private $clientId = '5499912462549392881';
    private $clientSecret = 'pwMapjZzHljBALIGHxfGGXmiGLxjWbkT';
    private $accessToken = '';
    private $privateKey = '';
    private $publicKey = '';
    private $version = 'stable';
    private $isSandbox = true;

    private $modules = [
        'merchant' => 'RM\SDK\Modules\MerchantModule',
        'payment' => 'RM\SDK\Modules\PaymentModule',
    ];

    public function __construct(array $arguments = []) 
    {
        foreach ($arguments as $property => $argument) {
            if (!property_exists($this, $property)) {
                continue;
            }
            if (gettype($this->{$property}) != gettype($argument)) {
                continue;
            }
            $this->{$property} = $argument;
        }

        $uri = $this->getAPIUrl('v1', '/token', 'oauth');
        $hash = base64_encode($this->clientId.':'.$this->clientSecret);

        $response = Request::post($uri, [
                'grantType' => 'client_credentials'
            ])
            ->sendsJson()
            ->expectsJson()
            ->addHeader('Authorization', "Basic $hash")
            ->send();

        $body = $response->body;
        $accessToken = $body->accessToken;
        $this->accessToken = $accessToken;
        // file_put_contents('access_token', json_encode($body));
    }

    public function getDomain(string $usage)
    {
        $domain = RevenueMonster::$apiDomain;
        switch ($usage) {
        case 'oauth':
            $domain = RevenueMonster::$oauthDomain;
        }
        return $domain;
    }

    public function getAPIUrl(string $version = 'v1', string $url, string $usage = 'api')
    {
        $url = trim($url, '/');
        $uri = "{$this->getDomain($usage)}/$version/$url";
        if ($this->isSandbox) {
            $uri = "sb-$uri";
        }
        echo "<p>https://$uri</p>";
        return "https://$uri";
    }

    private function accessTokenExpires()
    {

    }

    private function renewAccessToken()
    {
        $accessToken = '';
        $this->accessToken = $accessToken;
    }

    public function getAccessToken()
    {
        if ($this->accessTokenExpires()) {
            $this->renewAccessToken();
        }
        return $this->accessToken;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->modules)) {
            throw new Exception();
        }

        $obj = $this->modules[$name];
        $obj = new $obj($this);
        $this->{$name} = $obj;
        return $obj;
    }
}