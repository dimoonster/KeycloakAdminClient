<?php

namespace hstng\KeycloakAdminClient\Representation;

use hstng\KeycloakAdminClient\Tools\RepresentationIterator;
use IteratorAggregate;

/**
 * @template-implements IteratorAggregate<string, RoleRepresentation>
 */
class RolesList implements IteratorAggregate
{
    /** @var array<string, RoleRepresentation>  */
    private array $roles;

    /**
     * @param RoleRepresentation[] $roles
     */
    public function __construct(array $roles)
    {
        $this->roles = [];
        foreach ($roles as $role) {
            $this->roles[$role->getId()] = $role;
        }
    }

    public static function fromArray(array $data) : RolesList {
        $roles = [];
        foreach ($data as $datum) {
            $roles[] = RoleRepresentation::fromArray($datum);
        }
        return new RolesList($roles);
    }

    /**
     * @return RepresentationIterator<string, RoleRepresentation>
     */
    public function getIterator() : RepresentationIterator {
        return new RepresentationIterator($this->roles);
    }
}