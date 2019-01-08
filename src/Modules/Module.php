<?php

namespace RM\SDK\Modules;

use RM\SDK\RevenueMonster;
use Httpful\Request;

class Module
{
    protected $rm = null;

    public function __construct(RevenueMonster $rm) 
    {
        $this->rm = $rm;
    }

    protected function generateSignature($method, $url, $nonceStr, $timestamp, $payload = [])
    {
        $res = openssl_pkey_get_private($this->rm->getPrivateKey());
        $signType = 'sha256';

        $arr = array();
        if (is_array($payload) && !empty($payload)) {
            array_ksort($payload);
            $data = base64_encode(json_encode($payload, JSON_UNESCAPED_SLASHES));
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
        openssl_free_key($res);
        // echo '<p>Before SIGNATURE -------------------------------</p>';
        // var_dump(join("&", $arr));
        // echo '<p>After SIGNATURE --------------------------------</p>';
        $signature = base64_encode($signature);
        // var_dump($signature);
        return $signature;
    }

    protected function callApi(string $method, $url, $payload = null)
    {
        $accessToken = $this->rm->getAccessToken();
        $method = strtolower($method);
        $request = Request::get($url);
        if ($method == 'post') {
            $request = Request::post($url, $payload);
        }

        $nonceStr = random_str(32);
        $timestamp = time();
        $signature = $this->generateSignature($method, $url, $nonceStr, $timestamp, $payload);

        $request = $request->sendsJson()
            ->expectsJson()
            ->addHeader('Authorization', "Bearer $accessToken")    // Or use the addHeader method
            ->addHeaders([
                'X-Signature' => "sha256 $signature",
                'X-Nonce-Str' => $nonceStr,
                'X-Timestamp' => $timestamp,
            ]);

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


}