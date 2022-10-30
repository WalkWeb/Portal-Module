<?php

declare(strict_types=1);

namespace Portal\Chat\Message;

use Portal\Chat\User\ChatUserFactory;
use Portal\Traits\Validation\ValidationException;
use Portal\Traits\Validation\ValidationTrait;

class ChatMessageFactory
{
    use ValidationTrait;

    private ChatUserFactory $chatUserFactory;

    public function __construct(ChatUserFactory $chatUserFactory)
    {
        $this->chatUserFactory = $chatUserFactory;
    }

    /**
     * Создает объект сообщения в чате не основе массива параметров
     *
     * @param array $data
     * @return ChatMessageInterface
     * @throws ValidationException
     */
    public function create(array $data): ChatMessageInterface
    {
        $message = self::string($data, 'chat_message', ChatMessageException::INVALID_MESSAGE);

        self::stringMinMaxLength(
            $message,
            ChatMessageInterface::MIN_LENGTH,
            ChatMessageInterface::MAX_LENGTH,
            ChatMessageException::INVALID_MESSAGE_VALUE . ': ' . ChatMessageInterface::MIN_LENGTH . '-' . ChatMessageInterface::MAX_LENGTH
        );

        return new ChatMessage(
            self::string($data, 'chat_message_id', ChatMessageException::INVALID_ID),
            $message,
            self::string($data, 'chat_channel_id', ChatMessageException::INVALID_CHANNEL_ID),
            $this->chatUserFactory->create($data)
        );
    }
}
