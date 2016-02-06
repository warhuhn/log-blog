<?php
/**
 * Created by PhpStorm.
 * User: warhuhn
 * Date: 05.02.16
 * Time: 16:12
 */

namespace LogBlogBundle\Controller\Authoring;

use LogBlogBundle\Entity\Content\Post;
use LogBlogBundle\Form\Content\PostWriteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostWriteController extends Controller
{
    /**
     * Writes a new Post
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $post->setAuthor($this->getUser());

        return $this->handlePost($request, $post);
    }

    /**
     * Edits an existing Post
     *
     * @param Request $request
     * @param string  $postId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogBlogBundle\Exception\NotFoundException
     */
    public function editAction(Request $request, $postId)
    {
        $post = $this->get('log_blog.manager.post')->getPostByUuid($postId);

        return $this->handlePost($request, $post);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handlePost(Request $request, Post $post)
    {
        $form = $this->createForm(PostWriteType::class, $post);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->submit($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $post = $form->getData();

                $this->get('log_blog.manager.post')->persistPost($post);

                return $this->redirectToRoute('log_blog_authoring_post_view', [
                    'postId' => $post->getId(),
                ]);
            }
        }

        return $this->render('@LogBlog/Authoring/Post/write.html.twig', [
            'post_form' => $form,
            'post' => $post,
        ]);
    }
}