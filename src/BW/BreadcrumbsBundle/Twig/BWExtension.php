<?php

namespace BW\BreadcrumbsBundle\Twig;

use BW\BreadcrumbsBundle\Service\BreadcrumbsService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BWExtension
 * @package BW\BreadcrumbsBundle\Twig
 */
class BWExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bw_breadcrumbs', array($this, 'breadcrumbsFunction')),
            new \Twig_SimpleFunction('bw_render_breadcrumbs', array($this, 'renderBreadcrumbsFunction')),
        );
    }

    public function breadcrumbsFunction()
    {
        return $this->container->get('bw_breadcrumbs');
    }

    public function renderBreadcrumbsFunction(BreadcrumbsService $breadcrumbs, $template = 'BWBreadcrumbsBundle:Breadcrumbs:unordered-list.html.twig')
    {
        return $this->container->get('templating')->render($template, [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function getName()
    {
        return 'bw_breadcrumbs.twig.bw_extension';
    }
}
