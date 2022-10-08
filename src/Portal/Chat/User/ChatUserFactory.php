<?php

declare(strict_types=1);

namespace Portal\Chat\User;

use Portal\Traits\Validation\ValidationException;
use Portal\Traits\Validation\ValidationTrait;

class ChatUserFactory
{
    use ValidationTrait;

    /**
     * Создает объект пользователя чата на основе массива с данными
     *
     * @param array $data
     * @return ChatUserInterface
     * @throws ValidationException
     */
    public function create(array $data): ChatUserInterface
    {
        $id = self::string($data, 'chat_user_id', ChatUserException::INVALID_ID);
        $name = self::string($data, 'chat_user_name', ChatUserException::INVALID_NAME);
        $avatar = self::string($data, 'chat_user_avatar', ChatUserException::INVALID_AVATAR);

        return new ChatUser(
            $id,
            $name,
            $avatar
        );
    }
}
