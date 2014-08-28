<?php

namespace BW\MenuBundle\Service;

use BW\ModuleBundle\Service\WidgetServiceInterface;
use BW\ModuleBundle\Entity\Widget;
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
     * The constructor
     *
     * @param \Twig_Environment $twig
     * @param Logger $logger
     */
    public function __construct(\Twig_Environment $twig, Logger $logger)
    {
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
        /** @TODO Need to execute query with where statement and joins for optimize code */
        return $this->twig->render('BWMenuBundle:MenuWidget:show.html.twig', array(
            'menuWidget' => $widget->getMenuWidget(),
        ));
    }
}
