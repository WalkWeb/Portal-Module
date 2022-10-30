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
        return new ChatMessage(
            self::string($data, 'chat_message_id', ChatMessageException::INVALID_ID),
            self::string($data, 'chat_message', ChatMessageException::INVALID_MESSAGE),
            self::string($data, 'chat_channel_id', ChatMessageException::INVALID_CHANNEL_ID),
            $this->chatUserFactory->create($data)
        );
    }
}
