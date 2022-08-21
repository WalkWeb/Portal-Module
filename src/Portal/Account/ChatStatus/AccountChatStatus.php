<?php

declare(strict_types=1);

namespace Portal\Account\ChatStatus;

use Portal\Account\AccountException;

class AccountChatStatus implements ChatStatusInterface
{
    private static array $map = [
        self::ACTIVE          => 'Active',
        self::READ_ONLY       => 'Read only',
        self::BLOCKED         => 'Blocked',
        self::MODERATOR_HUMAN => 'Moderator humans channels',
        self::MODERATOR_ELF   => 'Moderator elves channels',
        self::MODERATOR_ORC   => 'Moderator orcs channels',
        self::MODERATOR_DWARF => 'Moderator dwarfs channels',
        self::MODERATOR_ANGEL => 'Moderator angels channels',
        self::MODERATOR_DEMON => 'Moderator demos channels',
        self::ADMIN           => 'Admin',
    ];

    private int $id;

    private string $name;

    /**
     * @param int $id
     * @throws AccountException
     */
    public function __construct(int $id)
    {
        $this->id = $id;
        $this->setName($id);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param int $channelId
     * @param int $chatStatusId
     * @return bool
     */
    public function isModerator(int $channelId, int $chatStatusId): bool
    {
        // TODO After added chat channels
        return false;
    }

    /**
     * @param int $id
     * @throws AccountException
     */
    private function setName(int $id): void
    {
        if (!array_key_exists($id, self::$map)) {
            throw new AccountException(AccountException::UNKNOWN_ACCOUNT_CHAT_STATUS_ID . ': ' . $id);
        }

        $this->name = self::$map[$id];
    }
}
