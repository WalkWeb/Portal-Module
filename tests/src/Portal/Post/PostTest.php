<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post;

use DateTime;
use Exception;
use Portal\Account\Status\AccountStatus;
use Portal\Account\Status\AccountStatusInterface;
use Portal\Post\Author\Author;
use Portal\Post\Post;
use Portal\Post\PostException;
use Portal\Post\PostInterface;
use Portal\Post\Rating\Rating;
use Portal\Post\Status\Status;
use Portal\Post\Status\StatusInterface;
use Portal\Post\Tag\Tag;
use Portal\Post\Tag\TagCollection;
use Tests\AbstractUnitTest;

class PostTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание поста
     *
     * @throws Exception
     */
    public function testPostCreateSuccess(): void
    {
        $id = '41b6a2e5-020c-4b18-8a57-1496709e43f5';
        $title = 'Обработка ошибок и C++';
        $slug = 'obrabotka-oshibok-i-c-123123';
        $content = 'post content';
        $status = new Status(StatusInterface::DEFAULT);
        $author = new Author(
            '4f88c009-6605-4ed9-9ba3-09a92b63bbdb',
            'Name',
            'avatar.png',
            15,
            new AccountStatus(AccountStatusInterface::ACTIVE)
        );
        $rating = new Rating($likes = 12, $dislikes = -2, $userReaction = 0);
        $commentsCount = 12;
        $published = true;
        $tags = new TagCollection();
        $isLiked = true;
        $createdAt = new DateTime('2019-08-12 14:46:02');
        $updatedAt = null;

        $post = new Post(
            $id,
            $title,
            $slug,
            $content,
            $status,
            $author,
            $rating,
            $commentsCount,
            $published,
            $tags,
            $isLiked,
            $createdAt,
            $updatedAt
        );

        self::assertEquals($id, $post->getId());
        self::assertEquals($title, $post->getTitle());
        self::assertEquals($slug, $post->getSlug());
        self::assertEquals($content, $post->getContent());
        self::assertEquals($status, $post->getStatus());
        self::assertEquals($author, $post->getAuthor());
        self::assertEquals($rating, $post->getRating());
        self::assertEquals($commentsCount, $post->getCommentsCount());
        self::assertEquals($published, $post->isPublished());
        self::assertEquals($tags, $post->getTags());
        self::assertEquals($isLiked, $post->isLiked());
        self::assertEquals($createdAt, $post->getCreatedAt());
        self::assertEquals($updatedAt, $post->getUpdatedAt());

        self::assertEquals(
            [
                "id"               => $id,
                "title"            => $title,
                "slug"             => $slug,
                "content"          => $content,
                "status_id"        => StatusInterface::DEFAULT,
                "likes"            => $likes,
                "dislikes"         => $dislikes,
                "user_reaction"    => $userReaction,
                "comments_count"   => $commentsCount,
                "published"        => $published,
                "tags"             => $tags->toArray(),
                "is_liked"         => $isLiked,
                "author_id"        => $author->getId(),
                "author_name"      => $author->getName(),
                "author_avatar"    => $author->getAvatar(),
                "author_level"     => $author->getLevel(),
                "author_status_id" => AccountStatusInterface::ACTIVE,
                "created_at"       => $createdAt->format('Y-m-d H:i:s'),
                "updated_at"       => $updatedAt,
            ],
            $post->toArray()
        );
    }

    /**
     * Тест на установку нового значения title
     *
     * @throws Exception
     */
    public function testPostSetTitleSuccess(): void
    {
        $post = $this->createPost();

        // Вначале проверяем, что новый title отличается от старого
        self::assertNotSame($newTitle = 'New Title', $post->getTitle());

        $post->setTitle($newTitle);

        self::assertEquals($newTitle, $post->getTitle());
    }

    /**
     * Тест на ситуации, когда указывается некорректный новый заголовок поста - слишком короткий или слишком длинный
     *
     * @dataProvider invalidTitleDataProvider
     * @param string $newTitle
     * @throws Exception
     */
    public function testPostSetTitleFail(string $newTitle): void
    {
        $this->expectException(PostException::class);
        $this->expectExceptionMessage(PostException::INVALID_TITLE_VALUE . PostInterface::TITLE_MIN_LENGTH . '-' . PostInterface::TITLE_MAX_LENGTH);
        $this->createPost()->setTitle($newTitle);
    }

    /**
     * Тест на установку нового содержимого поста
     *
     * @throws Exception
     */
    public function testPostSetContentSuccess(): void
    {
        $post = $this->createPost();

        // Вначале проверяем, что новый content отличается от старого
        self::assertNotSame($newContent = 'New Content', $post->getContent());

        $post->setContent($newContent);

        self::assertEquals($newContent, $post->getContent());
    }

    /**
     * Тест на ситуации, когда указывается некорректное новое содержимое поста - слишком короткое или слишком длинное
     *
     * @dataProvider invalidContentDataProvider
     * @param string $newContent
     * @throws Exception
     */
    public function testPostSetContentFail(string $newContent): void
    {
        $this->expectException(PostException::class);
        $this->expectExceptionMessage(PostException::INVALID_CONTENT_VALUE . PostInterface::CONTENT_MIN_LENGTH . '-' . PostInterface::CONTENT_MAX_LENGTH);
        $this->createPost()->setContent($newContent);
    }

    /**
     * Тест на установку новых тегов поста
     *
     * @throws Exception
     */
    public function testPostSetTags(): void
    {
        $newTags = new TagCollection();

        $newTags->add(new Tag(
            '16cb7f25-37b6-49d0-bd0d-13cd75bc71f8',
            'новости',
            'novosti',
            'icon-1.png',
            '59f2a61c-09bb-4187-8cff-f4efa0557a30',
            true
        ));

        $post = $this->createPost();

        // Вначале проверяем, что новые теги отличаются от старых
        self::assertNotSame($newTags, $post->getTags());

        $post->setTags($newTags);

        self::assertEquals($newTags, $post->getTags());
    }

    /**
     * @return array[]
     * @throws Exception
     */
    public function invalidTitleDataProvider(): array
    {
        return [
            [
                self::generateString(PostInterface::TITLE_MIN_LENGTH - 1),
            ],
            [
                self::generateString(PostInterface::TITLE_MAX_LENGTH + 1),
            ],
        ];
    }

    /**
     * @return array[]
     * @throws Exception
     */
    public function invalidContentDataProvider(): array
    {
        return [
            [
                self::generateString(PostInterface::CONTENT_MIN_LENGTH - 1),
            ],
            [
                self::generateString(PostInterface::CONTENT_MAX_LENGTH + 1),
            ],
        ];
    }

    /**
     * @return PostInterface
     * @throws Exception
     */
    private function createPost(): PostInterface
    {
        return new Post(
            '41b6a2e5-020c-4b18-8a57-1496709e43f5',
            'Title',
            'slug',
            'Content',
            new Status(Status::DEFAULT),
            new Author(
                '4f88c009-6605-4ed9-9ba3-09a92b63bbdb',
                'Name',
                'avatar.png',
                15,
                new AccountStatus(1)
            ),
            new Rating(0, 0, 0),
            0,
            false,
            new TagCollection(),
            false,
            new DateTime()
        );
    }
}
