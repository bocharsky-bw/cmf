<?php

namespace BW\BreadcrumbsBundle\Twig;

use BW\BreadcrumbsBundle\Service\BreadcrumbService;

/**
 * Class BWExtension
 * @package BW\BreadcrumbsBundle\Twig
 */
class BWExtension extends \Twig_Extension
{
    /**
     * @var BreadcrumbService
     */
    private $breadcrumb;


    public function __construct(BreadcrumbService $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }


    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bw_breadcrumb', array($this, 'breadcrumbFunction')),
            new \Twig_SimpleFunction('bw_render_breadcrumb', array($this, 'renderBreadcrumbFunction')),
        );
    }

    public function breadcrumbFunction()
    {
        return $this->breadcrumb;
    }

    public function renderBreadcrumbFunction($template = 'BWBreadcrumbsBundle:Breadcrumb:unordered-list.html.twig')
    {
        return $this->breadcrumb->render($template);
    }

    public function getName()
    {
        return 'bw_breadcrumb.twig.bw_extension';
    }
}
