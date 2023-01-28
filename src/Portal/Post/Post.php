<?php

declare(strict_types=1);

namespace Portal\Post;

use DateTimeInterface;
use Portal\Post\Author\AuthorInterface;
use Portal\Post\Rating\RatingInterface;
use Portal\Post\Status\StatusInterface;
use Portal\Post\Tag\TagCollection;

class Post implements PostInterface
{
    private string $id;
    private string $title;
    private string $slug;
    private string $content;
    private StatusInterface $status;
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
        StatusInterface $status,
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
        $this->status = $status;
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
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface
    {
        return $this->status;
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

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'content'          => $this->content,
            // TODO status лучше заменить на status_id, и тоже самое сделать в фабрике которая создает Post
            'status'           => $this->status->getId(),
            'likes'            => $this->rating->getLikes(),
            'dislikes'         => $this->rating->getDislikes(),
            'comments_count'   => $this->commentsCount,
            'published'        => $this->published,
            'created_at'       => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at'       => $this->updatedAt ? $this->updatedAt->format('Y-m-d H:i:s') : null,
            'tags'             => $this->tags->toArray(),
            'author_id'        => $this->author->getId(),
            'author_name'      => $this->author->getName(),
            'author_avatar'    => $this->author->getAvatar(),
            'author_level'     => $this->author->getLevel(),
            'author_status_id' => $this->author->getStatus()->getId(),
        ];
    }
}
