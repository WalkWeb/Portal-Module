<?php

declare(strict_types=1);

namespace Portal\Account\Carma;

use Exception;

class CarmaException extends Exception
{
    public const INVALID_CARMA = 'Invalid carma: post_carma + comment_carma != total_carma';
}
