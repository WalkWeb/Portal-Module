<?php

declare(strict_types=1);

namespace Portal\Post\Rating;

class Rating implements RatingInterface
{
    private int $rating;
    private int $likes;
    private int $dislikes;

    public function __construct(int $rating, int $likes, int $dislikes)
    {
        $this->rating = $rating;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * @return string
     */
    public function getColorClass(): string
    {
        if ($this->rating === 0) {
            return self::DEFAULT_CLASS_COLOR;
        }

        if ($this->rating > 0) {
            return self::POSITIVE_CLASS_COLOR;
        }

        return self::NEGATIVE_CLASS_COLOR;
    }
}
