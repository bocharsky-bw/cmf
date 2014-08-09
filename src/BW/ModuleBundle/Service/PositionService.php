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
        /** @TODO Load all widgets from DB and group them by positions */
    }


    public function show($name)
    {
        $position = $this->em->getRepository('BWModuleBundle:Position')->findOneByName($name);

        $currentRoute = 7;
        $qb = $this->em
            ->getRepository('BWModuleBundle:Widget')
            ->createQueryBuilder('w')
        ;
        $widgets = $qb
            ->leftJoin('w.widgetRoutes', 'wr')
            ->leftJoin('wr.route', 'r')
            ->where('w.published = 1')
            ->andWhere('(r.id IS NULL OR r.id = 3 OR w.visibility = 1)')
            ->andWhere('(w.visibility = 1 AND ((r.id IS NULL OR r.id != 3) AND NOT (r.id IS NULL AND r.id != 3)))')
            //->andWhere('(w.visibility = 1 AND (r.id IS NULL XOR r.id != 3))') // WORKED
            // p XOR q = ( p OR q ) AND NOT ( p AND q )
//            ->andWhere('(r.id = :current_route OR wr.route IS NULL)') // Filter by current route or NULL route
//            ->andWhere('(w.visibility = 0 AND wr.route IS NOT NULL AND r.id = :current_route)') // Only by listed routes WORKED
//            ->andWhere('(w.visibility = 1 AND wr.route IS NULL)')
//            ->setParameter('current_route', $currentRoute)
//            ->groupBy('w.id')
            ->orderBy('w.order', 'ASC')
            ->getQuery()
//            ->getResult()
        ;
        print $widgets->getSQL(); die;

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
