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
     * Тест на добавление опыта и увеличение уровня
     *
     * @throws LevelException
     */
    public function testLevelAddExpSuccess(): void
    {
        $level = new Level(1, 0, 0);

        self::assertEquals(1, $level->getLevel());
        self::assertEquals(0, $level->getExp());
        self::assertEquals(0, $level->getExpAtLevel());
        self::assertEquals(50, $level->getExpToLevel());

        // Вариант с повышением уровня на 1
        $level->addExp(50);

        self::assertEquals(2, $level->getLevel());
        self::assertEquals(50, $level->getExp());
        self::assertEquals(0, $level->getExpAtLevel());
        self::assertEquals(130, $level->getExpToLevel());

        // Но опыта может добавиться столько, что будет получено сразу несколько уровней
        $level->addExp(5000);

        self::assertEquals(9, $level->getLevel());
        self::assertEquals(5050, $level->getExp());
        self::assertEquals(980, $level->getExpAtLevel());
        self::assertEquals(1350, $level->getExpToLevel());
    }

    /**
     * Тест на ситуацию, когда добавляется некорректный опыт
     *
     * @throws LevelException
     */
    public function testLevelAddExpInvalidExp(): void
    {
        $level = new Level(1, 0, 0);
        $addExp = 0;

        $this->expectException(LevelException::class);
        $this->expectExceptionMessage(LevelException::INVALID_ADD_EXP . ': ' . $addExp);
        $level->addExp($addExp);
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
