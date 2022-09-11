<?php

declare(strict_types=1);

namespace Portal\Auth;

use Portal\Account\AccountException;
use Portal\Account\ChatStatus\AccountChatStatus;
use Portal\Account\Energy\EnergyFactory;
use Portal\Account\Group\AccountGroup;
use Portal\Account\Status\AccountStatus;
use Portal\Traits\Validation\ValidationException;
use Portal\Traits\Validation\ValidationTrait;

class AuthFactory
{
    use ValidationTrait;

    private EnergyFactory $energyFactory;

    public function __construct(EnergyFactory $energyFactory)
    {
        $this->energyFactory = $energyFactory;
    }

    /**
     * Создает объект реализующий интерфейс AuthInterface на основе массива с данными
     *
     * @param array $data
     * @return AuthInterface
     * @throws ValidationException
     * @throws AccountException
     */
    public function create(array $data): AuthInterface
    {
        self::string($data, 'id', AuthException::INVALID_ID);
        self::string($data, 'name', AuthException::INVALID_NAME);
        self::string($data, 'avatar', AuthException::INVALID_AVATAR);
        self::int($data, 'account_group_id', AuthException::INVALID_ACCOUNT_GROUP_ID);
        self::int($data, 'account_status_id', AuthException::INVALID_ACCOUNT_STATUS_ID);
        self::int($data, 'account_chat_status_id', AuthException::INVALID_ACCOUNT_CHAT_STATUS_ID);
        self::array($data, 'energy', AuthException::INVALID_ENERGY_DATA);
        self::bool($data, 'can_like', AuthException::INVALID_CAN_LIKE);

        return new Auth(
            $data['id'],
            $data['name'],
            $data['avatar'],
            new AccountGroup($data['account_group_id']),
            new AccountStatus($data['account_status_id']),
            new AccountChatStatus($data['account_chat_status_id']),
            $this->energyFactory->create($data['energy']),
            $data['can_like'],
        );
    }
}
