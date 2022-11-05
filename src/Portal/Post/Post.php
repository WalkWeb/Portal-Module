<?php

declare(strict_types=1);

namespace Portal\Post;

use DateTimeInterface;
use Portal\Post\Author\AuthorInterface;
use Portal\Post\Rating\RatingInterface;
use Portal\Post\Tag\TagCollection;

class Post implements PostInterface
{
    private string $id;
    private string $title;
    private string $slug;
    private string $content;
    private AuthorInterface $author;
    private RatingInterface $rating;
    private int $commentsCount;
    private bool $published;
    private TagCollection $tags;
    private DateTimeInterface $createdAt;
    private ?DateTimeInterface $updatedAt;

    public function __construct(
        string $id,
        string $title,
        string $slug,
        string $content,
        AuthorInterface $author,
        RatingInterface $rating,
        int $commentsCount,
        bool $published,
        TagCollection $collection,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->author = $author;
        $this->rating = $rating;
        $this->commentsCount = $commentsCount;
        $this->published = $published;
        $this->tags = $collection;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return htmlspecialchars($this->title);
    }

    /**
     * @param string $title
     * @throws PostException
     */
    public function setTitle(string $title): void
    {
        $length = mb_strlen($title);

        if ($length < self::TITLE_MIN_LENGTH || $length > self::TITLE_MAX_LENGTH) {
            throw new PostException(
                PostException::INVALID_TITLE_VALUE . self::TITLE_MIN_LENGTH . '-' . self::TITLE_MAX_LENGTH
            );
        }

        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return htmlspecialchars($this->content);
    }

    /**
     * @param string $content
     * @throws PostException
     */
    public function setContent(string $content): void
    {
        $length = mb_strlen($content);

        if ($length < self::CONTENT_MIN_LENGTH || $length > self::CONTENT_MAX_LENGTH) {
            throw new PostException(
                PostException::INVALID_CONTENT_VALUE . self::CONTENT_MIN_LENGTH . '-' . self::CONTENT_MAX_LENGTH
            );
        }

        $this->content = $content;
    }

    /**
     * @return AuthorInterface
     */
    public function getAuthor(): AuthorInterface
    {
        return $this->author;
    }

    /**
     * @return RatingInterface
     */
    public function getRating(): RatingInterface
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getCommentsCount(): int
    {
        return $this->commentsCount;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return TagCollection
     */
    public function getTags(): TagCollection
    {
        return $this->tags;
    }

    /**
     * @param TagCollection $tags
     */
    public function setTags(TagCollection $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
}
