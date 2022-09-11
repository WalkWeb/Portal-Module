<?php

declare(strict_types=1);

namespace Portal\Auth;

use Portal\Account\ChatStatus\ChatStatusInterface;
use Portal\Account\Energy\EnergyInterface;
use Portal\Account\Group\AccountGroupInterface;
use Portal\Account\Status\AccountStatusInterface;

class Auth implements AuthInterface
{
    private string $id;
    private string $name;
    private string $avatar;
    private AccountGroupInterface $group;
    private AccountStatusInterface $status;
    private ChatStatusInterface $chatStatus;
    private EnergyInterface $energy;
    private bool $canLike;

    public function __construct(
        string $id,
        string $name,
        string $avatar,
        AccountGroupInterface $group,
        AccountStatusInterface $status,
        ChatStatusInterface $chatStatus,
        EnergyInterface $energy,
        bool $canLike
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->avatar = $avatar;
        $this->group = $group;
        $this->status = $status;
        $this->chatStatus = $chatStatus;
        $this->energy = $energy;
        $this->canLike = $canLike;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @return AccountGroupInterface
     */
    public function getGroup(): AccountGroupInterface
    {
        return $this->group;
    }

    /**
     * @return AccountStatusInterface
     */
    public function getStatus(): AccountStatusInterface
    {
        return $this->status;
    }

    /**
     * @return ChatStatusInterface
     */
    public function getChatStatus(): ChatStatusInterface
    {
        return $this->chatStatus;
    }

    /**
     * @return EnergyInterface
     */
    public function getEnergy(): EnergyInterface
    {
        return $this->energy;
    }

    /**
     * @return bool
     */
    public function isCanLike(): bool
    {
        return $this->canLike;
    }
}
