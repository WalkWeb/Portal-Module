<?php

declare(strict_types=1);

namespace Portal\Auth;

use Exception;
use Portal\Account\Character\Level\LevelInterface;
use Portal\Account\Energy\EnergyFactory;
use Portal\Account\Group\AccountGroup;
use Portal\Account\Notice\NoticeCollection;
use Portal\Account\Notice\NoticeFactory;
use Portal\Account\Status\AccountStatus;
use Portal\Pieces\Traits\Validation\ValidationTrait;

class AuthFactory
{
    use ValidationTrait;

    private EnergyFactory $energyFactory;
    private NoticeFactory $noticeFactory;

    public function __construct(EnergyFactory $energyFactory, NoticeFactory $noticeFactory)
    {
        $this->energyFactory = $energyFactory;
        $this->noticeFactory = $noticeFactory;
    }

    /**
     * Создает объект реализующий интерфейс AuthInterface на основе массива с данными
     *
     * @param array $data
     * @return AuthInterface
     * @throws Exception
     */
    public function create(array $data): AuthInterface
    {
        self::string($data, 'id', AuthException::INVALID_ID);
        self::string($data, 'name', AuthException::INVALID_NAME);
        self::string($data, 'avatar', AuthException::INVALID_AVATAR);
        self::int($data, 'account_group_id', AuthException::INVALID_ACCOUNT_GROUP_ID);
        self::int($data, 'account_status_id', AuthException::INVALID_ACCOUNT_STATUS_ID);
        self::array($data, 'energy', AuthException::INVALID_ENERGY_DATA);
        self::bool($data, 'can_like', AuthException::INVALID_CAN_LIKE);
        self::array($data, 'notices', AuthException::INVALID_NOTICES_DATA);
        self::int($data, 'level', AuthException::INVALID_LEVEL);

        self::intMinMaxValue(
            $data['level'],
            LevelInterface::MIN_LEVEL,
            LevelInterface::MAX_LEVEL,
            AuthException::INVALID_LEVEL_VALUE . LevelInterface::MIN_LEVEL . '-' . LevelInterface::MAX_LEVEL
        );

        $notices = new NoticeCollection();

        foreach ($data['notices'] as $noticeData) {
            if (!is_array($noticeData)) {
                throw new AuthException(AuthException::INVALID_NOTICE_DATA);
            }

            $notices->add($this->noticeFactory->create($noticeData));
        }

        return new Auth(
            $data['id'],
            $data['name'],
            $data['avatar'],
            new AccountGroup($data['account_group_id']),
            new AccountStatus($data['account_status_id']),
            $this->energyFactory->create($data['energy']),
            $data['can_like'],
            $notices,
            $data['level'],
        );
    }
}
