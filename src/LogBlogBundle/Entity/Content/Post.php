<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 15:36
 */

namespace LogBlogBundle\Entity\Content;


use LogBlogBundle\Entity\Userbase\User;
use LogBlogBundle\Exception\InvalidArgumentException;
use LogBlogBundle\Exception\PublishingException;
use Ramsey\Uuid\Uuid;

class Post
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    private $id;

    /**
     * @var User
     */
    private $author;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $published;

    /**
     * @var \DateTimeImmutable
     */
    private $publishedAt;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @var \DateTimeImmutable
     */
    private $updatedAt;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->title = '';
        $this->content = '';
        $this->published = false;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the Post's author.
     *
     * Will add this Post to the Author's authored post list.
     *
     * @param User $author
     * @return Post
     *
     * @throws InvalidArgumentException
     */
    public function setAuthor($author)
    {
        if (!$author instanceof User) {
            throw new InvalidArgumentException('Author must be Instance of '.User::class);
        }
        $this->author = $author;

        $author->addPost($this);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Post
     *
     * @throws InvalidArgumentException
     */
    public function setTitle($title)
    {
        if (!is_string($title)) {
            throw new InvalidArgumentException('Title must be of type String');
        }
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Post
     *
     * @throws InvalidArgumentException
     */
    public function setContent($content)
    {
        if (!is_string($content)) {
            throw new InvalidArgumentException('Content must be of type String');
        }
        $this->content = $content;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Publishes the Post
     */
    public function publish()
    {
        if ($this->isPublished()) {
            throw new PublishingException('You cannot publish an already published Post');
        }
        $this->published = true;
        $this->publishedAt = new \DateTimeImmutable();
    }

    /**
     * Unpublishes the Post
     */
    public function unpublish()
    {
        if (!$this->isPublished()) {
            throw new PublishingException('You cannot unpublish a Post that is not published');
        }
        $this->published = false;
        $this->publishedAt = null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}