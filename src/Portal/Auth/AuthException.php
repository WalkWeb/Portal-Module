<?php

declare(strict_types=1);

namespace Portal\Auth;

use Exception;

class AuthException extends Exception
{
    public const INVALID_ID                     = 'Incorrect "id" parameter, it required and type int';
    public const INVALID_NAME                   = 'Incorrect "name" parameter, it required and type string';
    public const INVALID_AVATAR                 = 'Incorrect "avatar" parameter, it required and type string';
    public const INVALID_ACCOUNT_GROUP_ID       = 'Incorrect "account_group_id" parameter, it required and type int';
    public const INVALID_ACCOUNT_STATUS_ID      = 'Incorrect "account_status_id" parameter, it required and type int';
    public const INVALID_ACCOUNT_CHAT_STATUS_ID = 'Incorrect "account_chat_status_id" parameter, it required and type int';
    public const INVALID_ENERGY_DATA            = 'Incorrect "energy" parameter, it required and type array';
    public const INVALID_CAN_LIKE               = 'Incorrect "can_like" parameter, it required and type bool';
}
