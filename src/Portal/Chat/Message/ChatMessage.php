<?php

declare(strict_types=1);

namespace Portal\Chat\Message;

use Portal\Chat\User\ChatUserInterface;

class ChatMessage implements ChatMessageInterface
{
    private string $id;
    private string $message;
    private ChatUserInterface $user;
    private string $channelId;

    public function __construct(string $id, string $message, ChatUserInterface $user, string $channelId)
    {
        $this->id = $id;
        $this->message = $message;
        $this->user = $user;
        $this->channelId = $channelId;
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
     * @return ChatUserInterface
     */
    public function getUser(): ChatUserInterface
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }
}
