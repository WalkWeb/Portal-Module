<?php

declare(strict_types=1);

namespace Portal\Post;

use DateTimeInterface;
use Portal\Post\Author\AuthorInterface;
use Portal\Post\Tag\TagCollection;

/**
 * Важно: объект поста не содержит комментариев, чтобы не утяжелять объект для тех случаев, когда нам нужно сделать
 * коллекцию постов для отображения их списком
 *
 * На странице конкретного поста комментарии формируются отдельно, в самом контроллере
 *
 * @package Portal\Post
 */
interface PostInterface
{
    public const TITLE_MIN_LENGTH   = 2;
    public const TITLE_MAX_LENGTH   = 80;
    public const CONTENT_MIN_LENGTH = 2;
    public const CONTENT_MAX_LENGTH = 65534;

    /**
     * Возвращает ID поста
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Возвращает заголовок поста
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Возвращает транслитерацию заголовка поста
     *
     * @return string
     */
    public function getSlug(): string;

    /**
     * Возвращает контент для отображения поста
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Возвращает автора поста
     *
     * @return AuthorInterface
     */
    public function getAuthor(): AuthorInterface;

    /**
     * Возвращает рейтинг поста
     *
     * @return int
     */
    public function getRating(): int;

    /**
     * Возвращает количество комментариев поста
     *
     * @return int
     */
    public function getCommentsCount(): int;

    /**
     * Опубликован ли пост
     *
     * @return bool
     */
    public function isPublished(): bool;

    /**
     * Возвращает коллекцию тегов поста
     *
     * @return TagCollection
     */
    public function getTags(): TagCollection;

    /**
     * Возвращает дату создания поста
     *
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface;

    /**
     * Возвращает дату последнего редактирования поста
     *
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface;

    // TODO PostStatus

    // TODO isLiked
}
