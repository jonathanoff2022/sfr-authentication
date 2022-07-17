<?php

namespace SfrAuthentication;

use Throwable;

class SfrAuthenticationException extends SfrException
{
    // See com.altice.android.services.account.sfr.remote.CasAuthSFR$Companion$errorCodeTable$1

    public const INVALID_CREDENTIALS = 1;
    public const ACCOUNT_LOCKED = 2;

    public int $authenticationResult;

    public function __construct(int $authenticationResult, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->authenticationResult = $authenticationResult;
    }
}
