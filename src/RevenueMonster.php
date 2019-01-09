<?php

namespace RM\SDK;

use Httpful\Request;
use Datetime;
use DateInterval;
use Exception;

class RevenueMonster 
{
    private static $domains = [
        'oauth' => 'oauth.revenuemonster.my',
        'api' => 'open.revenuemonster.my',
    ];

    private $clientId = '';
    private $clientSecret = '';
    private $accessToken = '';
    private $privateKey = '';
    private $publicKey = '';
    // private $version = 'stable';
    private $isSandbox = true;
    private $refreshTime;
    private $tokenPath = '/storage/access_token.json';

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

        $this->oauth();
    }

    private function oauth()
    {
        $uri = $this->getAPIUrl('v1', '/token', 'oauth');
        $hash = base64_encode($this->clientId.':'.$this->clientSecret);

        $response = Request::post($uri, [
                'grantType' => 'client_credentials'
            ])
            ->sendsJson()
            ->expectsJson()
            ->addHeader('Authorization', "Basic $hash")
            ->send();

        $filepath = __DIR__.'/storage/access_token.json';
        $body = $response->body;
        $this->accessToken = $body->accessToken;
        file_put_contents($filepath, json_encode($body));
        $expiresIn = $body->expiresIn - 1000;
        $this->refreshTime = (new Datetime)->add(new DateInterval('PT'.$expiresIn.'S'));
    } 

    public function getDomain(string $usage)
    {
        $domain = RevenueMonster::$domains['api'];
        if (array_key_exists($usage, RevenueMonster::$domains)) {
            $domain = RevenueMonster::$domains[$usage];
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
        return "https://$uri";
    }

    private function refreshTokenIfNecessary()
    {
        var_dump(new Datetime, $this->refreshTime);
        if (new Datetime > $this->refreshTime) {
            echo '<p>refreshIT</p>';
            $this->oauth();
        }
    }

    public function getAccessToken()
    {
        $this->refreshTokenIfNecessary();
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