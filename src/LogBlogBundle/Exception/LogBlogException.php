<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 16:20
 */

namespace LogBlogBundle\Exception;

/**
 * Class LogBlogException
 *
 * I don't want this generic Exception to be thrown, so it's abstract.
 *
 * @package LogBlogBundle\Exception
 */
abstract class LogBlogException extends \Exception
{

}