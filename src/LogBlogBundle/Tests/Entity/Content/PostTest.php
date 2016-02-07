<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 07.02.16
 * Time: 13:41
 */

namespace LogBlogBundle\Tests\Entity\Content;

use LogBlogBundle\Entity\Content\Post;
use LogBlogBundle\Entity\Userbase\User;
use LogBlogBundle\Exception\InvalidArgumentException;

class PostTest extends \PHPUnit_Framework_TestCase
{
    public function testIdGeneration()
    {
        $p = new Post();
        static::assertNotNull($p->getId());
        static::assertEquals(36, strlen((string) $p->getId()));
    }

    public function testPublishing()
    {
        $p = new Post();

        static::assertFalse($p->isPublished());
        static::assertNull($p->getPublishedAt());

        $p->publish();

        static::assertTrue($p->isPublished());
        static::assertNotNull($p->getPublishedAt());
        static::assertInstanceOf(\DateTimeInterface::class, $p->getPublishedAt());
    }

    /**
     * @expectedException \LogBlogBundle\Exception\PublishingException
     */
    public function testDoublePublishing()
    {
        $p = new Post();

        $p->publish();
        $p->publish();
    }

    public function testUnpublishing()
    {
        static::hasDependencies();
        static::setDependencies([
            'PostTest::testPublishing'
        ]);

        $p = new Post();

        $p->publish();
        $p->unpublish();

        static::assertFalse($p->isPublished());
        static::assertNull($p->getPublishedAt());
    }

    /**
     * @expectedException \LogBlogBundle\Exception\PublishingException
     */
    public function testDoubleUnpublishing()
    {
        $p = new Post();

        $p->unpublish();
    }

    public function testAuthor()
    {
        $p = new Post();

        static::assertNull($p->getAuthor());

        $u = new User();

        static::assertCount(0, $u->getAuthoredPosts());

        $p->setAuthor($u);

        static::assertNotNull($p->getAuthor());
        static::assertSame($u, $p->getAuthor());

        static::assertCount(1, $u->getAuthoredPosts());
        static::assertContains($p, $u->getAuthoredPosts());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAuthorFailWithNull()
    {
        $p = new Post();

        $p->setAuthor(null);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAuthorFailWithObject()
    {
        $p = new Post();

        $o = new \stdClass();

        // Yes we know this will go wrong.
        /** @noinspection PhpParamsInspection */
        $p->setAuthor($o);
    }
}
