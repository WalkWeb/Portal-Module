<?php

declare(strict_types=1);

namespace Portal\Container;

use Portal\Account\Energy\Energy;
use Portal\Account\Energy\EnergyFactory;
use Portal\Account\Energy\EnergyInterface;

class Container implements ContainerInterface
{
    private array $map = [
        EnergyInterface::class => Energy::class,
        Energy::class          => Energy::class,

        EnergyFactory::class => EnergyFactory::class,
        'EnergyFactory'      => EnergyFactory::class,
    ];

    private array $storage = [];

    /**
     * @param string $id
     * @return object
     * @throws ContainerException
     */
    public function get(string $id): object
    {
        $class = $this->getNameService($id);

        if ($this->exist($class)) {
            return $this->storage[$class];
        }

        return $this->create($class);
    }

    /**
     * @param string $id
     * @param object $object
     * @throws ContainerException
     */
    public function set(string $id, object $object): void
    {
        $id = $this->getNameService($id);
        $this->storage[$id] = $object;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function exist(string $class): bool
    {
        try {
            $class = $this->getNameService($class);
            return array_key_exists($class, $this->storage);
        } catch (ContainerException $e) {
            // Контейнер может иметь только фиксированный набор сервисов. Если указан неизвестный - значит он не может быть добавлен.
            return false;
        }
    }

    /**
     * @return EnergyInterface
     * @throws ContainerException
     */
    public function getEnergy(): EnergyInterface
    {
        /** @var EnergyInterface $service */
        $service = $this->get(Energy::class);
        return $service;
    }

    /**
     * @return EnergyFactory
     * @throws ContainerException
     */
    public function getEnergyFactory(): EnergyFactory
    {
        /** @var EnergyFactory $service */
        $service = $this->get(EnergyFactory::class);
        return $service;
    }

    /**
     * @param string $class
     * @return object
     */
    private function create(string $class): object
    {
        $object = new $class;
        $this->storage[$this->map[$class]] = $object;

        return $object;
    }

    /**
     * @param string $id
     * @return string
     * @throws ContainerException
     */
    private function getNameService(string $id): string
    {
        if (!array_key_exists($id, $this->map)) {
            throw new ContainerException(ContainerException::UNKNOWN_SERVICE);
        }

        return $this->map[$id];
    }
}
