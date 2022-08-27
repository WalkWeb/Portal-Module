<?php

declare(strict_types=1);

namespace Portal\Account\Carma;

use Portal\Traits\Validation\ValidationException;
use Portal\Traits\Validation\ValidationTrait;

class CarmaFactory
{
    use ValidationTrait;

    /**
     * Создает объект Carma на основе массива с параметрами
     *
     * @param array $data
     * @return CarmaInterface
     * @throws CarmaException
     * @throws ValidationException
     */
    public function create(array $data): CarmaInterface
    {
        $accountId = self::string($data, 'account_id', CarmaException::INVALID_ID_DATA);
        $totalCarma = self::int($data, 'account_total_carma', CarmaException::INVALID_TOTAL_CARMA_DATA);
        $postCarma = self::int($data, 'account_post_carma', CarmaException::INVALID_POST_CARMA_DATA);
        $commentCarma = self::int($data, 'account_comment_carma', CarmaException::INVALID_COMMENT_CARMA_DATA);

        self::stringMinMaxLength(
            $accountId,
            CarmaInterface::ACCOUNT_ID_MIN_LENGTH,
            CarmaInterface::ACCOUNT_ID_MAX_LENGTH,
            CarmaException::INVALID_ID_VALUE . CarmaInterface::ACCOUNT_ID_MIN_LENGTH . '-' . CarmaInterface::ACCOUNT_ID_MAX_LENGTH
        );

        self::intMinMaxValue(
            $totalCarma,
            CarmaInterface::MIN_CARMA,
            CarmaInterface::MAX_CARMA,
            CarmaException::INVALID_TOTAL_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA
        );

        self::intMinMaxValue(
            $postCarma,
            CarmaInterface::MIN_CARMA,
            CarmaInterface::MAX_CARMA,
            CarmaException::INVALID_POST_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA
        );

        self::intMinMaxValue(
            $commentCarma,
            CarmaInterface::MIN_CARMA,
            CarmaInterface::MAX_CARMA,
            CarmaException::INVALID_COMMENT_CARMA_VALUE . CarmaInterface::MIN_CARMA . '-' . CarmaInterface::MAX_CARMA
        );

        return new Carma(
            $accountId,
            $totalCarma,
            $postCarma,
            $commentCarma
        );
    }
}
