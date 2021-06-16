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
