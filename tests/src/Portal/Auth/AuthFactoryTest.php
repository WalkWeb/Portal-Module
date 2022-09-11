<?php

declare(strict_types=1);

namespace Tests\src\Portal\Auth;

use Exception;
use Portal\Account\AccountException;
use Portal\Account\ChatStatus\AccountChatStatus;
use Portal\Account\Energy\EnergyFactory;
use Portal\Account\Group\AccountGroup;
use Portal\Account\Status\AccountStatus;
use Portal\Auth\AuthException;
use Portal\Auth\AuthFactory;
use Portal\Traits\Validation\ValidationException;
use Tests\AbstractUnitTest;

class AuthFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание объекта Auth на основе массива с параметрами
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @throws ValidationException
     * @throws AccountException
     */
    public function testAuthFactoryCreateSuccess(array $data): void
    {
        $auth = $this->getFactory()->create($data);

        self::assertEquals($data['id'], $auth->getId());
        self::assertEquals($data['name'], $auth->getName());
        self::assertEquals($data['avatar'], $auth->getAvatar());
        self::assertEquals(new AccountGroup($data['account_group_id']), $auth->getGroup());
        self::assertEquals(new AccountStatus($data['account_status_id']), $auth->getStatus());
        self::assertEquals(new AccountChatStatus($data['account_chat_status_id']), $auth->getChatStatus());
        self::assertEquals($data['can_like'], $auth->isCanLike());

        $exceptedEnergy = $this->getEnergyFactory()->create($data['energy']);

        self::assertEquals($exceptedEnergy->getId(), $auth->getEnergy()->getId());
        self::assertEquals($auth->getId(), $auth->getEnergy()->getAccountId());
        self::assertEquals($exceptedEnergy->getEnergy(), $auth->getEnergy()->getEnergy());
        self::assertEquals($exceptedEnergy->getMaxEnergy(), $auth->getEnergy()->getMaxEnergy());
        self::assertEquals($exceptedEnergy->getUpdatedAt(), $auth->getEnergy()->getUpdatedAt());
        self::assertEquals($exceptedEnergy->getResidue(), $auth->getEnergy()->getResidue());
        self::assertEquals($exceptedEnergy->getEnergyWeight(), $auth->getEnergy()->getEnergyWeight());
        self::assertEquals($exceptedEnergy->getRestoreWeight(), $auth->getEnergy()->getRestoreWeight());
        self::assertEquals($exceptedEnergy->isUpdated(), $auth->getEnergy()->isUpdated());
    }

    /**
     * Тесты на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @throws Exception
     */
    public function testAuthFactoryCreateFail(array $data, string $error): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage($error);
        $this->getFactory()->create($data);
    }

    /**
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
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
                // отсутствует id
                [
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_ID,
            ],
            [
                // id некорректного типа
                [
                    'id'                     => 123,
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_ID,
            ],
            [
                // отсутствует name
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_NAME,
            ],
            [
                // name некорректного типа
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => true,
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_NAME,
            ],
            [
                // отсутствует avatar
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_AVATAR,
            ],
            [
                // avatar некорректного типа
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => ['account_avatar.png'],
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_AVATAR,
            ],
            [
                // отсутствует account_group_id
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_ACCOUNT_GROUP_ID,
            ],
            [
                // account_group_id некорректного типа
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 'success',
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_ACCOUNT_GROUP_ID,
            ],
            [
                // отсутствует account_status_id
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_ACCOUNT_STATUS_ID,
            ],
            [
                // account_status_id некорректного типа
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => '1',
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_ACCOUNT_STATUS_ID,
            ],
            [
                // отсутствует account_chat_status_id
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_ACCOUNT_CHAT_STATUS_ID,
            ],
            [
                // account_chat_status_id некорректного типа
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => '3',
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => true,
                ],
                AuthException::INVALID_ACCOUNT_CHAT_STATUS_ID,
            ],
            [
                // отсутствует energy
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'can_like'               => true,
                ],
                AuthException::INVALID_ENERGY_DATA,
            ],
            [
                // energy некорректного типа
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => 100,
                    'can_like'               => true,
                ],
                AuthException::INVALID_ENERGY_DATA,
            ],
            [
                // отсутствует can_like
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                ],
                AuthException::INVALID_CAN_LIKE,
            ],
            [
                // can_like некорректного типа
                [
                    'id'                     => '68435c80-eb31-4756-a260-a00900e5db9f',
                    'name'                   => 'AccountName',
                    'avatar'                 => 'account_avatar.png',
                    'account_group_id'       => 10,
                    'account_status_id'      => 1,
                    'account_chat_status_id' => 3,
                    'energy'                 => [
                        'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                        'account_id'        => '68435c80-eb31-4756-a260-a00900e5db9f',
                        'energy'            => 30,
                        'energy_bonus'      => 15,
                        'energy_updated_at' => 1566745426.0000,
                        'energy_residue'    => 10,
                    ],
                    'can_like'               => 1,
                ],
                AuthException::INVALID_CAN_LIKE,
            ],
        ];
    }

    /**
     * @return AuthFactory
     */
    private function getFactory(): AuthFactory
    {
        return new AuthFactory($this->getEnergyFactory());
    }

    /**
     * @return EnergyFactory
     */
    private function getEnergyFactory(): EnergyFactory
    {
        return new EnergyFactory();
    }
}
