<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Request\Order;
use RevenueMonster\SDK\Exceptions\ValidationException;

class QuickPay implements JsonSerializable
{
    public $authCode;
    public $order;
    public $ipAddress;
    public $terminalId;
    public $storeId;

    public function __construct(array $arguments = [])
    {
        $this->order = new Order;
    }

    public function jsonSerialize()
    {
        $data = [
            'authCode' => $this->authCode,
            'order' => $this->order->jsonSerialize(),
            'ipAddress' => $this->ipAddress,
            'terminalId' => $this->terminalId,
            'storeId' => $this->storeId,
        ];

        $validator = new Validator;
        $validation = $validator->make($data, [
            'authCode' => 'required',
            'order' => 'required',
            'ipAddress' => 'required|ip',
            'storeId' => 'required',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return $data;
    }
}
