<?php

declare(strict_types=1);

namespace Portal\Post\Tag;

use Countable;
use Iterator;
use Portal\Pieces\Traits\CollectionTrait;

class TagCollection implements Iterator, Countable
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
}
