<?php

declare(strict_types=1);

namespace Portal\Post\ChangeRating;

class ChangeRating implements ChangeRatingInterface
{
    /**
     * Изменение рейтинга поста пользователем.
     *
     * 0 - пользователь не лайкал/дизлайкал пост
     * 1 - пользователь лайкнул пост
     * -1 - пользователь дизлайкнул пост
     *
     * @var int
     */
    private int $change;

    public function __construct(int $change)
    {
        $this->change = $change;
    }

    /**
     * @return bool
     */
    public function isLike(): bool
    {
        return $this->change > 0;
    }

    /**
     * @return bool
     */
    public function isDislike(): bool
    {
        return $this->change < 0;
    }
}
