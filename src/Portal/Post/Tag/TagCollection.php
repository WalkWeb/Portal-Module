<?php

declare(strict_types=1);

namespace Portal\Post\Tag;

use Countable;
use Iterator;
use Portal\Pieces\Interfaces\ArrayableInterface;
use Portal\Pieces\Traits\CollectionTrait;

class TagCollection implements Iterator, Countable, ArrayableInterface
{
    use CollectionTrait;

    /**
     * @var TagInterface[]
     */
    private array $elements = [];

    /**
     * @param TagInterface $tag
     * @throws TagException
     */
    public function add(TagInterface $tag): void
    {
        if (array_key_exists($tag->getId(), $this->elements)) {
            throw new TagException(TagException::ALREADY_EXIST);
        }

        $this->elements[$tag->getId()] = $tag;
    }

    /**
     * @return TagInterface
     */
    public function current(): TagInterface
    {
        return current($this->elements);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        foreach ($this as $tag) {
            $array[] = $tag->toArray();
        }

        return $array;
    }
}
