<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 06.02.16
 * Time: 18:37
 */

namespace LogBlogBundle\ORM\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractPagingRepository extends EntityRepository
{
    /**
     * @var string
     */
    private $defaultAlias;

    /**
     * @return string
     */
    protected final function getDefaultAlias()
    {
        if (null === $this->defaultAlias) {
            $this->defaultAlias = strtolower(substr($this->getClassName(), 0, 1));
        }

        return $this->defaultAlias;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected final function createDefaultQueryBuilder()
    {
        return $this->createQueryBuilder($this->getDefaultAlias());
    }

    /**
     * Creates a Query Builder with paging parameters
     *
     * @param int $page
     * @param int $limit
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function createPagedQueryBuilder($page, $limit)
    {
        return $this->createDefaultQueryBuilder()
            ->setFirstResult(max($page - 1, 0) * $limit)
            ->setMaxResults($limit);
    }
}