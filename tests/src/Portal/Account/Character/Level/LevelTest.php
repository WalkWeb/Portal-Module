<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Character\Level;

use Portal\Account\Character\Level\Level;
use Portal\Account\Character\Level\LevelException;
use Tests\AbstractUnitTest;

class LevelTest extends AbstractUnitTest
{
    /**
     * Тест на создание объекта Level
     *
     * @dataProvider createDataProvider
     * @param int $levelValue
     * @param int $exp
     * @param int $statPoints
     * @param int $expectedExpToLevel
     * @param int $expectedExpAtLevel
     * @param int $expectedExpBarWeight
     * @throws LevelException
     */
    public function testLevelCreate(
        int $levelValue,
        int $exp,
        int $statPoints,
        int $expectedExpToLevel,
        int $expectedExpAtLevel,
        int $expectedExpBarWeight
    ): void
    {
        $level = new Level($levelValue, $exp, $statPoints);

        // Параметры, которые указываются напрямую
        self::assertEquals($levelValue, $level->getLevel());
        self::assertEquals($exp, $level->getExp());
        self::assertEquals($statPoints, $level->getStatPoints());

        // Параметры, которые рассчитываются на основе уровня и опыта на основе внутренних данных по уровням
        self::assertEquals($expectedExpToLevel, $level->getExpToLevel());
        self::assertEquals($expectedExpAtLevel, $level->getExpAtLevel());

        // Параметр, который рассчитывается на ходу
        self::assertEquals($expectedExpBarWeight, $level->getExpBarWeight());
    }

    /**
     * Тест на ситуацию, когда указан некорректный (отсутствующий в данных внутри класса Level) уровень
     *
     * @throws LevelException
     */
    public function testLevelInvalid(): void
    {
        $level = 200;

        $this->expectException(LevelException::class);
        $this->expectExceptionMessage(LevelException::INVALID_LEVEL . ': ' . $level);
        new Level($level, 500, 10);
    }

    /**
     * @return array
     */
    public function createDataProvider(): array
    {
        return [
            [
                1,
                0,
                0,
                50,
                0,
                0,
            ],
            [
                1,
                25,
                3,
                50,
                25,
                50,
            ],
            [
                45,
                296400,
                0,
                17600,
                200,
                1,
            ],
        ];
    }
}
