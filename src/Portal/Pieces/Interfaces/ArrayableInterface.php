<?php

namespace Portal\Pieces\Interfaces;

interface ArrayableInterface
{
    /**
     * Представляет объект в виде массива
     *
     * @return array
     */
    public function toArray(): array;
}
