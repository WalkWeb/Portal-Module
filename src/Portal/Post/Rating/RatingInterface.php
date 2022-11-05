<?php

declare(strict_types=1);

namespace Portal\Post\Rating;

// TODO Подумать на тему того, сделать ли этот объект общим для постов и комментариев

interface RatingInterface
{
    public const DEFAULT_CLASS_COLOR  = 'defaultRatingColor';
    public const POSITIVE_CLASS_COLOR = 'positiveRatingColor';
    public const NEGATIVE_CLASS_COLOR = 'negativeRatingColor';

    /**
     * Возвращает суммарный рейтинг поста
     *
     * @return int
     */
    public function getRating(): int;

    /**
     * Возвращает суммарное количество лайков поста
     *
     * @return int
     */
    public function getLikes(): int;

    /**
     * Возвращает суммарное количество дизлайков поста
     *
     * @return int
     */
    public function getDislikes(): int;

    /**
     * Возвращает класс цвета рейтинга. Например положительный рейтинг будет зеленым, а отрицательный красным.
     *
     * При этом конкретные квета могут отличаться в разных шаблонах сайта
     *
     * @return string
     */
    public function getColorClass(): string;
}
