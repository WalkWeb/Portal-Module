<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\Author;

use Portal\Account\AccountException;
use Portal\Account\Status\AccountStatus;
use Portal\Post\Author\Author;
use Tests\AbstractUnitTest;

class AuthorTest extends AbstractUnitTest
{
    /**
     * Тест на создание автора поста
     *
     * @throws AccountException
     */
    public function testAuthorCreate(): void
    {
        $id = '4f88c009-6605-4ed9-9ba3-09a92b63bbdb';
        $name = 'Name';
        $avatar = 'avatar.png';
        $level = 15;
        $status = new AccountStatus(1);

        $author = new Author($id, $name, $avatar, $level, $status);

        self::assertEquals($id, $author->getId());
        self::assertEquals($name, $author->getName());
        self::assertEquals($avatar, $author->getAvatar());
        self::assertEquals($level, $author->getLevel());
        self::assertEquals($status, $author->getStatus());
    }
}
