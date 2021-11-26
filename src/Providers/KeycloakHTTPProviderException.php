<?php

namespace hstng\KeycloakAdminClient\Providers;

use Exception;
use Throwable;

class KeycloakHTTPProviderException extends Exception
{
    const REQUEST_GET = 1;
    const AUTH = 2;

    public static function SendGetRequestError(Throwable $prev) : self {
        return new self("Get request sending error", self::REQUEST_GET, $prev);
    }

    public static function AuthError(Throwable $prev) : self {
        return new self("Authenticate error", self::AUTH, $prev);
    }
}