<?php

declare(strict_types=1);

namespace Portal\Account\Notice\Action;

use DateTime;
use Portal\Account\Notice\Notice;
use Portal\Account\Notice\NoticeException;
use Portal\Account\Notice\NoticeInterface;
use Portal\Account\Notice\Repository\NoticeRepositoryInterface;
use Ramsey\Uuid\Uuid;

class SendNoticeAction implements SendNoticeActionInterface
{
    private NoticeRepositoryInterface $noticeRepository;

    public function __construct(NoticeRepositoryInterface $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * Создает уведомление для пользователя
     *
     * @param string $accountId
     * @param string $message
     * @param int $type
     * @throws NoticeException
     */
    public function send(string $accountId, string $message, int $type = NoticeInterface::TYPE_INFO): void
    {
        $this->noticeRepository->save(new Notice(
            (string)Uuid::uuid4(),
            $type,
            $accountId,
            $message,
            true,
            new DateTime()
        ));
    }
}
