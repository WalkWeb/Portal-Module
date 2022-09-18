<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\Comment;

use DateTime;
use Portal\Post\Comment\Comment;
use Tests\AbstractUnitTest;

class CommentTest extends AbstractUnitTest
{
    public function testCommentCreate(): void
    {
        $id = 'c5b1f320-65f2-4855-a7bb-ad347df24856';
        $postId = 'b05491f1-7da0-4fbf-bc16-7366e386b1ef';
        $accountId = 'cf87a769-ef07-4970-8050-20006aed69ba';
        $content = 'comment content';
        $rating = 10;
        $createdAt = new DateTime('2019-08-12 14:00:00');
        $updatedAt = null;

        $comment = new Comment($id, $postId, $accountId, $content, $rating, $createdAt, $updatedAt);

        self::assertEquals($id, $comment->getId());
        self::assertEquals($postId, $comment->getPostId());
        self::assertEquals($accountId, $comment->getAccountId());
        self::assertEquals($content, $comment->getContent());
        self::assertEquals($rating, $comment->getRating());
        self::assertEquals($createdAt, $comment->getCreatedAt());
        self::assertEquals($updatedAt, $comment->getUpdatedAt());
    }
}
