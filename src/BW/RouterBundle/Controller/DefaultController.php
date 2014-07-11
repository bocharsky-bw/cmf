<?php

namespace BW\RouterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BWRouterBundle:Default:index.html.twig', array());
    }
}
