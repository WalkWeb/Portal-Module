<?php

declare(strict_types=1);

namespace Tests\src\Mock\Account\Notice\Repository;

use Portal\Account\Notice\NoticeException;
use Portal\Account\Notice\NoticeInterface;
use Portal\Account\Notice\Repository\NoticeRepositoryInterface;

/**
 * Мок на NoticeRepository, который вместо того, чтобы сохранять уведомления в базе, просто сохраняет их в себе
 *
 * @package Tests\src\Mock\Account\Notice\Repository
 */
class MockNoticeRepository implements NoticeRepositoryInterface
{
    /**
     * @var NoticeInterface[]
     */
    private array $notices = [];

    /**
     * @param string $id
     * @return NoticeInterface
     * @throws NoticeException
     */
    public function get(string $id): NoticeInterface
    {
        if (!array_key_exists($id, $this->notices)) {
            throw new NoticeException("MockNoticeRepository: notice id $id not found");
        }

        return $this->notices[$id];
    }

    /**
     * @param NoticeInterface $notice
     */
    public function save(NoticeInterface $notice): void
    {
        $this->notices[$notice->getId()] = $notice;
    }
}
