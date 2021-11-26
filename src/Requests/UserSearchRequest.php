<?php

namespace hstng\KeycloakAdminClient\Requests;

class UserSearchRequest {
    private int $firstResult;
    private int $maxResults;
    private array $fields;

    const AVAILABLE_FIELDS_TYPES = [
        'search' => 'string',
        'username' => 'string',
        'firstName' => 'string',
        'lastName' => 'string',
        'email' => 'string',
        'emailVerified' => 'boolean',
        'idpAlias' => 'string',
        'idpUserId' => 'string',
        'enabled' => 'boolean',
    ];

    public function __construct() {
        $this->fields = [];
        $this->firstResult = 0;
        $this->maxResults = 50;
    }

    public function withFirstResult(int $position) : UserSearchRequest {
        $object = clone $this;
        $object->firstResult = $position;
        return $object;
    }
    public function getFirstResult() : int {
        return $this->firstResult;
    }
    public function withMaxResults(int $count) : UserSearchRequest {
        $object = clone $this;
        $object->maxResults = $count;
        return $object;
    }
    public function getMaxResults() : int {
        return $this->maxResults;
    }

    /**
     * @param string $field
     * @param string|bool $value
     * @return $this
     * @throws UserSearchRequestException
     */
    public function with(string $field, $value) : UserSearchRequest {
        if(isset(self::AVAILABLE_FIELDS_TYPES[$field]) === false)
            throw UserSearchRequestException::unknownField($field);

        if(gettype($value) !== self::AVAILABLE_FIELDS_TYPES[$field])
            throw UserSearchRequestException::invalidFieldType($field, self::AVAILABLE_FIELDS_TYPES[$field], gettype($value));

        $obj = clone $this;
        $obj->fields[$field] = $value;
        return $obj;
    }

    /**
     * @param string $field
     * @return UserSearchRequest
     * @throws UserSearchRequestException
     */
    public function without(string $field) : UserSearchRequest {
        if(isset(self::AVAILABLE_FIELDS_TYPES[$field]) === false)
            throw UserSearchRequestException::unknownField($field);

        if(isset($this->fields[$field]) === false)
            throw UserSearchRequestException::fieldValueDoesntExists($field);

        $object = clone $this;
        unset($object->fields[$field]);
        return $object;
    }

    public function has(string $field) : bool {
        return isset($this->fields[$field]);
    }

    /**
     * @throws UserSearchRequestException
     */
    public function get(string $field) {
        if($this->has($field) === false)
            throw UserSearchRequestException::fieldValueDoesntExists($field);

        return $this->fields[$field];
    }

    /**
     * @throws UserSearchRequestException
     */
    public function toRequestArray() : array {
        $data = [
            'first' => $this->getFirstResult(),
            'max' => $this->getMaxResults(),
        ];

        foreach (self::AVAILABLE_FIELDS_TYPES as $field=>$type) {
            if($this->has($field)) {
                switch($type) {
                    case 'boolean':
                        $value = $this->get($field) ? 'true' : 'false';
                        break;
                    default:
                        $value = $this->get($field);
                }
                $data[$field] = $value;
            }
        }

        return $data;
    }
}