<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\ChangeRating;

use Portal\Post\ChangeRating\ChangeRating;
use Tests\AbstractUnitTest;

class ChangeRatingTest extends AbstractUnitTest
{
    /**
     * Тест на создание объекта ChangeRating и проверку его методов
     *
     * @dataProvider createDataProvider
     * @param int $change
     * @param bool $like
     * @param bool $dislike
     */
    public function testChangeRatingCreate(int $change, bool $like, bool $dislike): void
    {
        $changeRating = new ChangeRating($change);

        self::assertEquals($like, $changeRating->isLike());
        self::assertEquals($dislike, $changeRating->isDislike());
    }

    public function createDataProvider(): array
    {
        return [
            [
                0,
                false,
                false,
            ],
            [
                1,
                true,
                false,
            ],
            [
                -1,
                false,
                true,
            ],
        ];
    }
}
