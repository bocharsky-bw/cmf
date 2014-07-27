<?php

namespace BW\RouterBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class KernelRequestListener
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    private $router;


    /**
     * The constructor
     *
     * @param RequestStack $requestStack
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(RequestStack $requestStack, EntityManager $em, Router $router)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
        $this->router = $router;
    }


    /**
     * Search route match in database
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
//        die('onKernelRequest');
        if ( ! $event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        if ( ! $this->request->isMethod('GET')) {
            // don't do anything if request method isn't GET
            return;
        }

        if ($this->isRouteMatched()) {
            // don't do anything if route already is matched
            return;
        }

        /** @TODO Replace with Monolog loger */
        var_dump('DEBUG: Search route in database');

        /** @var \BW\RouterBundle\Entity\Route $route */
        $route = $this->em->getRepository('BWRouterBundle:Route')->findOneBy(array(
            'path' => $this->request->getPathInfo(),
        ));
        if ( ! $route) {
            // don't do anything if route not found in database
            return;
        }

        $this->request->attributes->replace($route->getDefaults());
    }

    /**
     * Whether is route matched
     *
     * @return bool
     */
    private function isRouteMatched()
    {
        try {
            $this->router->matchRequest($this->request);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
