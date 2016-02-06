<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 06.02.16
 * Time: 18:36
 */

namespace LogBlogBundle\ORM\Repository;

class PostRepository extends AbstractDefaultRepository
{
    public function createPublishedQueryBuilder()
    {
        return $this->createDefaultQueryBuilder()
            ->where($this->getDefaultAlias().'.published = :isPublished')
            ->setParameter('isPublished', true);
    }
}