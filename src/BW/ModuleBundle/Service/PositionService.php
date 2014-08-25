<?php

namespace BW\ModuleBundle\Service;

use BW\RouterBundle\EventListener\DatabaseRouteLoadingEventListener;
use Symfony\Bridge\Monolog\Logger;
use Twig_Environment;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Query\Expr\Join;

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
     * @param EntityManager $em
     * @param \Twig_Environment $twig
     * @param \BW\RouterBundle\EventListener\DatabaseRouteLoadingEventListener
     */
    public function __construct(
        EntityManager $em,
        Twig_Environment $twig,
        DatabaseRouteLoadingEventListener $databaseRouteLoading,
        Logger $logger
    ){
        $this->em = $em;
        $this->twig = $twig;
        $this->databaseRouteLoading = $databaseRouteLoading;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded service "%s".',
            __METHOD__
        ));
        /** @TODO Maybe better load all widgets from DB at once and group them by positions? */
    }


    public function show($alias)
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
            ->addSelect('p')
            ->addSelect('wr')
            ->addSelect('wr2')
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
            'position' => $position,
            'widgets' => $widgets,
        ));
    }

}
