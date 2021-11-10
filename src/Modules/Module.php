<?php

namespace RevenueMonster\SDK\Modules;

use Httpful\Request;
use Httpful\Response;
use RevenueMonster\SDK\RevenueMonster;
use RevenueMonster\SDK\Exceptions\ApiException;

class Module
{
    protected $rm = null;

    public function __construct(RevenueMonster $rm)
    {
        $this->rm = $rm;
    }

    public function getOpenApiUrl(string $version = '1.0', string $url = '', string $usage = 'api')
    {
        return $this->rm->getOpenApiUrl($version, $url, $usage);
    }

    public function generateSignature($method, $url, $nonceStr, $timestamp, $payload = [])
    {
        $res = openssl_pkey_get_private($this->rm->getPrivateKey());
        $signType = 'sha256';

        $arr = array();
        if (is_array($payload)) {
            $data = '';
            if (!empty($payload)) {
                array_ksort($payload);
                $data = base64_encode(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_TAG));
            }
            array_push($arr, "data=$data");
        }

        array_push($arr, "method=$method");
        array_push($arr, "nonceStr=$nonceStr");
        array_push($arr, "requestUrl=$url");
        array_push($arr, "signType=$signType");
        array_push($arr, "timestamp=$timestamp");

        $signature = '';
        // compute signature
        openssl_sign(join("&", $arr), $signature, $res, OPENSSL_ALGO_SHA256);

        // free the key from memory
        unset($res);
        $signature = base64_encode($signature);
        return $signature;
    }

    protected function callApi(string $method, $url, $payload = null)
    {
        $accessToken = $this->rm->getAccessToken();
        $method = strtolower($method);

        switch ($method) {
            case 'post':
                $request = Request::post($url, $payload);
                break;
            case 'patch':
                $request = Request::patch($url, $payload);
                break;
            case 'delete':
                $request = Request::delete($url);
                break;
            default:
                $request = Request::get($url);
                break;
        }

        $nonceStr = random_str(32);
        $timestamp = time();
        $signature = $this->generateSignature($method, $url, $nonceStr, $timestamp, $payload);
        $header = [
            'Authorization' => "Bearer $accessToken",
            'X-Signature' => "sha256 $signature",
            'X-Nonce-Str' => $nonceStr,
            'X-Timestamp' => $timestamp,
        ];

        $request = $request->sendsJson()
            ->expectsJson()
            ->addHeaders($header);

        return $request;
    }

    protected function get(string $url)
    {
        return $this->callApi('get', $url);
    }

    protected function post(string $url, $payload = null)
    {
        return $this->callApi('post', $url, $payload);
    }

    /**
     * magic function to return response
     * 
     * @return stdClass|Tightenco\Collect\Support\Collection
     *
     * @throws ApiException
     */
    protected function mapResponse(Response $response)
    {
        $body = $response->body;

        // check the response contains error payload
        if (property_exists($body, 'error')) {
            throw new ApiException($response->code, $body->error->code, $body->error->message);
        } else if (property_exists($body, 'item')) {
            return $body->item;
        } else if (property_exists($body, 'items')) {
            return collect($body->items);
        }

        throw new ApiException($response->code, ApiException::$UNKNOWN_ERROR, 'unexpected error');
    }
}
