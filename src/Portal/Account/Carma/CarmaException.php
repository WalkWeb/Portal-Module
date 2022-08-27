<?php

declare(strict_types=1);

namespace Portal\Account\Carma;

use Exception;

class CarmaException extends Exception
{
    public const INVALID_CARMA               = 'Invalid carma: post_carma + comment_carma != total_carma';
    public const INVALID_ID_DATA             = 'CarmaFactory: Incorrect parameter "account_id", it required and type string';
    public const INVALID_ID_VALUE            = 'CarmaFactory: Incorrect "account_id", should be min-max length: ';
    public const INVALID_TOTAL_CARMA_DATA    = 'CarmaFactory: Incorrect parameter "account_total_carma", it required and type integer';
    public const INVALID_TOTAL_CARMA_VALUE   = 'CarmaFactory: Incorrect parameter "account_total_carma", should be min-max: ';
    public const INVALID_POST_CARMA_DATA     = 'CarmaFactory: Incorrect parameter "account_post_carma", it required and type integer';
    public const INVALID_POST_CARMA_VALUE    = 'CarmaFactory: Incorrect parameter "account_post_carma", should be min-max: ';
    public const INVALID_COMMENT_CARMA_DATA  = 'CarmaFactory: Incorrect parameter "account_comment_carma", it required and type integer';
    public const INVALID_COMMENT_CARMA_VALUE = 'CarmaFactory: Incorrect parameter "account_comment_carma", should be min-max: ';
}
