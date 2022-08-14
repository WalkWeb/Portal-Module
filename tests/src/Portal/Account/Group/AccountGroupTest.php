<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Group;

use Portal\Account\AccountException;
use Portal\Account\Group\AccountGroup;
use Tests\AbstractUnitTest;

class AccountGroupTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание группы аккаунта
     *
     * @dataProvider successDataProvider
     * @param int $id
     * @param string $name
     * @throws AccountException
     */
    public function testAccountGroupCreateSuccess(int $id, string $name): void
    {
        $status = new AccountGroup($id);

        self::assertEquals($id, $status->getId());
        self::assertEquals($name, $status->getName());
    }

    /**
     * Тест на ситуацию, когда передан неизвестный id группы аккаунта
     *
     * @dataProvider failDataProvider
     * @param int $id
     * @param string $error
     */
    public function testAccountGroupCreateFail(int $id, string $error): void
    {
        $this->expectException(AccountException::class);
        $this->expectExceptionMessage($error);
        new AccountGroup($id);
    }

    /**
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [
                10,
                'User',
            ],
            [
                20,
                'Moderator',
            ],
            [
                31,
                'Admin',
            ],
            [
                30,
                'Main Admin',
            ],
        ];
    }

    /**
     * @return array
     */
    public function failDataProvider(): array
    {
        return [
            [
                77,
                AccountException::UNKNOWN_ACCOUNT_GROUP_ID . ': 77',
            ],
        ];
    }
}
