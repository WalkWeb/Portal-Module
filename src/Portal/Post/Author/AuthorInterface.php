<?php

declare(strict_types=1);

namespace Portal\Post\Author;

use Portal\Account\Status\AccountStatusInterface;

/**
 * Для отображения информации об авторе поста создавать полноценный объект автора избыточно. По этому используется
 * отдельный объект, который имеет только те параметры, которые необходимы.
 *
 * @package Portal\Post\Author
 */
interface AuthorInterface
{
    /**
     * Возвращает ID автора поста
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Возвращает имя автора поста
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Возвращает url к аватару автора поста
     *
     * @return string
     */
    public function getAvatar(): string;

    /**
     * Возвращает уровень автора поста
     *
     * @return int
     */
    public function getLevel(): int;

    /**
     * Возвращает статус автора поста
     *
     * @return AccountStatusInterface
     */
    public function getStatus(): AccountStatusInterface;
}
