<?php

namespace BW\ModuleBundle\Service;

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
     * The constructor
     *
     * @param EntityManager $em
     * @param \Twig_Environment $twig
     * @param \BW\RouterBundle\EventListener\DatabaseRouteLoadingEventListener
     */
    public function __construct(
        EntityManager $em,
        \Twig_Environment $twig,
        \BW\RouterBundle\EventListener\DatabaseRouteLoadingEventListener $databaseRouteLoading
    ){
        $this->em = $em;
        $this->twig = $twig;
        $this->databaseRouteLoading = $databaseRouteLoading;
        /** @TODO Load all widgets from DB and group them by positions */
    }


    public function show($name)
    {
        $position = $this->em->getRepository('BWModuleBundle:Position')->findOneByName($name);

        $currentRoute = $this->databaseRouteLoading->getCurrentRoute(); // Get current Route object
        $currentRouteId = $currentRoute ? $currentRoute->getId() : 0; // Get current Route object ID
            $qb = $this->em
            ->getRepository('BWModuleBundle:Widget')
            ->createQueryBuilder('w')
        ;
        $widgets = $qb
            ->leftJoin('w.widgetRoutes', 'wr')
            ->leftJoin('w.widgetRoutes', 'wr2', Join::WITH, $qb->expr()->andx(
                $qb->expr()->eq('wr2.widget', 'w.id'),
                $qb->expr()->eq('wr2.route', $currentRouteId)
            ))
            ->where($qb->expr()->eq('w.published', '1'))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->eq('w.visibility', 0),
                    $qb->expr()->eq('wr.route', $currentRouteId)
                ),
                $qb->expr()->andX(
                    $qb->expr()->eq('w.visibility', 1),
                    $qb->expr()->isNull('wr2.id')
                )
            ))
            ->groupBy('w.id')
            ->orderBy('w.order', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        if ( ! $position) {
            /** @TODO Add to logger ID of not found Position entity */
            throw new EntityNotFoundException('Unable to find Position entity');
        }

        return $this->twig->render('BWModuleBundle:Position:show.html.twig', array(
            'position' => $position,
            'widgets' => $widgets,
        ));
    }

}
