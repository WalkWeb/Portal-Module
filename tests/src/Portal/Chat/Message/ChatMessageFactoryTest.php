<?php

declare(strict_types=1);

namespace Tests\src\Portal\Chat\Message;

use Exception;
use Portal\Chat\Message\ChatMessageException;
use Portal\Chat\Message\ChatMessageFactory;
use Portal\Chat\Message\ChatMessageInterface;
use Portal\Chat\User\ChatUserFactory;
use Portal\Traits\Validation\ValidationException;
use Tests\AbstractUnitTest;

class ChatMessageFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание сообщение в чате на основе массива параметров
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @throws ValidationException
     */
    public function testChatMessageFactoryCreateSuccess(array $data): void
    {
        $message = $this->getFactory()->create($data);

        self::assertEquals($data['chat_message_id'], $message->getId());
        self::assertEquals($data['chat_message'], $message->getMessage());
        self::assertEquals($data['chat_channel_id'], $message->getChannelId());

        self::assertEquals($data['chat_user_id'], $message->getUser()->getId());
        self::assertEquals($data['chat_user_name'], $message->getUser()->getName());
        self::assertEquals($data['chat_user_avatar'], $message->getUser()->getAvatar());
    }

    /**
     * Тесты на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @throws ValidationException
     */
    public function testChatMessageFactoryCreateFail(array $data, string $error): void
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
                    'chat_message_id'  => 'f8712d11-4da4-4716-8a64-a5fb28c03c69',
                    'chat_message'     => 'Chat message',
                    'chat_channel_id'  => '55be6800-f204-49f2-aead-82c3bd86cc82',
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
            ],
        ];
    }

    /**
     * @return array[]
     * @throws Exception
     */
    public function failDataProvider(): array
    {
        return [
            [
                // Отсутствует chat_message_id
                [
                    'chat_message'     => 'Chat message',
                    'chat_channel_id'  => '55be6800-f204-49f2-aead-82c3bd86cc82',
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatMessageException::INVALID_ID,
            ],
            [
                // chat_message_id некорректного типа
                [
                    'chat_message_id'  => 158,
                    'chat_message'     => 'Chat message',
                    'chat_channel_id'  => '55be6800-f204-49f2-aead-82c3bd86cc82',
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatMessageException::INVALID_ID,
            ],
            [
                // Отсутствует chat_message
                [
                    'chat_message_id'  => 'f8712d11-4da4-4716-8a64-a5fb28c03c69',
                    'chat_channel_id'  => '55be6800-f204-49f2-aead-82c3bd86cc82',
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatMessageException::INVALID_MESSAGE,
            ],
            [
                // chat_message некорректного типа
                [
                    'chat_message_id'  => 'f8712d11-4da4-4716-8a64-a5fb28c03c69',
                    'chat_message'     => null,
                    'chat_channel_id'  => '55be6800-f204-49f2-aead-82c3bd86cc82',
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatMessageException::INVALID_MESSAGE,
            ],
            [
                // chat_message меньше минимальной длины
                [
                    'chat_message_id'  => 'f8712d11-4da4-4716-8a64-a5fb28c03c69',
                    'chat_message'     => self::generateString(ChatMessageInterface::MIN_LENGTH - 1),
                    'chat_channel_id'  => '55be6800-f204-49f2-aead-82c3bd86cc82',
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatMessageException::INVALID_MESSAGE_VALUE . ': ' . ChatMessageInterface::MIN_LENGTH . '-' . ChatMessageInterface::MAX_LENGTH,
            ],
            [
                // chat_message больше максимальной длины
                [
                    'chat_message_id'  => 'f8712d11-4da4-4716-8a64-a5fb28c03c69',
                    'chat_message'     => self::generateString(ChatMessageInterface::MAX_LENGTH + 1),
                    'chat_channel_id'  => '55be6800-f204-49f2-aead-82c3bd86cc82',
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatMessageException::INVALID_MESSAGE_VALUE . ': ' . ChatMessageInterface::MIN_LENGTH . '-' . ChatMessageInterface::MAX_LENGTH,
            ],
            [
                // Отсутствует chat_channel_id
                [
                    'chat_message_id'  => 'f8712d11-4da4-4716-8a64-a5fb28c03c69',
                    'chat_message'     => 'Chat message',
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatMessageException::INVALID_CHANNEL_ID,
            ],
            [
                // chat_channel_id некорректного типа
                [
                    'chat_message_id'  => 'f8712d11-4da4-4716-8a64-a5fb28c03c69',
                    'chat_message'     => 'Chat message',
                    'chat_channel_id'  => 40.3,
                    'chat_user_id'     => 'b8912fda-54ec-4cdf-8693-5b9e52f043c5',
                    'chat_user_name'   => 'UserName',
                    'chat_user_avatar' => 'avatar.png',
                ],
                ChatMessageException::INVALID_CHANNEL_ID,
            ],
            // Параметры пользователя не проверяются - они проверяются в ChatUserFactoryTest
        ];
    }

    /**
     * @return ChatMessageFactory
     */
    private function getFactory(): ChatMessageFactory
    {
        return new ChatMessageFactory(new ChatUserFactory());
    }
}
