<?php
declare(strict_types=1);
namespace hstng\KeycloakAdminClient\Representation;

use Countable;
use hstng\KeycloakAdminClient\Tools\RepresentationIterator;
use IteratorAggregate;

/**
 * @template-implements IteratorAggregate<string, UserRepresentation>
 */
class UsersList implements IteratorAggregate, Countable {
    /** @var array<string, UserRepresentation> */
    private array $users;

    /**
     * @param UserRepresentation[] $users
     */
    public function __construct(array $users) {
        $this->users = [];
        foreach ($users as $user) {
            $this->users[$user->getId()] = $user;
        }
    }

    public static function fromArray(array $items) : UsersList {
        $users = [];

        foreach ($items as $item) {
            $users[] = UserRepresentation::fromArray($item);
        }

        return new self($users);
    }

    /**
     * @return RepresentationIterator<string, UserRepresentation>
     */
    public function getIterator() : RepresentationIterator {
        return new RepresentationIterator($this->users);
    }

    public function count() : int {
        return count($this->users);
    }
}