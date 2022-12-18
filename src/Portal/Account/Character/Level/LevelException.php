<?php

declare(strict_types=1);

namespace Portal\Account\Character\Level;

use Exception;

class LevelException extends Exception
{
    public const INVALID_LEVEL            = 'Invalid level';
    public const INVALID_ADD_EXP          = 'Invalid add exp';
    public const INVALID_LEVEL_DATA       = 'Incorrect parameter "character_level", it required and type integer';
    public const INVALID_EXP_DATA         = 'Incorrect parameter "character_exp", it required and type integer';
    public const INVALID_STAT_POINTS_DATA = 'Incorrect parameter "character_stat_points", it required and type integer';
}
