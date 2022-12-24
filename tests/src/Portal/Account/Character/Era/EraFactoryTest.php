<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Character\Era;

use Portal\Account\Character\Era\EraException;
use Portal\Account\Character\Era\EraFactory;
use Tests\AbstractUnitTest;

class EraFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на создание эпохи через фабрику
     *
     * @dataProvider createDataProvider
     * @param int $id
     * @param string $expectedName
     * @param bool $expectedActive
     * @throws EraException
     */
    public function testEraFactoryCreateSuccess(int $id, string $expectedName, bool $expectedActive): void
    {
        $era = $this->getFactory()->create($id);

        self::assertEquals($id, $era->getId());
        self::assertEquals($expectedName, $era->getName());
        self::assertEquals($expectedActive, $era->isActual());
    }

    /**
     * Тест на ситуацию, когда передан неизвестный id эпохи
     *
     * @throws EraException
     */
    public function testEraFactoryCreateUnknownId(): void
    {
        $id = 99;
        $this->expectException(EraException::class);
        $this->expectExceptionMessage(EraException::UNKNOWN_ERA . ": $id");
        $this->getFactory()->create($id);
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
                true,
            ],
            [
                2,
                'Beta',
                false,
            ],
        ];
    }

    /**
     * @return EraFactory
     */
    private function getFactory(): EraFactory
    {
        return new EraFactory();
    }
}
