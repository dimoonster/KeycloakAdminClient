<?php

namespace hstng\KeycloakAdminClient\Representation;

class AttributeRepresentation {
    private string $name;
    private array $values;

    /**
     * @param string $name
     * @param array $values
     */
    public function __construct(string $name, array $values) {
        $this->name = $name;
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return mixed
     */
    public function getFirst() {
        return $this->values[0];
    }

    public function hasValue(string $value) : bool {
        return in_array($value, $this->values);
    }
}