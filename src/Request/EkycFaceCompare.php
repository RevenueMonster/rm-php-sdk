<?php

namespace RevenueMonster\SDK\Request;

use Exception;
use stdClass;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Exceptions\ValidationException;

class EkycFaceCompare implements JsonSerializable
{
    public $base64Image1 = '';
    public $base64Image2 = '';

    public function __construct(array $arguments = [])
    {
        $request = new stdClass;
        $request->base64Image1 = $this->base64Image1;
        $request->base64Image2 = $this->base64Image2;
        $this->request = $request;
    }

    public function jsonSerialize()
    {
        $data = [
            'function' => 'face-compare',
            'request' => [
                "query_image_content_1" => $this->base64Image1,
                "query_image_content_2" => $this->base64Image2,
            ],
        ];

        $validator = new Validator;
        $validation = $validator->make($data, [
            'request.query_image_content_1' => 'required',
            'request.query_image_content_2' => 'required',
        ]);

        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return $data;
    }
}
