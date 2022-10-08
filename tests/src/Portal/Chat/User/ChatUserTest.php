<?php

declare(strict_types=1);

namespace Tests\src\Portal\Chat\User;

use Portal\Chat\User\ChatUser;
use Tests\AbstractUnitTest;

class ChatUserTest extends AbstractUnitTest
{
    /**
     * Тест на создание пользователя чата
     */
    public function testChatUserCreate(): void
    {
        $id = '025f32a4-a128-4815-80fc-b0878713aa99';
        $name = 'User';
        $avatar = 'avatar.png';

        $chatUser = new ChatUser($id, $name, $avatar);

        self::assertEquals($id, $chatUser->getId());
        self::assertEquals($name, $chatUser->getName());
        self::assertEquals($avatar, $chatUser->getAvatar());
    }
}
