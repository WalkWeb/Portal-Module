<?php

declare(strict_types=1);

namespace Portal\Post\Rating;

use Portal\Pieces\Traits\Validation\ValidationException;
use Portal\Pieces\Traits\Validation\ValidationTrait;

class RatingFactory
{
    use ValidationTrait;

    /**
     * Создает объект Rating на основе массива параметров
     *
     * @param array $data
     * @return RatingInterface
     * @throws ValidationException
     */
    public function create(array $data): RatingInterface
    {
        return new Rating(
            self::int($data, 'likes', RatingException::INVALID_LIKES),
            self::int($data, 'dislikes', RatingException::INVALID_DISLIKES)
        );
    }
}
