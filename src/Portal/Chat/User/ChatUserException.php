<?php

declare(strict_types=1);

namespace Portal\Chat\User;

use Exception;

class ChatUserException extends Exception
{
    public const INVALID_ID     = 'Incorrect "chat_user_id" parameter, it required and type string';
    public const INVALID_NAME   = 'Incorrect "chat_user_name" parameter, it required and type string';
    public const INVALID_AVATAR = 'Incorrect "chat_user_avatar" parameter, it required and type string';
    public const ALREADY_EXIST  = 'ChatUserCollection: user to be added already exists';
    public const EXPECTED_ARRAY = 'Incorrect chat user data: expected array';
}
