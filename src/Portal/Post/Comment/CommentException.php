<?php

declare(strict_types=1);

namespace Portal\Post\Comment;

use Exception;

class CommentException extends Exception
{
    public const INVALID_ID            = 'Incorrect "id" parameter, it required and type string';
    public const INVALID_POST_ID       = 'Incorrect "post_id" parameter, it required and type string';
    public const INVALID_ACCOUNT_ID    = 'Incorrect "account_id" parameter, it required and type string';
    public const INVALID_CONTENT       = 'Incorrect "content" parameter, it required and type string';
    public const INVALID_CONTENT_VALUE = 'Incorrect "content", should be min-max length';
    public const INVALID_RATING        = 'Incorrect "rating" parameter, it required and type int';
    public const INVALID_CREATED_AT    = 'Incorrect "created_at" parameter, it required and date in type string';
    public const INVALID_UPDATED_AT    = 'Incorrect "updated_at" parameter, it required and date in type string or null';
    public const ALREADY_EXIST         = 'CommentCollection: comment to be added already exists';
}
