<?php

namespace BW\ModuleBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;

class PositionService
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


    public function show($name)
    {
        $position = $this->em->getRepository('BWModuleBundle:Position')->findOneByName($name);
        $widgets = $this->em
            ->getRepository('BWModuleBundle:Widget')
            ->createQueryBuilder('w')
            ->orderBy('w.order', 'ASC')
            ->where('w.published = 1')
            ->getQuery()
            ->getResult();
        ;

        if ( ! $position) {
            /** @TODO Add lo logger ID of not found entity */
            throw new EntityNotFoundException('Unable to find Position entity');
        }

        return $this->twig->render('BWModuleBundle:Position:show.html.twig', array(
            'position' => $position,
            'widgets' => $widgets,
        ));
    }

}
