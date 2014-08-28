<?php

namespace BW\MenuBundle\Service;

use BW\ModuleBundle\Service\WidgetServiceInterface;
use BW\ModuleBundle\Entity\Widget;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;

/**
 * Class MenuWidgetService
 * @package BW\MenuBundle\Service
 */
class MenuWidgetService implements WidgetServiceInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * The constructor
     *
     * @param \Twig_Environment $twig
     * @param Logger $logger
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
     * Render the widget
     *
     * @param Widget $widget
     * @return string
     */
    public function render(Widget $widget)
    {
        $qb = $this->em->getRepository('BWMenuBundle:Item')->createQueryBuilder('i');
        $qb
            ->addSelect('m')
            ->addSelect('r')
            ->innerJoin('i.menu', 'm')
            ->leftJoin('i.route', 'r')
            ->innerJoin('m.menuWidgets', 'mw')
            ->where($qb->expr()->eq('mw.id', $widget->getMenuWidget()->getId()))
        ;
        $items = $qb->getQuery()->getResult();

        return $this->twig->render('BWMenuBundle:MenuWidget:show.html.twig', array(
            'menuWidget' => $widget->getMenuWidget(),
            'items' => $items,
        ));
    }
}
