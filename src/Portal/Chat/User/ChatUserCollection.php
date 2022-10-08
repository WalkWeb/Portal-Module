<?php

declare(strict_types=1);

namespace Portal\Chat\User;

use Countable;
use Iterator;
use Portal\Traits\CollectionTrait;

class ChatUserCollection implements Iterator, Countable
{
    use CollectionTrait;

    /**
     * @var ChatUserInterface[]
     */
    private array $elements = [];

    /**
     * @param ChatUserInterface $user
     * @throws ChatUserException
     */
    public function add(ChatUserInterface $user): void
    {
        if (array_key_exists($user->getId(), $this->elements)) {
            throw new ChatUserException(ChatUserException::ALREADY_EXIST);
        }

        $this->elements[$user->getId()] = $user;
    }

    /**
     * @return ChatUserInterface
     */
    public function current(): ChatUserInterface
    {
        return current($this->elements);
    }
}
