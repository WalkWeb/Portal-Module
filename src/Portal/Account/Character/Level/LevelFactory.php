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
     * TODO Подумать над тем, имеет ли смысл проверки на min/max значение разместить внутри класса Level
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

        self::intMinMaxValue(
            $level,
            LevelInterface::MIN_LEVEL,
            LevelInterface::MAX_LEVEL,
            LevelException::INVALID_LEVEL_VALUE . LevelInterface::MIN_LEVEL . '-' . LevelInterface::MAX_LEVEL
        );

        self::intMinMaxValue(
            $exp,
            LevelInterface::MIN_EXP,
            LevelInterface::MAX_EXP,
            LevelException::INVALID_EXP_VALUE . LevelInterface::MIN_EXP . '-' . LevelInterface::MAX_EXP
        );

        self::intMinMaxValue(
            $statPoints,
            LevelInterface::MIN_STAT_POINTS,
            LevelInterface::MAX_STAT_POINTS,
            LevelException::INVALID_STAT_POINTS_VALUE . LevelInterface::MIN_STAT_POINTS . '-' . LevelInterface::MAX_STAT_POINTS
        );

        return new Level($level, $exp, $statPoints);
    }
}
