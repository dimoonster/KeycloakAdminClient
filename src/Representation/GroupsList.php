<?php

namespace hstng\KeycloakAdminClient\Representation;

use hstng\KeycloakAdminClient\Tools\RepresentationIterator;
use IteratorAggregate;
use LogicException;

/**
 * @template-implements IteratorAggregate<string, GroupRepresentation>
 */
class GroupsList implements IteratorAggregate
{
    /** @var array<string, GroupRepresentation> */
    private array $groups;

    /**
     * @param GroupRepresentation[] $groups
     */
    public function __construct(array $groups)
    {
        $this->groups = [];
        foreach ($groups as $group) {
            $this->groups[$group->getId()] = $group;
        }
    }

    public static function fromArray(array $data) : self {
        $groups = [];
        foreach ($data as $datum) {
            $groups[] = GroupRepresentation::fromArray($datum);
        }
        return new self($groups);
    }

    public function getGroupByID(string $id) : GroupRepresentation {
        if(array_key_exists($id, $this->groups)) return $this->groups[$id];
        throw new LogicException("Group ID $id doesn't exists");
    }

    /**
     * @return RepresentationIterator<string, GroupRepresentation>
     */
    public function getIterator() : RepresentationIterator {
        return new RepresentationIterator($this->groups);
    }
}