<?php

declare(strict_types=1);

namespace Portal\Auth;

use Portal\Account\ChatStatus\ChatStatusInterface;
use Portal\Account\Energy\EnergyInterface;
use Portal\Account\Group\AccountGroupInterface;
use Portal\Account\Status\AccountStatusInterface;

/**
 * Auth - это особая модель (такой таблицы нет), которая создается при аутентификации пользователя. Хранит в себе
 * базовые параметры из разных таблиц, которые наиболее часто используются при взаимодействии с сайтом
 *
 * @package Portal\Auth
 */
interface AuthInterface
{
    /**
     * ID пользователя, если он успешно авторизован
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Имя пользователя
     *
     * @return string
     */
    public function getName(): string;

    /**
     * URL путь к аватару пользователя
     *
     * @return string
     */
    public function getAvatar(): string;

    /**
     * Группа пользователя
     *
     * @return AccountGroupInterface
     */
    public function getGroup(): AccountGroupInterface;

    /**
     * Статус пользователя
     *
     * @return AccountStatusInterface
     */
    public function getStatus(): AccountStatusInterface;

    /**
     * Статуса пользователя в чате
     *
     * @return ChatStatusInterface
     */
    public function getChatStatus(): ChatStatusInterface;

    /**
     * Возвращает энергию пользователя
     *
     * @return EnergyInterface
     */
    public function getEnergy(): EnergyInterface;

    /**
     * Может ли пользователь лайкать/дизлайкать
     *
     * @return bool
     */
    public function isCanLike(): bool;
}
