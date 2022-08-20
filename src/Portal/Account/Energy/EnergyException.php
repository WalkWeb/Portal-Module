<?php

declare(strict_types=1);

namespace Portal\Account\Energy;

use Exception;

class EnergyException extends Exception
{
    public const ALREADY_MAX                  = 'Energy already max';
    public const NO_ENOUGH                    = 'No enough energy. Have %d need %d';
    public const ZERO_VALUE                   = 'No change energy: zero value';
}
