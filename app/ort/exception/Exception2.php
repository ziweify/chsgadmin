<?php

namespace App\ort\exception;

use Throwable;

class Exception2 extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
