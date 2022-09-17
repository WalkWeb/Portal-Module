<?php

declare(strict_types=1);

namespace Tests\src\Portal\Auth;

use Portal\Account\AccountException;
use Portal\Account\ChatStatus\AccountChatStatus;
use Portal\Account\Energy\Energy;
use Portal\Account\Group\AccountGroup;
use Portal\Account\Status\AccountStatus;
use Portal\Auth\Auth;
use Tests\AbstractUnitTest;

class AuthTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание объекта Auth
     *
     * @throws AccountException
     */
    public function testAuthCreateSuccess(): void
    {
        $id = 'fed7e105-316d-4f9b-bfc4-7d70dba0b680';
        $name = 'Name';
        $avatar = 'avatar.png';
        $group = new AccountGroup(10);
        $status = new AccountStatus(2);
        $chatStatus = new AccountChatStatus(3);
        $energy = new Energy(
            '8d3af2e4-b706-4956-b59f-6d39526dc6dc',
            $id,
            100,
            150,
            (float)microtime(true),
            (float)microtime(true),
            0
        );
        $canLike = true;

        $auth = new Auth($id, $name, $avatar, $group, $status, $chatStatus, $energy, $canLike);

        self::assertEquals($id, $auth->getId());
        self::assertEquals($name, $auth->getName());
        self::assertEquals($avatar, $auth->getAvatar());
        self::assertEquals($group, $auth->getGroup());
        self::assertEquals($status, $auth->getStatus());
        self::assertEquals($chatStatus, $auth->getChatStatus());
        self::assertEquals($energy, $auth->getEnergy());
        self::assertEquals($canLike, $auth->isCanLike());
    }
}