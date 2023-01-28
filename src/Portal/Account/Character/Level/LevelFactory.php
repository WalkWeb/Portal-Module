<?php

declare(strict_types=1);

namespace Portal\Account\Character\Level;

use Exception;
use Portal\Account\Notice\Action\SendNoticeActionInterface;
use Portal\Pieces\Traits\Validation\ValidationTrait;

class LevelFactory
{
    use ValidationTrait;

    /**
     * Создает объект Level на основе массива с параметрами
     *
     * TODO Подумать над тем, имеет ли смысл проверки на min/max значение разместить внутри класса Level
     *
     * @param array $data
     * @param SendNoticeActionInterface $sendNoticeAction
     * @return LevelInterface
     * @throws Exception
     */
    public function create(array $data, SendNoticeActionInterface $sendNoticeAction): LevelInterface
    {
        $accountId = self::string($data, 'account_id', LevelException::INVALID_ACCOUNT_ID_DATA);
        $characterId = self::string($data, 'character_id', LevelException::INVALID_CHARACTER_ID_DATA);
        $level = self::int($data, 'character_level', LevelException::INVALID_LEVEL_DATA);
        $exp = self::int($data, 'character_exp', LevelException::INVALID_EXP_DATA);
        $statPoints = self::int($data, 'character_stat_points', LevelException::INVALID_STAT_POINTS_DATA);

        self::stringMinMaxLength(
            $accountId,
            LevelInterface::ACCOUNT_ID_MIN_LENGTH,
            LevelInterface::ACCOUNT_ID_MAX_LENGTH,
            LevelException::INVALID_ACCOUNT_ID_VALUE . LevelInterface::ACCOUNT_ID_MIN_LENGTH . '-' . LevelInterface::ACCOUNT_ID_MAX_LENGTH
        );

        self::stringMinMaxLength(
            $characterId,
            LevelInterface::CHARACTER_ID_MIN_LENGTH,
            LevelInterface::CHARACTER_ID_MAX_LENGTH,
            LevelException::INVALID_CHARACTER_ID_VALUE . LevelInterface::CHARACTER_ID_MIN_LENGTH . '-' . LevelInterface::CHARACTER_ID_MAX_LENGTH
        );

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

        return new Level($accountId, $characterId, $level, $exp, $statPoints, $sendNoticeAction);
    }
}
