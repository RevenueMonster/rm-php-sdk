<?php 

namespace RevenueMonster\SDK\Request;

use Exception;
use stdClass;
use JsonSerializable;
use Rakit\Validation\Validator;
use RevenueMonster\SDK\Exceptions\ValidationException;

class PredictMykad implements JsonSerializable
{
    public $base64Image = '';

    public function __construct(array $arguments = []) 
    {
        $request = new stdClass;
        $request->base64Image = $this->base64Image;
        $this->request = $request;
    }

    public function jsonSerialize()
    {
        $data = [
            'function' => 'mykad',
            'request' => [
                "query_image_content" => $this->base64Image,
            ],
        ];

        $validator = new Validator;
        $validation = $validator->make($data, [
            'request.query_image_content' => 'required',
        ]);
        
        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }

        return $data;
    }
}