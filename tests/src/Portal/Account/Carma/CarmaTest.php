<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Carma;

use Portal\Account\Carma\Carma;
use Portal\Account\Carma\CarmaException;
use Tests\AbstractUnitTest;

class CarmaTest extends AbstractUnitTest
{
    /**
     * @throws CarmaException
     */
    public function testCarmaCreateSuccess(): void
    {
        $accountId = '47b1cec3-ee30-49ea-997f-080126502dd6';
        $totalCarma = 20;
        $postCarma = 15;
        $commentCarma = 5;

        $carma = new Carma($accountId, $totalCarma, $postCarma, $commentCarma);

        self::assertEquals($accountId, $carma->getAccountId());
        self::assertEquals($totalCarma, $carma->getTotalCarma());
        self::assertEquals($postCarma, $carma->getPostCarma());
        self::assertEquals($commentCarma, $carma->getCommentCarma());
    }

    /**
     * @throws CarmaException
     */
    public function testCarmaCreateFail(): void
    {
        $accountId = '47b1cec3-ee30-49ea-997f-080126502dd6';
        $totalCarma = 20;
        $postCarma = 6;
        $commentCarma = 7;

        $this->expectException(CarmaException::class);
        $this->expectExceptionMessage(CarmaException::INVALID_CARMA);
        new Carma($accountId, $totalCarma, $postCarma, $commentCarma);
    }
}
