<?php

namespace BW\RouterBundle\EventListener;

use BW\RouterBundle\Entity\Route;
use BW\RouterBundle\Entity\RouteInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bridge\Monolog\Logger;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;

/**
 * Class RoutingEventListener
 * @package BW\RouterBundle\EventListener
 */
class RoutingEventListener
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    private $router;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @var bool Whether needs call flush
     */
    private $isPostFlush = false;


    /**
     * The constructor
     *
     * @param RequestStack $requestStack
     * @param Router $router
     * @param Logger $logger
     */
    public function __construct(RequestStack $requestStack, Router $router, Logger $logger)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->router = $router;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded event listener "%s".',
            __METHOD__
        ));
    }


    /**
     * The Doctrine entity post persist event trigger
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->handleEntity($args);
    }

    /**
     * The Doctrine entity post update event trigger
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->handleEntity($args);
    }

    /**
     * The entity handle for automatic route creating and binding with it
     *
     * @param LifecycleEventArgs $args
     */
    private function handleEntity(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof RouteInterface) {
            if (null === $entity->getRoute()) {
                $entity->setRoute(new Route()); // Create new Route if not exists
            }

            $entity->getRoute()->handleEntity($entity);
            $this->isPostFlush = true;
        }
    }

    /**
     * The Doctrine post flush event trigger
     *
     * @param PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        if (true === $this->isPostFlush) {
            $this->isPostFlush = false; // must be before flush!
            $args->getEntityManager()->flush();
        }
    }
}
