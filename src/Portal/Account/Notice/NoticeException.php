<?php

declare(strict_types=1);

namespace Portal\Account\Notice;

use Exception;

class NoticeException extends Exception
{
    public const UNKNOWN_TYPE = 'Unknown type notice';
}
