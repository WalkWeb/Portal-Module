<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\Author;

use Exception;
use Portal\Account\AccountException;
use Portal\Post\Author\AuthorException;
use Portal\Post\Author\AuthorFactory;
use Tests\AbstractUnitTest;

class AuthorFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание автора поста на основе массива с данными
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @throws Exception
     */
    public function testAuthorFactoryCreateSuccess(array $data): void
    {
        $author = $this->getFactory()->create($data);

        self::assertEquals($data['id'], $author->getId());
        self::assertEquals($data['name'], $author->getName());
        self::assertEquals($data['avatar'], $author->getAvatar());
        self::assertEquals($data['level'], $author->getLevel());
        self::assertEquals($data['author_status_id'], $author->getStatus()->getId());
    }

    /**
     * Тест на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     * @throws Exception
     */
    public function testAuthorFactoryCreateFail(array $data, string $error): void
    {
        $this->expectException(Exception::class);
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
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => 'Name',
                    'avatar'           => 'avatar.png',
                    'level'            => 25,
                    'author_status_id' => 1,
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
                // отсутствует id
                [
                    'name'             => 'Name',
                    'avatar'           => 'avatar.png',
                    'level'            => 25,
                    'author_status_id' => 1,
                ],
                AuthorException::INVALID_ID,
            ],
            [
                // id некорректного типа
                [
                    'id'               => 10,
                    'name'             => 'Name',
                    'avatar'           => 'avatar.png',
                    'level'            => 25,
                    'author_status_id' => 1,
                ],
                AuthorException::INVALID_ID,
            ],
            [
                // отсутствует name
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'avatar'           => 'avatar.png',
                    'level'            => 25,
                    'author_status_id' => 1,
                ],
                AuthorException::INVALID_NAME,
            ],
            [
                // name некорректного типа
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => ['Name'],
                    'avatar'           => 'avatar.png',
                    'level'            => 25,
                    'author_status_id' => 1,
                ],
                AuthorException::INVALID_NAME,
            ],
            [
                // отсутствует avatar
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => 'Name',
                    'level'            => 25,
                    'author_status_id' => 1,
                ],
                AuthorException::INVALID_AVATAR,
            ],
            [
                // avatar некорректного типа
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => 'Name',
                    'avatar'           => true,
                    'level'            => 25,
                    'author_status_id' => 1,
                ],
                AuthorException::INVALID_AVATAR,
            ],
            [
                // отсутствует level
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => 'Name',
                    'avatar'           => 'avatar.png',
                    'author_status_id' => 1,
                ],
                AuthorException::INVALID_LEVEL,
            ],
            [
                // level некорректного типа
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => 'Name',
                    'avatar'           => 'avatar.png',
                    'level'            => 25.5,
                    'author_status_id' => 1,
                ],
                AuthorException::INVALID_LEVEL,
            ],
            [
                // отсутствует author_status_id
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => 'Name',
                    'avatar'           => 'avatar.png',
                    'level'            => 25,
                ],
                AuthorException::INVALID_STATUS_ID,
            ],
            [
                // author_status_id некорректного типа
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => 'Name',
                    'avatar'           => 'avatar.png',
                    'level'            => 25,
                    'author_status_id' => true,
                ],
                AuthorException::INVALID_STATUS_ID,
            ],
            [
                // неизвестный author_status_id
                [
                    'id'               => '67ea6431-4523-42ee-bfa0-e302d6447acb',
                    'name'             => 'Name',
                    'avatar'           => 'avatar.png',
                    'level'            => 25,
                    'author_status_id' => $statusId = 333,
                ],
                AccountException::UNKNOWN_ACCOUNT_STATUS_ID . ': ' . $statusId,
            ],
        ];
    }

    /**
     * @return AuthorFactory
     */
    private function getFactory(): AuthorFactory
    {
        return new AuthorFactory();
    }
}
