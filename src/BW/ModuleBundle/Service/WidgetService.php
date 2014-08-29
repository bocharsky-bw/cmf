<?php

namespace BW\ModuleBundle\Service;

use Symfony\Bridge\Monolog\Logger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;

class WidgetService
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var Logger
     */
    private $logger;


    /**
     * The constructor
     *
     * @param EntityManager $em
     * @param Logger $logger
     */
    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded service "%s".',
            __METHOD__
        ));
    }


    /**
     * Get Widget entity by ID
     *
     * @param int $id The Widget entity ID
     * @return \BW\ModuleBundle\Entity\Widget
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function get($id)
    {
        $widget = $this->em->getRepository('BWModuleBundle:Widget')->find($id);

        if ( ! $widget) {
            $this->logger->alert(sprintf(
                'Unable to find Widget entity with ID "%d".',
                $id
            ));
            throw new EntityNotFoundException();
        }

        return $widget;
    }

}
