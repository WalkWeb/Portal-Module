<?php

declare(strict_types=1);

namespace Portal\Account\Character\Level;

use Exception;
use Portal\Traits\Validation\ValidationTrait;

class LevelFactory
{
    use ValidationTrait;

    /**
     * Создает объект Level на основе массива с параметрами
     *
     * @param array $data
     * @return LevelInterface
     * @throws Exception
     */
    public function create(array $data): LevelInterface
    {
        $level = self::int($data, 'character_level', LevelException::INVALID_LEVEL_DATA);
        $exp = self::int($data, 'character_exp', LevelException::INVALID_EXP_DATA);
        $statPoints = self::int($data, 'character_stat_points', LevelException::INVALID_STAT_POINTS_DATA);

        return new Level($level, $exp, $statPoints);
    }
}
