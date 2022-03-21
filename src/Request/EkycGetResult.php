<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use stdClass;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Exceptions\ValidationException;

class EkycGetResult implements JsonSerializable
{
    public $id = '';

    public function __construct(array $arguments = [])
    {
        $request = new stdClass;
        $request->id = $this->id;
        $this->request = $request;
    }

    public function jsonSerialize()
    {
        $data = [
            'function' => 'get-ekyc-result',
            'request' => [
                "id" => $this->id
            ],
        ];

        $validator = new Validator;
        $validation = $validator->make($data, [
            'request.id' => 'required',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return $data;
    }
}
