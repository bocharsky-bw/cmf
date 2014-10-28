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

            $path = $entity->getRoute()->handleEntity($entity)->getPath();
            // generate correct path without duplicate
            while (true) {
                // try to find Route with same path in repo
                $route = $args->getEntityManager()
                    ->getRepository('BWRouterBundle:Route')
                    ->createQueryBuilder('r')
                    ->where('r.id != :id')
                    ->andWhere('r.path = :path')
                    ->setParameter('id', (int)$entity->getRoute()->getId()) // type casting to int required!
                    ->setParameter('path', $path)
                    ->orderBy('r.path', 'DESC')
                    ->getQuery()
                    ->getOneOrNullResult();

                if (null === $route) {
                    break; // break generation if Route path is unique
                } else {
                    $matched = false; // reset matched flag
                    // increment index at the end of string
                    $path = preg_replace_callback('@(?<=-)(\d+)$@', function ($matches) use (&$matched) {
                        $matched = true; // set regex matched flag
                        $index = (int)$matches[1];
                        return ++$index;
                    }, $path);
                    // if regex not matched and Route path generation not break
                    if (false === $matched) {
                        $path .= '-1'; // add index to the end of string if not exist
                    }
                }
            }
            $entity->getRoute()->setPath($path); // update path
            // @TODO Also need to update entity slug...

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
