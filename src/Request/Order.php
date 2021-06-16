<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Exceptions\ValidationException;

class Order implements JsonSerializable
{
    public $id = '';
    public $currencyType = 'MYR';
    public $amount = 0;
    public $title = '';
    public $detail = '';
    public $additionalData = '';

    public function jsonSerialize()
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'currencyType' => $this->currencyType,
            'amount' => $this->amount,
            'detail' => $this->detail,
            'additionalData' => $this->additionalData,
        ];

        return $data;
    }
}
