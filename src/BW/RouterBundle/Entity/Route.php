<?php

namespace BW\RouterBundle\Entity;

/**
 * Class Route
 * @package BW\RouterBundle\Entity
 */
class Route
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $path The query with locale
     */
    private $path = '';

    /**
     * @var array $defaults
     */
    private $defaults = array();


    /**
     * @param RouteInterface $entity
     * @return $this
     */
    public function handleEntity(RouteInterface $entity)
    {
        $entity->setRoute($this);
        $this->setPath($entity->generatePath());
        $this->setDefaults($entity->getDefaults());

        return $this;
    }

    /**
     * Get the controller name (a string like BlogBundle:Post:index) or null if not defined
     *
     * @return string|null
     */
    public function getController()
    {
        return isset($this->defaults['_controller'])
            ? $this->defaults['_controller']
            : null
        ;
    }


    /* SETTERS / GETTERS */

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uri
     *
     * @param string $path
     * @return Route
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set defaults
     *
     * @param array $defaults
     * @return Route
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;

        return $this;
    }

    /**
     * Get defaults
     *
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }
}