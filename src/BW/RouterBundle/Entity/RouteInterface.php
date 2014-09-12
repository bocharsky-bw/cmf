<?php

namespace BW\RouterBundle\Entity;

/**
 * Interface RouteInterface
 * @package BW\RouterBundle\Entity
 */
interface RouteInterface
{
    /**
     * Generate route path
     *
     * @return string
     */
    public function generatePath();

    /**
     * Get array of route defaults
     *
     * @return array
     */
    public function getDefaults();

    /**
     * Set the Route entity
     *
     * @param Route $route
     * @return RouteInterface
     */
    public function setRoute(Route $route = null);

    /**
     * Get the Route entity
     * @return Route
     */
    public function getRoute();
}