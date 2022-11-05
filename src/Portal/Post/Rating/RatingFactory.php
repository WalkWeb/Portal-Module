<?php

declare(strict_types=1);

namespace Portal\Post\Rating;

use Portal\Traits\Validation\ValidationException;
use Portal\Traits\Validation\ValidationTrait;

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
            self::int($data, 'rating', RatingException::INVALID_RATING),
            self::int($data, 'likes', RatingException::INVALID_LIKES),
            self::int($data, 'dislikes', RatingException::INVALID_DISLIKES)
        );
    }
}
