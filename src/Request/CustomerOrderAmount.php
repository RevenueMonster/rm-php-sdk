<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Exceptions\ValidationException;

class CustomerOrderAmount implements JsonSerializable
{
    public $currency = 'MYR';
    public $amount = 0;

    public function jsonSerialize()
    {
        $data = [
            'currency' => $this->currency,
            'amount' => $this->amount,
        ];

        return $data;
    }
}
