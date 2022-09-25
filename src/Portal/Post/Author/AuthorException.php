<?php

declare(strict_types=1);

namespace Portal\Post\Author;

use Exception;

class AuthorException extends Exception
{
    public const INVALID_ID        = 'Incorrect "id" parameter, it required and type string';
    public const INVALID_NAME      = 'Incorrect "name" parameter, it required and type string';
    public const INVALID_AVATAR    = 'Incorrect "avatar" parameter, it required and type string';
    public const INVALID_LEVEL     = 'Incorrect "level" parameter, it required and type string';
    public const INVALID_STATUS_ID = 'Incorrect "author_status_id" parameter, it required and type string';
}
