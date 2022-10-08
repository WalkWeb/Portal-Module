<?php

declare(strict_types=1);

namespace Portal\Chat\User;

class ChatUser implements ChatUserInterface
{
    private string $id;
    private string $name;
    private string $avatar;

    public function __construct(string $id, string $name, string $avatar)
    {
        $this->id = $id;
        $this->name = $name;
        $this->avatar = $avatar;
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
}
