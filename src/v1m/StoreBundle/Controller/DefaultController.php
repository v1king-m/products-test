<?php

namespace v1m\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('v1mStoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
