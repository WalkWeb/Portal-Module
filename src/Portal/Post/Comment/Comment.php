<?php

declare(strict_types=1);

namespace Portal\Post\Comment;

use DateTimeInterface;

class Comment implements CommentInterface
{
    private string $id;
    private string $postId;
    private string $accountId;
    private string $content;
    private int $rating;
    private DateTimeInterface $createdAt;
    private ?DateTimeInterface $updatedAt;

    public function __construct(
        string $id,
        string $postId,
        string $accountId,
        string $content,
        int $rating,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt = null
    )
    {
        $this->id = $id;
        $this->postId = $postId;
        $this->accountId = $accountId;
        $this->content = $content;
        $this->rating = $rating;
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
    public function getPostId(): string
    {
        return $this->postId;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
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
