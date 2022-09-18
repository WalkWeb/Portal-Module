<?php

declare(strict_types=1);

namespace Portal\Post\Comment;

use DateTimeInterface;

interface CommentInterface
{
    /**
     * Возвращает ID комментария
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Возвращает ID поста к которому относится данный комментарий
     *
     * @return string
     */
    public function getPostId(): string;

    /**
     * Возвращает ID аккаунта - автора комментария
     *
     * @return string
     */
    public function getAccountId(): string;

    /**
     * Возвращает содержимое комментария
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Возвращает рейтинг комментария
     *
     * @return int
     */
    public function getRating(): int;

    /**
     * Возвращает дату создания комментария
     *
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface;

    /**
     * Возвращает дату последнего обновления комментария, если обновление было
     *
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface;
}
