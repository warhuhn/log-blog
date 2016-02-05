<?php

namespace LogBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LogBlogBundle:Default:index.html.twig');
    }
}
