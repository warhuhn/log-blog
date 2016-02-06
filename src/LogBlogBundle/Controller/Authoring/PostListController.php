<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 06.02.16
 * Time: 13:15
 */

namespace LogBlogBundle\Controller\Authoring;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostListController extends Controller
{
    /**
     * Lists all Posts for Authors
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $page = (int) $request->query->get('page', 1);

        $postsPager = $this->get('log_blog.manager.post')
            ->getPager($page);

        return $this->render('@LogBlog/Authoring/Post/list.html.twig', [
            'post_pager' => $postsPager,
        ]);
    }
}