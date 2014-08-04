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
     * The constructor
     *
     * @param EntityManager $em
     * @param \Twig_Environment $twig
     */
    public function __construct(EntityManager $em, \Twig_Environment $twig)
    {
        $this->em = $em;
        $this->twig = $twig;
        /** @TODO Load all widgets from DB and group them by positions */
    }


    public function show($name)
    {
        $position = $this->em->getRepository('BWModuleBundle:Position')->findOneByName($name);

        /** @TODO Get current route ID from service, not directly and not by new query from DB */
        $currentRoute = 6;
        $qb = $this->em
            ->getRepository('BWModuleBundle:Widget')
            ->createQueryBuilder('w')
        ;
        $widgets = $qb
            ->leftJoin('w.widgetRoutes', 'wr')
            ->leftJoin('w.widgetRoutes', 'wr2', Join::WITH, $qb->expr()->andx(
                $qb->expr()->eq('wr2.widget', 'w.id'),
                $qb->expr()->eq('wr2.route', $currentRoute)
            ))
            ->where($qb->expr()->eq('w.published', '1'))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->eq('w.visibility', 0),
                    $qb->expr()->eq('wr.route', $currentRoute)
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
//        print $widgets->getSQL(); die;

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
