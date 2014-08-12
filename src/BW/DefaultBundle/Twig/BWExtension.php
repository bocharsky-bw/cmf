<?php

namespace BW\DefaultBundle\Twig;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BWExtension extends \Twig_Extension
{

    /**
     * The Service Container instance
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var Logger
     */
    private $logger;



    public function __construct(ContainerInterface $container, Logger $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded twig extension "%s".',
            __METHOD__
        ));
    }


    public function getName()
    {
        return 'bw_default_extension';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('repeat', array($this, 'repeatFilter')),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('service', array($this, 'serviceFunction')),
        );
    }


    public function repeatFilter($input, $multiplier = 2)
    {
        return str_repeat($input, $multiplier);
    }

    public function serviceFunction($service_name)
    {
        return $this->container->get($service_name);
    }
}