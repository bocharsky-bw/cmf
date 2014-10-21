<?php

namespace BW\BlogBundle\Service;

use BW\ModuleBundle\Service\WidgetServiceInterface;
use BW\ModuleBundle\Entity\Widget;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Monolog\Logger;

/**
 * Class CategoryWidgetService
 * @package BW\BlogBundle\Service
 */
class CategoryWidgetService implements WidgetServiceInterface
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
        $qb = $this->em->getRepository('BWBlogBundle:Category')->createQueryBuilder('c');
        $qb
            ->addSelect('r')
            ->addSelect('COUNT(p.id) AS countPosts')
            ->innerJoin('c.route', 'r')
            ->innerJoin('c.posts', 'p')
            ->where('c.published = 1')
            ->groupBy('c.id');

        // Только перечисленные:
        $qb
            ->innerJoin('c.categoryWidgets', 'cw')
            ->andWhere('cw.widget = :widget')
            ->setParameter('widget', $widget);

        $categories = $qb->getQuery()->getResult();

        return $this->twig->render('BWBlogBundle:CategoryWidget:list-with-description-and-count.html.twig', array(
            'categories' => $categories,
        ));
    }
}
