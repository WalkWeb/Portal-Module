<?php

declare(strict_types=1);

namespace Portal\Post\Author;

use Portal\Account\AccountException;
use Portal\Account\Status\AccountStatus;
use Portal\Pieces\Traits\Validation\ValidationException;
use Portal\Pieces\Traits\Validation\ValidationTrait;

class AuthorFactory
{
    use ValidationTrait;

    /**
     * Создает объект Author на основе массива с данными
     *
     * @param array $data
     * @return AuthorInterface
     * @throws AccountException
     * @throws ValidationException
     */
    public function create(array $data): AuthorInterface
    {
        return new Author(
            self::string($data, 'author_id', AuthorException::INVALID_ID),
            self::string($data, 'author_name', AuthorException::INVALID_NAME),
            self::string($data, 'author_avatar', AuthorException::INVALID_AVATAR),
            self::int($data, 'author_level', AuthorException::INVALID_LEVEL),
            new AccountStatus(self::int($data, 'author_status_id', AuthorException::INVALID_STATUS_ID)),
        );
    }
}
