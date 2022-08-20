<?php

declare(strict_types=1);

namespace Tests\src\Portal\Container;

use Portal\Account\Energy\Energy;
use Portal\Account\Energy\EnergyFactory;
use Portal\Account\Energy\EnergyInterface;
use Portal\Container\Container;
use Portal\Container\ContainerException;
use Tests\AbstractUnitTest;

class ContainerTest extends AbstractUnitTest
{
    /**
     * @throws ContainerException
     */
    public function testContainerExistService(): void
    {
        $container = new Container();

        $container->get(EnergyFactory::class);

        self::assertTrue($container->exist(EnergyFactory::class));
    }

    public function testContainerNoExistService(): void
    {
        $container = new Container();

        self::assertFalse($container->exist(EnergyFactory::class));

        // no exist unknown service
        self::assertFalse($container->exist('UnknownService'));
    }

    /**
     * @throws ContainerException
     */
    public function testContainerSet(): void
    {
        $container = new Container();

        $energy = new Energy(
            '23474820-3e4f-45e3-ba0b-78d202f56ad5',
            'ec82ec25-3f79-4edc-9e68-b8ceee683870',
            50,
            130,
            microtime(true),
            microtime(true),
            0
        );

        $container->set(EnergyInterface::class, $energy);

        self::assertEquals($energy, $container->getEnergy());
    }

    /**
     * @throws ContainerException
     */
    public function testContainerGetEnergyFactory(): void
    {
        $container = new Container();

        $service = $container->get(EnergyFactory::class);
        self::assertInstanceOf(EnergyFactory::class, $service);

        $service = $container->get('EnergyFactory');
        self::assertInstanceOf(EnergyFactory::class, $service);

        $service = $container->getEnergyFactory();
        self::assertInstanceOf(EnergyFactory::class, $service);
    }
}
