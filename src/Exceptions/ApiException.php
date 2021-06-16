<?php

namespace RevenueMonster\SDK\Exceptions;

use Httpful\Response;
use Exception;

class ApiException extends Exception
{
    public static $UNKNOWN_ERROR = 'UNKNOWN_ERROR';

    protected $errorCode = '';

    public function __construct(int $statusCode = 500, string $errorCode = "", string $message = "", Exception $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
        $this->errorCode = $errorCode;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }
}
