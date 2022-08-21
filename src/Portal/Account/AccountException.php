<?php

declare(strict_types=1);

namespace Portal\Account;

use Exception;

class AccountException extends Exception
{
    public const UNKNOWN_ACCOUNT_STATUS_ID      = 'Unknown account status id';
    public const UNKNOWN_ACCOUNT_CHAT_STATUS_ID = 'Unknown account chat status id';
    public const UNKNOWN_ACCOUNT_GROUP_ID       = 'Unknown account group id';
    public const UNKNOWN_FLOOR_ID               = 'Unknown floor id';
}
