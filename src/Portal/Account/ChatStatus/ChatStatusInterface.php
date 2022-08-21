<?php

declare(strict_types=1);

namespace Portal\Account\ChatStatus;

interface ChatStatusInterface
{
    public const ACTIVE          = 1;
    public const READ_ONLY       = 2;
    public const BLOCKED         = 3;
    public const MODERATOR_HUMAN = 4;
    public const MODERATOR_ELF   = 5;
    public const MODERATOR_ORC   = 6;
    public const MODERATOR_DWARF = 7;
    public const MODERATOR_ANGEL = 8;
    public const MODERATOR_DEMON = 9;
    public const ADMIN           = 10;

    /**
     * Возвращает ID статуса аккаунта в чате
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Возвращает статус аккаунта в чате
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Является ли аккаунт с указанным статусом модератором канала
     *
     * @param int $channelId
     * @param int $chatStatusId
     * @return bool
     */
    public function isModerator(int $channelId, int $chatStatusId): bool;
}
