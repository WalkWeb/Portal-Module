<?php

declare(strict_types=1);

namespace Portal\Account\Carma;

class Carma implements CarmaInterface
{
    private string $accountId;

    private int $totalCarma;

    private int $postCarma;

    private int $commentCarma;

    /**
     * @param string $accountId
     * @param int $totalCarma
     * @param int $postCarma
     * @param int $commentCarma
     * @throws CarmaException
     */
    public function __construct(string $accountId, int $totalCarma, int $postCarma, int $commentCarma)
    {
        if ($postCarma + $commentCarma !== $totalCarma) {
            throw new CarmaException(CarmaException::INVALID_CARMA);
        }

        $this->accountId = $accountId;
        $this->totalCarma = $totalCarma;
        $this->postCarma = $postCarma;
        $this->commentCarma = $commentCarma;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return int
     */
    public function getTotalCarma(): int
    {
        return $this->totalCarma;
    }

    /**
     * @return int
     */
    public function getPostCarma(): int
    {
        return $this->postCarma;
    }

    /**
     * @return int
     */
    public function getCommentCarma(): int
    {
        return $this->commentCarma;
    }
}
