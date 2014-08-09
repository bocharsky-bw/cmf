<?php

namespace BW\RouterBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bridge\Monolog\Logger;

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
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @var \BW\RouterBundle\Entity\Route
     */
    private $currentRoute;


    /**
     * The constructor
     *
     * @param RequestStack $requestStack
     * @param EntityManager $em
     * @param Router $router
     */
    public function __construct(RequestStack $requestStack, EntityManager $em, Router $router, Logger $logger)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
        $this->router = $router;
        $this->logger = $logger;
    }


    /**
     * Get current route object
     *
     * @return \BW\RouterBundle\Entity\Route
     */
    public function getCurrentRoute()
    {
        return $this->currentRoute;
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

        /** @var \BW\RouterBundle\Entity\Route $route */
        $route = $this->em->getRepository('BWRouterBundle:Route')->findOneBy(array(
            'path' => $this->request->getPathInfo(),
        ));
        $this->logger->debug(''
            . 'Notified event "' . $event->getName() . '" '
            . 'to listener "' . __METHOD__ . '". '
            . 'Search route in database.'
        );

        if ( ! $route) {
            // don't do anything if route not found in database
            return;
        }

        $this->currentRoute = $route;
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
