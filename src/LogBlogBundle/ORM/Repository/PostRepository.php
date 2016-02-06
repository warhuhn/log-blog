<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 06.02.16
 * Time: 18:36
 */

namespace LogBlogBundle\ORM\Repository;

class PostRepository extends AbstractPagingRepository
{
    public function findAllOnPage($page, $limit)
    {
        return $this->createPagedQueryBuilder($page, $limit)
            ->getQuery()
            ->execute();
    }

    public function findAllPublishedOnPage($page, $limit)
    {
        return $this->createPagedQueryBuilder($page, $limit)
            ->where($this->getDefaultAlias().'.published = :isPublished')
            ->setParameter('isPublished', true)
            ->getQuery()
            ->execute();
    }
}