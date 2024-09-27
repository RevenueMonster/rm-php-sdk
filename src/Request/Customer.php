<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Exceptions\ValidationException;

class Customer implements JsonSerializable
{
    public $userId = '';
    public $email = '';
    public $countryCode = '';
    public $phoneNumber = '';

    // Add the #[\ReturnTypeWillChange] attribute to suppress warnings supporting PHP versions before PHP 8.1
    // or the proper return type in PHP 8.1+ would be eg. jsonSerialize(): mixed
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = [
            'userId' => $this->userId,
            'email' => $this->email,
            'countryCode' => $this->countryCode,
            'phoneNumber' => $this->phoneNumber,
        ];

        return $data;
    }
}
