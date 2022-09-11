<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Notice;

use DateTime;
use Portal\Account\Notice\Notice;
use Portal\Account\Notice\NoticeException;
use Tests\AbstractUnitTest;

class NoticeTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание уведомления
     *
     * @throws NoticeException
     */
    public function testNoticeCreateSuccess(): void
    {
        $id = 'd79f1191-d486-46b5-9624-e4a75bdaeeaf';
        $type = 1;
        $accountId = '3a08a6c4-ebca-4444-bff5-0eac1634fa15';
        $message = 'Notice message';
        $view = true;
        $createdAt = new DateTime('2019-08-12 14:00:00');

        $notice = new Notice($id, $type, $accountId, $message, $view, $createdAt);

        self::assertEquals($id, $notice->getId());
        self::assertEquals($type, $notice->getType());
        self::assertEquals($accountId, $notice->getAccountId());
        self::assertEquals($message, $notice->getMessage());
        self::assertEquals($view, $notice->isView());
        self::assertEquals($createdAt, $notice->getCreatedAt());
    }

    /**
     * Тест на ситуацию, когда передан неизвестный тип уведомления
     *
     * @throws NoticeException
     */
    public function testNoticeCreateUnknownType(): void
    {
        $id = 'd79f1191-d486-46b5-9624-e4a75bdaeeaf';
        $type = 4;
        $accountId = '3a08a6c4-ebca-4444-bff5-0eac1634fa15';
        $message = 'Notice message';
        $view = true;
        $createdAt = new DateTime('2019-08-12 14:00:00');

        $this->expectException(NoticeException::class);
        $this->expectExceptionMessage(NoticeException::UNKNOWN_TYPE . ': ' . $type);
        new Notice($id, $type, $accountId, $message, $view, $createdAt);
    }
}
