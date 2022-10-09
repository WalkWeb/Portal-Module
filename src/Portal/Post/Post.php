<?php

declare(strict_types=1);

namespace Portal\Post;

use DateTimeInterface;
use Portal\Post\Author\AuthorInterface;
use Portal\Post\Tag\TagCollection;

class Post implements PostInterface
{
    private string $id;
    private string $title;
    private string $slug;
    private string $content;
    private AuthorInterface $author;
    private int $rating;
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
        int $rating,
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
     * @return AuthorInterface
     */
    public function getAuthor(): AuthorInterface
    {
        return $this->author;
    }

    /**
     * @return int
     */
    public function getRating(): int
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
