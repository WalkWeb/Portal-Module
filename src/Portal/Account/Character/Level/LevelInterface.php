<?php

declare(strict_types=1);

namespace Portal\Account\Character\Level;

interface LevelInterface
{
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
     * Возвращает количество очков характеристик, с помощью которых пользователь может прокачать какие-то свои
     * параметры, например запас энергии или количество доступного места под личные файлы
     *
     * @return int
     */
    public function getStatPoints(): int;
}
