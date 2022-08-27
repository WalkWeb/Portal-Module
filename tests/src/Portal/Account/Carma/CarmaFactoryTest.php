<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Carma;

use Exception;
use Portal\Account\Carma\CarmaException;
use Portal\Account\Carma\CarmaFactory;
use Portal\Account\Carma\CarmaInterface;
use Tests\AbstractUnitTest;

class CarmaFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание объекта Carma на основе массива с параметрами
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function testCarmaFactoryCreateSuccess(array $data): void
    {
        $carma = $this->getFactory()->create($data);

        self::assertEquals($data['account_id'], $carma->getAccountId());
        self::assertEquals($data['account_total_carma'], $carma->getTotalCarma());
        self::assertEquals($data['account_post_carma'], $carma->getPostCarma());
        self::assertEquals($data['account_comment_carma'], $carma->getCommentCarma());
    }

    /**
     * Тест на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @return void
     * @throws Exception
     */
    public function testCarmaFactoryCreateFail(array $data, string $error): void
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
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
            ],
            [
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => -1000,
                    'account_post_carma'    => -500,
                    'account_comment_carma' => -500,
                ],
            ],
            [
                [
                    'account_id'            => 'abc_abc',
                    'account_total_carma'   => 2000,
                    'account_post_carma'    => -500,
                    'account_comment_carma' => 2500,
                ],
            ],
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function failDataProvider(): array
    {
        return [
            // account_id
            [
                // Отсутствует account_id
                [
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_ID_DATA,
            ],
            [
                // account_id некорректного типа
                [
                    'account_id'            => 0,
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_ID_DATA,
            ],
            [
                // account_id короче минимальный длины
                [
                    'account_id'            => self::generateString(CarmaInterface::ACCOUNT_ID_MIN_LENGTH - 1),
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_ID_VALUE . CarmaInterface::ACCOUNT_ID_MIN_LENGTH . '-' . CarmaInterface::ACCOUNT_ID_MAX_LENGTH,
            ],
            [
                // account_id длиннее максимальной длины
                [
                    'account_id'            => self::generateString(CarmaInterface::ACCOUNT_ID_MAX_LENGTH + 1),
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_ID_VALUE . CarmaInterface::ACCOUNT_ID_MIN_LENGTH . '-' . CarmaInterface::ACCOUNT_ID_MAX_LENGTH,
            ],

            // account_total_carma
            [
                // account_total_carma отсутствует
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_TOTAL_CARMA_DATA,
            ],
            [
                // account_total_carma некорректного типа
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => '1000',
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_TOTAL_CARMA_DATA,
            ],
            [
                // account_total_carma меньше минимального значения
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => CarmaInterface::MIN_CARMA - 1,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_TOTAL_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA,
            ],
            [
                // account_total_carma больше максимального значения
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => CarmaInterface::MAX_CARMA + 1,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_TOTAL_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA,
            ],

            // account_post_carma
            [
                // account_post_carma отсутствует
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_POST_CARMA_DATA,
            ],
            [
                // account_post_carma некорректного типа
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => true,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_POST_CARMA_DATA,
            ],
            [
                // account_post_carma меньше минимального значения
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => CarmaInterface::MIN_CARMA - 1,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_POST_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA,
            ],
            [
                // account_post_carma больше максимального значения
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => CarmaInterface::MAX_CARMA + 2,
                    'account_comment_carma' => 500,
                ],
                CarmaException::INVALID_POST_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA,
            ],


            // account_comment_carma
            [
                // account_comment_carma отсутствует
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                ],
                CarmaException::INVALID_COMMENT_CARMA_DATA,
            ],
            [
                // account_comment_carma некорректного типа
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => [500],
                ],
                CarmaException::INVALID_COMMENT_CARMA_DATA,
            ],
            [
                // account_comment_carma меньше минимального значения
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => CarmaInterface::MIN_CARMA - 1,
                ],
                CarmaException::INVALID_COMMENT_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA,
            ],
            [
                // account_comment_carma больше максимального значения
                [
                    'account_id'            => 'a11197c4-39a5-454e-a7e0-1e66a073aa5b',
                    'account_total_carma'   => 1000,
                    'account_post_carma'    => 500,
                    'account_comment_carma' => CarmaInterface::MAX_CARMA + 1,
                ],
                CarmaException::INVALID_COMMENT_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA,
            ],
        ];
    }

    /**
     * @return CarmaFactory
     */
    private function getFactory(): CarmaFactory
    {
        return new CarmaFactory();
    }
}
