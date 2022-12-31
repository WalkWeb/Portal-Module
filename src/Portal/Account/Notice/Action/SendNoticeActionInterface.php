<?php

declare(strict_types=1);

namespace Portal\Account\Notice\Action;

use Portal\Account\Notice\NoticeException;
use Portal\Account\Notice\NoticeInterface;

interface SendNoticeActionInterface
{
    /**
     * Создает и сохраняет уведомление для пользователя
     *
     * @param string $accountId
     * @param string $message
     * @param int $type
     * @throws NoticeException
     */
    public function send(string $accountId, string $message, int $type = NoticeInterface::TYPE_INFO): void;
}
