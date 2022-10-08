<?php

declare(strict_types=1);

namespace Portal\Chat\Message;

use Portal\Chat\User\ChatUserInterface;

interface ChatMessageInterface
{
    // TODO min-max message length

    /**
     * Возвращает id сообщения чата
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Возвращает сообщение чата
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Возвращает данные по автору сообщения
     *
     * @return ChatUserInterface
     */
    public function getUser(): ChatUserInterface;

    /**
     * Возвращает id канала, к которому относится данное сообщение
     *
     * @return string
     */
    public function getChannelId(): string;
}
