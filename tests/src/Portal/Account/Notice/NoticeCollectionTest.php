<?php

declare(strict_types=1);

namespace Tests\src\Portal\Account\Notice;

use DateTime;
use Portal\Account\Notice\Notice;
use Portal\Account\Notice\NoticeCollection;
use Portal\Account\Notice\NoticeException;
use Tests\AbstractUnitTest;

class NoticeCollectionTest extends AbstractUnitTest
{
    /**
     * @throws NoticeException
     */
    public function testNoticeCollection(): void
    {
        $collection = new NoticeCollection();

        self::assertCount(0, $collection);

        $notice1 = new Notice(
            'd79f1191-d486-46b5-9624-e4a75bdaeeaf',
            1,
            '3a08a6c4-ebca-4444-bff5-0eac1634fa15',
            'Notice message #1',
            false,
            new DateTime('2019-08-12 14:00:00')
        );

        $notice2 = new Notice(
            '5f56f5aa-bad5-46ba-91a7-2621762f9c29',
            1,
            'fac622bc-a276-4da5-8f77-bf01b8a2d579',
            'Notice message #2',
            true,
            new DateTime('2019-08-15 18:00:00')
        );

        $collection->add($notice1);
        $collection->add($notice2);

        self::assertCount(2, $collection);

        foreach ($collection as $i => $notice) {
            if ($i === 0) {
                self::assertEquals($notice, $notice1);
            }
            if ($i === 1) {
                self::assertEquals($notice, $notice2);
            }
        }
    }
}
