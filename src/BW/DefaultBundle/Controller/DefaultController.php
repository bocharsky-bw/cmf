<?php

namespace BW\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BWDefaultBundle:Default:index.html.twig', array('name' => $name));
    }
}
