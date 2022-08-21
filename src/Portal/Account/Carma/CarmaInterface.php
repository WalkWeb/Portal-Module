<?php

declare(strict_types=1);

namespace Portal\Account\Carma;

interface CarmaInterface
{
    /**
     * Возвращает id аккаунта, к которому относится данная карма
     *
     * @return string
     */
    public function getAccountId(): string;

    /**
     * Возвращает общую карму аккаунта
     *
     * @return int
     */
    public function getTotalCarma(): int;

    /**
     * Возвращает суммарную карму аккаунта по постам
     *
     * @return int
     */
    public function getPostCarma(): int;

    /**
     * Возвращает суммарную карму аккаунта по комментариям
     *
     * @return int
     */
    public function getCommentCarma(): int;
}
