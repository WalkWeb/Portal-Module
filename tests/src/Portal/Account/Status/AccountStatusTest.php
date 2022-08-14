<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Status;

use Portal\Account\AccountException;
use Portal\Account\Status\AccountStatus;
use Tests\AbstractUnitTest;

class AccountStatusTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание статуса аккаунта
     *
     * @dataProvider successDataProvider
     * @param int $id
     * @param string $name
     * @throws AccountException
     */
    public function testAccountStatusCreateSuccess(int $id, string $name): void
    {
        $status = new AccountStatus($id);

        self::assertEquals($id, $status->getId());
        self::assertEquals($name, $status->getName());
    }

    /**
     * Тест на ситуацию, когда передан неизвестный id
     *
     * @dataProvider failDataProvider
     * @param int $id
     * @param string $error
     */
    public function testAccountStatusCreateFail(int $id, string $error): void
    {
        $this->expectException(AccountException::class);
        $this->expectExceptionMessage($error);
        new AccountStatus($id);
    }

    /**
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [
                1,
                'Active',
            ],
            [
                2,
                'Blocked',
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
                33,
                AccountException::UNKNOWN_ACCOUNT_STATUS_ID . ': 33',
            ],
        ];
    }
}
