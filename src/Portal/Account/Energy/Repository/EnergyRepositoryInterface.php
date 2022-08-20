<?php

declare(strict_types=1);

namespace Portal\Account\Energy\Repository;

use Portal\Account\Energy\EnergyInterface;

interface EnergyRepositoryInterface
{
    /**
     * Возвращает объект Energy по id
     *
     * @param string $id
     * @return EnergyInterface
     */
    public function get(string $id): EnergyInterface;

    /**
     * Сохраняет объект Energy
     *
     * @param EnergyInterface $energy
     */
    public function save(EnergyInterface $energy): void;
}
