<?php

namespace BW\ModuleBundle\Service;

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
     * The constructor
     *
     * @param EntityManager $em
     * @param \Twig_Environment $twig
     */
    public function __construct(EntityManager $em, \Twig_Environment $twig)
    {
        $this->em = $em;
        $this->twig = $twig;
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
            /** @TODO Add lo logger ID of entity */
            throw new EntityNotFoundException('Unable to find Widget entity');
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
            /** @TODO Add lo logger ID of not found entity */
            throw new EntityNotFoundException('Unable to find Widget entity');
        }

        return $widget;
    }

}
