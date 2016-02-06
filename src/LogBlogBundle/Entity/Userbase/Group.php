<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 15:30
 */

namespace LogBlogBundle\Entity\Userbase;

use Ramsey\Uuid\Uuid;

class Group extends \FOS\UserBundle\Model\Group
{
    public function __construct($name, array $roles = [])
    {
        parent::__construct($name, $roles);
        $this->id = Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}