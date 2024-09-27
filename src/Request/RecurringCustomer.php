<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Exceptions\ValidationException;

class RecurringCustomer implements JsonSerializable
{
    public $storeId = '';
    public $email = '';
    public $name = '';
    public $countryCode = '';
    public $phoneNumber = '';
    public $productName = '';
    public $productDescription = '';
    public $currency = 'MYR';
    public $amount = 0;
    public $redirectUrl = '';
    public $notifyUrl = '';
    public $recurringInterval = '';
    public $recurringTarget = '';
    public $recurringRepetition = 1;

    // Add the #[\ReturnTypeWillChange] attribute to suppress warnings supporting PHP versions before PHP 8.1
    // or the proper return type in PHP 8.1+ would be eg. jsonSerialize(): mixed
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = [
            'storeId' => $this->storeId,
            'email' => $this->email,
            'name' => $this->name,
            'countryCode' => $this->countryCode,
            'phoneNumber' => $this->phoneNumber,
            'productName' => $this->productName,
            'productDescription' => $this->productDescription,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'redirectUrl' => escape_url($this->redirectUrl),
            'notifyUrl' => escape_url($this->notifyUrl),
            'recurringInterval' => $this->recurringInterval,
            'recurringTarget' => $this->recurringTarget,
            'recurringRepetition' => $this->recurringRepetition,
        ];

        $validator = new Validator;
        $validation = $validator->make($data, [
            'storeId' => 'required|max:255',
            'email' => 'required',
            'name' => 'required',
            'countryCode' => 'required',
            'phoneNumber' => 'required',
            'productName' => 'required',
            'productDescription' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'redirectUrl' => 'required|url',
            'notifyUrl' => 'required|url',
            'recurringInterval' => 'required|in:WEEKLY,MONTHLY',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return $data;
    }
}
