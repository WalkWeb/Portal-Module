<?php

declare(strict_types=1);

namespace Portal\Chat\Message;

use Exception;

class ChatMessageException extends Exception
{
    public const INVALID_ID            = 'Incorrect "chat_message_id" parameter, it required and type string';
    public const INVALID_MESSAGE       = 'Incorrect "chat_message" parameter, it required and type string';
    public const INVALID_MESSAGE_VALUE = 'Incorrect "chat_message", should be min-max length';
    public const INVALID_CHANNEL_ID    = 'Incorrect "chat_channel_id" parameter, it required and type string';
}
