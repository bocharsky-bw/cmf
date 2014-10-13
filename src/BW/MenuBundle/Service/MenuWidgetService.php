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
        $menu = $widget->getMenuWidget()->getMenu();

        $repo = $this->em->getRepository('BWMenuBundle:Item');
        $query = $repo->createQueryBuilder('node')
            ->addSelect('r')
            ->leftJoin('node.route', 'r')
            ->orderBy('node.root, node.left', 'ASC')
            ->where('node.published = 1')
            ->andWhere('node.menu = :menu')
            ->setParameter('menu', $menu)
            ->getQuery();

        $repo->setChildrenIndex('children');
        $itemTree = $repo->buildTree($query->getArrayResult());

        return $this->twig->render('BWMenuBundle:MenuWidget:unordered-list.html.twig', array(
            'menuWidget' => $widget->getMenuWidget(),
            'menu' => $menu,
            'itemTree' => $itemTree,
        ));
    }
}
