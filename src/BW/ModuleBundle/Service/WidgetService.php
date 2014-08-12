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
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var Logger
     */
    private $logger;


    /**
     * The constructor
     *
     * @param EntityManager $em
     * @param \Twig_Environment $twig
     */
    public function __construct(EntityManager $em, \Twig_Environment $twig, Logger $logger)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded service "%s".',
            __METHOD__
        ));
    }


    /**
     * Show widget template by ID
     *
     * @param $id The Widget entity ID
     * @return string Render HTML template
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function show($id)
    {
        $widget = $this->em->getRepository('BWModuleBundle:Widget')->find($id);

        if ( ! $widget) {
            $this->logger->alert(sprintf(
                'Unable to find Widget entity with ID "%d".',
                $id
            ));
            throw new EntityNotFoundException();
        }

        return $this->twig->render('BWModuleBundle:Widget:show.html.twig', array(
            'widget' => $widget,
        ));
    }

    /**
     * Get Widget entity by ID
     *
     * @param $id The Widget entity ID
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
