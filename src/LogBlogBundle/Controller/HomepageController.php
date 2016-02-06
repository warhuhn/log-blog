<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 17:29
 */

namespace LogBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    public function homepageAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $postPager = $this
            ->get('log_blog.manager.post')
            ->getPagerForPublished($page);

        return $this->render('@LogBlog/Homepage/homepage.html.twig', [
            'post_pager' => $postPager,
        ]);
    }
}