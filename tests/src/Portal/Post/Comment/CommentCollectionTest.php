<?php

declare(strict_types=1);

namespace Tests\src\Portal\Post\Comment;

use DateTime;
use Portal\Post\Comment\Comment;
use Portal\Post\Comment\CommentCollection;
use Portal\Post\Comment\CommentException;
use Tests\AbstractUnitTest;

class CommentCollectionTest extends AbstractUnitTest
{
    /**
     * Тест на успешное создание CommentCollection
     *
     * @throws CommentException
     */
    public function testCommentCollectionCreateSuccess(): void
    {
        $collection = new CommentCollection();

        self::assertCount(0, $collection);

        $comment1 = new Comment(
            'a6da3de1-bec9-4476-80c3-df9057f87f18',
            '6a409b5e-7d52-48c9-a1db-7eabda8368c6',
            '0cad64c1-8833-4ca2-b732-1dcc64d2ce5e',
            'comment #1',
            0,
            new DateTime('2019-08-12 14:00:00')
        );
        $comment2 = new Comment(
            'd441f035-05a0-4beb-9920-df1732cd3036',
            '6a409b5e-7d52-48c9-a1db-7eabda8368c6',
            '0cad64c1-8833-4ca2-b732-1dcc64d2ce5e',
            'comment #1',
            3,
            new DateTime('2019-08-12 16:00:00')
        );

        $collection->add($comment1);
        $collection->add($comment2);

        self::assertCount(2, $collection);

        $i = 0;
        foreach ($collection as $comment) {
            if ($i === 0) {
                self::assertEquals($comment, $comment1);
            }
            if ($i === 1) {
                self::assertEquals($comment, $comment2);
            }
            $i++;
        }
    }

    /**
     * Тест на ситуацию, когда в коллекцию добавляется комментарий, которые в ней уже существует
     *
     * @throws CommentException
     */
    public function testCommentCollectionDoubleComment(): void
    {
        $collection = new CommentCollection();

        $comment = new Comment(
            'a6da3de1-bec9-4476-80c3-df9057f87f18',
            '6a409b5e-7d52-48c9-a1db-7eabda8368c6',
            '0cad64c1-8833-4ca2-b732-1dcc64d2ce5e',
            'comment #1',
            0,
            new DateTime('2019-08-12 14:00:00')
        );

        $collection->add($comment);

        $this->expectException(CommentException::class);
        $this->expectExceptionMessage(CommentException::ALREADY_EXIST);
        $collection->add($comment);
    }
}
