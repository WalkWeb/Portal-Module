<?php

declare(strict_types=1);

namespace Portal\Chat\User;

/**
 * Для отображения пользователей в чате используется миниатюрная модель пользователя, которая имеет только те параметры,
 * которые нужны в чате
 *
 * @package Portal\Chat\ChatUser
 */
interface ChatUserInterface
{
    /**
     * Возвращает id пользователя чата
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Возвращает имя пользователя чата
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Возвращает url к аватару пользователя чата
     *
     * @return string
     */
    public function getAvatar(): string;
}
