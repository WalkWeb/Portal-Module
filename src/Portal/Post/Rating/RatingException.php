<?php

declare(strict_types=1);

namespace Portal\Post\Rating;

use Exception;

class RatingException extends Exception
{
    public const INVALID_RATING   = 'Incorrect "rating" parameter, it required and type int';
    public const INVALID_LIKES    = 'Incorrect "likes" parameter, it required and type int';
    public const INVALID_DISLIKES = 'Incorrect "dislikes" parameter, it required and type int';
}