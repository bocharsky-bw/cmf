<?php

namespace BW\DefaultBundle\Controller;

use BW\RouterBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function adminAction()
    {
        return $this->render('BWDefaultBundle:Default:admin.html.twig');
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Route $route */
        $route = $em->getRepository('BWRouterBundle:Route')->findOneByPath('/home');
        if ($route) {
            return $this->forward($route->getController(), $route->getDefaults());
        }

        return $this->render('BWDefaultBundle:Default:index.html.twig');
    }
}
