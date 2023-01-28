<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\Rating;

use Portal\Post\Rating\RatingException;
use Portal\Post\Rating\RatingFactory;
use Portal\Post\Rating\RatingInterface;
use Portal\Pieces\Traits\Validation\ValidationException;
use Tests\AbstractUnitTest;

class RatingFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание объекта Rating на основе массива параметров
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @param string $expectedClassRating
     * @throws ValidationException
     */
    public function testRatingFactoryCreateSuccess(array $data, string $expectedClassRating): void
    {
        $rating = $this->getFactory()->create($data);

        self::assertEquals($data['rating'], $rating->getRating());
        self::assertEquals($data['likes'], $rating->getLikes());
        self::assertEquals($data['dislikes'], $rating->getDislikes());
        self::assertEquals($expectedClassRating, $rating->getColorClass());
    }

    /**
     * Тест на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     */
    public function testRatingFactoryCreateFail(array $data, string $error): void
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
                    'rating'   => 0,
                    'likes'    => 0,
                    'dislikes' => 0,
                ],
                RatingInterface::DEFAULT_CLASS_COLOR
            ],
            [
                [
                    'rating'   => 10,
                    'likes'    => 15,
                    'dislikes' => -5,
                ],
                RatingInterface::POSITIVE_CLASS_COLOR
            ],
            [
                [
                    'rating'   => -80,
                    'likes'    => 20,
                    'dislikes' => -100,
                ],
                RatingInterface::NEGATIVE_CLASS_COLOR
            ],
        ];
    }

    /**
     * @return array
     */
    public function failDataProvider(): array
    {
        return [
            // Отсутствует rating
            [
                [
                    'likes'    => 0,
                    'dislikes' => 0,
                ],
                RatingException::INVALID_RATING
            ],
            // rating некорректного типа
            [
                [
                    'rating'   => '0',
                    'likes'    => 0,
                    'dislikes' => 0,
                ],
                RatingException::INVALID_RATING
            ],
            // Отсутствует likes
            [
                [
                    'rating'   => 0,
                    'dislikes' => 0,
                ],
                RatingException::INVALID_LIKES
            ],
            // likes некорректного типа
            [
                [
                    'rating'   => 0,
                    'likes'    => null,
                    'dislikes' => 0,
                ],
                RatingException::INVALID_LIKES
            ],
            // Отсутствует dislikes
            [
                [
                    'rating'   => 0,
                    'likes'    => 0,
                ],
                RatingException::INVALID_DISLIKES
            ],
            // dislikes некорректного типа
            [
                [
                    'rating'   => 0,
                    'likes'    => 0,
                    'dislikes' => 0.0,
                ],
                RatingException::INVALID_DISLIKES
            ],
        ];
    }

    /**
     * @return RatingFactory
     */
    private function getFactory(): RatingFactory
    {
        return new RatingFactory();
    }
}
