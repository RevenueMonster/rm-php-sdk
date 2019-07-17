<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Request\Order;
use RevenueMonster\SDK\Exceptions\ValidationException;

class QRPay implements JsonSerializable 
{
    // static $WALLET_WECHAT_MY = 'WECHATPAY_MY';
    // static $WALLET_WECHAT_CN = 'WECHATPAY_CN';
    // static $WALLET_PRESTO = 'PRESTO_MY';
    // static $WALLET_BOOST = 'BOOST_MY';

    // static $TYPE_WEB_PAYMENT = 'WEB_PAYMENT';
    // static $TYPE_MOBILE_PAYMENT = 'MOBILE_PAYMENT';

    public $currencyType = 'MYR';
    public $type = 'DYNAMIC';
    public $amount = 0;
    public $isPreFillAmount = true;
    public $method = [];
    public $order = 'WEB_PAYMENT';
    public $storeId = '';
    public $redirectUrl = '';
    // public $notifyUrl = '';

    public function __construct(array $arguments = []) 
    {
        // $this->order = new Order;
    }

    public function escapeURL($url = '') 
    {
        $url = parse_url($url);
        $fulluri = '';
        if (array_key_exists("scheme", $url)) {
            $fulluri = $fulluri.$url["scheme"]."://";
        }
        if (array_key_exists("host", $url)) {
            $fulluri = $fulluri.$url["host"];
        }
        if (array_key_exists("path", $url)) {
            $fulluri = $fulluri.$url["path"];
        }
        if (array_key_exists("query", $url)) {
            $fulluri = $fulluri."?".urlencode($url["query"]);
        }
        if (array_key_exists("fragment", $url)) {
            $fulluri = $fulluri."#".urlencode($url["fragment"]);
        }

        return $fulluri;
    }

    public function jsonSerialize()
    {
        $data = [
            'currencyType' => $this->currencyType,
            'amount' => $this->amount,
            'expiry' => [
                'type' => 'PERMANENT',
            ],
            'isPreFillAmount' => $this->isPreFillAmount,
            'method' => $this->method,
            'order' => [
                'title' => "服务费",
                'detail' => "test",
            ],
            'redirectUrl' => $this->escapeURL($this->redirectUrl),
            'storeId' => $this->storeId,
            'type' => $this->type,
        ];

        $validator = new Validator;
        $validation = $validator->make($data, [
            'currencyType' => 'required|in:MYR',
            'amount' => 'required',
            'isPreFillAmount' => 'required',
            'redirectUrl' => 'required|url',
            'storeId' => 'required',
            'type' => 'required|in:DYNAMIC,STATIC',
        ]);
        
        $validation->validate();
        
        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return $data;
    }
}
