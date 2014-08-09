<?php

namespace BW\ModuleBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use BW\ModuleBundle\Entity\WidgetRoute;
use BW\ModuleBundle\Entity\Widget;

class UrlToWidgetRoutesTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var Widget
     */
    private $entity;


    /**
     * @param ObjectManager $om
     * @param Widget $entity
     */
    public function __construct(ObjectManager $om, Widget $entity)
    {
        $this->om = $om;
        $this->entity = $entity;
    }


    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param $widgetRoute
     * @return string
     */
    public function transform($widgetRoute)
    {
        return '';
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param string $url
     * @return \Doctrine\Common\Collections\Collection
     */
    public function reverseTransform($url)
    {
        $request = Request::createFromGlobals();

        if ( ! $url) {
            return $this->entity->getWidgetRoutes();
        }

        if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->entity->getWidgetRoutes();
        }

        // Get only path from URL
        $path = str_replace(
            $request->getSchemeAndHttpHost() . $request->getBaseUrl(),
            '',
            $url
        );

        $route =  $this->om
            ->getRepository('BWRouterBundle:Route')
            ->findOneBy(array(
                'path' => $path,
            ))
        ;
        if ( ! $route) {
            return $this->entity->getWidgetRoutes();
        }

        $widgetRoute =  $this->om
            ->getRepository('BWModuleBundle:WidgetRoute')
            ->findOneBy(array(
                'widget' => $this->entity,
                'route' => $route,
            ))
        ;
        if ( ! $widgetRoute) {
            $widgetRoute = new WidgetRoute();
            $widgetRoute->setWidget($this->entity);
            $widgetRoute->setRoute($route);
            $this->om->persist($widgetRoute);
            $this->entity->addWidgetRoute($widgetRoute);
        }

        return $this->entity->getWidgetRoutes();
    }
} 