<?php

namespace hstng\KeycloakAdminClient\Requests;

use Exception;

class UserSearchRequestException extends Exception
{
    const UNKNOWN_FIELD = 1;
    const INVALID_FIELD_TYPE = 2;
    const FIELD_VALUE_DOESNT_EXISTS = 3;

    public static function unknownField(string $field) : UserSearchRequestException {
        return new self("Unknown field $field", self::UNKNOWN_FIELD);
    }

    public static function invalidFieldType(string $field, string $needType, string $providedType) : UserSearchRequestException {
        return new self(
            "Invalid value type '$providedType' for field $field, excepted $needType",
            self::INVALID_FIELD_TYPE
        );
    }

    public static function fieldValueDoesntExists(string $field) : UserSearchRequestException {
        return new self(
            "Field $field value doesn't exists",
            self::FIELD_VALUE_DOESNT_EXISTS
        );
    }
}