<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 07.02.16
 * Time: 13:31
 */

namespace LogBlogBundle\Controller\Authoring;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostPublishController extends Controller
{
    public function publishAction($postId)
    {
        $postManager = $this->get('log_blog.manager.post');

        $post = $postManager->getPostByUuid($postId);

        if (!$post->isPublished()) {
            $post->publish();

            $postManager->persistPost($post);
        }

        return $this->redirectToRoute('log_blog_authoring_post_list');
    }

    public function unpublishAction($postId)
    {
        $postManager = $this->get('log_blog.manager.post');

        $post = $postManager->getPostByUuid($postId);

        if ($post->isPublished()) {
            $post->unpublish();

            $postManager->persistPost($post);
        }

        return $this->redirectToRoute('log_blog_authoring_post_list');
    }
}