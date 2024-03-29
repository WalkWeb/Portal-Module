<?php

declare(strict_types=1);

namespace Portal\Account\Group;

use Portal\Account\AccountException;

class AccountGroup implements AccountGroupInterface
{
    private static array $map = [
        self::USER       => 'User',
        self::MODERATOR  => 'Moderator',
        self::ADMIN      => 'Admin',
        self::MAIN_ADMIN => 'Main Admin',
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
     * @param int $id
     * @throws AccountException
     */
    private function setName(int $id): void
    {
        if (!array_key_exists($id, self::$map)) {
            throw new AccountException(AccountException::UNKNOWN_ACCOUNT_GROUP_ID . ': ' . $id);
        }

        $this->name = self::$map[$id];
    }
}
