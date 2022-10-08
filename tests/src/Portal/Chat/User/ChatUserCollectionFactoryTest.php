<?php

declare(strict_types=1);

namespace Tests\src\Portal\Chat\User;

use Exception;
use Portal\Chat\User\ChatUserCollectionFactory;
use Portal\Chat\User\ChatUserException;
use Portal\Chat\User\ChatUserFactory;
use Tests\AbstractUnitTest;

class ChatUserCollectionFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание коллекции пользователей чата на основе массива с данными
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @throws Exception
     */
    public function testChatUserCollectionFactoryCreateSuccess(array $data): void
    {
        $collection = $this->getFactory()->create($data);

        self::assertSameSize($data, $collection);

        $i = 0;
        foreach ($collection as $user) {
            self::assertEquals($data[$i]['chat_user_id'], $user->getId());
            self::assertEquals($data[$i]['chat_user_name'], $user->getName());
            self::assertEquals($data[$i]['chat_user_avatar'], $user->getAvatar());
            $i++;
        }
    }

    /**
     * Тест на ошибку при попытке создания коллекции пользователей чата на основе массива с данными
     *
     * В текущей ситуации ошибка может быть только одна: когда вместо массива по пользователю получен какой-то другой
     * тип данных
     *
     * Все остальные невалидные варианты конкретного пользователя проверяются в тесте ChatUserFactoryTest
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @throws Exception
     */
    public function testChatUserCollectionFactoryCreateFail(array $data, string $error): void
    {
        $this->expectException(ChatUserException::class);
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
                    [
                        'chat_user_id'     => '963f3f66-0753-4b21-841b-ae76e8f9750c',
                        'chat_user_name'   => 'User#1',
                        'chat_user_avatar' => 'avatar-1.png',
                    ],
                    [
                        'chat_user_id'     => '6efb5323-f5a2-42e8-9a79-01a05f563670',
                        'chat_user_name'   => 'User#2',
                        'chat_user_avatar' => 'avatar-2.png',
                    ],
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
                [
                    [
                        'chat_user_id'     => '963f3f66-0753-4b21-841b-ae76e8f9750c',
                        'chat_user_name'   => 'User#1',
                        'chat_user_avatar' => 'avatar-1.png',
                    ],
                    // По второму пользователю вместо массива с данными просто строка
                    'User#2',
                ],
                ChatUserException::EXPECTED_ARRAY . ". Element 2",
            ],
        ];
    }

    /**
     * @return ChatUserCollectionFactory
     */
    private function getFactory(): ChatUserCollectionFactory
    {
        return new ChatUserCollectionFactory(new ChatUserFactory());
    }
}
