<?php

declare(strict_types=1);

namespace Portal\Account\Notice;

use Exception;
use Portal\Pieces\Traits\Validation\ValidationTrait;

class NoticeFactory
{
    use ValidationTrait;

    /**
     * Создает объект, реализующий интерфейс NoticeInterface на основе массива параметров
     *
     * @param array $data
     * @return NoticeInterface
     * @throws Exception
     */
    public function create(array $data): NoticeInterface
    {
        self::string($data, 'id', NoticeException::INVALID_ID);
        self::int($data, 'type', NoticeException::INVALID_TYPE);
        self::string($data, 'account_id', NoticeException::INVALID_ACCOUNT_ID);
        self::string($data, 'message', NoticeException::INVALID_MESSAGE);
        self::bool($data, 'view', NoticeException::INVALID_VIEW);

        return new Notice(
            $data['id'],
            $data['type'],
            $data['account_id'],
            $data['message'],
            $data['view'],
            self::date($data, 'created_at', NoticeException::INVALID_CREATED_AT),
        );
    }
}
