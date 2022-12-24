<?php

declare(strict_types=1);

namespace Portal\Account\Character\Level;

interface LevelInterface
{
    public const MIN_LEVEL       = 1;
    public const MAX_LEVEL       = 100;

    public const MIN_EXP         = 0;
    public const MAX_EXP         = 2459799; // 2396700 exp_total + 63100 exp_to_lvl - 1

    public const MIN_STAT_POINTS = 0;
    public const MAX_STAT_POINTS = 495; // 99 уровней * 5 очков на уровень

    public const ADD_STAT_POINT  = 5; // количество добавляемых очков характеристик на каждый новый уровень

    // TODO Объект Level должен уметь создаваться и без объекта Character и быть самодостаточным, т.е. нужны
    // TODO characterId и accountId

    /**
     * Возвращает значение уровня
     *
     * @return int
     */
    public function getLevel(): int;

    /**
     * Возвращает суммарное количество опыта (персонажа/аккаунта)
     *
     * @return int
     */
    public function getExp(): int;

    /**
     * Возвращает количество опыта, необходимого для получения следующего уровня. Используется для построения полоски
     * прогресса прокачки
     *
     * @return int
     */
    public function getExpToLevel(): int;

    /**
     * Возвращает количество опыта, набранного на текущем уровне. Используется для построения полоски прогресса прокачки
     *
     * @return int
     */
    public function getExpAtLevel(): int;

    /**
     * Возвращает % набранного опыта от необходимого количества до следующего уровня. Используется для построения
     * полоски прогресса прокачки
     *
     * @return int
     */
    public function getExpBarWeight(): int;

    /**
     * Добавляет опыт, если опыта достаточно для получения следующего уровня (уровней) - повышает уровни и начисляет
     * stat points
     *
     * @param int $addExp
     * @throws LevelException
     */
    public function addExp(int $addExp): void;

    /**
     * Возвращает количество очков характеристик, с помощью которых пользователь может прокачать какие-то свои
     * параметры, например запас энергии или количество доступного места под личные файлы
     *
     * @return int
     */
    public function getStatPoints(): int;
}
