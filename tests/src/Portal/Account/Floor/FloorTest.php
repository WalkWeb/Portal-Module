<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Floor;

use Portal\Account\AccountException;
use Portal\Account\Floor\Floor;
use Tests\AbstractUnitTest;

class FloorTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание пола
     *
     * @dataProvider successDataProvider
     * @param int $id
     * @param string $name
     * @throws AccountException
     */
    public function testAccountGroupCreateSuccess(int $id, string $name): void
    {
        $status = new Floor($id);

        self::assertEquals($id, $status->getId());
        self::assertEquals($name, $status->getName());
    }

    /**
     * Тест на ситуацию, когда передан неизвестный id пола
     *
     * @dataProvider failDataProvider
     * @param int $id
     * @param string $error
     */
    public function testAccountGroupCreateFail(int $id, string $error): void
    {
        $this->expectException(AccountException::class);
        $this->expectExceptionMessage($error);
        new Floor($id);
    }

    /**
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [
                1,
                'Male',
            ],
            [
                2,
                'Female',
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
                3,
                AccountException::UNKNOWN_FLOOR_ID . ': 3',
            ],
        ];
    }
}
