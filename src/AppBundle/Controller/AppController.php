<?php

namespace AppBundle\Controller;

use BW\RouterBundle\Entity\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AppController
 * @package AppBundle\Controller
 */
class AppController extends Controller
{
    public function adminAction()
    {
        return $this->render('AppBundle:App:admin.html.twig');
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Route $route */
        $route = $em->getRepository('BWRouterBundle:Route')->findOneByPath('/home');
        if ($route) {
            return $this->forward($route->getController(), $route->getDefaults());
        }

        return $this->render('AppBundle:App:index.html.twig');
    }
}
