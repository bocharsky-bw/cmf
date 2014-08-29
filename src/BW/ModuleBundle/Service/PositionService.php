<?php

namespace BW\ModuleBundle\Service;

use BW\RouterBundle\EventListener\DatabaseRouteLoadingEventListener;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Environment;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Query\Expr\Join;

class PositionService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var \BW\RouterBundle\EventListener\DatabaseRouteLoadingEventListener
     */
    private $databaseRouteLoading;

    /**
     * @var Logger
     */
    private $logger;


    /**
     * The constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->twig = $container->get('twig');
        $this->databaseRouteLoading = $container->get('bw_router.event_listener.database_route_loading');
        $this->logger = $container->get('logger');
        $this->logger->debug(sprintf(
            'Loaded service "%s".',
            __METHOD__
        ));
        /** @TODO Maybe better load all widgets from DB at once and group them by positions? */
    }


    /**
     * Render Position entity by alias
     *
     * @param string $alias
     * @return string The rendered position
     * @throws EntityNotFoundException
     */
    public function render($alias)
    {
        $position = $this->em->getRepository('BWModuleBundle:Position')->findOneByAlias($alias);
        if ( ! $position) {
            $this->logger->alert(sprintf(
                'Unable to find Position entity with alias "%s".',
                $alias
            ));
            throw new EntityNotFoundException();
        }

        $currentRoute = $this->databaseRouteLoading->getCurrentRoute(); // Get current Route object
        $currentRouteId = $currentRoute ? $currentRoute->getId() : 0; // Get current Route object ID
            $qb = $this->em
            ->getRepository('BWModuleBundle:Widget')
            ->createQueryBuilder('w')
        ;
        $widgets = $qb
            ->addSelect('t')
            ->addSelect('p')
            ->addSelect('wr')
            ->innerJoin('w.type', 't')
            ->innerJoin('w.position', 'p')
            ->leftJoin('w.widgetRoutes', 'wr')
            ->leftJoin('w.widgetRoutes', 'wr2', Join::WITH, $qb->expr()->andx(
                $qb->expr()->eq('wr2.widget', 'w.id'),
                $qb->expr()->eq('wr2.route', $currentRouteId)
            ))
            ->where($qb->expr()->eq('w.published', 1))
            ->andWhere($qb->expr()->eq('w.position', ':position'))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->eq('w.visibility', 0),
                    $qb->expr()->eq('wr.route', ':route_id')
                ),
                $qb->expr()->andX(
                    $qb->expr()->eq('w.visibility', 1),
                    $qb->expr()->isNull('wr2.id')
                )
            ))
            ->setParameter('position', $position)
            ->setParameter('route_id', $currentRouteId)
            ->groupBy('w.id')
            ->orderBy('w.order', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return $this->twig->render('BWModuleBundle:Position:show.html.twig', array(
            'container' => $this->container,
            'position' => $position,
            'widgets' => $widgets,
        ));
    }

}
