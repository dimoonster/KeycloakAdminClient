<?php

namespace hstng\KeycloakAdminClient\Representation;

use hstng\KeycloakAdminClient\Tools\RepresentationIterator;
use IteratorAggregate;

class AttributesList implements IteratorAggregate {
    /** @var array<string, AttributeRepresentation> */
    private array $attributes;

    /**
     * @param AttributeRepresentation[] $attributes
     */
    public function __construct(array $attributes) {
        $this->attributes = [];
        foreach ($attributes as $attribute) {
            $this->attributes[$attribute->getName()] = $attribute;
        }
    }

    public static function fromArray(array $data) : self {
        $items = [];

        foreach ($data as $attributeName=>$attributeValues) {
            $items[] = new AttributeRepresentation($attributeName, $attributeValues);
        }

        return new self($items);
    }

    public function hasAttribute(string $attributeName) : bool {
        return array_key_exists($attributeName, $this->attributes);
    }

    public function getAttribute(string $attributeName) : AttributeRepresentation {
        return $this->attributes[$attributeName];
    }

    /**
     * @return RepresentationIterator<string, AttributeRepresentation>
     */
    public function getIterator() : RepresentationIterator {
        return new RepresentationIterator($this->attributes);
    }
}