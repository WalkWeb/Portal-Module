<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Notice\Action;

use Portal\Account\Notice\Action\SendNoticeAction;
use Portal\Account\Notice\NoticeException;
use Portal\Account\Notice\NoticeInterface;
use ReflectionClass;
use ReflectionException;
use Tests\AbstractUnitTest;
use Tests\src\Mock\Account\Notice\Repository\MockNoticeRepository;

class SendNoticeActionTest extends AbstractUnitTest
{
    /**
     * Тест на создание и сохранение (как бы сохранение) уведомления для пользователя
     *
     * @throws NoticeException
     * @throws ReflectionException
     */
    public function testSendNoticeAction(): void
    {
        $sendNoticeAction = new SendNoticeAction($mockRepository = new MockNoticeRepository());

        $accountId = '3a08a6c4-ebca-4444-bff5-0eac1634fa15';
        $message = 'Notice message';

        // Создание уведомление и сохранение его
        $sendNoticeAction->send($accountId, $message);

        // Чтобы получить уведомление из репозитория, используем рефлексию
        $reflectionClass = new ReflectionClass($mockRepository);
        $reflectionProperty = $reflectionClass->getProperty('notices');
        $reflectionProperty->setAccessible(true);

        $notices = $reflectionProperty->getValue($mockRepository);

        self::assertCount(1, $notices);

        /** @var NoticeInterface $notice */
        foreach ($notices as $notice) {
            self::assertEquals($accountId, $notice->getAccountId());
            self::assertEquals($message, $notice->getMessage());
            self::assertEquals(NoticeInterface::TYPE_INFO, $notice->getType());
        }
    }
}
