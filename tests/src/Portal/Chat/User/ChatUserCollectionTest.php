<?php

declare(strict_types=1);

namespace Tests\src\Portal\Chat\User;

use Portal\Chat\User\ChatUser;
use Portal\Chat\User\ChatUserCollection;
use Portal\Chat\User\ChatUserException;
use Tests\AbstractUnitTest;

class ChatUserCollectionTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание ChatUserCollection
     *
     * @throws ChatUserException
     */
    public function testTagCollectionCreateSuccess(): void
    {
        $collection = new ChatUserCollection();

        self::assertCount(0, $collection);

        $user1 = new ChatUser(
            '8f009f45-c789-40d2-9c23-df4b704383d0',
            'User#1',
            'avatar-1.png'
        );
        $user2 = new ChatUser(
            '978f4202-b6b2-450f-86bb-7706eadae276',
            'User#2',
            'avatar-2.png'
        );

        $collection->add($user1);
        $collection->add($user2);

        self::assertCount(2, $collection);

        $i = 0;
        foreach ($collection as $user) {
            if ($i === 0) {
                self::assertEquals($user1, $user);
            }
            if ($i === 1) {
                self::assertEquals($user2, $user);
            }
            $i++;
        }
    }

    /**
     * Тест на ситуацию, когда в коллекцию добавляется пользователь, который в ней уже существует
     *
     * @throws ChatUserException
     */
    public function testNoticeCollectionDoubleNotice(): void
    {
        $collection = new ChatUserCollection();

        $user = new ChatUser(
            '8f009f45-c789-40d2-9c23-df4b704383d0',
            'User#1',
            'avatar-1.png'
        );

        $collection->add($user);

        $this->expectException(ChatUserException::class);
        $this->expectExceptionMessage(ChatUserException::ALREADY_EXIST);
        $collection->add($user);
    }
}
