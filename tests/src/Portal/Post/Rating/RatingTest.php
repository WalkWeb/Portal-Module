<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\Rating;

use Portal\Post\Rating\Rating;
use Portal\Post\Rating\RatingInterface;
use Tests\AbstractUnitTest;

class RatingTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание объекта Rating
     *
     * @dataProvider createDataProvider
     * @param int $ratingValue
     * @param int $likes
     * @param int $dislikes
     * @param string $expectedColorClass
     */
    public function testRatingCreate(int $ratingValue, int $likes, int $dislikes, string $expectedColorClass): void
    {
        $rating = new Rating($ratingValue, $likes, $dislikes);

        self::assertEquals($ratingValue, $rating->getRating());
        self::assertEquals($likes, $rating->getLikes());
        self::assertEquals($dislikes, $rating->getDislikes());
        self::assertEquals($expectedColorClass, $rating->getColorClass());
    }

    /**
     * @return array
     */
    public function createDataProvider(): array
    {
        return [
            [
                0,
                0,
                0,
                RatingInterface::DEFAULT_CLASS_COLOR
            ],
            [
                10,
                15,
                -5,
                RatingInterface::POSITIVE_CLASS_COLOR
            ],
            [
                -80,
                20,
                -100,
                RatingInterface::NEGATIVE_CLASS_COLOR
            ],
        ];
    }
}
