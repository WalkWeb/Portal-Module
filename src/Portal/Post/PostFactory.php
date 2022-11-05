<?php

declare(strict_types=1);

namespace Portal\Post;

use Exception;
use Portal\Post\Author\AuthorFactory;
use Portal\Post\Rating\RatingFactory;
use Portal\Post\Tag\TagCollection;
use Portal\Post\Tag\TagFactory;
use Portal\Traits\Validation\ValidationTrait;

class PostFactory
{
    use ValidationTrait;

    private AuthorFactory $authorFactory;
    private TagFactory $tagFactory;
    private RatingFactory $ratingFactory;

    public function __construct(AuthorFactory $authorFactory, TagFactory $tagFactory, RatingFactory $ratingFactory)
    {
        $this->authorFactory = $authorFactory;
        $this->tagFactory = $tagFactory;
        $this->ratingFactory = $ratingFactory;
    }

    /**
     * Создает объект поста на основе массива с данными
     *
     * @param array $data
     * @return PostInterface
     * @throws Exception
     */
    public function create(array $data): PostInterface
    {
        $title = self::string($data, 'title', PostException::INVALID_TITLE);
        $content = self::string($data, 'content', PostException::INVALID_CONTENT);

        self::stringMinMaxLength(
            $title,
            PostInterface::TITLE_MIN_LENGTH,
            PostInterface::TITLE_MAX_LENGTH,
            PostException::INVALID_TITLE_VALUE . PostInterface::TITLE_MIN_LENGTH . '-' . PostInterface::TITLE_MAX_LENGTH
        );

        self::stringMinMaxLength(
            $content,
            PostInterface::CONTENT_MIN_LENGTH,
            PostInterface::CONTENT_MAX_LENGTH,
            PostException::INVALID_CONTENT_VALUE . PostInterface::CONTENT_MIN_LENGTH . '-' . PostInterface::CONTENT_MAX_LENGTH
        );

        $tagCollection = new TagCollection();

        foreach (self::array($data, 'tags', PostException::INVALID_TAGS) as $tagData) {
            if (!is_array($tagData)) {
                throw new PostException(PostException::INVALID_TAGS_DATA);
            }

            $tagCollection->add($this->tagFactory->create($tagData));
        }

        return new Post(
            self::string($data, 'id', PostException::INVALID_ID),
            $title,
            self::string($data, 'slug', PostException::INVALID_SLUG),
            $content,
            $this->authorFactory->create($data),
            $this->ratingFactory->create($data),
            self::int($data, 'comments_count', PostException::INVALID_COMMENTS_COUNT),
            (bool)self::int($data, 'published', PostException::INVALID_PUBLISHED),
            $tagCollection,
            self::date($data, 'created_at', PostException::INVALID_CREATED_AT),
            self::dateOrNull($data, 'updated_at', PostException::INVALID_UPDATED_AT),
        );
    }
}
