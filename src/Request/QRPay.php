<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use stdClass;
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

    public function __construct(array $arguments = [])
    {
        $order = new stdClass;
        $order->title = '';
        $order->detail = '';
        $this->order = $order;
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
                'title' => $this->order->title,
                'detail' => $this->order->detail,
            ],
            'redirectUrl' => escape_url($this->redirectUrl),
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
