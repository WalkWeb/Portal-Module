<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Character\Level;

use Exception;
use Portal\Account\Character\Level\LevelException;
use Portal\Account\Character\Level\LevelFactory;
use Portal\Account\Character\Level\LevelInterface;
use Portal\Traits\Validation\ValidationException;
use Tests\AbstractUnitTest;

class LevelFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание объекта Level на основе массива параметров
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @param int $expectedExpToLevel
     * @param int $expectedExpAtLevel
     * @param int $expectedExpBarWeight
     * @throws Exception
     */
    public function testLevelFactoryCreateSuccess(
        array $data,
        int $expectedExpToLevel,
        int $expectedExpAtLevel,
        int $expectedExpBarWeight
    ): void
    {
        $level = $this->getFactory()->create($data);

        self::assertEquals($data['character_level'], $level->getLevel());
        self::assertEquals($data['character_exp'], $level->getExp());
        self::assertEquals($data['character_stat_points'], $level->getStatPoints());

        self::assertEquals($expectedExpToLevel, $level->getExpToLevel());
        self::assertEquals($expectedExpAtLevel, $level->getExpAtLevel());
        self::assertEquals($expectedExpBarWeight, $level->getExpBarWeight());
    }

    /**
     * Тест на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @throws Exception
     */
    public function testLevelFactoryCreateFail(array $data, string $error): void
    {
        $this->expectException(ValidationException::class);
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
                    'character_level'       => 1,
                    'character_exp'         => 0,
                    'character_stat_points' => 0,
                ],
                50,
                0,
                0,
            ],
            [
                [
                    'character_level'       => 1,
                    'character_exp'         => 25,
                    'character_stat_points' => 3,
                ],
                50,
                25,
                50,
            ],
            [
                [
                    'character_level'       => 45,
                    'character_exp'         => 296400,
                    'character_stat_points' => 0,
                ],
                17600,
                200,
                1,
            ],
        ];
    }

    /**
     * @return array
     */
    public function failDataProvider(): array
    {
        return [
            // character_level
            [
                // Отсутствует character_level
                [
                    'character_exp'         => 0,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_LEVEL_DATA,
            ],
            [
                // character_level некорректного типа
                [
                    'character_level'       => '1',
                    'character_exp'         => 0,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_LEVEL_DATA,
            ],
            [
                // character_level меньше минимального значения
                [
                    'character_level'       => LevelInterface::MIN_LEVEL - 1,
                    'character_exp'         => 0,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_LEVEL_VALUE . LevelInterface::MIN_LEVEL . '-' . LevelInterface::MAX_LEVEL,
            ],
            [
                // character_level больше максимального значения
                [
                    'character_level'       => LevelInterface::MAX_LEVEL + 1,
                    'character_exp'         => 0,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_LEVEL_VALUE . LevelInterface::MIN_LEVEL . '-' . LevelInterface::MAX_LEVEL,
            ],

            // character_exp
            [
                // Отсутствует character_exp
                [
                    'character_level'       => 1,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_EXP_DATA,
            ],
            [
                // character_exp некорректного типа
                [
                    'character_level'       => 1,
                    'character_exp'         => null,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_EXP_DATA,
            ],
            [
                // character_exp меньше минимального значения
                [
                    'character_level'       => 1,
                    'character_exp'         => LevelInterface::MIN_EXP - 1,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_EXP_VALUE . LevelInterface::MIN_EXP . '-' . LevelInterface::MAX_EXP,
            ],
            [
                // character_exp больше максимального значения
                [
                    'character_level'       => 1,
                    'character_exp'         => LevelInterface::MAX_EXP + 1,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_EXP_VALUE . LevelInterface::MIN_EXP . '-' . LevelInterface::MAX_EXP,
            ],

            // character_stat_points
            [
                // Отсутствует character_stat_points
                [
                    'character_level'       => 1,
                    'character_exp'         => 0,
                ],
                LevelException::INVALID_STAT_POINTS_DATA,
            ],
            [
                // character_stat_points некорректного типа
                [
                    'character_level'       => 1,
                    'character_exp'         => 0,
                    'character_stat_points' => [0],
                ],
                LevelException::INVALID_STAT_POINTS_DATA,
            ],
            [
                // character_stat_points меньше минимального значения
                [
                    'character_level'       => 1,
                    'character_exp'         => 0,
                    'character_stat_points' => LevelInterface::MIN_STAT_POINTS - 1,
                ],
                LevelException::INVALID_STAT_POINTS_VALUE . LevelInterface::MIN_STAT_POINTS . '-' . LevelInterface::MAX_STAT_POINTS,
            ],
            [
                // character_stat_points больше максимального значения
                [
                    'character_level'       => 1,
                    'character_exp'         => 0,
                    'character_stat_points' => LevelInterface::MAX_STAT_POINTS + 1,
                ],
                LevelException::INVALID_STAT_POINTS_VALUE . LevelInterface::MIN_STAT_POINTS . '-' . LevelInterface::MAX_STAT_POINTS,
            ],
        ];
    }

    /**
     * @return LevelFactory
     */
    private function getFactory(): LevelFactory
    {
        return new LevelFactory();
    }
}
