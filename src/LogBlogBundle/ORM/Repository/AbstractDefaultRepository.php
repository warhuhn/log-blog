<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 06.02.16
 * Time: 18:37
 */

namespace LogBlogBundle\ORM\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractDefaultRepository extends EntityRepository
{
    /**
     * @var string
     */
    private $defaultAlias;

    /**
     * @return string
     */
    public final function getDefaultAlias()
    {
        if (null === $this->defaultAlias) {
            $this->defaultAlias = strtolower(substr($this->getClassName(), 0, 1));
        }

        return $this->defaultAlias;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public final function createDefaultQueryBuilder()
    {
        return $this->createQueryBuilder($this->getDefaultAlias());
    }
}