<?php

declare(strict_types=1);

namespace Portal\Account\Notice;

use Countable;
use Iterator;
use Portal\Pieces\Traits\CollectionTrait;

class NoticeCollection implements Iterator, Countable
{
    use CollectionTrait;

    /**
     * @var NoticeInterface[]
     */
    private array $elements = [];

    /**
     * @param NoticeInterface $notice
     * @throws NoticeException
     */
    public function add(NoticeInterface $notice): void
    {
        if (array_key_exists($notice->getId(), $this->elements)) {
            throw new NoticeException(NoticeException::ALREADY_EXIST);
        }

        $this->elements[$notice->getId()] = $notice;
    }

    public function current(): NoticeInterface
    {
        return current($this->elements);
    }
}
