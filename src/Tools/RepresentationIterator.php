<?php

namespace hstng\KeycloakAdminClient\Tools;

use Countable;
use Iterator;

/**
 * @template TKey
 * @template TVal
 */
class RepresentationIterator implements Iterator, Countable {
    /** @var array<TKey, TVal> */
    private array $items;
    /** @var TKey[]  */
    private array $index;
    private int $position;

    /**
     * @param array<TKey, TVal> $items
     */
    public function __construct(array $items) {
        $this->items = $items;
        $this->index = array_keys($items);
        $this->position = 0;
    }

    /**
     * @return TVal
     */
    public function current() {
        return $this->items[$this->key()];
    }

    public function next() : void {
        $this->position++;
    }

    /**
     * @return TKey
     */
    public function key() {
        return $this->index[$this->position];
    }

    public function valid() : bool {
        return isset($this->index[$this->position]);
    }

    public function rewind() : void {
        $this->position = 0;
    }

    public function count() : int {
        return count($this->items);
    }
}