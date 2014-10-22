<?php

namespace BW\BlogBundle\Service;

use BW\ModuleBundle\Service\WidgetServiceInterface;
use BW\ModuleBundle\Entity\Widget;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Types\Type;
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
        $categories = $widget->getCategoryWidget()->getCategories();
        $exclude = $widget->getCategoryWidget()->getExclude();

        $qb = $this->em->getRepository('BWBlogBundle:Category')->createQueryBuilder('c');
        $qb
            ->addSelect('r')
            ->addSelect('COUNT(p.id) AS countPosts')
            ->innerJoin('c.route', 'r')
            ->innerJoin('c.posts', 'p')
            ->where('c.published = 1')
            ->andWhere('c.id ' . ($exclude ? 'NOT' : '') . ' IN (:categories)')
            ->setParameter('categories', $categories->toArray(), Connection::PARAM_INT_ARRAY)
            ->groupBy('c.id');

        $categories = $qb->getQuery()->getResult();

        return $this->twig->render('BWBlogBundle:CategoryWidget:list-with-description-and-count.html.twig', array(
            'categories' => $categories,
        ));
    }
}
