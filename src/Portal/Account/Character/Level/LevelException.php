<?php

declare(strict_types=1);

namespace Portal\Account\Character\Level;

use Exception;

class LevelException extends Exception
{
    public const INVALID_LEVEL = 'Invalid level';
}
