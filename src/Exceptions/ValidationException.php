<?php

namespace RevenueMonster\SDK\Exceptions;

use Rakit\Validation\ErrorBag;
use Exception;

class ValidationException extends Exception
{
    protected $errors = '';

    public function __construct(ErrorBag $errors)
    {
        parent::__construct(json_encode($errors->toArray()));
        $this->errors = $errors;
    }
}