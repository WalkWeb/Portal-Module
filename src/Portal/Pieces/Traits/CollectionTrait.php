<?php

declare(strict_types=1);

namespace Portal\Pieces\Traits;

/**
 * Вспомогательный trait для создания собственных коллекций со строгой типизацией - коллекций, которые на добавление
 * элемента и возвращение текущего будут проверять типизацию, например:
 *
 * use CollectionTrait;
 *
 * public function add(NoticeInterface $notice): void
 * {
 *     $this->elements[] = $notice;
 * }
 *
 * public function current(): NoticeInterface
 * {
 *     return current($this->elements);
 * }
 *
 * @package Battle\Traits
 */
trait CollectionTrait
{
    public function key()
    {
        return key($this->elements);
    }

    public function next()
    {
        return next($this->elements);
    }

    public function rewind(): void
    {
        reset($this->elements);
    }

    public function valid(): bool
    {
        return key($this->elements) !== null;
    }

    public function count(): int
    {
        return count($this->elements);
    }
}
