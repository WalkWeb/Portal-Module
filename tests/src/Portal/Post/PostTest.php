<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post;

use DateTime;
use Portal\Account\AccountException;
use Portal\Account\Status\AccountStatus;
use Portal\Post\Author\Author;
use Portal\Post\Post;
use Portal\Post\Tag\TagCollection;
use Tests\AbstractUnitTest;

class PostTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание поста
     *
     * @throws AccountException
     */
    public function testPostCreateSuccess(): void
    {
        $id = '41b6a2e5-020c-4b18-8a57-1496709e43f5';
        $title = 'Обработка ошибок и C++';
        $slug = 'obrabotka-oshibok-i-c-123123';
        $content = 'post content';
        $author = new Author(
            '4f88c009-6605-4ed9-9ba3-09a92b63bbdb',
            'Name',
            'avatar.png',
            15,
            new AccountStatus(1)
        );
        $rating = 43;
        $commentsCount = 12;
        $published = true;
        $tags = new TagCollection();
        $createdAt = new DateTime('2019-08-12 14:46:02');
        $updatedAt = null;

        $post = new Post(
            $id,
            $title,
            $slug,
            $content,
            $author,
            $rating,
            $commentsCount,
            $published,
            $tags,
            $createdAt,
            $updatedAt
        );

        self::assertEquals($id, $post->getId());
        self::assertEquals($title, $post->getTitle());
        self::assertEquals($slug, $post->getSlug());
        self::assertEquals($content, $post->getContent());
        self::assertEquals($author, $post->getAuthor());
        self::assertEquals($rating, $post->getRating());
        self::assertEquals($commentsCount, $post->getCommentsCount());
        self::assertEquals($published, $post->isPublished());
        self::assertEquals($tags, $post->getTags());
        self::assertEquals($createdAt, $post->getCreatedAt());
        self::assertEquals($updatedAt, $post->getUpdatedAt());
    }
}
