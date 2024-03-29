<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Upload;

use Portal\Account\Upload\AccountUpload;
use Tests\AbstractUnitTest;

class AccountUploadTest extends AbstractUnitTest
{
    /**
     * Тест на создание AccountUpload
     *
     * @dataProvider successDataProvider
     * @param int $upload
     * @param int $uploadMax
     */
    public function testAccountUploadCreateSuccess(int $upload, int $uploadMax): void
    {
        $accountUpload = new AccountUpload($upload, $uploadMax);

        self::assertEquals($upload, $accountUpload->getUpload());
        self::assertEquals($uploadMax, $accountUpload->getUploadMax());
        self::assertEquals($uploadMax - $upload, $accountUpload->getUploadRemainder());
    }

    /**
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [
                50,
                100,
            ],
            [
                0,
                0,
            ],
            [
                1000,
                1000,
            ],
        ];
    }
}
