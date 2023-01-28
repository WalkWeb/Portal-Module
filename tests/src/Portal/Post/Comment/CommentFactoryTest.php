<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\Comment;

use Exception;
use Portal\Post\Comment\CommentException;
use Portal\Post\Comment\CommentFactory;
use Portal\Post\Comment\CommentInterface;
use Portal\Pieces\Traits\Validation\ValidationException;
use Tests\AbstractUnitTest;

class CommentFactoryTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание комментария на основе массива данных
     *
     * @dataProvider successDataProvider
     * @param array $data
     * @throws ValidationException
     */
    public function testCommentFactoryCreateSuccess(array $data): void
    {
        $comment = $this->getFactory()->create($data);

        self::assertEquals($data['id'], $comment->getId());
        self::assertEquals($data['post_id'], $comment->getPostId());
        self::assertEquals($data['account_id'], $comment->getAccountId());
        self::assertEquals($data['content'], $comment->getContent());
        self::assertEquals($data['rating'], $comment->getRating());
        self::assertEquals($data['created_at'], $comment->getCreatedAt()->format(self::DATE_FORMAT));

        if (!is_null($data['updated_at'])) {
            self::assertEquals($data['updated_at'], $comment->getUpdatedAt()->format(self::DATE_FORMAT));
        } else {
            self::assertNull($comment->getUpdatedAt());
        }
    }

    /**
     * Тест на различные варианты невалидных данных
     *
     * @dataProvider failDataProvider
     * @param array $data
     * @param string $error
     */
    public function testCommentFactoryCreateFail(array $data, string $error): void
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
                // Дата редактирования указана
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
            ],
            [
                // Дата редактирования отсутствует
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #2',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => null,
                ],
            ],
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function failDataProvider(): array
    {
        return [
            [
                // отсутствует id
                [
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_ID,
            ],
            [
                // id некорректного типа
                [
                    'id'         => 100,
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_ID,
            ],
            [
                // отсутствует post_id
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_POST_ID,
            ],
            [
                // post_id некорректного типа
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 100,
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_POST_ID,
            ],
            [
                // отсутствует account_id
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_ACCOUNT_ID,
            ],
            [
                // account_id некорректного типа
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 100,
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_ACCOUNT_ID,
            ],
            [
                // отсутствует content
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_CONTENT,
            ],
            [
                // content некорректного типа
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => ['content #1'],
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_CONTENT,
            ],
            [
                // content короче минимальной длины
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => self::generateString(CommentInterface::MIN_LENGTH - 1),
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_CONTENT_VALUE . ': ' . CommentInterface::MIN_LENGTH . '-' . CommentInterface::MAX_LENGTH,
            ],
            [
                // content длиннее максимальной длины
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => self::generateString(CommentInterface::MAX_LENGTH + 1),
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_CONTENT_VALUE . ': ' . CommentInterface::MIN_LENGTH . '-' . CommentInterface::MAX_LENGTH,
            ],
            [
                // отсутствует rating
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_RATING,
            ],
            [
                // rating некорректного типа
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => '5',
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_RATING,
            ],
            [
                // отсутствует created_at
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_CREATED_AT,
            ],
            [
                // created_at некорректного типа
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => 10000000000,
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_CREATED_AT,
            ],
            [
                // в created_at указана некорректная дата
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => 'bbbbbbb',
                    'updated_at' => '2019-08-19 19:00:00',
                ],
                CommentException::INVALID_CREATED_AT,
            ],
            [
                // отсутствует updated_at
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                ],
                CommentException::INVALID_UPDATED_AT,
            ],
            [
                // updated_at некорректного типа
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => true,
                ],
                CommentException::INVALID_UPDATED_AT,
            ],
            [
                // в updated_at указана некорректная дата
                [
                    'id'         => '20497e1a-304e-4007-90ff-bc74a10f3bc3',
                    'post_id'    => 'edb4bd4b-dc8d-4d6e-8d76-d87149fc4391',
                    'account_id' => 'bd4e04c6-632d-4914-86f9-44520865f067',
                    'content'    => 'content #1',
                    'rating'     => 5,
                    'created_at' => '2019-08-15 15:00:00',
                    'updated_at' => 'uuuuuu',
                ],
                CommentException::INVALID_UPDATED_AT,
            ],
        ];
    }

    /**
     * @return CommentFactory
     */
    private function getFactory(): CommentFactory
    {
        return new CommentFactory();
    }
}
