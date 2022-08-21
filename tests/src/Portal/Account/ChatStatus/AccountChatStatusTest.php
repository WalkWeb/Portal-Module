<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\ChatStatus;

use Portal\Account\AccountException;
use Portal\Account\ChatStatus\AccountChatStatus;
use Tests\AbstractUnitTest;

class AccountChatStatusTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание статуса аккаунта в чате
     *
     * @dataProvider successDataProvider
     * @param int $id
     * @param string $expectedStatus
     * @throws AccountException
     */
    public function testAccountChatStatusCreateSuccess(int $id, string $expectedStatus): void
    {
        $chatStatus = new AccountChatStatus($id);

        self::assertEquals($id, $chatStatus->getId());
        self::assertEquals($expectedStatus, $chatStatus->getName());
        // TODO
        self::assertFalse($chatStatus->isModerator(1, $id));
    }

    /**
     * Тест на ситуацию, когда передан неизвестный id статуса аккаунта в чате
     *
     * @dataProvider failDataProvider
     * @param int $id
     * @param string $error
     * @throws AccountException
     */
    public function testAccountChatStatusCreateFail(int $id, string $error): void
    {
        $this->expectException(AccountException::class);
        $this->expectExceptionMessage($error);
        new AccountChatStatus($id);
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
                'Read only',
            ],
            [
                3,
                'Blocked',
            ],
            [
                4,
                'Moderator humans channels',
            ],
            [
                5,
                'Moderator elves channels',
            ],
            [
                6,
                'Moderator orcs channels',
            ],
            [
                7,
                'Moderator dwarfs channels',
            ],
            [
                8,
                'Moderator angels channels',
            ],
            [
                9,
                'Moderator demos channels',
            ],
            [
                10,
                'Admin',
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
                AccountException::UNKNOWN_ACCOUNT_CHAT_STATUS_ID . ': 33',
            ],
        ];
    }
}
