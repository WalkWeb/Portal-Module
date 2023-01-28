<?php

declare(strict_types=1);

namespace Tests\src\Portal\Chat\User;

use Portal\Chat\User\ChatUserException;
use Portal\Chat\User\ChatUserFactory;
use Portal\Pieces\Traits\Validation\ValidationException;
use Tests\AbstractUnitTest;

class ChatUserFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание пользователя чата на основе массива параметров
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @throws ValidationException
     */
    public function testChatUserFactoryCreateSuccess(array $data): void
    {
        $chatUser = $this->getFactory()->create($data);

        self::assertEquals($data['chat_user_id'], $chatUser->getId());
        self::assertEquals($data['chat_user_name'], $chatUser->getName());
        self::assertEquals($data['chat_user_avatar'], $chatUser->getAvatar());
    }

    /**
     * Тест на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @throws ValidationException
     */
    public function testChatUserFactoryCreateFail(array $data, string $error): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage($error);
        $this->getFactory()->create($data);
    }

    /**
     * @return array
     */
    public function successDataProvider(): array
    {
        return [
            [
                [
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function failDataProvider(): array
    {
        return [
            [
                // отсутствует chat_user_id
                [
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatUserException::INVALID_ID,
            ],
            [
                // chat_user_id некорректного типа
                [
                    'chat_user_id'     => 10,
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatUserException::INVALID_ID,
            ],
            [
                // отсутствует chat_user_name
                [
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatUserException::INVALID_NAME,
            ],
            [
                // chat_user_name некорректного типа
                [
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => null,
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatUserException::INVALID_NAME,
            ],
            [
                // отсутствует chat_user_avatar
                [
                    'chat_user_id'   => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name' => 'UserName',
                ],
                ChatUserException::INVALID_AVATAR,
            ],
            [
                // chat_user_avatar некорректного типа
                [
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => ['avatar.png'],
                ],
                ChatUserException::INVALID_AVATAR,
            ],
        ];
    }

    /**
     * @return ChatUserFactory
     */
    private function getFactory(): ChatUserFactory
    {
        return new ChatUserFactory();
    }
}
