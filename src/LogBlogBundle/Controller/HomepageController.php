<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 17:29
 */

namespace LogBlogBundle\Controller;

use LogBlogBundle\Entity\Content\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function homepageAction()
    {
        // TODO: Move this to Manager
        $posts = $this->getDoctrine()->getRepository('LogBlogBundle:Content\Post')->findAll();

        return $this->render('@LogBlog/Homepage/homepage.html.twig', [
            'posts' => $posts,
        ]);
    }
}