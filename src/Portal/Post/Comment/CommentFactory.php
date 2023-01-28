<?php

declare(strict_types=1);

namespace Portal\Post\Comment;

use Portal\Pieces\Traits\Validation\ValidationException;
use Portal\Pieces\Traits\Validation\ValidationTrait;

class CommentFactory
{
    use ValidationTrait;

    /**
     * Создает комментарий на основе массива данных
     *
     * @param array $data
     * @return CommentInterface
     * @throws ValidationException
     */
    public function create(array $data): CommentInterface
    {
        $content = self::string($data, 'content', CommentException::INVALID_CONTENT);

        self::stringMinMaxLength(
            $content,
            CommentInterface::MIN_LENGTH,
            CommentInterface::MAX_LENGTH,
            CommentException::INVALID_CONTENT_VALUE . ': ' . CommentInterface::MIN_LENGTH . '-' . CommentInterface::MAX_LENGTH
        );

        return new Comment(
            self::string($data, 'id', CommentException::INVALID_ID),
            self::string($data, 'post_id', CommentException::INVALID_POST_ID),
            self::string($data, 'account_id', CommentException::INVALID_ACCOUNT_ID),
            $content,
            self::int($data, 'rating', CommentException::INVALID_RATING),
            self::date($data, 'created_at', CommentException::INVALID_CREATED_AT),
            self::dateOrNull($data, 'updated_at', CommentException::INVALID_UPDATED_AT),
        );
    }
}
