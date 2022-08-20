<?php

declare(strict_types=1);

namespace Portal\Container;

use Portal\Account\Energy\EnergyFactory;
use Portal\Account\Energy\EnergyInterface;

interface ContainerInterface
{
    /**
     * Возвращает сервис по его id
     *
     * id может быть как название класса в виде ClassName::class так и название в виде 'ClassName'
     * Допустимые имена смотрите в Container->map
     *
     * При этом если сервис уже запрашивался и создавался ранее, то при повторном запросе будет возвращен существующий
     *
     * По сути контейнер это более правильная реализация паттерна Singleton
     *
     * @param string $id
     * @return object
     */
    public function get(string $id): object;

    /**
     * Добавляет сервис
     *
     * Можно добавить только сервис из списка доступных (с.м. Container->map)
     *
     * @param string $id
     * @param object $object
     */
    public function set(string $id, object $object): void;

    /**
     * Проверяет существование во внутреннем хранилище уже созданного объекта данного класса
     *
     * @param string $class
     * @return bool
     */
    public function exist(string $class): bool;

    /**
     * Возвращает энергию (текущего) авторизованного персонажа
     *
     * @return EnergyInterface
     * @throws ContainerException
     */
    public function getEnergy(): EnergyInterface;

    /**
     * Возвращает энергию (текущего) авторизованного персонажа
     *
     * @return EnergyFactory
     * @throws ContainerException
     */
    public function getEnergyFactory(): EnergyFactory;
}
