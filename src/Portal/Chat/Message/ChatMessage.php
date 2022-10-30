<?php

declare(strict_types=1);

namespace Portal\Chat\Message;

use Portal\Chat\User\ChatUserInterface;

class ChatMessage implements ChatMessageInterface
{
    private string $id;
    private string $message;
    private string $channelId;
    private ChatUserInterface $user;

    public function __construct(string $id, string $message, string $channelId, ChatUserInterface $user)
    {
        $this->id = $id;
        $this->message = $message;
        $this->channelId = $channelId;
        $this->user = $user;
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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @return ChatUserInterface
     */
    public function getUser(): ChatUserInterface
    {
        return $this->user;
    }
}
