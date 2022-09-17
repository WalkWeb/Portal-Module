<?php

declare(strict_types=1);

namespace Portal\Account\Notice;

use Countable;
use Iterator;
use Portal\Traits\CollectionTrait;

class NoticeCollection implements Iterator, Countable
{
    use CollectionTrait;

    /**
     * @var NoticeInterface[]
     */
    private array $elements = [];

    public function add(NoticeInterface $notice): void
    {
        $this->elements[] = $notice;
    }

    public function current(): NoticeInterface
    {
        return current($this->elements);
    }
}
