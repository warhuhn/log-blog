<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 16:13
 */

namespace LogBlogBundle\Manager;

use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use LogBlogBundle\Entity\Content\Post;
use LogBlogBundle\Exception\InvalidArgumentException;
use LogBlogBundle\Exception\NotFoundException;
use LogBlogBundle\ORM\Repository\PostRepository;

/**
 * Class PostManager
 *
 * Retrieves and persists Posts
 *
 * @package LogBlogBundle\Manager
 */
class PostManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * PostManager constructor.
     *
     * @param EntityManager  $entityManager  Doctrine Entity Manager
     * @param PostRepository $postRepository Entity Repository for Posts
     * @param Paginator      $paginator      KnpPaginator Service
     */
    public function __construct(EntityManager $entityManager, PostRepository $postRepository, Paginator $paginator)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param string $uuid
     * @return Post
     * @throws NotFoundException
     */
    public function getPostByUuid($uuid)
    {
        if (!is_string($uuid) && strlen($uuid) !== 36) {
            throw new InvalidArgumentException('The post id must be a string with a length of 36 characters');
        }
        $post = $this->getPostRepository()->find($uuid);

        if (null === $post) {
            throw new NotFoundException('Post for UUID '.$uuid.' not found');
        }

        return $post;
    }

    /**
     * Persists a Post to the Entity Manager
     *
     * @param Post $post
     * @return PostManager
     */
    public function persistPost(Post $post)
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();

        return $this;
    }

    /**
     * @param int $page
     * @return Post[]
     */
    public function getPager($page)
    {
        if (!is_int($page) || $page <= 0) {
            throw new InvalidArgumentException('Page must be an integer greater than 0');
        }
        return $this->getPaginator()->paginate(
            $this->getPostRepository()->createDefaultQueryBuilder(),
            $page
        );
    }

    /**
     * @param int $page
     * @return Post[]
     */
    public function getPagerForPublished($page)
    {
        if (!is_int($page) || $page <= 0) {
            throw new InvalidArgumentException('Page must be an integer greater than 0');
        }
        return $this->getPaginator()->paginate(
            $this->getPostRepository()->createPublishedQueryBuilder(),
            $page
        );
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return PostRepository
     */
    protected function getPostRepository()
    {
        return $this->postRepository;
    }

    /**
     * @return Paginator
     */
    protected function getPaginator()
    {
        return $this->paginator;
    }
}