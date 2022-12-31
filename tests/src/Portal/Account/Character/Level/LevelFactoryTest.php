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

        self::assertEquals($data['account_id'], $level->getAccountId());
        self::assertEquals($data['character_id'], $level->getCharacterId());
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
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
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
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
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
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
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
            // account_id
            [
                // Отсутствует account_id
                [
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => 1,
                    'character_exp'         => 25,
                    'character_stat_points' => 3,
                ],
                LevelException::INVALID_ACCOUNT_ID_DATA,
            ],
            [
                // account_id некорректного типа
                [
                    'account_id'            => 10,
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => 1,
                    'character_exp'         => 25,
                    'character_stat_points' => 3,
                ],
                LevelException::INVALID_ACCOUNT_ID_DATA,
            ],
            // character_id
            [
                // Отсутствует account_id
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_level'       => 1,
                    'character_exp'         => 25,
                    'character_stat_points' => 3,
                ],
                LevelException::INVALID_CHARACTER_ID_DATA,
            ],
            [
                // account_id некорректного типа
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => 100,
                    'character_level'       => 1,
                    'character_exp'         => 25,
                    'character_stat_points' => 3,
                ],
                LevelException::INVALID_CHARACTER_ID_DATA,
            ],
            // character_level
            [
                // Отсутствует character_level
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_exp'         => 0,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_LEVEL_DATA,
            ],
            [
                // character_level некорректного типа
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => '1',
                    'character_exp'         => 0,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_LEVEL_DATA,
            ],
            [
                // character_level меньше минимального значения
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => LevelInterface::MIN_LEVEL - 1,
                    'character_exp'         => 0,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_LEVEL_VALUE . LevelInterface::MIN_LEVEL . '-' . LevelInterface::MAX_LEVEL,
            ],
            [
                // character_level больше максимального значения
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
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
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => 1,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_EXP_DATA,
            ],
            [
                // character_exp некорректного типа
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => 1,
                    'character_exp'         => null,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_EXP_DATA,
            ],
            [
                // character_exp меньше минимального значения
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => 1,
                    'character_exp'         => LevelInterface::MIN_EXP - 1,
                    'character_stat_points' => 0,
                ],
                LevelException::INVALID_EXP_VALUE . LevelInterface::MIN_EXP . '-' . LevelInterface::MAX_EXP,
            ],
            [
                // character_exp больше максимального значения
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
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
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level' => 1,
                    'character_exp'   => 0,
                ],
                LevelException::INVALID_STAT_POINTS_DATA,
            ],
            [
                // character_stat_points некорректного типа
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => 1,
                    'character_exp'         => 0,
                    'character_stat_points' => [0],
                ],
                LevelException::INVALID_STAT_POINTS_DATA,
            ],
            [
                // character_stat_points меньше минимального значения
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
                    'character_level'       => 1,
                    'character_exp'         => 0,
                    'character_stat_points' => LevelInterface::MIN_STAT_POINTS - 1,
                ],
                LevelException::INVALID_STAT_POINTS_VALUE . LevelInterface::MIN_STAT_POINTS . '-' . LevelInterface::MAX_STAT_POINTS,
            ],
            [
                // character_stat_points больше максимального значения
                [
                    'account_id'            => 'cafc3584-74ea-4fba-bbc3-205bde3697d0',
                    'character_id'          => '2f3de667-d5a4-48c8-bcbf-b9a2b3257719',
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
