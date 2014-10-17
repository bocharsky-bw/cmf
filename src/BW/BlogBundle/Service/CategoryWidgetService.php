<?php

namespace BW\BlogBundle\Service;

use BW\ModuleBundle\Service\WidgetServiceInterface;
use BW\ModuleBundle\Entity\Widget;
use Doctrine\ORM\EntityManager;
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
        $categories = $qb
            ->addSelect('r')
            ->addSelect('COUNT(p.id) AS countPosts')
            ->innerJoin('c.route', 'r')
            ->innerJoin('c.posts', 'p')
            ->where('c.published = 1')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();

        return $this->twig->render('BWBlogBundle:CategoryWidget:list-with-description-and-count.html.twig', array(
            'categories' => $categories,
        ));
    }
}
