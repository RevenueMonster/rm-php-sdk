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

    // Add the #[\ReturnTypeWillChange] attribute to suppress warnings supporting PHP versions before PHP 8.1
    // or the proper return type in PHP 8.1+ would be eg. jsonSerialize(): mixed
    #[\ReturnTypeWillChange]
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
