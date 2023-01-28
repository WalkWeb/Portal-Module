<?php

declare(strict_types=1);

namespace Portal\Post\Comment;

use Countable;
use Iterator;
use Portal\Pieces\Traits\CollectionTrait;

class CommentCollection implements Iterator, Countable
{
    use CollectionTrait;

    /**
     * @var CommentInterface[]
     */
    private array $elements = [];

    /**
     * @param CommentInterface $comment
     * @throws CommentException
     */
    public function add(CommentInterface $comment): void
    {
        if (array_key_exists($comment->getId(), $this->elements)) {
            throw new CommentException(CommentException::ALREADY_EXIST);
        }

        $this->elements[$comment->getId()] = $comment;
    }

    public function current(): CommentInterface
    {
        return current($this->elements);
    }
}
