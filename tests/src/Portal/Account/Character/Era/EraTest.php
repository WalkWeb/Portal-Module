<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Character\Era;

use Portal\Account\Character\Era\Era;
use Tests\AbstractUnitTest;

class EraTest extends AbstractUnitTest
{
    /**
     * Тест на создание объекта эпохи
     *
     * @dataProvider createDataProvider
     * @param int $id
     * @param string $name
     * @param bool $actual
     */
    public function testEraCreate(int $id, string $name, bool $actual): void
    {
        $era = new Era($id, $name, $actual);

        self::assertEquals($id, $era->getId());
        self::assertEquals($name, $era->getName());
        self::assertEquals($actual, $era->isActual());
    }

    /**
     * @return array
     */
    public function createDataProvider(): array
    {
        return [
            [
                1,
                'Alpha',
                false,
            ],
            [
                2,
                'Beta',
                true,
            ],
        ];
    }
}
