<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Request\Customer;
use RevenueMonster\SDK\Request\Order;
use RevenueMonster\SDK\Exceptions\ValidationException;

class WebPayment implements JsonSerializable
{
    static $WALLET_WECHAT_MY = 'WECHATPAY_MY';
    static $WALLET_WECHAT_CN = 'WECHATPAY_CN';
    static $WALLET_PRESTO = 'PRESTO_MY';
    static $WALLET_BOOST = 'BOOST_MY';

    static $TYPE_WEB_PAYMENT = 'WEB_PAYMENT';
    static $TYPE_MOBILE_PAYMENT = 'MOBILE_PAYMENT';

    public $order;
    public $customer;
    public $method = [];
    public $type = 'WEB_PAYMENT';
    public $storeId = '';
    public $redirectUrl = '';
    public $notifyUrl = '';
    public $layoutVersion = '';

    public function __construct(array $arguments = [])
    {
        $this->order = new Order;
        $this->customer = new Customer;
    }

    public function jsonSerialize()
    {
        $data = [
            'order' => $this->order->jsonSerialize(),
            'customer' => $this->customer->jsonSerialize(),
            'method' => $this->method,
            'type' => $this->type,
            'storeId' => $this->storeId,
            'redirectUrl' => escape_url($this->redirectUrl),
            'notifyUrl' => escape_url($this->notifyUrl),
            'layoutVersion' => $this->layoutVersion,
        ];

        $validator = new Validator;
        $validation = $validator->make($data, [
            'order' => 'required',
            'customer' => 'required',
            'type' => 'required|in:WEB_PAYMENT,MOBILE_PAYMENT',
            'storeId' => 'required|max:255',
            'redirectUrl' => 'required|url',
            'notifyUrl' => 'required|url',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return $data;
    }
}
