<?php

namespace SfrAuthentication;

use Throwable;

class SfrAuthenticationException extends SfrException
{
    public const INVALID_CREDENTIALS = 1;

    public int $authenticationResult;

    public function __construct(int $authenticationResult, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->authenticationResult = $authenticationResult;
    }
}
