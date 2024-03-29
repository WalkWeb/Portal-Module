<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Energy;

use Portal\Account\Energy\EnergyException;
use Portal\Account\Energy\EnergyFactory;
use Portal\Account\Energy\EnergyInterface;
use Portal\Pieces\Traits\Validation\ValidationException;
use Tests\AbstractUnitTest;

class EnergyFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание объекта Energy на основе массива с данными
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @param int $expectedEnergy
     * @param int $expectedResidue
     * @throws ValidationException
     */
    public function testEnergyFactoryCreateSuccess(array $data, int $expectedEnergy, int $expectedResidue): void
    {
        $energy = $this->getFactory()->create($data);

        self::assertEquals($data['energy_id'], $energy->getId());
        self::assertEquals($expectedEnergy, $energy->getEnergy());
        self::assertEquals($data['energy_updated_at'], $energy->getUpdatedAt());
        self::assertEquals($expectedResidue, $energy->getResidue());
        self::assertFalse($energy->isUpdated());
    }

    /**
     * Тесты на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @throws ValidationException
     */
    public function testEnergyFactoryCreateFail(array $data, string $error): void
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
                // Вариант с данными по энергии с очень старой датой последнего обновления
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'energy'            => 30,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyInterface::BASE_ENERGY + 15,
                0,
            ],
            [
                // Вариант с со свежими данными
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'energy'            => 50,
                    'energy_bonus'      => 20,
                    'energy_updated_at' => (float)microtime(true),
                    'energy_residue'    => 5,
                ],
                50,
                5,
            ],
        ];
    }

    /**
     * @return array
     */
    public function failDataProvider(): array
    {
        return [

            // energy_id
            [
                // energy_id отсутствует
                [
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_ID_DATA,
            ],
            [
                // energy_id некорректного типа
                [
                    'energy_id'         => 100,
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_ID_DATA,
            ],
            [
                // energy_id меньше минимальный длины
                [
                    'energy_id'         => '4444',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_ID_VALUE . EnergyInterface::ID_MIN_LENGTH . '-' . EnergyInterface::ID_MAX_LENGTH,
            ],
            [
                // energy_id больше максимальной длины
                [
                    'energy_id'         => '1111111111111111111111111111111111111111111111111111111111111111111111111111111111111',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_ID_VALUE . EnergyInterface::ID_MIN_LENGTH . '-' . EnergyInterface::ID_MAX_LENGTH,
            ],

            // energy
            [
                // energy отсутствует
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_DATA,
            ],
            [
                // energy некорректного типа
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => '30',
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_DATA,
            ],
            [
                // energy меньше минимального значения
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => EnergyInterface::MIN_ENERGY - 1,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_VALUE . EnergyInterface::MIN_ENERGY . '-' . EnergyInterface::MAX_ENERGY,
            ],
            [
                // energy больше минимального значения
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => EnergyInterface::MAX_ENERGY + 1,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_VALUE . EnergyInterface::MIN_ENERGY . '-' . EnergyInterface::MAX_ENERGY,
            ],

            // energy_bonus
            [
                // energy_bonus отсутствует
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_BONUS_DATA,
            ],
            [
                // energy_bonus некорректного типа
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => [15],
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_BONUS_DATA,
            ],
            [
                // energy_bonus меньше минимального значения
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => EnergyInterface::MIN_BONUS - 1,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_BONUS_VALUE . EnergyInterface::MIN_BONUS . '-' . EnergyInterface::MAX_BONUS,
            ],
            [
                // energy_bonus больше максимального значения
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => EnergyInterface::MAX_BONUS + 1,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_ENERGY_BONUS_VALUE . EnergyInterface::MIN_BONUS . '-' . EnergyInterface::MAX_BONUS,
            ],

            // updated_at
            [
                // updated_at отсутствует
                [
                    'energy_id'      => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'         => 30,
                    'energy_bonus'   => 15,
                    'energy_residue' => 10,
                ],
                EnergyException::INCORRECT_UPDATED_AT_DATA,
            ],
            [
                // updated_at некорректного типа
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => true,
                    'energy_residue'    => 10,
                ],
                EnergyException::INCORRECT_UPDATED_AT_DATA,
            ],
            [
                // residue отсутствует
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                ],
                EnergyException::INCORRECT_RESIDUE_DATA,
            ],
            [
                // residue некорректного типа
                [
                    'energy_id'         => 'f0c4391a-f16a-4a22-80fb-ac0a02168b1f',
                    'account_id'        => '8a05b239-a9f3-4e01-8c68-99198ab8b17f',
                    'energy'            => 30,
                    'energy_bonus'      => 15,
                    'energy_updated_at' => 1566745426.0000,
                    'energy_residue'    => 10.6,
                ],
                EnergyException::INCORRECT_RESIDUE_DATA,
            ],
        ];
    }

    /**
     * @return EnergyFactory
     */
    private function getFactory(): EnergyFactory
    {
        return new EnergyFactory();
    }
}
