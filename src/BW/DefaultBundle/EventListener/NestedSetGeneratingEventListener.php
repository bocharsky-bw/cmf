<?php

namespace BW\DefaultBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Symfony\Bridge\Monolog\Logger;
use BW\DefaultBundle\Service\NestedSetService;
use BW\DefaultBundle\Entity\NestedSetInterface;

/**
 * Class NestedSetGeneratingEventListener
 * @package BW\DefaultBundle\EventListener
 */
class NestedSetGeneratingEventListener
{
    /**
     * @var \BW\DefaultBundle\Service\NestedSetService
     */
    private $nestedSet;

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
     * @param NestedSetService $nestedSet
     * @param Logger $logger
     */
    public function __construct(NestedSetService $nestedSet, Logger $logger)
    {
        $this->nestedSet = $nestedSet;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded event listener "%s".',
            __METHOD__
        ));
    }


    public function postPersist(LifecycleEventArgs $args)
    {
        $this->handleEntity($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->handleEntity($args);
    }

    private function handleEntity(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof NestedSetInterface) {
            $em = $args->getEntityManager();

            $this->nestedSet->regenerate($em, $em->getClassMetadata(get_class($entity))->getName());
            $this->isPostFlush = true;
        }
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        if (true === $this->isPostFlush) {
            $this->isPostFlush = false; // must be before flush!
            $args->getEntityManager()->flush();
        }
    }
}
