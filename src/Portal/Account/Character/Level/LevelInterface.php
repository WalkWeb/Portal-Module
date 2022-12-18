<?php

declare(strict_types=1);

namespace Portal\Account\Character\Level;

interface LevelInterface
{
    // TODO min/max level
    // TODO min/max exp
    // TODO min/max stat points

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
