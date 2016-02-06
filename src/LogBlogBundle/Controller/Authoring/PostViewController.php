<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 06.02.16
 * Time: 19:22
 */

namespace LogBlogBundle\Controller\Authoring;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostViewController extends Controller
{
    /**
     * Views a single Post in Authoring Mode
     *
     * @param string $postId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogBlogBundle\Exception\NotFoundException
     */
    public function viewAction($postId)
    {
        $post = $this->get('log_blog.manager.post')->getPostByUuid($postId);

        return $this->render('@LogBlog/Authoring/Post/view.html.twig', [
            'post' => $post,
        ]);
    }
}