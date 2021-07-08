<?php

namespace RevenueMonster\SDK;

use Httpful\Request;
use Datetime;
use DateInterval;
use Exception;
use RevenueMonster\SDK\Exceptions\ApiException;

class RevenueMonster
{
    private static $domains = [
        'oauth' => 'oauth.revenuemonster.my',
        'api' => 'open.revenuemonster.my',
    ];

    // RevenueMonster clientId
    private $clientId = '';

    // RevenueMonster clientSecret
    private $clientSecret = '';

    // access token for api call
    public $accessToken = '';

    // private key for signature generation
    private $privateKey = '';

    // public key for signature verification
    private $publicKey = '';

    // identifier for sandbox or production
    private $isSandbox = true;

    // access token refresh time
    private $refreshTime;

    // private $tokenPath = '/storage/access_token.json';

    private $modules = [
        'merchant' => Modules\MerchantModule::class,
        'store' => Modules\StoreModule::class,
        'user', Modules\UserModule::class,
        'payment' => Modules\PaymentModule::class,
        'ekyc' => Modules\EkycModule::class,
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
        $uri = $this->getOpenApiUrl('v1', '/token', 'oauth');
        $hash = base64_encode($this->clientId . ':' . $this->clientSecret);

        $response = Request::post($uri, [
            'grantType' => 'client_credentials'
        ])
            ->sendsJson()
            ->expectsJson()
            ->addHeader('Authorization', "Basic $hash")
            ->send();

        // $filepath = __DIR__.'/storage/access_token.json';
        $body = $response->body;

        if (property_exists($body, 'error')) {
            throw new ApiException($response->code, $body->error->code, $body->error->message);
        }

        $this->accessToken = $body->accessToken;
        // file_put_contents($filepath, json_encode($body));
        $expiresIn = $body->expiresIn - 1000;
        $this->refreshTime = (new Datetime)->add(new DateInterval('PT' . $expiresIn . 'S'));
    }

    public function getDomain(string $usage)
    {
        $domain = RevenueMonster::$domains['api'];
        if (array_key_exists($usage, RevenueMonster::$domains)) {
            $domain = RevenueMonster::$domains[$usage];
        }
        return $domain;
    }

    public function getOpenApiUrl(string $version = 'v1', string $url = '', string $usage = 'api')
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
        if (new Datetime > $this->refreshTime) {
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
            throw new Exception("invalid property name : $name");
        }

        $obj = $this->modules[$name];
        $obj = new $obj($this);
        $this->{$name} = $obj;
        return $obj;
    }
}
