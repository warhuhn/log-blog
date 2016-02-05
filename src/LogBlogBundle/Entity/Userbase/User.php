<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 15:29
 */

namespace LogBlogBundle\Entity\Userbase;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use LogBlogBundle\Entity\Content\Post;
use Ramsey\Uuid\Uuid;

class User extends \FOS\UserBundle\Model\User
{
    /**
     * @var Post[]|Collection
     */
    private $authoredPosts;

    public function __construct()
    {
        parent::__construct();
        $this->id = Uuid::uuid4();
    }

    /**
     * @return Post[]|Collection
     */
    public function getAuthoredPosts()
    {
        return $this->authoredPosts ?: $this->authoredPosts = new ArrayCollection();
    }

    /**
     * Adds a post top the User's authored Posts.
     *
     * Post Author needs to be updated manually.
     *
     * @param Post $addPost
     * @return User
     */
    public function addPost(Post $addPost)
    {
        if (!$this->getAuthoredPosts()->contains($addPost)) {
            $this->authoredPosts->add($addPost);
        }

        return $this;
    }

    /**
     * Removes a Post from the User's authored Posts
     *
     * Post Author needs to be updated manually.
     *
     * @param Post $removePost
     * @return User
     */
    public function removePost(Post $removePost)
    {
        if ($this->getAuthoredPosts()->contains($removePost)) {
            $this->getAuthoredPosts()->removeElement($removePost);
        }

        return $this;
    }
}