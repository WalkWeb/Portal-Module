<?php

declare(strict_types=1);

namespace Tests\src\Portal\Chat\Message;

use Portal\Chat\Message\ChatMessage;
use Portal\Chat\User\ChatUser;
use Tests\AbstractUnitTest;

class ChatMessageTest extends AbstractUnitTest
{
    /**
     * Тест на создание объекта сообщения чата
     */
    public function testChatMessageCreate(): void
    {
        $id = 'd5372f7c-7c75-4e25-8856-b45b39703a61';
        $message = 'message';
        $channelId = 'b36edd66-a504-4e2f-9764-fddd213d4391';
        $user = new ChatUser('1c1603e3-61e1-452c-adfd-8721edbb86b7', 'User', 'avatar.png');

        $chatMessage = new ChatMessage($id, $message, $channelId, $user);

        self::assertEquals($id, $chatMessage->getId());
        self::assertEquals($message, $chatMessage->getMessage());
        self::assertEquals($channelId, $chatMessage->getChannelId());
        self::assertEquals($user, $chatMessage->getUser());
    }
}
