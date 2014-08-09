<?php

namespace BW\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BWMenuBundle:Default:index.html.twig', array('name' => $name));
    }
}
