<?php

namespace BW\ModuleBundle\Service;

use BW\ModuleBundle\Entity\Widget;
use Symfony\Bridge\Monolog\Logger;

/**
 * Class CustomWidgetService
 * @package BW\ModuleBundle\Service
 */
class CustomWidgetService implements WidgetServiceInterface
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
        return $this->twig->render('BWModuleBundle:CustomWidget:show.html.twig', array(
            'customWidget' => $widget->getCustomWidget(),
        ));
    }
}
